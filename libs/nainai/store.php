<?php
/**
 * 仓库管理类
 * author: weiping
 * Date: 2016/4/21
 * Time: 8:18
 */
namespace nainai;
use \Library\M;
use \Library\Query;
use \nainai\product;
use \Library\Tool;

class store{

     private $storeProduct = 'store_products';//仓单数据表
    //仓单数据规则
     protected $storeProductRules = array(
        array('store_id', 'number', '必须选择仓库!'),
        array('product_id', 'number', '请填写产品信息'),
        array('package', 'number','请选择是否打包!')
    );

     /**
      * 获取仓单的状态
      * @return [Array] 
      */
    public function getStatus(){
        return array(
            0 => '未审核',
            1 => '仓库管理员审核通过',
            2 => '仓库管理员审核不通过',
            3 => '卖方确认',
            4 => '后台审核通过',
            5 => '后台审核驳回'
        );
    }

     /**
     * 获取仓库列表
     * @return mixed
     */
    public static function getStoretList(){
        $storeModel = new M('store_list');
        $where  = array('status' => 1);
        return $storeModel->table('store_list')->fields('id, name, short_name, area, address')->where($where)->select();
    }

   
 /**
     * 获取仓单列表
     * @param  [Int] $page     
     * @param  [Int] $pagesize 
     * @return [Array]       ]
     */
    public function getApplyStoreList($page, $pagesize, $user_id=0){
         //仓单列表
        $query = new Query('store_list as b');
        $query->fields = 'a.id, b.name as sname, a.status, c.name as pname,  d.name as cname, c.attribute, a.package_unit, a.package_weight';
        $query->join = ' RIGHT JOIN (store_products as a LEFT JOIN products as c ON a.product_id = c.id ) ON a.store_id=b.id LEFT JOIN product_category as d  ON c.cate_id=d.id';
        $query->page = $page;
        $query->pagesize = $pagesize;

        if (intval($user_id) > 0) {
            $query->where = ' a.user_id=:user_id';
            $query->bind = array('user_id' => $user_id);
        }

        $storeList = $query->find();

        $attrs = $attr_id = array();
        foreach ($storeList as $key => $value) {

            $attrs = unserialize($value['attribute']);
            $storeList[$key]['attribute'] = $attrs;
            foreach ($attrs as $aid => $name) {
                if (!in_array($aid, $attr_id)) {
                    $attr_id[] = $aid;
                }
            }
        }

        $obj = new \nainai\product();
        
        return array('list' => $storeList, 'pageHtml' => $query->getPageBar(), 'attrs' => $obj->getHTMLProductAttr($attr_id));
    }

    /**
     * 审核仓单
     * @param [Array] $store [审核的仓单数据]
     * @param [Int] $id    [仓单id]
     */
    public function UpdateApplyStore( & $store, $id){
         $storeProductObj = new M($this->storeProduct);
        return  $storeProductObj->data($store)->where('id = :id')->bind(array('id'=>$id))->update(0);
    }

    /**
     * [获取用户的仓单列表, 并且没有添加报盘]
     * @param  [Int] $uid [用户id]
     * @return [Array]
     */
    public function getUserStoreLIst($uid){
        $query = new Query('store_products as a');
        $query->fields = 'a.id as sid,  b.name, c.id as oid';
        $query->join = ' LEFT JOIN store_list as b ON a.store_id = b.id LEFT JOIN product_offer as c ON a.product_id=c.product_id';
        $query->where = 'a.status=:status AND a.user_id=:user_id AND c.id IS NULL';
        $query->bind = array('status' => 4, 'user_id' => $uid);
        $data = $query->find();
        return $data;
    }

    /**
     * 获取对应的仓单详情
     * @param  [Int] $id [仓单id]
     * @return [Array]
     */
    public function getUserStoreDetail($id){
        $query = new Query('store_products as a');
        $query->fields = 'a.id as sid, b.name as pname, c.name as cname, b.attribute, b.produce_area, b.create_time, b.quantity, b.unit, b.id as pid, b.price, d.name as sname, b.note, a.store_pos, a.in_time, a.rent_time';
        $query->join = ' LEFT JOIN products as b ON a.product_id = b.id LEFT JOIN product_category  as c  ON b.cate_id=c.id LEFT JOIN store_list as d ON a.store_id=d.id';
        $query->where = ' a.id=:id';
        $query->bind = array('id' => $id);
        return $query->getObj();
    }

    /**
     * 判断仓单是否为这个用户的
     * @param  [Int] $id      [仓单Id]
     * @param  [Int] $user_id [用户id]
     * @return [Boolean] 
     */
    public function judgeIsUserStore($id, $user_id){
        if (intval($id) > 0 && intval($user_id) > 0) {
            $storeObj = new M($this->storeProduct);
            $data = $storeObj->fields('id')->where('id=:id AND user_id=:user_id AND status=:status')->bind(array('id'=>$id, 'user_id' => $user_id, 'status' => 4))->getObj();

            if (!empty($data)) {
                return true;
            }
        }
        return false;
    }

     /**
     * 生成仓单
     * @param array $productData 商品数据
     * @param array $storeData 仓库数据
     */
    public function createStoreProduct($productData,$storeData){
        $productObj = new product();
        $storeProductObj = new M($this->storeProduct);
        //验证商品数据和仓单数据
        if($productObj->proValidate($productData) && $storeProductObj->validate($this->storeProductRules,$storeData)){
            $storeProductObj->beginTrans();
            $pId = $storeProductObj->table('products')->data($productData[0])->add(1);
            $imgData = $productData[1];
            if (intval($pId) > 0) {
                //插入图片数据
                if (!empty($imgData)) {
                    foreach ($imgData as $key => $imgUrl) {
                        $imgData[$key]['products_id'] = $pId;
                    }
                    $storeProductObj->table('product_photos')->data($imgData)->adds(1);

                }
                //插入仓单数据
                $storeData['product_id'] = $pId;
                $storeProductObj->table($this->storeProduct)->data($storeData)->add(1);
            }
            $res = $storeProductObj->commit();
        }
        else{
            $res = $productObj->getErrorMessage();
            $res = $storeProductObj->getError();
        }
        if($res===true){
            $resInfo = Tool::getSuccInfo();
        }
        else{
            $resInfo = Tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
        }
        return $resInfo;


    }


}


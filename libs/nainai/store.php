<?php
/**
 * �ֿ������
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

     private $storeProduct = 'store_products';//�ֵ����ݱ�
    //�ֵ����ݹ���
     protected $storeProductRules = array(
        array('store_id', 'number', '����ѡ��ֿ�!'),
        array('product_id', 'number', '����д��Ʒ��Ϣ'),
        array('package', 'number','��ѡ���Ƿ���!')
    );

    public function getStatus(){
        return array(
            0 => 'δ���',
            1 => '���ͨ��'
        );
    }

     /**
     * ��ȡ�ֿ��б�
     * @return mixed
     */
    public static function getStoretList(){
        $storeModel = new M('store_list');
        $where  = array('status' => 1);
        return $storeModel->table('store_list')->fields('id, name, short_name, area, address')->where($where)->select();
    }

   
 /**
     * ��ȡ�ֵ��б�
     * @param  [Int] $page     
     * @param  [Int] $pagesize 
     * @return [Array]       ]
     */
    public function getApplyStoreList($page, $pagesize){
         //�ֵ��б�
        $query = new Query('store_list as b');
        $query->fields = 'a.id, b.name as sname, a.status, c.name as pname,  d.name as cname, c.attribute, a.package_unit, a.package_weight';
        $query->join = ' RIGHT JOIN (store_products as a LEFT JOIN products as c ON a.product_id = c.id ) ON a.store_id=b.id LEFT JOIN product_category as d  ON c.cate_id=d.id';
        $query->page = $page;
        $query->pagesize = $pagesize;
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

        if (!empty($attr_id)) {
            $attrObj = new M('product_attribute');
            $attr_id = $attrObj->fields('id, name')->where('id IN (' . implode(',', $attr_id) . ')')->select();
            foreach ($attr_id as $value) {
               $attrs[$value['id']] = $value['name']; 
            }
        }
        
        return array('list' => $storeList, 'pageHtml' => $query->getPageBar(), 'attrs' => $attrs);
    }

    /**
     * ��ȡ�ֵ�����
     * @param  [Int] $id [�ֵ�id]
     * @return [Array]    
     */
    public function getApplyStoreDetails($id){

        $query = new Query('store_products as a');
        $query->fields = 'a.id, a.product_id, b.name as sname, a.package_num, a.package_unit, a.package_weight, a.package';
        $query->join = ' LEFT JOIN store_list as b ON a.store_id = b.id';
        $query->where = ' a.id = '.$id;
        $storeDetail = $query->getObj();

        $imgObj = new M('product_photos');
        $storeDetail['imgData'] = $imgObj->fields('id, img')->where('products_id = ' .  $storeDetail['product_id'])->select();

        return $storeDetail;
    }

    public function UpdateApplyStore( & $store, $id){
         $storeProductObj = new M($this->storeProduct);
        return  $storeProductObj->data($store)->where('id = '. $id)->update(0);
    }

     /**
     * ���ɲֵ�
     * @param array $productData ��Ʒ����
     * @param array $storeData �ֿ�����
     */
    public function createStoreProduct($productData,$storeData){
        $productObj = new product();
        $storeProductObj = new M($this->storeProduct);
        //��֤��Ʒ���ݺͲֵ�����
        if($productObj->proValidate($productData) && $storeProductObj->validate($this->storeProductRules,$storeData)){
            $storeProductObj->beginTrans();
            $pId = $storeProductObj->table('products')->data($productData[0])->add(1);
            $imgData = $productData[1];
            if (intval($pId) > 0) {
                //����ͼƬ����
                if (!empty($imgData)) {
                    foreach ($imgData as $key => $imgUrl) {
                        $imgData[$key]['products_id'] = $pId;
                    }
                    $storeProductObj->table('product_photos')->data($imgData)->adds(1);

                }
                //����ֵ�����
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
            $resInfo = Tool::getSuccInfo(0,is_string($res) ? $res : 'ϵͳ��æ�����Ժ�����');
        }
        return $resInfo;


    }


}

<?php
/**
 * ��Ʒ������
 * author: weipinglee
 * Date: 2016/4/19
 * Time: 13:31
 */
namespace nainai;
use \Library\M;
use \Library\Time;
use \Library\Query;
use \Library\Thumb;
use \Library\log;
use \Library\tool;
class product{

    private $product_limit = 5;

    private $_errorInfo = '';
    /**
     * ��Ʒ��֤����
     * @var array
     */
    protected $productRules = array(
        array('name','require','��Ʒ���Ʊ�����д'),
        // array('cate_id','number','��Ʒ����id����'),
        array('price','double','��Ʒ�۸����������'),
        array('quantity','number','������������������'),
        array('attribute', 'require', '��ѡ����Ʒ����'),
        array('note', 'require', '��Ʒ����������д')
    );

    /**
     * ������֤����
     * @var array
     */
    protected $offerRules = array(
        array('product_id', 'number', '��������Ʒid'),
        array('mode', 'number', '�����б�������'),
        array('divide', 'number','�Ƿ�ɲ�ֵ�id����'),
        array('accept_area', 'require', '���յص������д'),
        array('accept_day', 'number', '����ʱ�������д')
    );



    /**
     * pdo�Ķ���
     * @var [Obj]
     */
    private $_productObj;

    public function __construct(){
        $this->_productObj = new M('products');
    }

    public function getErrorMessage(){
        return $this->_errorInfo;
    }

    public function setErrorMessage($mess){
        $this->_errorInfo = $mess;
    }

    /**
     * ��ȡ�ּ��ķ���
     * @param int $gid
     * @return array array('chain'=>,'default'=>,1=>,2=>);
     */
    public function getCategoryLevel($pid = 0){
        $where  = array('status' => 1);
        $categorys=array();
        $category = $this->_productObj->table('product_category')->fields('id,pid, name, unit, childname, attrs')->where($where)->select();
        foreach ($category as $key => $cate) {
            $categorys[$cate['pid']][] = $cate;
        }
        $pid_chain = array();//���������������������

        if($pid!=0){
            $pid_chain[] = $pid;
            $parent_id = $pid;
            while($parent_id!=0){
                $parent_id = $this->getParentCateId($parent_id);
                $pid_chain[] = $parent_id;
            }
        }

        return $this->getTree($categorys,$pid,1,$pid_chain);
    }

    /**
     * �ҳ���������id
     * @param $id
     */
    private function getParentCateId($id){
        return $this->_productObj->table('product_category')->where(array('id'=>$id))->getField('pid');
    }




    /**
     * [getTree ��ȡ������Ϣ��,Ĭ�ϻ�ȡ��һ���������������]
     * @param  [type]  $list [������Ϣ]
     * @param  integer $pid  [pid]
     * @param array $chain ����������
     * @return [type]        [description]
     */
    private function getTree(& $list,  $pid=0, $level=1,$chain=array()){
        $last = 0;
        static $category = array();
        if(!empty($chain))
            $category['chain'] = $chain;
        if(isset($list[$pid])){
            foreach ($list as $p => $cate) {//$p�Ǹ����id
                if ($p == $pid) {
                    if ($last == 0) {
                        $last = $cate[0]['id'];
                        $category['chain'][] = $last;
                        $category['default'] = $last;
                    }
                    foreach($cate as $k=>$v){
                        $m = new M('product_category');
                        $childname = $m->where(array('id'=>$pid))->getField('childname');
                        $category['cate'][$level]['childname'] = $childname ? $childname : '';
                        if($k+1<=$this->product_limit){
                            $category['cate'][$level]['show'][] = $v;
                        }
                        else
                            $category['cate'][$level]['hide'][] = $v;
                    }

                }
            }
            if ($last == 0) {
                return array();
            }else{
                $level++;
                $this->getTree($list, $last, $level);
            }
        }
        else{
            $category['default'] = $pid;
        }

        return $category;
    }
    /**
     *��ȡ���з�������ԣ�ȥ���ظ�
     * @param array $cates ��������,array(2,3)
     * @return mixed
     */
    public function getProductAttr($cates=array()){
        if(empty($cates))
            return array();
        $attrs = $this->_productObj->table('product_category')->fields('attrs')->where('id in ('.join(',',$cates).')')->select();

        $attr_arr = array();
        foreach($attrs as $v){
            if($v['attrs']!='')
                $attr_arr = array_merge($attr_arr,explode(',',$v['attrs']));
        }
        if(empty($attr_arr))
            return array();
        return $this->_productObj->table('product_attribute')->where('id in ('.join(',',$attr_arr).')')->select();
    }

    /**
     * ��֤��Ʒ�����Ƿ���ȷ
     * @param array $productData ��Ʒ����
     * @return bool
     */
    public function proValidate($productData){
        if($this->_productObj->validate($this->productRules,$productData)){
            return true;
        }

        return false;

    }



    /**
     * ���뱨������
     * @param  array $productData ��Ʒ����
     * @param array $productOffer ��������
     * @return [Boolean]
     */
    public function insertOffer(&$productData,&$productOffer){
        if($this->_productObj->validate($this->offerRules, $productOffer) && $this->proValidate($productData)){
            $this->_productObj->beginTrans();
            $pId = $this->_productObj->data($productData[0])->add(1);
            $imgData = $productData[1];
            if (intval($pId) > 0) {
                //����ͼƬ����
                if (!empty($imgData)) {
                    foreach ($imgData as $key => $imgUrl) {
                        $imgData[$key]['products_id'] = $pId;
                    }
                    $this->_productObj->table('product_photos')->data($imgData)->adds(1);

                }
                //���뱨������
                $this->_productObj->table('product_offer')->data($productOffer)->add(1);
            }
            $res = $this->_productObj->commit();

        }
        else{
            $this->setErrorMessage($this->_productObj->getError());
            $res = $this->_errorInfo;
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
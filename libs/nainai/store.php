<?php
/**
 * �ֿ������
 * author: weiping
 * Date: 2016/4/21
 * Time: 8:18
 */
namespace nainai;
use \Library\M;
use \nainai\product;
use \Library\Tool;
class store{


    private $storeProduct = 'store_products';//�ֵ����ݱ�
    //�ֵ����ݹ���
    private $storeProductRules = array(
        array('store_id','number','�ֿ�id����������'),

    );

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

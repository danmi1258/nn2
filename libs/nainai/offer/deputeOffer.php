<?php
/**
 * ί�б��̹���
 * author: weipinglee
 * Date: 2016/5/7
 * Time: 23:43
 */

namespace nainai\offer;

class deputeOffer extends product{

    /**
     * ��ȡί�б��̷���
     * @return int
     */
    public function getFeeRate($user_id){
        return 20;
    }


    /**
     * ���̲�������
     * @param array $productData  ��Ʒ����
     * @param array $offerData ��������
     */
    public function doOffer($productData,$offerData){
        $offerData['mode'] = self::DEPUTE_OFFER;
        $this->_productObj->beginTrans();
        $offerData['user_id'] = $this->user_id;
        $insert = $this->insertOffer($productData,$offerData);

        if($insert===true){
            if($this->_productObj->commit()){
                return true;
            }
            else return $this->errorCode['server'];
        }
        else{
            $this->_productObj->rollBack();
            $this->errorCode['dataWrong']['info'] = $insert;
            return $this->errorCode['dataWrong'];
        }
    }
}
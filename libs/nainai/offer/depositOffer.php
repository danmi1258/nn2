<?php
/**
 * ��֤���̹�����
 * author: weipinglee
 * Date: 2016/5/7
 * Time: 23:16
 */
namespace nainai\offer;

class depositOffer extends product{

    /**
     * ��ȡ��֤����ȡ���� TODO
     */
    public function getDepositRate($user_id){
        return 10;
    }

    /**
     * ���������������
     * @param array $productData  ��Ʒ����
     * @param array $offerData ��������
     */
    public function doOffer($productData,$offerData){
        $offerData['mode'] = self::DEPOSIT_OFFER;
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
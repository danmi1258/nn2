<?php
/**
 * 保证金报盘管理类
 * author: weipinglee
 * Date: 2016/5/7
 * Time: 23:16
 */
namespace nainai\offer;
use \Library\tool;
class depositOffer extends product{

    /**
     * 获取保证金收取比例 TODO
     */
    public function getDepositRate($user_id){
        $obj = new \nainai\member();
        $res=$obj->getUserGroup($user_id);
        return $res['caution_fee'];
    }

    /**
     * 报盘申请插入数据
     * @param array $productData  商品数据
     * @param array $offerData 报盘数据
     */
    public function doOffer($productData,$offerData){
        $offerData['mode'] = self::DEPOSIT_OFFER;
        $offerData['expire_time'] = $this->getExpireTime();
        $this->_productObj->beginTrans();
        $offerData['user_id'] = $this->user_id;
        $insert = $this->insertOffer($productData,$offerData);

        if($insert===true){
            if($this->_productObj->commit()){
                return tool::getSuccInfo();
            }
            else return tool::getSuccInfo(0,$this->errorCode['server']['info']);
        }
        else{
            $this->_productObj->rollBack();
            $this->errorCode['dataWrong']['info'] = $insert;
            return tool::getSuccInfo(0,$this->errorCode['dataWrong']['info']);
        }

    }
}
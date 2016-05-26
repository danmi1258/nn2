<?php 

/**
 * 保证金提货
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;

class DepositDeliveryController extends DeliveryController{

	//卖家发货
	public function sellerConsignmentAction(){
		$delivery_id = safe::filter($this->_request->getParam('id'),'int');
		$user_id = 36;//$this->user_id;
		$deposit = new \nainai\delivery\DepositDelivery();
		$res = $deposit->sellerConsignment($delivery_id,$user_id);

		if($res['success'] == 1){
			$this->redirect(url::createUrl('/Delivery/deliveryList?is_seller=1'));
		}else{
			die($res['info']);
		}
	}

	//买家确认收货
	public function buyerConfirmAction(){
		$delivery_id = safe::filter($this->_request->getParam('id'),'int');
		$user_id = 36;

		$deposit = new \nainai\delivery\DepositDelivery();
		$res = $deposit->buyerConfirm($delivery_id,$user_id);
		
		if($res['success'] == 1){
			$this->redirect(url::createUrl('/Delivery/deliveryList'));
		}else{
			die($res['info']);
		}

	}
}
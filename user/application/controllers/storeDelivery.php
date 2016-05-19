<?php 

/**
 * 仓单提货
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;

class StoreDeliveryController extends DeliveryController{

	//生成提货表
	public function geneDeliveryAction(){
		$order_id = 2;
		$num = 1;

		$deliveryData['order_id'] = $order_id;
		$deliveryData['num'] = $num;
		$deliveryData['user_id'] = 49;

		$store = new \nainai\delivery\StoreDelivery();
		$res = $store->geneDelivery($deliveryData);

		var_dump($res);exit;
	}

	//卖家支付仓库管理费用
	public function storeFeesAction(){
		$delivery_id = safe::filter($this->_request->getParam('id'));
		$user_id = 44;//$this->user_id;

		$store = new \nainai\delivery\StoreDelivery();
		$res = $store->storeFees($delivery_id,$user_id);

		if($res['success'] == 1){
			$this->redirect(url::createUrl('/Delivery/deliveryList?is_seller=1'));
		}else{
			die($res['info']);
		}
	}

	//模拟仓库管理员确认出货
	public function managerCheckoutAction(){
		$delivery_id = 5;

		$store = new \nainai\delivery\StoreDelivery();
		$res = $store->managerCheckout($delivery_id);
		var_dump($res);exit;

	}

	//模拟后台管理员进行审核
	public function adminCheckAction(){
		$delivery_id = 5;

		$store = new \nainai\delivery\StoreDelivery();
		$res = $store->adminCheck($delivery_id);

		var_dump($res);exit;
	}
}
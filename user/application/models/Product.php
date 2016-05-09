<?php

use \Library\Query;
use \Library\tool;
use \Library\M;
/**
 * 商品模型
 * @author zengmaoyong 
 */
class productModel extends \nainai\offer\product{


	/**
	 * 获取报盘对应的产品列表
	 * @param  [Int] $page     [分页]
	 * @param  [Int] $pagesize [分页]
	 * @param  string $where    [where的条件]
	 * @param  array  $bind     [where绑定的参数]
	 * @return [Array.list]           [返回的对应的列表数据]
	 * @return [Array.pageHtml]           [返回的分页html数据]
	 */
	public function getOfferProductList($page, $pagesize, $where='', $bind=array()){
		$query = new Query('product_offer as c');
		$query->fields = 'c.id, a.name, b.name as cname, a.quantity, a.price, a.expire_time, c.status, c.mode, a.user_id, c.apply_time';
		$query->join = '  LEFT JOIN products as a ON c.product_id=a.id LEFT JOIN product_category as b ON a.cate_id=b.id ';
		$query->page = $page;
		$query->pagesize = $pagesize;
		$query->order = ' a.create_time desc';

		if (empty($where)) {
			$where = ' c.mode IN (1, 2,3, 4) ';
		}else{
			$where .= ' AND c.mode IN (1, 2,3, 4) ';
			$query->bind = $bind;
		}

		$query->where = $where;
		$list = $query->find();
		return array('list' => $list, 'pageHtml' => $query->getPageBar());
	}


	/**
	 * 获取报盘的状态
	 * @return [Array]
	 */
	public function getStatus(){
		return array(
			self::OFFER_APPLY => '审核中',
			self::OFFER_OK => '发布成功',
			self::OFFER_NG => '被驳回',
			self::OFFER_EXPIRE => '已过期'
		);
	}


	/**
	 * 获取对应id的报盘和产品详情数据
	 * @param  [Int] $id [报盘id]
	 * @return [Array]     [报盘和产品数据]
	 */
	public function getOfferProductDetail($id,$user_id){
		$query = new M('product_offer');
		$offerData = $query->where(array('id'=>$id,'user_id'=>$user_id))->getObj();
		$status =  $this->getStatus();
		$offerData['status_txt'] = isset($status[$offerData['status']]) ? $status[$offerData['status']] : '未知';
		$productData = $this->getProductDetails($offerData['product_id']);
		return array($offerData,$productData);
	}


}
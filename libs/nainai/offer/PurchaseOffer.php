<?php
namespace nainai\offer;

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;

/**
 * 采购报盘操作对应的api
 * @author maoyong.zeng <zengmaoyong@126.com>
 * @copyright 2016年06月07日
 */
class PurchaseOffer extends product {

	CONST OFFER_TYPE =  2;

	/**
	* 报盘验证规则
	* @var array
	*/
	protected $productOfferRules = array(
		array('product_id', 'number', '必须有商品id'),
		array('acc_type','/^[\d+,?]+$/','账户类型错误'),
		array('offer_fee','currency','金额错误'),
		array('sign','/^[a-zA-Z0-9_@\.\/]+$/','请上传图片'),
		array('accept_area', 'require', '交收地点必须填写'),
		array('accept_day', 'number', '交收时间必须填写')
	);

	/**
	* 报盘申请插入数据
	* @param array $productData  商品数据
	* @param array $offerData 报盘数据
	*/
	public function doOffer(&$productData, &$offerData){
		$this->_productObj->beginTrans();
		if ($this->_productObj->validate($this->productRules,$productData) && $this->_productObj->validate($this->productOfferRules, $offerData)){

			$pId = $this->_productObj->table('products')->data($productData[0])->add();
			$offerData['product_id'] = $pId;
			$offerData['type'] = self::OFFER_TYPE;
			if (intval($pId) < 0) {
				$this->_productObj->rollBack();
				return tool::getSuccInfo(0, $this->_productObj->getError());
			}

			$this->_productObj->table('product_offer')->data($offerData)->add(1);
			$imgData = $productData[1];
			if (!empty($imgData)) {
				foreach ($imgData as $key => $imgUrl) {
					$imgData[$key]['products_id'] = $pId;
				}
				$this->_productObj->table('product_photos')->data($imgData)->adds(1);
			}
			if($this->_productObj->commit()){
		        		return tool::getSuccInfo();
		    	}
		    	else return tool::getSuccInfo(0, $this->_productObj->getError());
		}else{
			return tool::getSuccInfo(0,  $this->_productObj->getError());
		}
	

	}

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
		$query->fields = 'c.id, c.price,c.price_r,a.name, b.name as cname, a.quantity,a.unit, a.expire_time, c.status, a.user_id, c.apply_time';
		$query->join = '  LEFT JOIN products as a ON c.product_id=a.id LEFT JOIN product_category as b ON a.cate_id=b.id ';
		$query->page = $page;
		$query->pagesize = $pagesize;
		$query->order = ' c.apply_time desc';

		$query->where = $where;
		$query->bind = $bind;

		$list = $query->find();
		foreach($list as $k=>$v){
			$list[$k]['status'] = $this->getStatus($list[$k]['status']);
		}
		return array('list' => $list, 'pageHtml' => $query->getPageBar());
	}

	/**
	 * 获取对应id的报盘和产品详情数据
	 * @param  [Int] $id [报盘id]
	 * @return [Array]     [报盘和产品数据]
	 */
	public function getOfferProductDetail($id,$user_id=0){
		$query = new M('product_offer');
		$where = array('id'=>$id, 'type' => self::OFFER_TYPE);
		if (intval($user_id) > 0) {
			$where['user_id'] = $user_id;
		}
		$offerData = $query->where($where)->getObj();
		$offerData['status_txt'] = $this->getStatus($offerData['status']);
		$productData = $this->getProductDetails($offerData['product_id']);
		return array($offerData,$productData);
	}

	

}
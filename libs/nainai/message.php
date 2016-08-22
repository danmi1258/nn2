<?php 
/**
 * 用户消息通知类
 * author :wangzhande
 * Date :2015/5/12
 */
namespace nainai;
use \Library\M;
use \Library\Query;
class message{
	//用户id 
	private $user_id="";
	//通知类型
	private static $type=array(
		'orderPay',
		'fundOut',
		'depositPay',
		'newbankaccount',
		'breakcontract',
		'register',
		'dealer',
		'store_manager',
		'ApplyResetpay'
	);
	/**
	 * [__construct 构造方法]
	 * @param     [type]      $user_id 用户id
	 */
	public function __construct($user_id){
		$this->user_id=$user_id;
	}
	private $messCode=array(
		'sendOk'=>array('code'=>1,'info'=>'发送成功'),
		'sendWrong'=>array('code'=>0,'info'=>'发送失败'),
		'typeWrong'=>array('code'=>0,'info'=>'类型不存在')
		);
	/**
	 * [send  发送消息]
	 * @param   $type    通知类型
	 * @param   $param 订单id,
	 * @return    [type]             [description]
	 */
	public function send($type,$param=0){
		if(in_array($type, self::$type)){
			$mess=call_user_func(array(__CLASS__,$type),$param);
			$mess['user_id']=$this->user_id;
			$mess['send_time']= \Library\Time::getDateTime();
			$messObj=new M('message');
			if($messObj->data($mess)->add()){
				return $this->messCode['sendOk'];
			}else{
				return $this->messCode['sendWrong'];
			}


		}else{
			return $this->messCode['typeWrong'];
		}
	}
	/**
	 * [order_pay 支付通知]
	 * @param     [type]      $order_id 
	 * @return    [type]                [内容]
	 */
	public function orderPay($order_id){
		$title='支付通知';
		$message="您的订单".$order_id."已经形成,请在多少时间内支付 <a href='?order_id={$order_id}'></a>";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function breakcontract($order_id){
		$title="违约";
		$message="您的订单".$order_id."已被判为违约";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function depositPay($order_id){
		$title="保证金支付";
		$message="您的订单".$order_id."需支付保证金";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function buyerRetainage($order_id){
		$title="尾款通知";
		$message="您的订单".$order_id."买家已支付尾款";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function buyerProof($order_id){
		$title="请确认支付凭证";
		$message="您的订单".$order_id."买家已上传支付凭证";
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function newbankaccount(){
		$title = '开户提醒';
		$message='有买家要通过线下支付货款，请尽快开户';
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	//注册
	public function register(){
		$title = '注册提醒';
		$message='（您好，您已注册成功。为了您更好的交易，请及时进行认证。 ）<a href=" ' .\Library\url::createUrl('/ucenter/dealcert'). ' ">点击消息，跳转到认证界面！</a>';
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	public function dealer($status){
		$title = '交易商认证提醒';
		if ($status == 2) {
			$message = '您好，您已成功认证交易商。';
		}else{
			$message = '很遗憾，您申请的交易商认证未通过审核，您可以修改相关信息再次进行申请';
		}
		return array(
			'title'=>$title,
			'content'=>$message);
	}

	public function store_manager($status){
		$title = '仓库管理员认证提醒';
		if ($status == 2) {
			$message = '您好，您已成功认证仓库管理员。';
		}else{
			$message = '很遗憾，您申请的仓库管理员认证未通过审核，您可以修改相关信息再次进行申请';
		}
		return array(
			'title'=>$title,
			'content'=>$message);
	}

	public function ApplyResetpay($status){
		$title = '仓库管理员认证提醒';
		if ($status == 0) {
			$message = '很遗憾，您的忘记支付密码申诉未能通过审核。您可以修改相关信息再次进行申诉，或联系客服解决。';
		}else{
			$message = '您好，您的忘记支付密码申诉已通过审核。新密码已于短信的形式发送到你的手机，为了资金安全请您及时进行修改。';
		}
		return array(
			'title'=>$title,
			'content'=>$message);
	}
	/**
	 * [fundOut 提现通知]
	 * @param     [type]      $order_id [订单id]
	 * @return    [type]                [通知内容]
	 */
	public function fundOut($order_id){
		$title='提现通知';
		$message='您的提现订单号为：'.$order_id;
		return array(
			'title'=>$title,
			'content'=>$message
			);

	}
	/**
	 * [isReadMessage 获取已读消息]
	 */
	public function isReadMessage(){
		$messObj=new Query('message');
		$messObj->fields='id,title,content,send_time';
		$messObj->where='user_id = :user_id and write_time is NOT NULL';
		$messObj->bind=array('user_id'=>$this->user_id);
		return $messObj->find();

	}
	/**
	 * [getNeedmessage 获取未读信息]
	 * @return    [type]      [description]
	 */
	public function getNeedMessage(){
		$messObj=new Query('message');
		$messObj->fields='id,title,content,send_time';
		$messObj->where='user_id = :user_id and write_time is NULL';
		$messObj->bind=array('user_id'=>$this->user_id);
		return $messObj->find();
	}
	//获取未读消息的总数
	public function getCountMessage(){
		$res=$this->getNeedMessage();
		return count($res);

	}
	/**
	 * [writeMess 写入阅读时间]
	 * @param     [type]      $message_id [消息id]
	 * @return    [type]                  [description]
	 */
	public function writeMess($message_id){
		$messObj=new M('message');
		$where=array('id'=>$message_id);
		$data['write_time']=\Library\Time::getDateTime();
		return $messObj->where($where)->data($data)->update();
	}

	/**
	 * 获得所有消息
	 * @param int $page
	 * @return array
     */
	public function getAllMessage($page=1){
		$messObj=new Query('message');
		$messObj->where='user_id= :user_id';
		$messObj->bind=array('user_id'=>$this->user_id);
		$messObj->order='send_time desc';
		$messObj->page=$page;
		$messInfo=$messObj->find();
		$bar=$messObj->getPageBar();
		return array($messInfo,$bar);
	}

	/**
	 * 批量删除消息
	 * @param $ids
     */
	public function batchDel($ids){
		$messObj=new M('message');
		$where='id in ('.$ids.')';
		return $messObj->where($where)->delete();
	}

	/**
	 * 单个删除消息
	 * @param $id
	 * @return mixed
     */
	public function delMessage($id){
		$messObj=new M('message');
		$where=array('id'=>$id);
		return $messObj->where($where)->delete();

	}
}

?>
<?php
namespace nainai;

use \Library\M;
use \Library\Query;
use \Library\Tool;

class AdminMsg extends \nainai\Abstruct\ModelAbstract{


	protected $tableName = 'admin_msg';

	protected $id = 0;

	protected $msgType = array(
		'checkoffer'=>array(
			'url' => 'trade/offermanage/reviewdetails/id/',
			'url_oper' => 'trade/offermanage/setstatus',
			'title' => '报盘审核',
		),
	);

	/**
	 * 生成一条消息数据
	 * @param int $id 关键性参数 ,一般是id
	 * @param string $content 内容
	 * @param string $title 标题
	 */
	public function createMsg($type , $id,$content='',$title=''){
		$this->id = $id;
		if(!isset($this->msgType[strtolower($type)])){
			return false;
		}
		$msg = $this->msgType[strtolower($type)];
		$msg['args'] = $id;
		if($title){
			$msg['title'] = $title;
		}
		if($content){
			$msg['content'] = $content;
		}

		$msg['status'] = 0;
		$msg['create_time'] = \Library\time::getDateTime();
		return $this->model->data($msg)->add();
 	}

	/**
	 * 获取某个管理员的通知信息
	 * @param $admin_id
	 * @return mixed
	 */
	public function getmsg($admin_id)
	{
		$where = 'status = 0 and find_in_set('.$admin_id.',visited) = 0';
		return $this->model->where($where)->select();
	}
	/**
	 * 设置用户已访问
	 * @param Int $uid 管理员用户id
	 * @param Int $id  通知id
	 */
	public function setVisit($uid, $id){
		if (intval($uid) > 0 && intval($id) > 0) {
			$visited = $this->model->where(array('id'=>$id))->getField('visited');
			$res = $this->model->where(array('id'=>$id))->data(array('visited'=>$visited.','.$uid))->update();
			return $res;
		}

		return false;
	}

	/**
	 * 设置信息已执行
	 * @param string $url_oper 操作url
	 * @param $id 参数
	 * @return mixed
	 */
	public function setStatus($controller,$id){
		if (intval($id) > 0) {
			$module = $controller->getRequest()->getModuleName();
			$contr = $controller->getRequest()->getControllerName();
			$action = $controller->getRequest()->getActionName();
			$url_oper = strtolower($module).'/'.strtolower($contr).'/'.strtolower($action);
			 $this->model->where(array('url_oper'=>$url_oper,'args'=>$id))->data(array('status' => 1))->update();
		}
	}
}
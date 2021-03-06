<?php 

use \Library\Safe;
class OperController extends UcenterBaseController{

	public function successAction(){
		$info = safe::filter($this->_request->getParam('info'));
		$redirect = safe::filter($this->_request->getParam('redirect'));

		$this->getView()->assign('info',$info);
		$this->getView()->assign('redirect',urldecode(str_replace('||','%',$redirect)));
	}

	public function errorAction(){
		$info = safe::filter($this->_request->getParam('info'));
		$redirect = safe::filter($this->_request->getParam('redirect'));

		$this->getView()->assign('info',$info);
		$this->getView()->assign('redirect',urldecode(str_replace('||','%',$redirect)));
	}

	public function confirmAction(){
		$info = safe::filter($this->_request->getParam('info'));
		$redirect = safe::filter($this->_request->getParam('redirect'));

		$this->getView()->assign('info',$info);
		$this->getView()->assign('redirect',urldecode(str_replace('||','%',$redirect)));
	}
}
 ?>

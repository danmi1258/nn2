<?php
/**
 * @name storeController
 * @author weipinglee
 * @desc �û����������
 */
use \Library\safe;
use \Library\Thumb;
use \nainai\subRight;
use \Library\tool;
class storeProductController extends Yaf\Controller_Abstract{

    public function init(){
        $this->getView()->setLayout('admin');
        //echo $this->getViewPath();
    }

    /**
     * ��ȡ�ֵ��б�
     */
   public function getListAction(){
       $page = safe::filterGet('page','int',1);
        $obj = new storeProductModel();
       $data = $obj->getList($page);
       $this->getView()->assign('list',$data['list']);
       $this->getView()->assign('attr',$data['attrs']);
       $this->getView()->assign('bar',$data['pageHtml']);
    }

    /**
     * ����˲ֵ�
     */
    public function checkListAction(){
        $page = safe::filterGet('page','int',1);
        $obj = new storeProductModel();
        $data = $obj->getApplyList($page);
        $this->getView()->assign('list',$data['list']);
        $this->getView()->assign('attr',$data['attrs']);
        $this->getView()->assign('bar',$data['pageHtml']);
    }




}
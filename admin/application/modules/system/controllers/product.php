<?php
/**
 * @name storeController
 * @author weipinglee
 * @desc �û����������
 */
use \Library\safe;
use \nainai\certificate;
use \Library\Thumb;
use \nainai\subRight;
use \Library\tool;
class productController extends Yaf\Controller_Abstract{

    public function init(){
        $this->getView()->setLayout('admin');

    }



    /**
     *�ֿ����
     */
    public function categoryAddAction(){
        $productModel = new productModel();
        if(IS_POST){//�༭������
            $cate['id'] = safe::filterPost('id','int',0);
            $cate['name'] = safe::filterPost('name');
            $cate['childname'] = safe::filterPost('childname');
            $cate['pid']       = safe::filterPost('pid','int',0);
            $cate['sort']      = safe::filterPost('sort','int',0);
            $cate['note']      = safe::filterPost('note');
            $productModel->cateAdd($cate);
            $this->redirect('categoryList');

        }else{
            $cate_id  = $this->getRequest()->getParam('cid',0);
            $cate_id = safe::filter($cate_id,'int');
            if($cate_id){
                $cateData = $productModel->getCateInfo($cate_id);
                $this->getView()->assign('cate',$cateData);
            }
            $cateTree = $productModel->getCateTree();
print_r($cateTree);
            $this->getView()->assign('tree',$cateTree);
        }
    }




}
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
     *�������
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
            $cate['attrs']     = implode(',',safe::filterPost('attrs','int',''));

            $res = $productModel->cateAdd($cate);
            if($res['success']==1){
                $this->redirect('categoryList');
            }
            else{
                echo $res['info'];
                return false;
            }


        }else{
            $cate_id  = $this->getRequest()->getParam('cid',0);
            $cate_id = safe::filter($cate_id,'int');
            if($cate_id){
                $cateData = $productModel->getCateInfo($cate_id);
                if(!empty($cateData))
                    $this->getView()->assign('cate',$cateData);
            }
            $cateTree = $productModel->getCateTree();//��ȡ������

            //��ȡ��������
            $attr = $productModel->getAttr();

            $this->getView()->assign('tree',$cateTree);
            $this->getView()->assign('attr',$attr);
        }
    }

    /**
     * �����б�
     *
     */
    public function categoryListAction(){
        $productModel = new productModel();
        $cateTree = $productModel->getCateTree();//��ȡ������
        $attrs    = $productModel->getAttr();//��ȡ��������

        //�������������idת��Ϊ��������
        foreach($cateTree as $key=>$val){
            $temp = '';
            $attr = explode(',',$val['attrs']);
            foreach($attr as $k=>$v){
                $temp .= isset($attrs[$attr[$k]]['name']) ? $attrs[$attr[$k]]['name'] .',' : '';
            }
            $temp = rtrim($temp,',');
            $cateTree[$key]['attrs'] =$temp;

        }
        $this->getView()->assign('cate',$cateTree);
    }

    /**
     * �������
     */
    public function attributeAddAction(){
        $productModel = new productModel();
        if(IS_POST){
            $attr['id']    = safe::filterPost('id','int',0);
            $attr['name']  = safe::filterPost('name');
            $attr['value'] = safe::filterPost('value');
            $attr['type']  = safe::filterPost('type','int',1);
            $attr['sort']  = safe::filterPost('sort','int',0);
            $attr['note']  = safe::filterPost('note');
            $res = $productModel->attrAdd($attr);
            if($res['success']==1)
                 $this->redirect('attributeList');
            else
                echo $res['info'];
        }
        else{
            $attr_id  = $this->getRequest()->getParam('aid',0);
            $attr_id = safe::filter($attr_id,'int',0);
            if($attr_id){
                $attrData = $productModel->getAttrInfo($attr_id);
                if(!empty($attrData))
                    $this->getView()->assign('attr',$attrData);
            }
        }
    }





}
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
use \Library\json;
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
            $cate['unit'] = safe::filterPost('unit');
            $cate['percent'] = safe::filterPost('percent','int',100);
            $cate['pid']       = safe::filterPost('pid','int',0);
            $cate['sort']      = safe::filterPost('sort','int',0);
            $cate['note']      = safe::filterPost('note');

            $attrs = safe::filterPost('attr_id','int','');
            $cate['attrs']     = $attrs=='' ? '' : implode(',',array_unique($attrs));

            $res = $productModel->updateCate($cate);
            die(json::encode($res));


        }else{
            $cate_id  = $this->getRequest()->getParam('cid',0);
            $cate_id = safe::filter($cate_id,'int');
            //��ȡ��������
            $attr = $productModel->getAttr();
            if($cate_id){
                $cateData = $productModel->getCateInfo($cate_id);
                if(!empty($cateData)){
                    $attr_arr = explode(',',$cateData['attrs']);
                    $attr_sel = array();
                    foreach($attr_arr as $v){
                        if($v=='')
                            continue;
                        $attr_sel[$v] = $attr[$v]['name'];
                    }
                    $this->getView()->assign('attr_sel',$attr_sel);
                    $this->getView()->assign('cate',$cateData);
                }


            }
            $cateTree = $productModel->getCateTree();//��ȡ������



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

    /**
     * �����б�
     */
    public function attributeListAction(){
        $page = safe::filterGet('page','int',1);
        $productModel = new productModel();
        $attrs    = $productModel->getAttr($page);//��ȡ��������


        $this->getView()->assign('attr',$attrs);
    }





}
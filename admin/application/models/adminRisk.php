<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/5
 * Time: 14:21
 */
use Library\tool;
class adminRiskModel
{
    public $loginTimes=3;
    /**
     * @param array $params['admin_id','ip'];
     */
    public function checkAdminAdd($params= array()){
        if(!isset($params['admin_id'])&&!is_int($params['admin_id'])){
            return \Library\tool::getSuccInfo(0,'admin_id不正确');
        }
        if(!isset($params['ip'])){
            return \Library\tool::getSuccInfo(0,'ip不正确');
        }
        $ipModel=new \nainai\riskMgt\userRisk();
        $cityInfo=$ipModel->getIpInfo($params['ip']);
        $adminRiskObj=new \Library\M('admin_often_use_address');
        if(!$adminRiskObj->where(['admin_id'=>$params['admin_id']])->getObj()){
            $this->addUseAddress($params,true);
            return true;
        }else{
            $where['city_name']=$cityInfo['city'];
            $where['admin_id']=$params['admin_id'];
            $where['status']=1;
            if(!$addInfo=$adminRiskObj->where($where)->getObj()){
                $data['admin_id']=$params['admin_id'];
                $data['introduce']='在'.$cityInfo['region'].$cityInfo['city'].$cityInfo['county'].'登录';
                $this->addUseAddress($params);
                $this->writeRecord($data);
                return false;
            }else{
                $this->addUseAddress($params);
                return  true;
            }
        }
    }
    //添加，修改管理员常用登录地址
    /**
     * @param  ['admin_id','ip']
     * @param bool $force 为true的话 设置成常用登录地址
     * @return array
     */
    public function  addUseAddress($params, $force=false){
        $userRiskObj=new \Library\M('admin_often_use_address');
        if(!isset($params['admin_id'])&&!is_int($params['admin_id'])){
            return tool::getSuccInfo(0,'admin_id不正确');
        }

        $ipModel=new \nainai\riskMgt\userRisk();
        if(!$cityInfo=$ipModel->getIpInfo($params['ip'])){
            return tool::getSuccInfo(0,'ip不正确');
        }

        $params['city_name']=$cityInfo['city'];
        $params['login_address']=$cityInfo['country'].$cityInfo['province'].$cityInfo['city'];
        $where=array('admin_id'=>$params['admin_id'],'ip'=>$params['ip']);
        if($addInfo=$userRiskObj->where($where)->getObj()){
            if($addInfo['login_times']+1>=$this->loginTimes){
                $params['status']=1;
            }
            if($force==true){
                $params['status']=1;
            }
            if($userRiskObj->data($params)->where($where)->update()){
                $userRiskObj->setInc('login_times');
                return tool::getSuccInfo(1,'修改成功');
            }else{
                return tool::getSuccInfo(0,'修改失败');
            }
        }else{
            if($force==true){
                $params['status']=1;
            }
            if($addId=$userRiskObj->data($params)->add()){
                $userRiskObj->where(['id'=>$addId])->setInc('login_times');
                return tool::getSuccInfo(1,'添加成功');
            }else{
                return tool::getSuccInfo(0,'添加失败');
            }
        }
    }
    //写入预警记录
    /**
     * @param $params ['admin_id']
     * @return array
     */
    public function writeRecord($params){
        if(!isset($params['admin_id'])&&!is_int($params['admin_id'])){
            return tool::getSuccInfo(0,'userid不正确');
        }
        $recordObj=new \Library\M('admin_alerted_record');
        $params['record_time']=date('Y-m-d H:i:s',time());
        if($recordObj->data($params)->add()){
            return tool::getSuccInfo(1,'插入成功');
        }else{
            return tool::getSuccInfo(0,'插入失败');
        }

    }
}
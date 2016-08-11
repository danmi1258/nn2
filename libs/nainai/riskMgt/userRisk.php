<?php
/**
 * Created by PhpStorm.
 * User: wangzhande
 * Date: 2016/8/2
 * Time: 15:57
 */

namespace nainai\riskMgt;
use Library\Query;
use \Library\tool;
use \Library\M;
//风险管理类
class userRisk
{
    private $loginTimes=3;
    protected $useAddress=array(
        array('user_id','number','user_id错误','regex'),
        array('ip','require','ip不能为空'),
    );


    //添加，修改用户常用登录地址
    /**
     * @param  ['user_id','ip']
     * @param bool $force 为true的话 设置成常用登录地址
     * @return array
     */
    public function  addUseAddress($params, $force=false){
        $userRiskObj=new M('user_often_use_address');
        if(!$userRiskObj->data($params)->validate($this->useAddress)){
            $error=$userRiskObj->getError();
            return tool::getSuccInfo(0,$error);
        }
        if(!$cityInfo=$this->getIpInfo($params['ip'])){
            return tool::getSuccInfo(0,'ip不正确');
        }

        $params['city_id']=$cityInfo['city_id'];
        $params['login_address']=$cityInfo['region'].$cityInfo['city'].$cityInfo['county'];
        $params['login_time']=date('Y-m-d H:i:s',time());
        $where=array('user_id'=>$params['user_id'],'ip'=>$params['ip']);
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
    //检查登录地址是否是常用地址
    /**
     * @param ['user_id','ip']
     * @return array|bool
     */
    public function checkUserAddress($params){
        $userRiskObj=new M('user_often_use_address');
        if(!$userRiskObj->data($params)->validate($this->useAddress)){
            return tool::getSuccInfo(0,$userRiskObj->getError());
        }
        if(!$cityInfo=$this->getIpInfo($params['ip'])){
            return tool::getSuccInfo(0,'ip不正确');
        }

        if(!$userRiskObj->where(['user_id'=>$params['user_id']])->getObj()){
            $this->addUseAddress($params,true);
            return true;
        }else{
            $where['city_id']=$cityInfo['city_id'];
            $where['user_id']=$params['user_id'];
            $where['status']=1;
            if(!$addInfo=$userRiskObj->where($where)->getObj()){
                $data['user_id']=$params['user_id'];
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
    //获取ip地址的详细信息
    /**
     * @param $ip
     * @return array|bool
     */
    public function getIpInfo($ip){
       // $ip='114.254.141.149';
        $ch=curl_init('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt ( $ch ,  CURLOPT_TIMEOUT ,  2 );
        $output = curl_exec($ch) ;
        if($output===false){
            return false;
        }
        $cityInfo=json_decode($output);
        if($cityInfo->code==1){
            return false;
        }
        return get_object_vars($cityInfo->data);
    }
    //写入预警记录
    /**
     * @param $params ['user_id']
     * @return array
     */
    public function writeRecord($params){
        if(!isset($params['user_id'])&&!is_int($params['user_id'])){
            return tool::getSuccInfo(0,'userid不正确');
        }
        $recordObj=new \Library\M('user_alerted_record');
        $params['record_time']=date('Y-m-d H:i:s',time());
        if($recordObj->data($params)->add()){
            return tool::getSuccInfo(1,'插入成功');
        }else{
            return tool::getSuccInfo(0,'插入失败');
        }

    }
    //获取会员预警记录
    public function getUserRiskList($page){
        $recordObj=new \Library\Query('user_alerted_record as r');
        $recordObj->join='left join user as u on u.id=r.user_id left join company_info as c on r.user_id=c.user_id left join person_info as p on p.user_id=r.user_id';
		$recordObj->fields='r.*,c.company_name,p.true_name,u.username';
        $recordObj->page=$page;
        $userRiskList=$recordObj->find();
        $pageBar=$recordObj->getPageBar();
        return [$userRiskList,$pageBar];
    }
}
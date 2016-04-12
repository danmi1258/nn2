<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/18 0018
 * Time: ���� 9:28
 */
namespace Library;
class tool{

    //ȫ������
    private static $globalConfigs = array();
    /**
     * ��ȡapplication.ini�е��������ת��Ϊ����
     * @param string $name ��������
     * @return mix ���û�и�������Ϣ�򷵻�null
     */
    public static function getConfig($name=null){
        $configObj = \Yaf\Registry::get("config");
        if($configObj===false){
            $configObj = Yaf\Application::app()->getConfig();
        }
        if($name!=null){
            if(!is_array($name)){
                $configObj = isset($configObj->$name) ? $configObj->$name : null;
            }
            else{
                foreach($name as $v){
                    if($configObj==null)break;
                    $configObj = isset($configObj->$v) ? $configObj->$v : null;
                }
            }

        }
        if(is_object($configObj))
            return $configObj->toArray();
        else if(is_null($configObj))
            return array();
        else return $configObj;
    }

    public static function getBasePath(){
        return APPLICATION_PATH.'/public/';
    }

    /**
     * ��ͼƬ·������@��ǰϵͳ��
     * @param string $imgSrc ͼƬ���·��
     * @return string
     */
    public static function setImgApp($imgSrc){
        $name = self::getConfig(array('application','name'));
        if(!is_string($name)){
            $name = '';
        }
        return ($imgSrc!='' && strpos($imgSrc,'@')===false) ? $imgSrc.'@'.$name : $imgSrc;

    }

    //��ȡȫ��������Ϣ
    public static function getGlobalConfig($name=null){
        if(empty(self::$globalConfigs)){
            self::$globalConfigs = require 'configs.php';
        }

        if($name==null)
            return self::$globalConfigs;
        elseif(is_string($name))
            return isset(self::$globalConfigs[$name]) ?self::$globalConfigs[$name] : null ;
        else if(is_array($name)){
            $temp = self::$globalConfigs;
            foreach($name as $v){
                if(isset($temp[$v])){
                    $temp = $temp[$v];
                }
                else return null;
            }
            return $temp;
        }
    }

    public static function getSuccInfo($res=1,$info='',$url=''){
        return array('success'=>$res,'info'=>$info,'return'=>$url);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/14 0014
 * Time: ���� 11:13
 */

namespace confs;
class search_config {

    private static $config_arr = array(
        'user_bank' => array(
            'time'=>array('b.apply_time','����ʱ��'),
            'like' => array('u.username,b.identify_no','�û��������֤��'),
        ),

    );

    public static function config($tableName=''){
        return isset(self::$config_arr[$tableName]) ? self::$config_arr[$tableName] : array() ;
    }
}
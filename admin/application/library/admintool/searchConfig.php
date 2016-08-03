<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/14 0014
 * Time: 上午 11:13
 */

namespace admintool;
class searchConfig {

    private static $config_arr = array(
        'user_bank' => array(
            'time'=>array('b.apply_time','申请时间'),
            'like' => array('u.username,b.identify_no','用户名，身份证号'),
        ),
        'recharge_order' => array(
            'time'=>array('r.create_time','申请时间'),
            'like' => array('r.order_no,u.username','用户名，订单号'),
        ),
        'withdraw_request' => array(
            'time'=>array('w.create_time','申请时间'),
            'like' => array('w.request_no,u.username','用户名，订单号'),
        ),
         'user_account' => array(
            'like' => array('u.mobile,u.username','用户名，手机号'),
             'between' => array('a.credit','信誉保证金')
        ),
        'configs_general' => array(
            'like'=>array('c.name,c.name_zh','英文名，中文名'),
            'select'=> array('c.type','配置类型')
        ),
        'order_sell' => array(
            'like'=>array('o.order_no,o.order_no','订单号'),
             'time'=>array('o.create_time','创建时间'),
        ),
    );

    public static function config($tableName=''){
        return isset(self::$config_arr[$tableName]) ? self::$config_arr[$tableName] : array() ;
    }
}
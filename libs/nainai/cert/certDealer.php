<?php
/**
 * ��������֤������
 * author: weipinglee
 * Date: 2016/4/27 0027
 * Time: ���� 3:35
 */

namespace nainai\cert;
use Library\M;

class certDealer extends certificate{


    public static $certType = 'deal';
    //��֤��Ҫ���ֶ�,0�����û���1��ҵ�û�
    public $certFields = array(

        0=>array(

        ),
        1=>array(
            'company_name',
            'area',
            'address',
            'legal_person',
            'contact',
            'contact_phone',
            'cert_oc',//��֯��������֤
            'cert_bl',
            'cert_tax'
        )
    );

    /**
     *��ȡ��֤����
     * @param $user_id
     */
    public function getCertData($user_id){
        return $this->getCertDetail($user_id,self::$certType);


    }


}
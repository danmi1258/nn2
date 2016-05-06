<?php
/**
 * ��������֤������
 * author: weipinglee
 * Date: 2016/4/27 0027
 * Time: ���� 3:35
 */

namespace nainai\cert;
use \Library\M;
use \Library\Time;
use \Library\Query;
use \Library\Thumb;
use \Library\log;
use \Library\JSON;
class certStore extends certificate{


    protected static $certType = 'store';
    //��֤��Ҫ���ֶ�,0�����û���1��ҵ�û�
    protected static $certFields = array(

        0=>array(
            'true_name',
            'identify_no',
            'identify_front',
            'identify_back'
        ),
        1=>array(
            'company_name',
            'area',
            'address',
            'legal_person',
            'contact',
            'contact_phone',
        )
    );

    /**
     * ��֤����
     * array(�ֶΣ����򣬴�����Ϣ�����������ӹ���ʱ�䣩
     * ������0�������ֶ�����֤ 1��������֤ 2����Ϊ��ʱ��֤
     *
     */
    private $rules = array(
        array('user_id','number','�û�id����'),//Ĭ��������
    );






    /**
     * ������֤
     * @param array  $accData �˻����ݣ����ˡ���˾�����ݣ�
     * @param array $certData ��֤���� ����֤������ݣ�
     */
    public function certStoreApply($accData,$certData=array()){

        //���鹫˾������Ϣ�Ƿ���Ϲ���
        $m = new \UserModel();
        if($this->user_type==1){
            $check = $m->checkCompanyInfo($accData);
        }
        else
            $check = $m->checkPersonInfo($accData);


        $certObj = new M(self::$certClass[self::$certType]);


        if($check===true ){
            //������������֤�Ƿ���Ҫ������֤
            $reCertType = $this->checkOtherCert($accData);
            $certObj->beginTrans();
            if(!empty($reCertType))//����������֤�����Ͳ�Ϊ�գ������ʼ��
                $this->certInit($reCertType);

            $this->createCertApply(self::$certType,$accData,$certData);

            $res = $certObj->commit();
        }
        else{
            $res = $check;
        }

        if($res===true){
            echo  JSON::encode(\Library\Tool::getSuccInfo());
            exit;
        }

        else{
            echo \Library\Tool::getSuccInfo(0,is_string($res) ? $res : '����ʧ��');
            exit;
        }

    }


    /**
     * ��ȡ��֤��ϸ��Ϣ
     */
    public function getDetail($id=0){
        $userModel = new M('user');
        if($id==0)$id=$this->user_id;
        $certType = self::$certType;
        $userData = $userModel->fields('username,type,mobile,email')->where(array('id'=>$id,'pid'=>0))->getObj();

        if(!empty($userData)){
            $userDetail = $userData['type']==1 ? $this->getCompanyInfo($id) : $this->getPersonInfo($id);
                $userCert   = $userModel->table($this->getCertTable($certType))->fields('status as cert_status,apply_time,verify_time,admin_id,message,store_id')->where(array('user_id'=>$id))->getObj();
               $store = array();
            if(isset($userCert['store_id'])){
                   $store = $userModel->table('store_list')->where(array('id'=>$userCert['store_id'],'status'=>1))->getObj();
               }
                return array(array_merge($userData,$userDetail,$userCert),$store);
        }
        return array();
    }

    /**
     * ���������
     * @param int $user_id �û�id
     * @param int $result ��˽�� 1��ͨ����0������
     * @param string $info ���
     */
    public function verify($user_id,$result=1,$info=''){
        return $this->certVerify($user_id,$result,$info,self::$certType);
    }

    /**
     * ��ȡ������֤�û��б�
     * @param int $page ҳ��
     */
    public function certList($page){
        $type = self::$certType;
        $table = self::getCertTable($type);
        $Q = new Query('user as u');
        $Q->join = 'left join '.$table.' as c on u.id = c.user_id left join store_list as s on c.store_id = s.id';
        $Q->fields = 'u.id,u.type,u.username,u.mobile,u.email,u.status as user_status,u.create_time,c.*,s.name as store_name';
        $Q->page = $page;
        $Q->where = 'c.status='.self::CERT_APPLY;
        $data = $Q->find();
        $pageBar =  $Q->getPageBar();
        return array('data'=>$data,'bar'=>$pageBar);
    }



}
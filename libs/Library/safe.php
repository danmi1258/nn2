<?php
/**
 * User: weipinglee
 * Date: 2016/3/8 0008
 * Time: ���� 9:26
 */
namespace Library;
class safe
{


    protected static $defalut = 'string';

    //php filter���ͳ���
    private static $filterVars = array(
        'int'     => FILTER_VALIDATE_INT,
        'float'   => FILTER_VALIDATE_FLOAT,
        'email'   => FILTER_VALIDATE_EMAIL,
        'ip'      => FILTER_VALIDATE_IP,
        'url'     => FILTER_VALIDATE_URL,


    );

    private static $filterRegex = array(
        'zip'     => '/^\d{6}$/',
        'english'   =>  '/^[A-Za-z]+$/',
        'date'    => '/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/i',
        'datetime'  =>  '/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29) (?:(?:[0-1][0-9])|(?:2[0-3])):(?:[0-5][0-9]):(?:[0-5][0-9])$/i',

    );
    /**
     * ��ȡpost�����н��й���
     * @param string $name ���������� ֧��ָ������
     * @param string $filter �������˷���
     * @param mixed $default �����ڵ�ʱ��Ĭ��ֵ
     * @param mixed $datas Ҫ��ȡ�Ķ�������Դ
     */
    public static function filterPost($name='',$filter='string',$default=''){
       return self::filterRequest($_POST,$name,$filter,$default);
    }
    /**
     * ��ȡget�����н��й���
     * @param string $name ���������� ֧��ָ������
     * @param string $filter �������˷���
     * @param mixed $default �����ڵ�ʱ��Ĭ��ֵ
     * @param mixed $datas Ҫ��ȡ�Ķ�������Դ
     */
    public static function filterGet($name='',$filter='string',$default=''){
        return self::filterRequest($_GET,$name,$filter,$default);
    }
    /**
     * �����ݽ��й���
     * param array Ԫ����
     * @param string $name ���������� ֧��ָ������
     * @param string $filter �������˷���
     * @param mixed $default �����ڵ�ʱ��Ĭ��ֵ
     * @param mixed $datas Ҫ��ȡ�Ķ�������Դ
     */
    public static function filterRequest(&$souceData,$name='',$filter='string',$default=''){
        $input = $souceData;
        $result = array();
        $filter    =   isset($filter) && is_string($filter) ? $filter:self::$defalut;
        if(''==$name) { // ��ȡȫ������
            foreach ($input as $key => $val) {
                $result[$key] = self::filter(trim($val),$filter,$default);
            }
            return $result;
        }elseif(isset($input[$name]) && is_array($input[$name])) { // ȡֵ����
            foreach($input[$name] as $key =>$v){
                $result[$key] = self::filter(trim($v),$filter,$default);
            }
            return $result;
        }
        elseif(isset($input[$name])) { // ȡֵ����
            return self::filter(trim($input[$name]),$filter,$default);
        }
        else{ // ����Ĭ��ֵ
            return $default;
        }

    }


    /**
     * ����������˵�����������
     * @param string $filter
     * @param mixed $data
     */
    public static function filter($data,$filter='string',$default=''){
        $filter = trim($filter);
        if(method_exists(__CLASS__,$filter)){//���ñ���ķ���
            return  call_user_func(array(__CLASS__,$filter),$data);
        }
        else if(isset(self::$filterVars[$filter])){//����filter_var����
            $res = filter_var($data,self::$filterVars[$filter]);
            return $res===false ? $default : $res;
        }
        else if(isset(self::$filterRegex[$filter])){
            $res = preg_match(self::$filterRegex,(string)$data);
            return $res ==0 ? $default : $res;
        }
        else if(function_exists($filter)){//����php����
            return call_user_func($filter,$data);
        }
        else if(0 === strpos($filter,'/')){
            if(preg_match($filter,(string)$data)==0)
                return $default;
        }
        return $data;

    }




    /**
     * @brief ����ת��б��
     * @param string $str Ҫת����ַ���
     * @return string ת�����ַ���
     */
    public static function addSlash($str)
    {
        if(is_array($str))
        {
            $resultStr = array();
            foreach($str as $key => $val)
            {
                $resultStr[$key] = self::addSlash($val);
            }
            return $resultStr;
        }
        else
        {
            return addslashes($str);
        }
    }

    /**
     * @brief ȥ��ת��б��
     * @param string $str Ҫת����ַ���
     * @return string ȥ��ת����ַ���
     */
    public static function stripSlash($str)
    {
        if(is_array($str))
        {
            $resultStr = array();
            foreach($str as $key => $val)
            {
                $resultStr[$key] = self::stripSlash($val);
            }
            return $resultStr;
        }
        else
        {
            return stripslashes($str);
        }
    }

    /**
     * @brief ����ļ��Ƿ��п�ִ�еĴ���
     * @param string  $file Ҫ�����ļ�·��
     * @return boolean �����
     */
    public static function checkHex($file)
    {
        $resource = fopen($file, 'rb');
        $fileSize = filesize($file);
        fseek($resource, 0);
        // ��ȡ�ļ���ͷ����β��
        if ($fileSize > 512)
        {
            $hexCode = bin2hex(fread($resource, 512));
            fseek($resource, $fileSize - 512);
            $hexCode .= bin2hex(fread($resource, 512));
        }
        // ��ȡ�ļ���ȫ������
        else
        {
            $hexCode = bin2hex(fread($resource, $fileSize));
        }
        fclose($resource);
        /* ƥ��16�����е� <% (  ) %> */
        /* ƥ��16�����е� <? (  ) ?> */
        /* ƥ��16�����е� <script  /script>  */
        if (preg_match("/(3c25.*?28.*?29.*?253e)|(3c3f.*?28.*?29.*?3f3e)|(3C534352495054.*?2F5343524950543E)|(3C736372697074.*?2F7363726970743E)/is", $hexCode))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * ����URL��ַ���е�Σ���ַ�����ֹXSSע�빥��
     * @param string $url
     * @return string
     */
    public static function clearUrl($url)
    {
        return str_replace(array('\'','"','&#',"\\","<",">"),'',$url);
    }

    /**
     * @brief �����ļ�����
     * @param string $string �����ַ���
     * @return string
     */
    public static function fileName($string)
    {
        return str_replace(array('./','../','..'),'',$string);
    }

    /**
     * @brief �����ַ����ĳ���
     * @param string $str �����Ƶ��ַ���
     * @param int $length ���Ƶ��ֽ���
     * @return string ��:��������ֵ; $str:ԭ�ַ���;
     */
    public static function limitLen($str,$length)
    {
        if($length !== false)
        {
            $count = String::getStrLen($str);
            if($count > $length)
            {
                return '';
            }
            else
            {
                return $str;
            }
        }
        return $str;
    }

    /**
     * @brief  ���ַ��������ϸ�Ĺ��˴���
     * @param  string  $str      �����˵��ַ���
     * @param  int     $limitLen ���������󳤶�
     * @return string �����˺���ַ���
     * @note ��������html��ǩ��php��ǩ�Լ������������
     */
    public static function string($str,$limitLen = false)
    {
        $str = trim($str);
        $str = self::limitLen($str,$limitLen);
        $str = htmlspecialchars($str,ENT_NOQUOTES);
        $str = str_replace(array("/*","*/"),"",$str);
        return self::addSlash($str);
    }

    /**
     * @brief ���ַ���������ͨ�Ĺ��˴���
     * @param string $str      �����˵��ַ���
     * @param int    $limitLen �޶��ַ������ֽ���
     * @return string �����˺���ַ���
     * @note �����ڲ�����:<script,<iframe�ȱ�ǩ���й���
     */
    public static function text($str,$limitLen = false)
    {
        $str = self::limitLen($str,$limitLen);
        $str = trim($str);

        require_once(dirname(__FILE__)."/htmlpurifier/HTMLPurifier.standalone.php");
        $cache_dir=APPLICATION_PATH."/htmlpurifier/";

        if(!file_exists($cache_dir))
        {
          //  File::mkdir($cache_dir);
        }
        $config = \HTMLPurifier_Config::createDefault();

        //���� ����flash
        $config->set('HTML.SafeEmbed',true);
        $config->set('HTML.SafeObject',true);
        $config->set('Output.FlashCompat',true);

        //���� ����Ŀ¼
        //$config->set('Cache.SerializerPath',$cache_dir); //����cacheĿ¼

        //����<a>��target����
        $def = $config->getHTMLDefinition(true);
        $def->addAttribute('a', 'target', 'Enum#_blank,_self,_target,_top');

        //���Ե�����<script>��<i?frame>��ǩ��on�¼�,css��js-expression��import��js��Ϊ��a��js-href
        $purifier = new \HTMLPurifier($config);
        return self::addSlash($purifier->purify($str));
    }


    /**
     * ��ȡ
     */
    public static function createToken(){
        $token = sha1(mt_rand(1,999999).Client::getIp().time());
        session::set('token',$token);
        return $token;
    }

    /**
     * ����token��ȷ���
     */
    public static function checkToken($token){
        $sessToken = \Library\session::get('token');
        \Library\session::clear('token');
        if($sessToken!=$token || $sessToken==null)
            return false;
        return true;
    }

}


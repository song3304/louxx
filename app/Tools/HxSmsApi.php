<?php
namespace App\Tools;
use Cache;

class HxSmsApi {
    private $config = array(
        'action_url'=>'https://sh2.ipyy.com/smsJson.aspx',           //地址
        'single_code'=>'【楼查查】尊敬的客户，您的验证码为：%s，三分钟内有效！',          //消息格式
        'userid'=>'',               //企业id
        'account'=>'jkwl490',              //发送用户帐号
        'password'=>'jkwl49088',             //密码
    );
    
    //返回信息解析
    private function post_result_analyze($result)
    {
        $ret = array('returnstatus'=>-1,
                    'message'=>'解析数据出错',
                    'remainpoint'=>'-1',
                    'taskID'=>'-1',
                    'successCount'=>'-1');

        $r = json_decode($result, TRUE);
        if (!is_array($r)) {
            //返回数据出错
            return $ret;
        } else {
            if (isset($r['returnstatus'])) {
                if ($r['returnstatus'] == 'Success')
                    $ret['returnstatus'] = 0;
                else
                    $ret['returnstatus'] = 1;
            }
            if (isset($r['message']))
                    $ret['message'] = $r['message'];
            if (isset($r['remainpoint']))
                    $ret['remainpoint'] = $r['remainpoint'];
            if (isset($r['taskID']))
                    $ret['taskID'] = $r['taskID'];
            if (isset($r['successCount']))
                    $ret['successCount'] = $r['successCount'];

            return $ret;
        }
    }

    //发送单条消息
    //return: 0->success 1->failed
    public function sendSingleCodeSms($phone ,$type = 1)
    {
        //生成验证码
        $code = $this->__generateCode($phone);
        
        $config = $this->config;
        //发送
        $url = $config['action_url'];
        $msg = mb_convert_encoding(sprintf($config['single_code'], $code), 'UTF-8', 'auto');
        $data = array(
            'userid' => $config['userid'], //企业id
            'account' => $config['account'], //发送用户帐号
            'mobile' => $phone,
            'password' => strtoupper(md5($config['password'])), //密码
            'content' => $msg,
            'sendTime' => '',
            'action' => 'send',
            'extno' => ''
        );

        $result = $this->_post_url($url, $data);
        $post_result_analyze_array = $this->post_result_analyze($result);
        return $post_result_analyze_array['returnstatus'];
    }
    
    //生成验证码
    private function _generateCode($phone) {
        $valid_code_key = 'send_code_phone_'.$phone;
        if (!Cache::has($valid_code_key)) {
            $valid_code = $this->_generateNonceStr(6);
            Cache::put($valid_code_key, $valid_code, 5);//分钟数缓存5分钟
        }else{
            $valid_code = Cache::get($valid_code_key);
        }
        return $valid_code;
    }
    
    
    //随机字符串
    private function _generateNonceStr($length=16){
        // 密码字符集，可任意添加你需要的字符
        $chars = "0123456789";
        $str = "";
        for($i = 0; $i < $length; $i++)
        {
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        //return '123456';
        return $str;
    }
    
    
    //检查手机验证码是否正确
    public function checkPhoneCode($phone, $code) {
        $valid_code_key = 'send_code_phone'.'_'.$phone;
        if (!empty($code) && Cache::get($valid_code_key) === $code) {
            //验证成功，将缓存清除
            Cache::pull($valid_code_key);
            return true;
        }
        return false;
    }
    
    private function _post_url($url, $post_data, $timeout = 30)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        //($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=UTF-8'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl))
        {
            return 'curl_error';
        }
        curl_close($curl);
    
        return $tmpInfo;
    }
}

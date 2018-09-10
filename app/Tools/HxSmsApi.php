<?php
namespace App\Tools;
use Cache;

class HxSmsApi {
    private $config = array(
        'action_url'=>'http://112.124.24.5/api/MsgSend.asmx/SendMsg',           //地址
        'Msg'=>'【楼查查】尊敬的客户，您的验证码为：%s，三分钟内有效！',          //消息格式
        'userCode'=>'xkxxcf',              //发送用户帐号
        'userPass'=>'Thhsd126',             //密码
        "Channel"=>0                        //通道号
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
        $msg = mb_convert_encoding(sprintf($config['Msg'], $code), 'UTF-8', 'auto');
        $data = array(
            'userCode' => $config['account'], //发送用户帐号
            'DesNo' => $phone,
            'userPass' => $config['password'], //密码
            'Msg' => $msg,
            'Channel' => 0
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
    
    function _post_url($url,$param,$timeout = 30){
        $ch=curl_init();
        $config=array(CURLOPT_RETURNTRANSFER=>true,CURLOPT_URL=>$url,CURLOPT_POST=>true);
        $config[CURLOPT_POSTFIELDS]=http_build_query($param);
        curl_setopt_array($ch,$config);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $result=curl_exec($ch);
        if (curl_errno($ch))
        {
            return 'curl_error';
        }
        curl_close($ch);
        return $result;
    }
}

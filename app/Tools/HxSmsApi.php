<?php
namespace App\Tools;
use Cache;

class HxSmsApi {
    private $config = array(
        'action_url'=>'http://120.55.197.77:1210/Services/MsgSend.asmx/SendMsg',           //地址
        'Msg'=>'尊敬的客户，您的验证码为：%s，三分钟内有效！【楼查查】',          //消息格式
        'userCode'=>'xkxxcf',              //发送用户帐号
        'userPass'=>'Thhsd126',             //密码
        "Channel"=>0                        //通道号
    );
    
    /*返回信息解析
    -1	应用程序异常
    -3	用户名密码错误或者用户无效
    -4	短信内容和备案的模板不一样
    -5	签名不正确(格式为:XXX【签名内容】), 注意：短信内容最后一个字符必须是】
    -7	余额不足
    -8	通道错误
    -9	无效号码
    -10	签名内容不符合长度
    -11	用户有效期过期
    -12	黑名单
    -13	语音验证码的Amount参数必须是整形字符串
    -14	语音验证码的内容只能为数字
    */
    private function post_result_analyze($code)
    {
       $result = ['result'=>true,'msg'=>''];
       switch ($code){
           case '-1':
               $result = ['result'=>false,'msg'=>'应用程序异常'];
               break;
            case '-3':
               $result = ['result'=>false,'msg'=>'用户名密码错误或者用户无效'];
               break;
            case '-4':
               $result = ['result'=>false,'msg'=>'短信内容和备案的模板不一样'];
               break;
            case '-5':
               $result = ['result'=>false,'msg'=>'签名不正确'];
               break;
            case '-7':
               $result = ['result'=>false,'msg'=>'余额不足'];
               break;     
            case '-8':
               $result = ['result'=>false,'msg'=>'通道错误'];
               break;
            case '-9':
               $result = ['result'=>false,'msg'=>'无效号码'];
               break;
            case '-10':
               $result = ['result'=>false,'msg'=>'签名内容不符合长度'];
               break;
            case '-11':
               $result = ['result'=>false,'msg'=>'用户有效期过期'];
               break;
            case '-12':
               $result = ['result'=>false,'msg'=>'黑名单'];
               break;
            case '-13':
               $result = ['result'=>false,'msg'=>'语音验证码的Amount参数必须是整形字符串'];
               break;
            case '-14':
               $result = ['result'=>false,'msg'=>'语音验证码的内容只能为数字'];
               break;
       }
       return $result;
    }

    //发送单条消息
    //return: 0->success 1->failed
    public function sendSingleCodeSms($phone ,$type = 1)
    {
        //生成验证码
        $code = $this->_generateCode($phone);
        
        $config = $this->config;
        //发送
        $url = $config['action_url'];
        $msg = sprintf($config['Msg'], $code);//mb_convert_encoding(, 'UTF-8', 'auto');
        $data = array(
            'userCode' => $config['userCode'], //发送用户帐号
            'DesNo' => $phone,
            'userPass' => $config['userPass'], //密码
            'Msg' => $msg,
            'Channel' => 0
        );
//return ['result'=>true,'msg'=>''];
        $result = $this->_post_url($url, $data);
        return $this->post_result_analyze($result);
    }
    
    //生成验证码
    private function _generateCode($phone) {
        $valid_code_key = 'send_code_phone_'.$phone;
        if (!Cache::has($valid_code_key)) {
            $valid_code = $this->_generateNonceStr(6);
            Cache::put($valid_code_key, $valid_code, 3);//分钟数缓存5分钟
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
        $valid_code_key = 'send_code_phone_'.$phone;
        //echo Cache::get($valid_code_key).'---'.$code;
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
        //print_r(http_build_query($param));
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



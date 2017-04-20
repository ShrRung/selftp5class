<?php
/**
 * Created by PhpStorm.
 * User: shrrung
 * Date: 17/4/20
 * Time: 20:54
 */
namespace Catclass\Sms;

class Yunxin{

    private $setting = [];

    public function __construct($config = []){
        $this->setting['AppKey'] = $config['AppKey'];
        $this->setting['AppSecret'] = $config['AppSecret'];

    }
    /*
     * 网易云信发送模板短信
     * $mobile 是jsonArray数组格式，最多100个
     * $params 是填充对应模板值的jsonArray
     * eg. $Nonce = rand(100000,999999);
     * @return $resArr 是一个json数据转化后的array，code:200 为成功
     */
    private function yx_send_temp_sms($mobile=[],$params='',$templateid=''){
        header("Content-Type:text/html; charset=utf-8");
        $CurTime = time();
        $Nonce = rand(000000,999999);
        $CheckSum = strtolower(sha1($this->setting['AppSecret'].$Nonce.$CurTime));
        $url = 'https://api.netease.im/sms/sendtemplate.action';
        $head_arr = array();
        $head_arr[] = 'Content-Type: application/x-www-form-urlencoded';
        $head_arr[] = 'charset: utf-8';
        $head_arr[] = 'AppKey:'.$this->setting['AppKey'];
        $head_arr[] = 'Nonce:'.$Nonce;
        $head_arr[] = 'CurTime:'.$CurTime;
        $head_arr[] = 'CheckSum:'.$CheckSum;
        $data = array();
        $data['templateid'] = $templateid;
        $data['mobiles'] = json_encode($mobile);
        $data['params'] = $params;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head_arr);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        curl_close($ch);
        $resArr = (array) json_decode($result);
        return $resArr;
    }

    /*
     * 向指定手机号发送短信验证码
     * string $mobile  must
     * string deviceId choose
     * int templateid  choose 不指定则使用配置的默认模板
     * int codeLen     choose [4~10]
     * @return array resArr
     *      code:状态码，msg:此次发送的sendid,obj:发送的$codeLen
     */
    private function yx_send_code($mobile = '',$codeLen = '',$deviceId = '',$templateid=''){
        header("Content-Type:text/html; charset=utf-8");
        $CurTime = time();
        $Nonce = rand(000000,999999);
        $CheckSum = strtolower(sha1($this->setting['AppSecret'].$Nonce.$CurTime));
        $url = 'https://api.netease.im/sms/sendcode.action';
        $head_arr = array();
        $head_arr[] = 'Content-Type: application/x-www-form-urlencoded';
        $head_arr[] = 'charset: utf-8';
        $head_arr[] = 'AppKey:'.$this->setting['AppKey'];
        $head_arr[] = 'Nonce:'.$Nonce;
        $head_arr[] = 'CurTime:'.$CurTime;
        $head_arr[] = 'CheckSum:'.$CheckSum;
        $data = array();
        $data['mobile'] = $mobile;
        if($deviceId){
            $data['deviceId'] = $deviceId;
        }
        if($templateid){
            $data['templateid'] = $templateid;
        }
        if($codeLen){
            $data['codeLen'] = $codeLen;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head_arr);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $result = curl_exec($ch);
        curl_close($ch);
        $resArr = (array) json_decode($result);
        return $resArr;
    }
}
<?php
// vim: set expandtab cindent tabstop=4 shiftwidth=4 fdm=marker:
// +----------------------------------------------------------------------+
// | The Code Inc                                                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2013, Code Inc. All rights reserved.            |
// +----------------------------------------------------------------------+
// | Authors: The PHP Dev Team, ISRD, Code Inc.                    |
// |                                                                      |
// +----------------------------------------------------------------------+

namespace Catclass\Sms;

use Catclass\Sms\Alidayucode\Top\TopClient;
use Catclass\Sms\Alidayucode\Top\ResultSet;
use Catclass\Sms\Alidayucode\Top\RequestCheckUtil;
use Catclass\Sms\Alidayucode\Top\TopLogger;
use Catclass\Sms\Alidayucode\Top\Request\AlibabaAliqinFcSmsNumSendRequest;


class Alidayu
{
    public $gatewayUrl = "http://gw.api.taobao.com/router/rest";

    public $connectTimeout;

    public $readTimeout;

    /** 是否打开入参check**/
    public $checkRequest = true;

    private $setting;

    public function __construct($config = []){
        //时区设置：亚洲/上海
        date_default_timezone_set('Asia/Shanghai');
        $this->setting = [
            'app_key'            => $config['app_key'],
            'secret_key'         => $config['secret_key'],
            'timestamp'          => date("Y-m-d H:i:s", time()),
            'format'             => $config['format'],
            'api_version'        => $config['api_version'],
            'sign_method'        => $config['sign_method'],   //2.0版本只有md5
            'sign_name'          => $config['sign_name'],
            'sms_templateCode'  => $config['sms_templateCode']
        ];
    }

    /*
     * 获取模板
     * 必须与阿里大于管理后台一致
     */
    function sendSMS($mobile,$SignName,$clientName='default',$data = [])
    {
        $c = new TopClient($this->setting);
        new ResultSet();
        new RequestCheckUtil();
        new TopLogger();

        $c->appkey = $this->setting['app_key'];
        $c->secretKey = $this->setting['secret_key'];
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend($clientName);       //可选 这个是用户名记录那个用户操作
        $req->setSmsType($this->setting['format']);     //短信类型 此处默认 不用修改
        $req->setSmsFreeSignName($this->setting['sign_name']);        //短信签名 必须  为网站设置的验证通过的签名
        //短信模板 必须
        $req->setSmsParam(json_encode($data));  //"{\"code\":\"$code\",\"name\":\"$name\"}"
        $req->setRecNum("$mobile");         //支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔
        $req->setSmsTemplateCode($this->setting['sms_templateCode']); //模板code
        $c->format=$this->setting['format'];
        //发送短信
        $resp = $c->execute($req);
        var_dump($resp);
        $return_str = [
            'status' => 'true',
            'msg' => 'success'
        ];
        if ($resp && $resp->result){// if($resp->result->success == true)
            return $return_str;
        }else{
            $return_str['status'] = 'false';
            switch ($resp['error_response']['sub_code']) {
                case 'isv.BUSINESS_LIMIT_CONTROL':
                    $return_str['msg'] = '请勿频繁请求,稍后再试';
                    break;
                case 'isv.MOBILE_NUMBER_ILLEGAL':
                    $return_str['msg'] = '手机号码格式不正确';
                    break;
                default :
                    $return_str['msg'] = '短信系统异常';
            }
            return $return_str;
        }

    }
}
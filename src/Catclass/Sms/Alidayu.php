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

    private $mobile;

    private $SignName;

    private $setting;

    public function __construct($mobile,$SignName,$config = []){
        //时区设置：亚洲/上海
        date_default_timezone_set('Asia/Shanghai');
        $this->setting = [
            'sms_product'        => $config['sms_product'],
            'app_key'            => $config['app_key'],
            'secret_key'         => $config['secret_key'],
            'timestamp'          => date("Y-m-d H:i:s", time()),
            'format'             => $config['format'],
            'api_version'        => $config['api_version'],
            'sign_method'        => $config['sign_method'],   //hmac，md5
            'sms_free_sign_name' => $config['signature'],
            'sms_templateCode'   => $config['sms_templateCode']
        ];
        $this->mobile = $mobile;
        $this->SignName = $SignName;

    }

    /*
     * 获取模板
     * 必须与阿里大于管理后台一致
     */
    function sendSMS($mobile, $code)
    {
//        //这个是topClient 里面需要实例化一个类所以我们也要加载 不然会报错
//        vendor('Alidayu.ResultSet');
//        //这个是成功后返回的信息文件
//        vendor('Alidayu.RequestCheckUtil');
//        //这个是错误信息返回的一个php文件
//        vendor('Alidayu.TopLogger');

        $c = new TopClient();
        //短信内容：公司名/名牌名/产品名
        $product = $this->setting['sms_product'];
        $c->appkey = $this->setting['app_key'];
        $c->secretKey = $this->setting['secret_key'];
        //这个是用户名记录那个用户操作
        $req = new AlibabaAliqinFcSmsNumSendRequest();
        //代理人编号 可选 这个是用户名记录那个用户操作
        $req->setExtend("123456");
        //短信类型 此处默认 不用修改
        $req->setSmsType("format");
        //短信签名 必须
        $req->setSmsFreeSignName($this->SignName);
        //短信模板 必须
        $req->setSmsParam("{\"code\":\"$code\",\"product\":\"$product\"}");
        //短信接收号码 支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，
        $req->setRecNum("$this->mobile");
        //短信模板ID，传入的模板必须是在阿里大鱼“管理中心-短信模板管理”中的可用模板。
        $req->setSmsTemplateCode($this->setting['sms_templateCode']); //SMS_60870256

        $c->format=$this->setting['format'];
        //发送短信
        $resp = $c->execute($req);
        var_dump($resp);
        //短信发送成功返回True，失败返回false
        //if (!$resp)
//        if ($resp && $resp->result)   // if($resp->result->success == true)
//        {
//            // 从数据库中查询是否有验证码
//            $data = M('sms_log')->where("code = '$code' and add_time > ".(time() - 60*60))->find();
//            // 没有就插入验证码,供验证用
//            empty($data) && M('sms_log')->add(array('mobile' => $mobile, 'code' => $code, 'add_time' => time(), 'session_id' => SESSION_ID));
//            return true;
//        }
//        else
//        {
//            return false;
//        }
    }
}
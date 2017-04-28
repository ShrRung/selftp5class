# selftp5class
self tp5 classes for simple use
### 安装依赖包
`composer require lazycat/selftp5class dev-master`
进行以上操作即可使用所有定义的方法
# 短信类
## alidayu 阿里大于短信发送
### 前期准备
* 1、 注册阿里大于账号，https://www.alidayu.com 免费赠送200条
* 2、 进入后台，应用管理->应用列表->创建应用，经过审核后再使用
* 3、 配置管理->验证码/短信通知->添加签名，经过审核后使用
* 4、 配置管理->验证码/短信通知->添加模板，经过审核后使用
### 如何使用
```php
<?php

namespace app\index\Controller;

use Catclass\Sms\Alidayu;

class Sms {

    public function send_sms($mobile,$data = [],$sign_name = '',$clientId = 0){
        $config = [
            'app_key'            => 'xxxxxxxx',
            'secret_key'         => 'xxxxxxxxxxxxxxxxxxxxxxxx',
            'format'             => 'json',
            'api_version'        => '2.0',
            'sign_method'        => 'MD5',
            'signature'          => '签名名称',  //有多少个验证通过的签名都可以使用
            'sms_templateCode'   => 'xx'
        ];
        if($sign_name){
            $config['sign_name'] = $sign_name;
        }
        //data 举例
        //$data = ["code"=>$code,"name"=>$name];  //举例
        //$code = '1234';         //自己随意生成
        //$name = '测试公司1234';

        //$clientId = '123456';      //用户可以传入自己下级的会员ID
        $alidayu = new Alidayu($config);
        $result = $alidayu->sendSMS($mobile,$clientId,json_encode($data));
        exit();
        }
}

```

## 网易云信短信
### 前期准备
和阿里大于类似
### 如何使用
```php
<?php
namespace app\index\Controller;

use Catclass\Sms\Yunxin;

class Sms {
/*
 * 发送模板短信
 * $mobile 为一个数组
 */
    public function yx_send_temp_sms($mobile = [],$parmas = [],$templateid = ''){
        $config = [
            'AppKey'            => 'xxxxxxxx',
            'AppSecret'         => 'xxxxxxxxxxxxxxxxxxxxxxxx',
        ];
        $yunxin = new Yunxin($config);
        $result = $yunxin->yx_send_temp_sms($mobiles,$params,$templateid);
    }
/*
 * 发送code短信
 */
    public function yx_send_code($mobile = '',$codeLen = '',$deviceId = '',$templateid=''){
        $config = [
            'AppKey'            => 'xxxxxxxx',
            'AppSecret'         => 'xxxxxxxxxxxxxxxxxxxxxxxx'
        ];
        $yunxin = new Yunxin($config);
        $result = $yunxin->yx_send_code($mobile,$codeLen,$deviceId,$templateid);
    }

}

```

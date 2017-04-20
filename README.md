# selftp5class
self tp5 classes for simple use
# alidayu 阿里大于短信发送
## 前期准备
* 1 注册阿里大于账号 https://www.alidayu.com，免费赠送200条
* 2 进入后台，应用管理->应用列表->创建应用，经过审核后再使用
* 3 配置管理->验证码/短信通知->添加签名，经过审核后使用
* 4 配置管理->验证码/短信通知->添加模板，经过审核后使用
## 如何使用
### 安装依赖包
`composer require lazycat/selftp5class dev-master`
### 用法
```php
<?php

namespace app\index\Controller;

use Catclass\Sms\Alidayu;

class Sms {

    public function send_sms($mobile){
        $config = [
            'app_key'            => 'xxxxxxxx',
            'secret_key'         => 'xxxxxxxxxxxxxxxxxxxxxxxx',
            'format'             => 'json',
            'api_version'        => '2.0',
            'sign_method'        => 'MD5',
            'sign_name'          => '签名名称',  //有多少个验证通过的签名都可以使用
            'sms_templateCode'   => 'xx'
        ];
        $code = '1234';         //自己随意生成
        $name = '测试公司1234';
        $guest_name = 'guest';      //用户名
        $alidayu = new Alidayu($config);
        $result = $alidayu->sendSMS($mobile,$guest_name,['code'=>$code,'name'=>$name]);
        exit();
        }
}

```


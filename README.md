# selftp5class
self tp5 classes for simple use
# alidayu ������ڶ��ŷ���
## ǰ��׼��
* 1 ע�ᰢ������˺� https://www.alidayu.com���������200��
* 2 �����̨��Ӧ�ù���->Ӧ���б�->����Ӧ�ã�������˺���ʹ��
* 3 ���ù���->��֤��/����֪ͨ->���ǩ����������˺�ʹ��
* 4 ���ù���->��֤��/����֪ͨ->���ģ�壬������˺�ʹ��
## ���ʹ��
### ��װ������
`composer require lazycat/selftp5class dev-master`
### �÷�
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
            'sign_name'          => 'ǩ������',  //�ж��ٸ���֤ͨ����ǩ��������ʹ��
            'sms_templateCode'   => 'xx'
        ];
        $code = '1234';         //�Լ���������
        $name = '���Թ�˾1234';
        $guest_name = 'guest';      //�û���
        $alidayu = new Alidayu($config);
        $result = $alidayu->sendSMS($mobile,$guest_name,['code'=>$code,'name'=>$name]);
        exit();
        }
}

```


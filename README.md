# wechat-detection-php

一个微信检测的方法，包括链接封禁检测、小程序封禁检测等

## 环境需求

- PHP >= 5.6

## 安装

```bash
composer require "methecode/wechat-detection-php"
```

## 使用示例

### 链接检测（支持微信、QQ、抖音)

```php

$appCode= ''; // https://91.zhuolianai.com 申请试用
$client = new \MeTheCode\WeChat\DetectionClient($appCode);
$response = $client->urlCheck('https://91.zhuolianai.com', 'weixin');

{
    "code":201,
    "msg":"网页包含色情内容，被多人投诉，为维护绿色上网环境，已停止访问。"
}

```

### 小程序检测

```php

$appCode= ''; // https://91.zhuolianai.com 申请试用
$client = new \MeTheCode\WeChat\DetectionClient($appCode);
$response = $client->queryWechatMpStatus('xxx'); // xxx 替换为小程序appid

{
    "banCode":90091,
    "banReason":"内容属于平台未开放的服务范围",
    "statusText":"XXX小程序因违规已暂停服务",
    "statusDetail":"很抱歉，小程序XXX由于内容属于平台未开放的服务范围，已暂停服务，查看对应规则。"
}

```
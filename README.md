# dayu-client 阿里大鱼发送短信客户端

这是一个超简单的客户端，只有不到70行的代码，实现了利用阿里大鱼发送短信的功能。但是，我只拼装了接口地址出来，接下来您可以用curl 等工具都能取到接口的内容，也可以用guzzleHttp，snoopy第三方包来取得这个url地址的内容。

最好看一下代码，因为实在太短了，没有理由不看啊。。。。

##　使用方法

直接上代码了

```
$smsSend = new DaYuClient("NjOBTNw0YRvJW0Un","VRhOKIuIe3DHumO8CIZ4R3eq8NCvWA");
$url =  $smsSend->getUrl4SendSms("手机号码", "示例短信签名", "SMS_****",
json_encode(["code"=>12345]),
    rand(1111,9999)
);// 这里的几个参数要改一下 

/**
接下来，
*/
$guzzleClient = new \GuzzleHttp\Client();
$response = $guzzleClient->request('GET', $url);
$aliyunResponse = json_decode( $response->getBody(),true);
print_r($aliyunResponse);
```


## 入坑心得

坑点之一：生成时间字符串的时候，要UTC的时区，所以，看代码，我们临时切到UTC了。
坑点之二，他们的接口可能经常换，所以，我也不知道什么时候就不能用了。。。。





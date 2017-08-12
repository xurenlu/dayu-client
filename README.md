# dayu-client 阿里大鱼发送短信客户端

这是一个超简单的客户端，只有不到70行的代码，实现了利用阿里大鱼发送短信的功能。但是，我只拼装了接口地址出来，接下来您可以用curl 等工具都能取到接口的内容，也可以用guzzleHttp，snoopy第三方包来取得这个url地址的内容。所以，我根本就没有添加任何进行接口访问的依赖。
最好看一下代码，因为实在太短了，没有理由不看啊。。。。

# 安装方法:

 composer 安装 :

```
 composer require glz/dayu-client dev-master"
```

如果不会composer，直接从[github](https://github.com/xurenlu/dayu-client)上把文件拉下来也行，反正源代码目录就一个文件。

# 使用方法

直接上代码了

```
$smsSend = new DaYuClient("NjOBTNw0YRvJW0Un","VRhOKIuIe3DHumO8CIZ4R3eq8NCvWA");
$url =  $smsSend->getUrl4SendSms("手机号码", "示例短信签名", "SMS_****",
json_encode(["code"=>12345]),
    rand(1111,9999)
);// 这里的几个参数要改一下 ,倒数第二个参数 ，是对templateParam 进行json_encode后的字符串，是因为我的短信模板是"您的验证码是$code",所以我传的templateParam参数就是{"code":12345} .

/**
接下来，
*/
$guzzleClient = new \GuzzleHttp\Client();
$response = $guzzleClient->request('GET', $url);
$aliyunResponse = json_decode( $response->getBody(),true);
print_r($aliyunResponse);
```



# 入坑心得

1. 坑点之一：生成时间字符串的时候，要UTC的时区，所以，看代码，我们临时切到UTC了。
1. 坑点之二，他们的接口可能经常换，所以，我也不知道什么时候就不能用了。。。。
2. 不小心就把appkey 和我的secret写出来了 还好我第一时间删除了。





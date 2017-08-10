<?php
namespace  Glz;
/**
 * User: renlu.xu<55547082@qq.com>
 * Date: 2017/8/11
 */
class DaYuClient
{
    protected $kvs=[];
    protected  $secret = "";
    public $endPoint = "https://dysmsapi.aliyuncs.com/";
    public function __construct($appKey,$appSecret,$timeStamp = null)
    {
        $this->secret = $appSecret;
        $this->kvs = [
            "Format"=>"JSON",
            "Version"=>"2017-05-25",
            "AccessKeyId"=>$appKey,
            "SignatureMethod"=>"HMAC-SHA1",
            "SignatureVersion"=>"1.0",
            //"Action"=>"Dysmsapi" 坑死了,阿里的客服一开始告诉我的是这个Dysmsapi,其实不是。
            "Action"=>"SendSms",
            "RegionId"=>"cn-hangzhou"
        ];
    }

    /**
     * @param $phoneNumbers string 手机号码
     * @param $signName string 短信签名
     * @param $templateCode string 短信模板代码
     * @param $templateParam string 短信模板的参数,json encode方式编码
     * @param $OutId string 外部业务ID
     * @param null $signatureNonce string 一个随机码,避免被重放攻击。
     * @return string 返回一个url,您要做的就访问这个地址,得到json串。
     */
    public function getUrl4SendSms($phoneNumbers,$signName,$templateCode,$templateParam,$OutId,$signatureNonce = null){
        if(is_null($signatureNonce)) {
            $this->SignatureNonce = rand(10000, 99999);
        }else{
            $this->SignatureNonce = $signatureNonce;
        }
        $dataZone = date_default_timezone_get();
        date_default_timezone_set("UTC");
        $this->Timestamp = date("Y-m-d")."T".date("H:i:s")."Z";
        date_default_timezone_set($dataZone);
        $this->PhoneNumbers = $phoneNumbers;
        $this->SignName = $signName;
        $this->TemplateCode = $templateCode;
        $this->TemplateParam = $templateParam;
        $this->OutId = $OutId;
        $arguments = $this->kvs;
        $uncoded = ($this->argumentsToString($arguments));
        $toencoded = "GET&%2F&".rawurlencode($uncoded);
        $sign = $this->sign($toencoded);
        $this->Signature = $sign;
        $result =[];
        $kvs = $this->kvs;
        ksort($kvs);
        foreach($kvs as $k=>$v){
            $result[]=rawurlencode($k).'='.rawurlencode($v);
        }
        $url = $this->endPoint."?".  trim(implode("&", $result),"&");
        return $url;
    }
    private function argumentsToString($arguments){
        ksort($arguments);
        $result=[];
        foreach($arguments as $k=>$v){
            $result[]=rawurlencode($k)."=".rawurlencode($v);
        }
        return trim(implode("&", $result),"&");
    }
    protected  function sign($stringToSign){
        return base64_encode(hash_hmac("SHA1",$stringToSign ,$this->secret."&" ,true));
    }
    public function __set($k,$v){
        $this->kvs[$k] = $v;
    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: r
 * Date: 2017/11/21
 * Time: 下午10:58
 */

namespace Glz;


use Psr\Http\Message\ResponseInterface;

class AliDaYuHelper
{

    protected  $appKey;
    protected  $appSecret ;

    public  function __construct($appKey,$appSecret){
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }


    protected function parseAliyunResponse($url){
        $guzzle =new \GuzzleHttp\Client();
        /**
         * @var $resp ResponseInterface
         */
        $resp = $guzzle->get($url);
        if($resp->getStatusCode()!=200){
            throw  new \Exception("aliyun api error;status code:".$resp->getStatusCode().",html body:".$resp->getBody());
        }
        $json =  $resp->getBody();
        $responseObject = json_decode($json,true);
        if(!$responseObject){
            throw new \Exception("aliyun api error;html body:".$resp->getBody());
        }
        if($responseObject["Message"]!="OK"){
            throw new \Exception("aliyun api error;".$json);
        }
        return true;
    }

    /**
     * @param $CalledShowNumber string
     * @param $CalledNumber string
     * @param $TtsCode string
     * @param $TtsParam array
     */
    public  function SingleCallByTts($CalledShowNumber,$CalledNumber,$TtsCode,$TtsParam){
        $dayu  = new \Glz\DaYuClient($this->appKey,$this->appSecret);
        $dayu->endPoint = "https://dyvmsapi.aliyuncs.com/";
        $url = $dayu->SingleCallByTts(["CalledShowNumber"=>$CalledShowNumber,"CalledNumber"=>$CalledNumber,"TtsCode"=>$TtsCode,"TtsParam"=>json_encode($TtsParam)]);
        return $this->parseAliyunResponse($url);
    }

    public function SendSms($PhoneNumbers,$SignName,$TemplateCode,$TemplateParam,$OutId){
        $dayu  = new \Glz\DaYuClient($this->appKey,$this->appSecret);
        $dayu->endPoint = "https://dysmsapi.aliyuncs.com/";
        $url = $dayu->SendSms(["PhoneNumbers"=>$PhoneNumbers,"SignName"=>$SignName,"TemplateCode"=>$TemplateCode,"TemplateParam"=>json_encode($TemplateParam),"OutId"=>$OutId]);
        return $this->parseAliyunResponse($url);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //接口测试
    public function info(){
        $key = '1910';
        $data = $_GET['data'];      //接收到的数据
        $sign = $_GET['sign'];      //接收到的签名

        //验签，使用与 发送端相同的签名算法
        $local_sign = sha1($data.$key);

        if($sign==$local_sign)
        {
            echo "验签成功";
        }else{
            echo "验签失败";
        }

    }
    //接收数据
    public function receive(){
        echo "<pre>";print_r($_GET);echo "</pre>";
        echo "<pre>";print_r($_POST);echo "</pre>";
    }
    //接收数据 post
    public function receivePost(){
        echo "<pre>";print_r($_POST);echo "</pre>";
    }
    //对称加密 --解密
    public function decrypt(){
        echo "<pre>";print_r($_POST);echo "</pre>";

        $mothod = "AES-256-CBC";   //加密方法
        $key = "1910api";   //加密密钥
        $iv = "hellohelloabc123";   //加密初始化向量


        $enc_data=$_POST["data"];   //接收加密密文
        $sign=$_POST["sign"];   //接收签名

        //验签
        $local_sign=sha1($enc_data,$key);   //签名

        if($sign==$local_sign){
            echo "验签成功";echo "<br>";
            //解密
            $dec_data = openssl_decrypt($enc_data,$mothod,$key,OPENSSL_RAW_DATA,$iv);
            echo "解密的数据：".$dec_data;echo '<br>';
        }else{
            echo "验签失败";
        }

    }
    //非对称加密
    public function rsaDecrypt(){
        $data = $_GET["data"];   //接收加密密文
        $enc_data = base64_decode($data);   //base64解码

        $priv_key = openssl_get_privatekey(file_get_contents(storage_path('keys/b_priv.key')));   //获取B私钥内容
        //使用私钥解密
        openssl_private_decrypt($enc_data,$dec_data,$priv_key);   //1、解密的数据 2、解密后的数据 3、私钥内容
        echo "A向B发送的数据：".$dec_data;echo "<br>";


        //B向A响应的数据  使用A的公钥
        $data2 = "宝塔镇河妖";   //响应的加密明文
        //使用A的公钥加密
        $a_pub_key = openssl_get_publickey(file_get_contents(storage_path('keys/a_pub.key')));   //获取A公钥内容
        openssl_public_encrypt($data2,$enc_data2,$a_pub_key);   // 1、加密的数据 2、加密后的数据 3、公钥内容

        $enc_data2 = base64_encode($enc_data2);

        $response = [
            "errno" => 0,
            "msg" => "ok",
            "data" => $enc_data2
        ];
        return $response;

    }
    //非对称加密  --签名
    public function verify1(){
        //验签
        $data = $_GET['data'];                      //接收发送发的数据
        $sign = base64_decode($_GET['sign']);       // 接收发送方的签名

        // 使用公钥验签
        $key = openssl_get_publickey(file_get_contents(storage_path('keys/a_pub.key')));
        $res = openssl_verify($data,$sign,$key,OPENSSL_ALGO_SHA1);

        if($res){        //验签通过
            echo "验签成功";
        }else{          //验签失败
            echo "验签失败";
        }

    }
}

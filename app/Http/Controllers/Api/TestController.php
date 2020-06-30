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
    //接口解密数据
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
}

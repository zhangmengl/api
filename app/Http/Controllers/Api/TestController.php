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
}

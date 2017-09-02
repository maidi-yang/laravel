<?php
    $notifyUrl="http://".$_SERVER['HTTP_HOST']."/notifyUrl.php"; //回调地址，外网能访问
	$data = array(
        "pay"=>"wxwap",//支付类型 此处可选项为 微信公众号：wxgzh  微信H5网页：wxwap   支付宝H5网页：zfbwap
	    "uboid"=>"2017100",//商户号
	    "ubokey"=>"439e79c6dbc546730cfc807c44a36f7b",//key
	    "ubodingdan"=>time().mt_rand(100, 500),//商户订单号
	    "ubodes"=>"vip",//商品名
	    "ubomoney"=>1,//支付金额
	    "ubotzurl"=>$notifyUrl,//异步回调 , 支付结果以异步为准
	    "ubobackurl"=>$notifyUrl//同步回调 不作为最终支付结果为准，请以异步回调为准
        );
    $data["ubosign"]=md5($data["uboid"].$data["ubodingdan"].$data["ubomoney"].$data["ubotzurl"].$data["ubokey"]); //加密
    $r=getHttpContent("http://www.yidaozhifu.com/pay/","POST",$data);
    $r=json_decode($r,true);
    if($r["msg"]==0){
        header('Location:'.$r["payUrl"]);
    }else{
		switch($r['errcode']){
            case 'errcode=0':
                echo '系统维护';
                break;
            case 'errcode=1':
                echo '未开通当前支付功能';
                break;
            case 'errcode=2':
                echo '提交方式有误 请检查提交的pay字段pay=wxgzh微信公众号 pay=zfbwap 支付宝wap pay=wxwap 微信wap';
                break;
            case 'errcode=3':
                echo '提交的金额小于0.01块钱';
                break;
            case 'errcode=4':
                echo '签名验证失败';
                break;
            case 'errcode=5':
                echo '商户不存在';
                break;
            case 'errcode=6':
                echo '数据POST|GET为空';
                break;
        }
	}
	
function getHttpContent($url, $method = 'GET', $postData = array())  {  
    $data = '';  
    $user_agent = $_SERVER ['HTTP_USER_AGENT'];
    $header = array (
                "User-Agent: $user_agent" 
    );
    if (!empty($url)) {  
        try {
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_URL, $url);  
            curl_setopt($ch, CURLOPT_HEADER, false);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //30秒超时  
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header ); 
            //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);  
            if (strtoupper($method) == 'POST') {  
                $curlPost = is_array($postData) ? http_build_query($postData) : $postData;  
                curl_setopt($ch, CURLOPT_POST, 1);  
                curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);  
            }  
            $data = curl_exec($ch);  
            curl_close($ch);  
        } catch (Exception $e) {  
            $data = '';  
        }  
    }  
    return $data;  
}
?>


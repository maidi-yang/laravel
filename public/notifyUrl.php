<?php
error_reporting(0);
$userkey='090c16f2889ddbd2a241a6d67fdde265';//key
$status=$_REQUEST['ubozt'];//订单状态
$customerid=$_REQUEST['uboid'];//商户编号
$sdorderno=$_REQUEST['ubodingdan'];//商户订单号
$total_fee=$_REQUEST['ubomoney'];//交易金额
$paytype=$_REQUEST['pid'];//支付类型
$sign=$_REQUEST['ubosign'];//md5验证签名串


$mysign=md5($status.$customerid.$sdorderno.$total_fee.$userkey); //验证
if($sign==$mysign){
    if($status=='1'){//支付成功
		//////////////更改支付状态
		echo 'success';
	}
	else {
        echo 'fail';
    }
} else {
    echo 'sign error';
}
?>
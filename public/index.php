<?php
    $notifyUrl="http://".$_SERVER['HTTP_HOST']."/notifyUrl.php"; //�ص���ַ�������ܷ���
	$data = array(
        "pay"=>"wxwap",//֧������ �˴���ѡ��Ϊ ΢�Ź��ںţ�wxgzh  ΢��H5��ҳ��wxwap   ֧����H5��ҳ��zfbwap
	    "uboid"=>"2017100",//�̻���
	    "ubokey"=>"439e79c6dbc546730cfc807c44a36f7b",//key
	    "ubodingdan"=>time().mt_rand(100, 500),//�̻�������
	    "ubodes"=>"vip",//��Ʒ��
	    "ubomoney"=>1,//֧�����
	    "ubotzurl"=>$notifyUrl,//�첽�ص� , ֧��������첽Ϊ׼
	    "ubobackurl"=>$notifyUrl//ͬ���ص� ����Ϊ����֧�����Ϊ׼�������첽�ص�Ϊ׼
        );
    $data["ubosign"]=md5($data["uboid"].$data["ubodingdan"].$data["ubomoney"].$data["ubotzurl"].$data["ubokey"]); //����
    $r=getHttpContent("http://www.yidaozhifu.com/pay/","POST",$data);
    $r=json_decode($r,true);
    if($r["msg"]==0){
        header('Location:'.$r["payUrl"]);
    }else{
		switch($r['errcode']){
            case 'errcode=0':
                echo 'ϵͳά��';
                break;
            case 'errcode=1':
                echo 'δ��ͨ��ǰ֧������';
                break;
            case 'errcode=2':
                echo '�ύ��ʽ���� �����ύ��pay�ֶ�pay=wxgzh΢�Ź��ں� pay=zfbwap ֧����wap pay=wxwap ΢��wap';
                break;
            case 'errcode=3':
                echo '�ύ�Ľ��С��0.01��Ǯ';
                break;
            case 'errcode=4':
                echo 'ǩ����֤ʧ��';
                break;
            case 'errcode=5':
                echo '�̻�������';
                break;
            case 'errcode=6':
                echo '����POST|GETΪ��';
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
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //30�볬ʱ  
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


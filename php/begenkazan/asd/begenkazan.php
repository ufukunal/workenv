<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
var fb_param = {};
fb_param.pixel_id = '6005670350922';
fb_param.value = '0.00';
(function(){
  var fpw = document.createElement('script');
  fpw.async = true;
  fpw.src = (location.protocol=='http:'?'http':'https')+'://connect.facebook.net/en_US/fp.js';
  var ref = document.getElementsByTagName('script')[0];
  ref.parentNode.insertBefore(fpw, ref);
})();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6005670350922&amp;value=0" /></noscript>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Facebook Begen Kazan</title>
<style type="text/css">
<!--
.kazanan {
	font-size: 12px;
	color: #FFF;
	font-family: Arial, Helvetica, sans-serif;
	top: 0px;
	vertical-align: top;
}
#shop {
overflow: hidden;
position:absolute;
top: 0px;
left: 0px;
background-color: #ffffff;
width: 800px;
height: 100%;
}

-->
</style>
</head>

<body>
<?php
require_once "face/facebook.php";
require_once "config.php";

@session_start();

//Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
//Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
//unset($_SESSION["authok"]);
//die();
$facebook = new Facebook(array(
			       'appId'  => '737479209612025',
			       'secret' => '8286aea9942394873791eabbe6ac6716',
			       'cookie' => true,
			       ));
$request = $facebook->getSignedRequest();

if(!$request['page']['liked'] and true)
  {


	echo "<script type='text/javascript'>
			location.href='begenkazan2.php';
		</script>";

  }
else{

?>


<table width="800" border="0" cellspacing="0" cellpadding="0">


<meta http-equiv="refresh" content="0;URL=https://clicksem.net/billyboytr/kuponkod.php">



</table>


<?php
		  }
?>
</body>
</html>





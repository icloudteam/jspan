<?php
/**
 * 微信二维码登陆测试
 */
	include("wechatauth.class.php");
	session_start();
	function logdebug($text){
		file_put_contents('data/logwechat.txt',$text."\n",FILE_APPEND);		
	};
	$sid  = session_id();
	$options = array(
		'account'=>$sid,
		'datapath'=>'data/cookiecode_',
			'debug'=>true,
			'logcallback'=>'logdebug'	
	); 
	$wechat = new Wechatauth($options);

	if (isset($_POST['code'])) {
		$logincode = $_POST['code'];
		$vres = $wechat->set_login_code($logincode)->verify_code();
		if ($vres===false) {
			$result = array('status'=>0);
		} else {
			$result = array('status'=>$vres);
			if ($vres==200) {
				$result['info'] = $wechat->get_login_info();
				$result['cookie'] = $wechat->get_login_cookie(true);
			}
		}

		die(json_encode($result));	
	}
	$logincode =  $wechat->get_login_code();
	$qrimg = $wechat->get_code_image();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>iCloud Pan - The Best NetDiskSystem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
</head>
<body>
<h2>使用微信扫一扫登录</h2>
<div id="content">
<img src="<?php echo $qrimg;?>" />
</div>
<script type="text/javascript">
var ajaxlock = false;
var ajaxhandle;
function synclogin(){
	if (!ajaxlock) {
		ajaxlock = true;
		$.post(location.href,{code:'<?php echo $logincode;?>'},function(json){
			//console.log(json);
			if (json.status) {
				console.log(json.status);
				if (json.status==200) {
					var nick,uid,username,sex,avatar;
					if (json.info && json.info.User){
						uid = json.info.User.Uin;
						nick = json.info.User.NickName;
						username = json.info.User.UserName;
						sex = json.info.User.Sex;
						avatar = json.info.User.HeadImgUrl;
						$('#content').html('<h2>用户信息</h2><ul><li><b>Uid:</b>'+uid
								+'</li><li><b>Nick:</b>'+nick
								+'</li><li><b>username:</b>'+username
								+'</li><li><b>sex:</b>'+(sex==1?'男':'女')
								+'</li><li><b>avatar:</b>'+avatar
								+'</li></ul>');
					}
					alert('login success, welcome '+nick);

					clearInterval(ajaxhandle);
				}
			}
			ajaxlock = false;
		},'json');
	}
}
$(function(){
	ajaxhandle = setInterval("synclogin()",2000);
});
</script>
</body>
</html>
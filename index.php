<?php
/**
 * 微信二维码登陆测试
 */
	include "wechatauth.class.php";
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
    <link href="css/bootstrap-modal.css" rel="stylesheet"> 
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
    <div class="container-narrow">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">

        </ul>
        <h3 class="muted">iCloud Pan</h3>
      </div>
      <hr>
      <div class="jumbotron">
        <h1>爱云网盘!<br>iCloud Pan!<br>Super awesome!</h1>
        <p class="lead">产品不是一个人的战役，即使是天才的乔布斯，他也需要一个团队。只有最好的团队才能做好顶级的产品。iCloud团队，你值得信赖的团队！</p>
        <a class="btn btn-large btn-success" href="#" onclick="about();">立即使用</a>
      </div>
      <hr>
      <div class="span9">
        <div class="span2">
          <h2>安全</h2>
          <p>采用分布式存储技术，同时利用Iaas平台，确保您的确保数据安全。</p>
        </div>
        <div class="span2">
          <h2>简单</h2>
          <p>无需注册，无需键盘，使用手机微信二维码，扫一扫就登录。</p>
       </div>
        <div class="span2">
          <h2>快捷</h2>
          <p>拖拽你的文件到界面即可完成上传操作，使用二维码将你的文件分享给好友。</p>
        </div>
      </div>
      <hr>
      <div class="footer">
        <br>
        <center><p>&copy; iCloud 2013</p></center>
      </div>

    </div> <!-- /container -->
    <script src="js/bootstrap-modalmanager.js"></script>
    <script src="js/bootstrap-modal.js"></script>
<script type="text/javascript">

  $(function(){

    $.fn.modalmanager.defaults.resize = true;

    $('[data-source]').each(function(){
      var $this = $(this),
        $source = $($this.data('source'));

      var text = [];
      $source.each(function(){
        var $s = $(this);
        if ($s.attr('type') == 'text/javascript'){
          text.push($s.html().replace(/(\n)*/, ''));
        } else {
          text.push($s.clone().wrap('<div>').parent().html());
        }
      });
      
      $this.text(text.join('\n\n').replace(/\t/g, '    '));
    });

//    prettyPrint();
  });
</script>
<script language="javascript">
      function about(){
          var tmpl = [
    // tabindex is required for focus
    '<div class="modal hide fade" tabindex="-1" data-width="640">',
      '<div class="modal-header">',
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
        '<h3>使用微信扫一扫登录</h3>',
      '</div>',
      '<div class="modal-body">',
        '<center><img height="299px" src="<?php echo $qrimg;?>" /></center>',
      '</div>',
      '<div class="modal-footer">',
        '<a href="#" data-dismiss="modal" class="btn  btn-primary">取消</a>',
      '</div>',
    '</div>'
  ].join('');
  $(tmpl).modal();
      }
    </script>
  </body>
</html>
<?php
	session_start();
	$sid  = session_id();
if(!isset($_SESSION["Uin"])){
    header( "Location: index.php" );
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>iCloud Pan - The Best NetDiskSystem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-modal.css" rel="stylesheet"> 
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
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

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">iCloud Pan</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link"><?php echo $_SESSION["NickName"] ?></a>
            </p>
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about" onclick="about();">About</a></li>
              <li><a href="#contact" onclick="contact();">Contact</a></li>
              <li><a href="#share" onclick="share();">Share</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">功能列表</li>
              <li class="active"><a href="#"><i class="icon-folder-open"></i>所有文件</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">
          <div class="row-fluid">
            <button class="btn btn btn-success" onclick="refreshfilelist();"><i class="icon-refresh icon-white"></i> 刷新列表</button>
            <button class="btn btn btn-primary" onclick="create();"><i class="icon-upload icon-white"></i> 上传文件</button>
            <hr>
            <table id="filelist" class="table table-hover">
              <thead>
                <tr>
                  <th>文件名</th>
                  <th>时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; iCloud Team 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

<!-- jQuery -->
<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
<script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
    <script src="js/bootstrap-modalmanager.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/jquery.qrcode.js"></script>
    <script src="js/qrcode.js"></script>
  <script type="text/javascript">
var markup = "<tr><td><a href='http://hdfsm.qmcr.me:50075/webhdfs/v1/${pathSuffix}?op=OPEN' target='_blank'>${pathSuffix}</a></td><td>${accessTime}</td><td><button filepath='${pathSuffix}' class='btn btn-danger del'><i class='icon-remove icon-white'></i> 删除</button> <button filepath='${pathSuffix}' class='btn btn-info share'><i class='icon-globe icon-white'></i> 分享</button></td></tr>";
$.template( "fileTemplate", markup );


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

  });

    </script>
    <script language="javascript">
      function refreshfilelist(){
        window.parent.frames["xhr"].postMessage("LISTSTATUS", 'http://hdfsm.qmcr.me:50070');
      }

      function mkuserdir(filepath){
          window.parent.frames["mkdir"].postMessage(filepath, 'http://hdfsm.qmcr.me:50070');
      }

      function share(filepath){
          var tmpl = [
    // tabindex is required for focus
    '<div class="modal hide fade" tabindex="-1" data-width="760">',
      '<div class="modal-header">',
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
        '<h3>分享文件</h3>',
      '</div>',
      '<div class="modal-body center">',
    '<div id="qrcode"></div>',
        '<h4>http://hdfsm.qmcr.me:50075/webhdfs/v1/',filepath,'?op=OPEN</h2>',
      '</div>',
      '<div class="modal-footer">',
        '<a href="#" data-dismiss="modal" class="btn  btn-primary">关闭</a>',
      '</div>',
    '</div>'
  ].join('');
  $(tmpl).modal();
  $("#qrcode").qrcode({	color: '#403D40',text: 'http://hdfsm.qmcr.me:50075/webhdfs/v1/'+filepath+'?op=OPEN'});
      }


      function about(){
          var tmpl = [
    // tabindex is required for focus
    '<div class="modal hide fade" tabindex="-1" data-width="760">',
      '<div class="modal-header">',
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
        '<h3>About</h3>',
      '</div>',
      '<div class="modal-body">',
        '<h2>We are iCloud team!</h2>',
      '</div>',
      '<div class="modal-footer">',
        '<a href="#" data-dismiss="modal" class="btn  btn-primary">确定</a>',
      '</div>',
    '</div>'
  ].join('');
  $(tmpl).modal();
      }

      function contact(){
          var tmpl = [
    // tabindex is required for focus
    '<div class="modal hide fade" tabindex="-1" data-width="760">',
      '<div class="modal-header">',
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
        '<h3>Contact</h3>',
      '</div>',
      '<div class="modal-body">',
        '<h2>我们只接待高富帅和白富美，非诚勿扰!</h2>',
      '</div>',
      '<div class="modal-footer">',
        '<a href="#" data-dismiss="modal" class="btn  btn-primary">确定</a>',
      '</div>',
    '</div>'
  ].join('');
  $(tmpl).modal();
      }

      function ldelete(filepath){
          var tmpl = [
    // tabindex is required for focus
    '<div class="modal hide fade" tabindex="-1" data-width="760">',
      '<div class="modal-header">',
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
        '<h3>警告</h3>', 
      '</div>',
      '<div class="modal-body">',
        '您是否确定删除文件[ ',filepath,' ]?',
      '</div>',
      '<div class="modal-footer">',
        '<a href="#" onclick="" data-dismiss="modal" class="btn">取消</a>',
        '<a href="#" onclick="calldelete(\'',filepath,'\');" data-dismiss="modal" class="btn  btn-primary">确定</a>',
      '</div>',
    '</div>'
  ].join('');
  $(tmpl).modal();
      }
      function calldelete(filepath){
        window.parent.frames["del"].postMessage(filepath, 'http://hdfsm.qmcr.me:50070'); 
      }
      function create(){
          var tmpl = [
    // tabindex is required for focus
    '<div class="modal hide fade" tabindex="-1" data-width="760">',
      '<div class="modal-header">',
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
        '<h3>将文件拖拽至空白区域</h3>', 
      '</div>',
      '<div class="modal-body">',
        '<iframe id="upload" src="http://hdfsm.qmcr.me:9999" width="100%" height="350px" name="upload" frameborder="0"></iframe>',
      '</div>',
      '<div class="modal-footer">',
        '<a href="#" onclick="refreshfilelist();" data-dismiss="modal" class="btn">Close</a>',
      '</div>',
    '</div>'
  ].join('');
  $(tmpl).modal();
      }
    </script>
<script type="text/javascript">
  window.onload = function() {
    var onmessage = function(e) {
    console.log(e.data);
  if(e.data["boolean"]){

          var tmpl = [
    // tabindex is required for focus
    '<div class="modal hide fade" tabindex="-1" data-width="760">',
      '<div class="modal-header">',
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>',
        '<h3>提示</h3>',
      '</div>',
      '<div class="modal-body">',
        '删除成功！',
      '</div>',
      '<div class="modal-footer">',
        '<a href="#" data-dismiss="modal" class="btn  btn-primary">确定</a>',
      '</div>',
    '</div>'
  ].join('');
  $(tmpl).modal();
  window.parent.frames[0].postMessage("LISTSTATUS", 'http://hdfsm.qmcr.me:50070');
  }
  if (e.data["FileStatuses"]){
    $("#filelist tbody").remove();
  var files=e.data["FileStatuses"]["FileStatus"];
    files = jQuery.grep(files, function(o) {
  return o.type == "FILE";
});
  $.each(files,function(i,o){
      var d=new Date(o.accessTime);
      files[i].accessTime=d.toLocaleString();
      });
  $.tmpl( "fileTemplate", files )
      .appendTo( "#filelist" );
      $(".del").each(function(e,o){$(o).click(function(){ldelete($(o).attr('filepath'));});});
      $(".share").each(function(e,o){$(o).click(function(){share($(o).attr('filepath'));});});
  }
    };
	//监听postMessage消息事件
    if (typeof window.addEventListener != 'undefined') {
      window.addEventListener('message', onmessage, false);
    } else if (typeof window.attachEvent != 'undefined') {
      window.attachEvent('onmessage', onmessage);
    }

  };
$(document).ready(function() {
  mkuserdir();
});
</script>
     <iframe id="xhr" src="http://hdfsm.qmcr.me:50070/static/cros/xhr.html" name="xhr" width="0" height="0" frameborder="0"></iframe> 
     <iframe id="del" src="http://hdfsm.qmcr.me:50070/static/cros/del.html" name="del" width="0" height="0" frameborder="0"></iframe>
     <iframe id="mkdir" src="http://hdfsm.qmcr.me:50070/static/cros/mkdir.html" name="mkdir" width="0" height="0" frameborder="0"></iframe>
  </body>
</html>

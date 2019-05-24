<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <meta name="csrf-token" content="{{ csrf_token() }}">
      <h3>还没有三级分销账号？点此<a class="orange" href="{{asset('index/login/register')}}">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" name="u_emial" id="u_email" /></div>
       <div class="lrList"><input type="text" placeholder="输入密码" name="u_pwd" id="u_pwd" /></div> 
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="立即登录" id="btn" />
      </div>
     <div class="height1"></div>
@include('public/footer')
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/index/js/bootstrap.min.js"></script>
    <script src="/index/js/style.js"></script>
  </body>
</html>
<script>
    $(function(){
        $("#btn").click(function(){
            // alert(123);
            var u_email=$('#u_email').val();
            var reg=/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
            var u_pwd=$('#u_pwd').val();
            var flag= false;
            if(u_email==''){
                alert('邮箱账号不得为空');
                return false;
            }else if(!reg.test(u_email)){
                alert('邮箱格式不正确');
                return false;
            }else if(u_pwd==''){
                alert('登录密码不得为空');
                return false;
            }else{
               $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
            }
             $.post(
                "loginDo",
                {u_email:u_email,u_pwd:u_pwd},
                function(res){
                    if(res.code==1){
                        alert(res.count);
                        location.href="{{url('/')}}"
                    }else{
                        alert(res.count);
                    }
                },'json'
            );
        });
    });
</script>


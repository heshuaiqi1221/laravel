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
       @csrf
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
       <meta name="csrf-token" content="{{ csrf_token() }}">
      <h3>已经有账号了？点此<a class="orange" href="{{asset('index/login/login')}}">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" name="u_email" id="u_email" /></div>
       <div class="lrList2"><input type="text" placeholder="输入短信验证码"  name="u_code" class='u_code' /><a class="btn" href="javascript:void(0);" id="sendEmailCode">
              <span style=color:red;font-size:20px; id="span_email">获取</span>
          </a>
       <div class="lrList"><input type="text" placeholder="设置新密码（6-18位数字或字母）" name="u_pwd" id="u_pwd" /></div>
       <div class="lrList"><input type="text" placeholder="再次输入密码" name="u_pwd1" id="u_pwd1" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="立即注册" id="btn" />
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
      $("#sendEmailCode").click(function(){
        var u_email = $('#u_email').val();
        var reg=/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        var flag =false;
        if(u_email==''){
          alert('注册邮箱不得为空');
          return false;
        }else if(!reg.test(u_email)){
          alert('注册邮箱格式不正确')
          return false;
        }else{
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             //把邮箱传给控制器
            $.ajax({
              method:'post',
              url:'checkName',
              dataType:'json',
              async:false,
              data:{u_email:u_email}
            }).done(function(res){
              if(res.count){
                alert('邮箱已存在');
                flag=false;
              }else{
                flag=true;
              }
            });
            if(flag!=true){
              return flag;
            }
      }
      //秒数倒计时
        $("#span_email").text(30+'s');
        setI=setInterval(timeLess,1000);
        //把邮箱传给控制器  控制器发送邮件
        $.post(
          "sendCode",
          {u_email:u_email},
          function(res){
            // console.log(res);
            if(res.code==1){
              alert(res.count);
            }else{
              alert(res.count);
            }
          },
          'json'
        );
      });
      //倒计时
    function timeLess(){
      var _time=parseInt($("#span_email").text());
      if(_time<=0){
        $("#span_email").text('获取');
        clearInterval(setI);
            //允许点击
            $('#sendEmailCode').css("pointerEvents","auto");
        }else{
          //秒数减一
          _time=_time-1;
          $("#span_email").text(_time+'s');
            //不允许点击
            $('#sendEmailCode').css("pointerEvents","none");
        }
    }
    //验证码失去焦点
    $(".u_code").blur(function(){
      var u_code=$(this).val();
      var flag=false;
      $.ajax({
        method:'post',
        url:'checkYzm',
        dataType:'json',
        async:false,
        data:{u_code:u_code}
      }).done(function(res){
        // console.log(res);
        if(!res.code==1){
          alert('验证码错误');
          flag=false;
        }else{
          flag=true;
        }
      });
      if(flag!=true){
        return flag;
      }
    });
    });

    $('#btn').click(function(){
        var u_email=$('#u_email').val();
        var reg=/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        var u_code=$('.u_code').val();
        var u_pwd=$('#u_pwd').val();
        var u_pwd1=$('#u_pwd1').val();
        var flag=false;
        if(u_email==''){
            alert('注册邮箱不得为空');
            return false;
        }else if(!reg.test(u_email)){
            alert('注册邮箱格式不正确');
            return false;
        }else if(u_code==''){
            alert('验证码不得为空');
            return false;
        }else if(u_pwd==''){
            alert('密码不得为空');
        }else if(u_pwd1==''){
            alert('确认密码不得为空');
        }else if(u_pwd != u_pwd1){
            alert('两次密码必须一致');
        }else{
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             //把邮箱传给控制器
            $.ajax({
              method:'post',
              url:'checkName',
              dataType:'json',
              async:false,
              data:{u_email:u_email}
            }).done(function(res){
              if(res.count){
                alert('邮箱已存在');
                flag=false;
              }else{
                flag=true;
              }
            });
            if(flag!=true){
              return flag;
            }
        }
        $.post(
            "registerDo",
            {u_email:u_email,u_code:u_code,u_pwd:u_pwd},
            function(res){
              if(res.code==1){
                alert(res.count);
                location.href="{{url('index/login/login')}}"
              }else{
                alert(res.count);
              }
            },'json'
        );
    });
</script>
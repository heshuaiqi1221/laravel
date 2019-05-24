  <!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />
    
    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond./index/js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="login.html" method="get" class="reg-login">
              <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="收货人" id="address_name"/></div>
       <div class="lrList"><input type="text" placeholder="详细地址" id="address_detail" /></div>
       <div class="lrList">
        <select class="changearea" id="province">
         <option value="0" selected="selected">--请选择--</option>
         @if($provinceInfo)
         @foreach($provinceInfo as $v)
            <option value="{{$v->id}}">{{$v->name}}</option>
         @endforeach
         @endif
        </select>
       </div>
       <div class="lrList">
        <select class="changearea" id="city">
         <option value="0" selected="selected">--请选择--</option>
        </select>
       </div>
       <div class="lrList">
        <select class="changearea" id="area">
         <option value="0" selected="selected">--请选择--</option>
        </select>
       </div>
       <div class="lrList"><input type="text" placeholder="手机" id="address_tel" /></div>
       <div class="lrList2">
        <input type="checkbox" placeholder="设为默认地址" id="is_default" /> 
        <button>设为默认</button>
      </div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" value="保存" id="btn" />
      </div>
     </form><!--reg-login/-->
@include('public/footer')
<script src="/index/js/jquery.min.js"></script>
<script>

    $(function(){
        //收货地址
        $('.changearea').change(function(){
            var _this=$(this);
            _this.nextAll('select').html("<option value='0'>--请选择--</option>");
            var id=_this.val();
            $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $.post(
                "{{url('/index/address/getArea')}}",
                {id:id},
                function(res){
                  var _option="<option value='0'>--请选择--</option>";
                  for(var i =0;i<res.length; i++){
                      _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>";
                  }
                  _this.parent("div[class='lrList']").next("div").children('select').html(_option);
                },'json'
            );
        })
        //添加收货地址
        $('#btn').click(function(){
            var data={};
            data.address_name=$('#address_name').val();
            data.address_detail=$("#address_detail").val();
            data.province=$("#province").val();
            data.city=$("#city").val();
            data.area=$("#area").val();
            data.address_tel=$("#address_tel").val();
            data.is_default=$('#is_default').prop('checked');
            if(is_default=true){
                data.is_default=1;
            }else{
                data.is_default=2;
            }
            $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $.post(
                "{{url('index/address/addressdo')}}",
                data,
                function(res){
                  if(res.code==1){
                    alert(res.content);
                    location.href="{{url('index/address/lists')}}"
                  }else{
                    alert(res.content);
                  }
                }
            );
        });
    });
</script>
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
     <table class="shoucangtab">
      <tr>
       <td width="75%"><a href="{{url('/index/address/add')}}" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
       <td width="25%" align="center" style=background:#fff url(/index/images/xian.jpg) left center no-repeat;><a href="javascript:;" class="orange">删除信息</a></td>
      </tr>
     </table>
     
     <div class="dingdanlist">
      <table>
      @if($addressInfo)
      @foreach($addressInfo as $v)
       <tr>
        <td width="50%">
         <h3>{{$v->address_name}}  {{$v->address_tel}}</h3>
         <time>{{$v->province}} {{$v->city}} {{$v->area}}</time>
        </td>
        <td align="right"><a href="#" class="edit"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
        <td align="right"><a href="#" class="del"><span class="glyphicon glyphicon-check"></span> 删除信息</a></td>
       </tr>
      @endforeach
      @endif
      </table>
     </div><!--dingdanlist/-->
     
@include('public/footer')
<script src="/index/js/jquery.min.js"></script>
<script>
    $(function(){
        $('.edit').click(function(){
            var _this=$(this);
            _this.parents('div')
        });
    });
</script>
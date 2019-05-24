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
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
      <img src="/index/images/image1.jpg" />
      <img src="/index/images/image2.jpg" />
      <img src="/index/images/image3.jpg" />
      <img src="/index/images/image4.jpg" />
      <img src="/index/images/image5.jpg" />
     </div><!--sliderA/-->
     <table class="jia-len">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <tr goods_number="{{$data->goods_number}}" id="goods_id" goods_id="{{$data->goods_id}}  ">
       <th><strong class="orange">{{$data->shop_price}}</strong></th>
            <td align="center">
                  <div class="c_num">
                    <input type="hidden" id="goods_number" value="{{$data->goods_number}}">
                        <input type="button" value="-" class="less " />
                        <input type="text" value="1" name="" class="car_ipt buy_number" />
                        <input type="button" value="＋" class="add" />
                  </div>
            </td>
      </tr>
      <tr>
       <td>
        <strong>{{$data->goods_name}}</strong>
        <p class="hui">{{$data->keywords}}</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="{{config('app.img_url')}}{{$data->goods_img}}" width="636" height="822" />
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息....
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table border="1" width="500" height="50">
        <tr>
          <td>用户名:<input type="text" name="critical_name" id="critical_name"></td>
        </tr>
        <tr>
          <td>Emial:<input type="text" name="critical_email" id="critical_email"></td>
        </tr>
        <tr>
          <td>等级:
              <input type="radio" name="is_grade" id="is_grade" value="1❤">1级
              <input type="radio" name="is_grade" id="is_grade" value="2❤">2级
              <input type="radio" name="is_grade" id="is_grade" value="3❤">3级
              <input type="radio" name="is_grade" id="is_grade" value="4❤">4级
              <input type="radio" name="is_grade" id="is_grade" value="5❤">5级
          </td>
        </tr>
          <tr>
            <td>评论内容:<textarea name="critical_content" id="critical_content" cols="30" rows="10"></textarea></td>
          </tr>
          <tr><input type="button" name="" class="critical" value="提交评论"></tr>
     </table>
     <table>
        
        <tr style=color:red>
            <th>用户评论</th>
        </tr>
        @foreach($data2 as $v)
        <tr>
            <td>{{$v->critical_name}}&nbsp;&nbsp;&nbsp;&nbsp;{{$v->is_grade}}</td>
        </tr>
        <tr>
            <td>{{$v->critical_content}}</td>
        </tr>
        <tr>
            <td align=right>{{$v->created_at}}</td>
        </tr>
        <tr>
           <td><hr></td>
        </tr>
        @endforeach
    </table>
    {{ $data2->links()}}
     <table class="jrgwc">
      <tr>
       <th>
        <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a id="addcar">加入购物车</a></td>
      </tr>
     </table>
    </div><!--maincont-->
    @include('public/footer');
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/index/js/bootstrap.min.js"></script>
    <script src="/index/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/index/js/jquery.excoloSlider.js"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
     <!--jq加减-->

   <script>
	</script>
  </body>
</html>
<script>
    $(function(){
        //提交评论
        $('.critical').click(function(){
            var critical_name=$('#critical_name').val();
            var critical_email=$('#critical_email').val();
            var critical_content=$('#critical_content').val();
            var is_grade=$(':checked').val();
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.post(
                "critical",
                {critical_name:critical_name,critical_email:critical_email,critical_content:critical_content,is_grade:is_grade},
                function(res){
                    if(res.code==1){
                        alert(res.count);
                    }else{
                        alert(res.count);
                    }
                },'json'
            );
        });
        //点击加号
        $('.add').click(function(){
            var _this=$(this);
            //1.文本框数量+1 同时数据库或cookie中数量要发生改变
            var buy_number=parseInt(_this.prev('input').val());
            //获取库存
            var goods_number=_this.parents('tr').attr('goods_number');
            if(buy_number>=goods_number){
                _this.prop('disabled',true);
            }else{
                buy_number=buy_number+1;
                _this.prev('input').val(buy_number);
            }
            
        }); 
        //点击减号
        $('.less').click(function(){
            var _this=$(this);
            //1.文本框数量+1 同时数据库或cookie中数量要发生改变
            var buy_number=parseInt(_this.next('input').val());
            //获取库存
            var goods_number=_this.parents('tr').attr('goods_number');
            if(buy_number<=1){
                _this.prop('disabled',false);
            }else{
                buy_number-=1;
                _this.next('input').val(buy_number);
            }
        });
        //失去焦点
        $('.buy_number').blur(function(){
            var _this=$(this);
            var buy_number=$('.buy_number').val();
            var goods_number=$('#goods_number').val();
            var reg=/^\d+$/;
            if(buy_number=''||buy_number<=1||!reg.test(buy_number)){
                _this.val(1);
            }else if(parseInt(buy_number)>=parseInt(goods_number)){
                _this.val(goods_number);
            }else{
                buy_number=parseInt(buy_number);
                _this.val(buy_number);
            }
        });
        //加入购物车
        $('#addcar').click(function(){
            //获取商品id 购买数量
            var goods_id=$('#goods_id').attr('goods_id');
            var buy_number=$('.buy_number').val();
             if(goods_id==''){
            alert('请选择一件商品');
            return false;
            }
            if(buy_number==''){
                alert('请选择要购买的数量');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
            $.post(
                "{{url('index/goods/addcar')}}",
                {goods_id:goods_id,buy_number:buy_number},
                function(res){
                    if(res.code==1){
                        alert(res.count);
                        location.href="{{url('/index/car/car')}}"
                    }else{
                        alert(res.count);
                    }
                },'json'
            );
            return false;
        });
    });
</script>
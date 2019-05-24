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
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">2</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/index/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     <table>
        <tr>
          <td><input type="checkbox" id="allbox"> 全选 </td>
        </tr>
      </table>
       @if($data)
      @foreach($data as $v)
     <div class="dingdanlist" width="200px">
    <div class="dingdanlist">
      <table>
        <meta name="csrf-token" content="{{ csrf_token() }}">
       <tr goods_number="{{$v->goods_number}}" goods_id="{{$v->goods_id}}">
        <td width="4%"><input type="checkbox" class="box" /></td>
        <td class="dingimg" width="15%"><img src="{{config('app.img_url')}}{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{$v->create_time}}</time>
        </td>
        <!-- 小计 -->
        <td colspan="4" style=color:red>¥{{$v->total}}</td>

        <td align="right">
          <input type="button" class="less" value="-" style=width:17px; />
          <input type="text" style=width:17px; value="{{$v->buy_number}}" class="buy_number" />  
          <input type="button" class="add" value="+" style=width:17px;/>
        </td>
        <td align="right">
          <input type="button" id="del" value="删除">
        </td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
      @endforeach
      @endif
     </div><!--dingdanlist/-->
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
      <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<b style=font-size:20px;color:red;>￥<font id="count">0</font></b></td>
       <td width="40%"><a href="javascript:;" id="confirmOrder" class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/index/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/index/js/bootstrap.min.js"></script>
    <script src="/index/js/style.js"></script>
    <!--jq加减-->
    <script src="/index/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
	</script>
  </body>
</html>
<script>
    $(function(){
      //全选
      $('#allbox').click(function(){
          // alert(111);
          var status=$(this).prop('checked');
          // console.log(status);
          $('.box').prop('checked',status);

          //调用商品总价
          getCount();
      })
      //点击复选框
      $(".box").click(function(){
          //获取总价
          getCount(); 
      });
      //点击加号
        $('.add').click(function(){
            var _this=$(this);
            var buy_number=parseInt(_this.prev('input').val());
            var goods_number=_this.parents('tr').attr('goods_number');
            //改变购买数量
            var goods_id=_this.parents('tr').attr('goods_id');
            //判断是否大于库存
            if(buy_number>=goods_number){
                //失效加号
                _this.prop('disabled',true);
            }else{
                buy_number+=1;
                _this.prev('input').val(buy_number);
                _this.parent().children('input').first().prop('disabled',false);
            }

            //更改购买数量
            changeBuyNumber(goods_id,buy_number);

            //获取小计
            getSubTotal(goods_id,_this);

            //给当前复选框选中
            boxChecked(_this);
            //4.重新获取总价
            getCount();
        });
      //点击减号
        $('.less').click(function(){
            var _this=$(this);
            var buy_number=parseInt(_this.next('input').val());
            //改变购买数量
            var goods_id=_this.parents('tr').attr('goods_id');
            //判断是否大于库存
            if(buy_number<=1){
                //失效加号
                _this.prop('disabled',true);
            }else{
                buy_number-=1;
                _this.next('input').val(buy_number);
                _this.parent().children('input').last().prop('disabled',false);
            }

            //更改购买数量
            changeBuyNumber(goods_id,buy_number);

            //获取小计
            getSubTotal(goods_id,_this);
            //4.重新获取总价
            getCount();
        });
        //失去焦点
          $('.buy_number').blur(function(){
              var _this=$(this);
              //改变购买数量
              var buy_number=_this.val();
              var goods_number=_this.parents('tr').attr('goods_number');
              //验证
              var reg=/^\d{1,}$/;
              if(buy_number==''||buy_number<=1||!reg.test(buy_number)){
                  _this.val(1);
              }else if(parseInt(buy_number)>=parseInt(goods_number)){
                  _this.val(goods_number);
              }else{
                  _this.val(parseInt(buy_number));
              }
              //控制器改变购买数量
              var goods_id=_this.parents('tr').attr('goods_id');
              changeBuyNumber(goods_id,buy_number);

              //复选框选中
              // boxChecked(_this);

              //改变小计
              getSubTotal(goods_id,_this);
          });
          $.ajaxSetup({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
          });
          //获取小计
          function getSubTotal(goods_id,_this){
              $.post(
                  "{{url('/index/car/getSubTotal')}}",
                  {goods_id:goods_id},
                  function(res){
                      _this.parents('td').prev('td').text('￥'+res);
                  }
              );
          }
          //更改购买数量
          function changeBuyNumber(goods_id,buy_number){
              $.ajax({
            url:'/index/car/changeBuyNumber',
            method:'post',
            data:{goods_id:goods_id,buy_number:buy_number},
            dataType:'json',
            async:false
            }).done(function(res){
            // console.log(res);
            if(res==2){
              // alert('更改数量失败');
              location.href="{{url('/index/car/car')}}"
            }
            });
          }
          //给当前复选框选中
          function boxChecked(_this)
          {
              _this.parents('tr').find("input[class='box']").prop('checked',true);
          }
          //删除
          $('#del').click(function(){
              var _this=$(this);
              var goods_id=_this.parents('tr').attr('goods_id');
              $.post(
                  "{{url('/index/car/cartdel')}}",
                  {goods_id:goods_id},
                  function(res){
                      if(res.code==1){
                          alert(res.count);
                          location.href="{{url('/index/car/car')}}"
                      }else{
                          alert(res.count);
                      }
                  }
              );
          });
          //给重新获取总价
          function getCount(){
              //获取所有选中的复选框 对应的id
              var _box=$('.box');
              var goods_id='';
              _box.each(function(index){
                  if($(this).prop('checked')==true){
                      goods_id+=$(this).parents('tr').attr('goods_id')+',';
                  }
              })
              //去掉最后一个
              goods_id=goods_id.substr(0,goods_id.length-1);
              // console.log(goods_id);
              //把商品id传给控制器 获取商品总价
              $.post(
                  "{{url('/index/car/getCount')}}",
                  {goods_id:goods_id},
                  function(res){
                    $('#count').text(res);
                  }
              );
          }
          //点击确认结算
          $('#confirmOrder').click(function(){
                //获取复选框
                var len=$('.box:checked').length;
                console.log(len);
                if(len==0){
                  alert('请至少选择一件商品');
                  return false;
                }
                //获取选中的复选框商品id
                var goods_id='';
                $('.box:checked').each(function(){
                    goods_id+=$(this).parents('tr').attr('goods_id')+',';
                });
                 goods_id=goods_id.substr(0,goods_id.length-1);
                 // console.log(goods_id);
                 location.href="{{url('/index/order/lists')}}?goods_id="+goods_id;
          });
    });
</script>
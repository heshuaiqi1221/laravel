<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{asset('css/page.css')}}">
        <script type="text/javascript" src="/admin/js/jquery.min.js"></script>
    </head>
    <body>
        <form>
            move标题<input type="text" name="move_name" value="{{$query['move_name']??''}}" placeholder="请输入关键字">
            <button>搜索</button>
        </form>
        <a href="{{url('move/add')}}">返回添加</a>
        <br>

        @csrf

		<table border="1">
            <meta name="csrf-token" content="{{ csrf_token() }}">
			<tr align="center">
                <td>id</td>
				<td>move标题</td>
				<td>move分类</td>
                <td>moveLOGO</td>
                <td>是否显示</td>
                <td>添加日期</td>
                <td colspan="2">操作</td>
			</tr>
            @if($data)
            @foreach($data as $v)
            <tr align="center" move_id={{$v->move_id}}>
                <td>{{$v->move_id}}</td>
                <td>{{$v->move_name}}</td>
                <td>{{$v->c_name}}</td>
                <td><img src="{{config('app.img_url')}}{{$v->move_logo}}" width="100"></td>
                <td>{{$v->is_show}}</td>
                <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                <td class="del">
                    <a href="javascript:;" id="{{$v->move_id}}">删除</a>
                </td>
                <td>
                    <a href="edit/{{$v->move_id}}">修改</a>
                </td>
            </tr>
            @endforeach
            @endif
		</table>
      {{$data->appends($query)->links()}}
    </body>
</html>
<script>
   $(function(){
      //点击删除
      $(document).on('click','.del',function(){
          var _this=$(this);
          var move_id=_this.parents('tr').attr('move_id');
          if(!move_id){
            alert('请选择一条记录');
          }
          //基于 AJAX 的请求提供了简单、方便的方式来避免 CSRF 攻击： 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          //把商品id传给控制器
          $.post(
              "{{url('/move/destroy')}}",
              {move_id:move_id},
              function(res){
                  window.location.href="/move/lists";
              }
          );   
      }),'json'

  });
</script>
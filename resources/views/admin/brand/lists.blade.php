<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{asset('css/page.css')}}">
    </head>
    <body>
        <form>
                          <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="text" name="brand_name" value="{{$query['brand_name']??''}}" placeholder="请输入名称关键字">
            <input type="text" name="brand_url" value="{{$query['brand_url']??''}}" placeholder="请输网址入关键字">
            <button>搜索</button>
        </form>
        <a href="{{url('brand/add')}}">返回添加</a>
        <br>
        <div id="con"> 
		<table border="1">
            
                <tr>
                <td>id</td>
                <td>品牌名称</td>
                <td>品牌描述</td>
                <td>品牌LOGO</td>
                <td>品牌网址</td>
                <td>操作</td>
            </tr>
            @if($data)
            @foreach($data as $v)
            <tr>
                <td><a href="brand/show">{{$v->brand_id}}</a></td>
                <td><a href="show/{{$v->brand_id}}">{{$v->brand_name}}</a></td>
                <td>{{$v->brand_desc}}</td>
                <td><img src="{{config('app.img_url')}}{{$v->brand_logo}}" width="100"></td>
                <td>{{$v->brand_url}}</td>
                <td>
                    <a href="del/{{$v->brand_id}}">删除</a>
                    <a href="edit/{{$v->brand_id}}">编辑</a>
                </td>
            </tr>
            @endforeach
            @endif
		</table>
        {{ $data->appends($query)->links() }}
         </div>
        
    </body>
</html>
<script src="/index/js/jquery.min.js"></script>
<script>
   $(document).on('click','.pagination a',function(){
        var url=$(this).prop('href');
        $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
        $.ajax({
          method: "GET",
          url: url,
          data: '',
        }).done(function( msg ) {
          $('#con').html(msg);
        });
        return false;
   });
</script>
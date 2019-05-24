<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="">
        <script type="text/javascript" src="/admin/js/jquery.min.js"></script>
    </head>
    <body>
        @if ($errors->any())
        <div class="alert alert-danger">         
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    	<form action="/move/update/{{$data->move_id}}" method="post" enctype="multipart/form-data">
            <!-- <input type="hidden" name="_token" value="{{csrf_token()}}"> -->
            @csrf
    		<table>
                <meta name="csrf-token" content="{{ csrf_token() }}">
    			<tr>
    				<td>文章标题：</td>
    				<td><input type="text" class="move_name" name="move_name" value="{{$data->move_name}}"></td>
    			</tr>
                <tr>
                    <td>文章分类：</td>
                    <td>
                        <select name="c_id" id="c_name">
                            <option value="">请选择分类</option>
                            @foreach($res as $v)
                            <option value="{{$v->c_id}}" selected>{{$v->c_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>是否显示：</td>
                    <td>
                        <input type="radio" class="is_show" name="is_show" value="是" @if($data->is_show =='是') checked @endif/>是
                        <input type="radio" class="is_show" name="is_show" value="否" @if($data->is_show =='否') checked @endif/>否
                    </td>
                </tr>
    			<tr>
    				<td>网页描述：</td>
                    <td><textarea name="move_desc" class="move_desc" cols="30" rows="10">{{$data->move_desc}}</textarea></td>
    			</tr>
                <tr>
                    <td>上传文件</td>
                    <td><img src="{{config('app.img_url')}}{{$data->move_logo}}" width="100"><input type="file" name="move_logo" class="move_logo" ></td>
                </tr>
                <tr>
                    <td><input type="submit" name="" class="sub" value="修改"></td>
                </tr>
    		</table>
            <a href="{{url('move/lists')}}">展示</a>
    	</form>
    </body>
</html>
<script>
   //$(function(){
        // $(".sub").click(function(){
        //     var move_name = $(".move_name").val();
        //     var move_logo = $(".move_logo").val();
        //     var is_show = $(".is_show").val();
        //     var c_id = $("#c_id").val();
        //     var move_desc = $(".move_desc").val();
        //     var _token=$("input:hidden").val();
        //     if(move_name==''){
        //         alert('move标题不得为空');
        //         return false;
        //     }
        //     var reg=/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/;
        //     if(!reg.test(move_name)){
        //         alert("标题必须是中文字幕数字下划线");
        //         return false;
        //     }
        //     var c_name=$("#c_name").val();
        //     if(c_name==''){
        //         alert('分类不得为空');
        //         return false;
        //     }
            // var fd = new FormData($('#tf')[0]);
            // $.ajax({
            //     method: "POST",
            //     url: "/move/add_do",
            //     data: fd,
            //     dataType:'json',
            //     processData:false,
            //     contentType:false,
            // }).done(function(msg){
            //     if(msg.code==0){
            //         if(msg.data.move_name){
            //             $('.errorname').text(msg.data.brand_name);
            //         }
            //          if(msg.data.move_desc){
            //             $('.errordesc').text(msg.data.brand_name);
            //         }
            //     }
            //     if(msg.code==1){
            //         window.location.href='/move/lists';
            //     }
            // });
   //      }); 
   // });
</script>
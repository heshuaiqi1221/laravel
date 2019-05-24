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
    	<form action="{{url('/move/add_do')}}" method="post" id="tf" enctype="multipart/form-data">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @csrf
    		<table>
    			<tr>
    				<td>文章标题：</td>
    				<td><input type="text" class="move_name" name="move_name"><b class="errorname"></b></td>
    			</tr>
                <tr>
                    <td>文章分类：</td>
                    <td>
                        <select name="c_id" id="c_id">
                            <option value="">请选择分类</option>
                            @foreach($data as $v)
                            <option value="{{$v->c_id}}">{{$v->c_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>是否显示：</td>
                    <td>
                        <input type="radio" class="is_show" name="is_show" value="是"/>是
                        <input type="radio" class="is_show" name="is_show" value="否" />否
                    </td>
                </tr>
    			<tr>
    				<td>网页描述：</td>
                    <td><textarea name="move_desc" class="move_desc" cols="30" rows="10"></textarea><b class="errordesc"></td>
    			</tr>
                <tr>
                    <td>上传文件</td>
                    <td><input type="file" name="move_logo" class="move_logo"></td>
                </tr>
                <tr>
                    <td><input type="button" name="" class="sub" value="提交"></td>
                </tr>
    		</table>
            <a href="{{url('move/lists')}}">展示</a>
    	</form>
    </body>
</html>
<script>
    $(function(){
        //基于 AJAX 的请求提供了简单、方便的方式来避免 CSRF 攻击： 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $(".sub").click(function(){
            var move_name = $(".move_name").val();
            var move_logo = $(".move_logo").val();
            var is_show = $(".is_show").val();
            var c_id = $("#c_id").val();
            var move_desc = $(".move_desc").val();
            var _token=$("input:hidden").val();
            var flag=true;
            if(move_name==''){
                alert('move标题不得为空');
                return false;
            }
            var reg=/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/;
            if(!reg.test(move_name)){
                alert("标题必须是中文字幕数字下划线");
                return false;
            }
            var c_name=$("#c_name").val();
            if(c_name==''){
                alert('分类不得为空');
                return false;
            }
            var fd = new FormData($('#tf')[0]);
            $.ajax({
                method: "POST",
                url: "/move/add_do",
                data: fd,
                dataType:'json',
                processData:false,
                contentType:false,
            }).done(function(msg){
                if(msg.code==0){
                    if(msg.data.move_name){
                        $('.errorname').text(msg.data.brand_name);
                    }
                     if(msg.data.move_desc){
                        $('.errordesc').text(msg.data.brand_name);
                    }
                }
                if(msg.code==1){
                    window.location.href='/move/lists';
                }
        });
    });
        //失去焦点
            $('.move_name').blur(function(){
                var move_name=$(this).val();
                if(move_name==''){
                    alert('move名称不得为空');
                    return false;
                }
                var reg=/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/;
                if(!reg.test(move_name)){
                    alert("标题必须是中文字幕数字下划线");
                    return false;
                }
                $('.move_desc').blur(function(){
                var move_desc=$(this).val();
                if(move_desc==''){
                    alert('网页描述不得为空');
                    return false;
                }
            });
            $.ajax({
                method: "POST",
                url: "/move/checkName",
                dataType:'json',
                async:false,
                data: {move_name:move_name},
            }).done(function(msg){
                if(msg.count){
                    alert('move名称已存在');
                    flag= false
                }
             });
            if(!flag){
                return;
            }
           
         }); 
            
    });
        

</script>
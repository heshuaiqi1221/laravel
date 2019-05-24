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
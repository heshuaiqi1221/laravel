<div class="conShow">
					
						<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">ID</td>
							<td width="435px" class="tdColor">分类名称</td>
							<td width="400px" class="tdColor">是否显示</td>
							<td width="630px" class="tdColor">添加时间</td>
							<td width="130px" class="tdColor">操作</td>
						</tr>
						@if($data)
            			@foreach($data as $v)
						<tr height="40px">
							<td>{{$v->cate_id}}</td>
							<td>{{$v->cate_name}}</td>
							<td>{{$v->is_show}}</td>
							<td>{{$v->addtime}}</td>
							<td><a href="connoisseuradd.html"><img class="operation"
									src="../admin/img/update.png"></a> <img class="operation delban"
								src="../admin/img/delete.png"></td>
						</tr>
						@endforeach
            			@endif
					</table>
					
					{{ $data->appends(['keywords'=>$keywords])->links() }}
					</div>
		
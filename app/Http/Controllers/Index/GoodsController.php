<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\model\Goods;
use App\model\Critical;
class GoodsController extends Controller
{
	//列表展示
    public function proinfo(Request $request,$goods_id)
    {
        // dd($goods_id);
        $data=cache('data_'.$goods_id);
        // dd($data);
        if(!$data){
            echo 'db';
            $where=[
                'goods_id'=>$goods_id
            ];
            $data = DB::table('goods')->where($where)->first();
            cache(['data_'.$goods_id=>$data],1);
        }
        $PageSize=config('app.PageSize');
    	$data2=Critical::orderBy('critical_id','desc')->paginate($PageSize);
    	
    	return view('index/goods/proinfo',['data'=>$data,'data2'=>$data2,'goods_id'=>$goods_id]);	
    }
    //加入购物车
    public function addcar(Request $request){
        $goods_id=request()->goods_id;
        $buy_number=request()->buy_number;
        $goodsInfo = DB::table('goods')->where('goods_id',$goods_id)->first();
        $shop_price=$goodsInfo->shop_price;
        if(empty($goods_id)){
            alert('请至少选择一件欧品');die;
        }
        if(empty($buy_number)){
            echo '请选择要购买的数量';die;
        }
        //根据用户id，商品id判断用户是否买过此商品
        $user_id=session('u_id');
        $where=[
            'user_id'=>$user_id,
            'goods_id'=>$goods_id,
            'is_del'=>1
        ]; 
          //查询一跳
        $cartInfo=DB::table('cart')->where($where)->first();
        if(!empty($cartInfo)){
            //用户买过之后 判断库存 累加
            $number=$cartInfo->buy_number;
            //查询根据id查询商品库存
            $goods_number=DB::table('goods')->where('goods_id',$goods_id)->value('goods_number');
            //检测库存
            if($buy_number+$number>$goods_number){
                echo "超出库存";die;
            }
            //没超库存执行修改数据
            $updateInfo=[
                //已加入购车的数量+将要购买数量
                'buy_number'=>$number+$buy_number
            ];
            $result=DB::table('cart')->where($where)->update($updateInfo);
        }else{
            // echo "添加";die;
            //没买过 判断库存 添加
            //根据id查询商品库存
            $goods_number=DB::table('goods')->where('goods_id',$goods_id)->value('goods_number');
            // echo $goods_number;exit;
            //监测商品库存
            if($buy_number>$goods_number){
                echo "超过库存";die;
            }
            $info=[
                'goods_id'=>$goods_id,
                'buy_number'=>$buy_number,
                'user_id'=>$user_id
            ];
            // print_r($info);die;
            $result=DB::table('cart')->insert($info);
        }
        if($result){
            return ['code'=>1,'count'=>'加入购物车成功'];
        }else{
            return ['code'=>0,'count'=>'加入购物车失败'];
        }
    }
    //添加评论
    public function critical(Request $request){
        $res=$request->input();
        $result=Critical::insert($res);
        if($result){
            return ['code'=>1,'count'=>'评论成功'];
        }else{
            return ['code'=>2,'count'=>'评论失败'];
        } 
    }

}

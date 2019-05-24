<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class CarController extends Controller
{
    //购物车列表
    public function car(Request $request)
    {
    	// echo "购物车";die;
        //根据用户id查询商品id
        $user_id=session('u_id');
        // dd(session('u_id'));
        $where=[
            ['user_id','=',$user_id],
            ['is_on_sale','=',1],
            ['is_del','=',1]
        ];
        // dd($where);
        $data=DB::table('cart')
            ->join('goods','cart.goods_id','=','goods.goods_id')
            ->where($where)
            ->orderBy('cart_id')
            ->get();
         // print_r($data);exit;
        
        // 获取小计
        if(!empty($data)){
            foreach ($data as $k => $v) {
                $total=$v->shop_price*$v->buy_number;
                $data[$k]->total=$total;
            }
        }

    	return view('index/car/car',['data'=>$data]);
    }

    //获取小计
    public function getSubTotal(Request $request){
    	$goods_id=request()->goods_id;
    	//获取商品价格
    	$goodsWhere=[
    		['is_on_sale','=',1],
    		['goods_id','=',$goods_id]
    	];
    	$shop_price=DB::table('goods')->where($goodsWhere)->value('shop_price');
    	//根据商品购买数量
    	//根据用户id
    	$user_id=session('u_id');
    	$cartWhere=[
    		['goods_id','=',$goods_id],
    		['user_id','=',$user_id]
    	];
    	$buy_number=DB::table('cart')->where($cartWhere)->value('buy_number');
    	$total= $shop_price*$buy_number;
    	// dd($total);
    	echo $total;


    	
    }
    //改变购买数量
    public function changeBuyNumber(Request $request){
    	// echo "更改购买数量";die;
        $goods_id=request()->goods_id;
        $buy_number=request()->buy_number;
        // echo $goods_id;
        // echo $buy_number;exit;
        //根据id查询商品库存
        $goods_number=DB::table('goods')->where('goods_id',$goods_id)->value('goods_number');
        // echo $goods_number;exit;
        //监测商品库存
        if($buy_number>$goods_number){
            echo "超过库存";die;
        }

        //获取用户id
        $user_id=session('u_id');
        // echo $user_id;die;
        $where=[
            'goods_id'=>$goods_id,
            'user_id'=>$user_id
        ];
        $updateInfo=[
            'buy_number'=>$buy_number
        ];
        $result=DB::table('cart')->where($where)->update($updateInfo);
        // dump($result);die;
        if($result){
            echo 1;
        }else{
            echo 2;
        }
    }

    //删除购物车数据
    public function cartdel(Request $request){
        $goods_id=request()->goods_id;
        if (empty($goods_id)) {
            alert('请至少选择一个商品进行删除');
        }
        $res = DB::table('cart')->where('goods_id',$goods_id)->delete();
        if($res){
        	return ['code'=>1,'count'=>'删除成功'];
        }else{
        	return ['code'=>0,'count'=>'删除失败'];
        }
    }
    //重新获取总价
    public function getCount(){
    	$goods_id=request()->goods_id;
    	$goods_id=explode(',',$goods_id);
    	//获取用户id
    	$user_id=session('u_id');
    	// dd(session('u_id'));
    	$where=[
    		'user_id'=>$user_id
    	];
    	$info=DB::table('cart')
    	->select('shop_price','buy_number')
    	->join('goods','cart.goods_id','=','goods.goods_id')
    	->where($where)
    	->whereIn('cart.goods_id',$goods_id)
    	->get();
    	// print_r($info);die;
    	$count=0;
    	foreach($info as $k=>$v){
    		$count+=$v->shop_price*$v->buy_number;
    	}
    	echo $count;
    }
    
}

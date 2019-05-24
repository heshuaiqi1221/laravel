<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class AddressController extends Controller
{
	  //收货地址
    public function lists()
    {
    	// echo "收货地址";die;
        //查询收货地址列表
        $addressInfo=$this->getAddressInfo();
        // print_r($addressInfo);exit;
        
    	return view('/index/address/lists',compact('addressInfo'));
    }

    //查询收货地址列表
    public function getAddressInfo()
    {
        //获取用户id
        $user_id=session('u_id');
        // dd(session('u_id'));
        $where=[
            ['is_del','=',1],
            ['user_id','=',$user_id]
        ];
        $addressInfo=DB::table('address')->where($where)->get();
        // dump($addressInfo);exit;
        if(!empty($addressInfo)){
            //处理省市区
            foreach ($addressInfo as $k => $v) {
                $addressInfo[$k]->province=DB::table('Area')->where('id',$v->province)->value('name');
                $addressInfo[$k]->city=DB::table('Area')->where('id',$v->city)->value('name');
                $addressInfo[$k]->area=DB::table('Area')->where('id',$v->area)->value('name');
            }
            return $addressInfo;
        }else{
            return false;
        }
    }

    //添加收货地址
    public function add()
    {
        // echo "添加收货地址";die;
        //查询省份
        $provinceInfo=$this->getAreaInfo(0);
        // print_r($provinceInfo);exit;
        return view('index/address/add',compact('provinceInfo'));
    }

    //获取地区
    public function getAreaInfo($pid)
    {
        $where=[
            ['pid','=',$pid]
        ];
        $areaInfo=DB::table('area')->where($where)->get();
        return $areaInfo;
    }
    
    //获取区域
    public function getArea()
    {
        // echo "获取区域";die;
        $id=request()->id;
        $aresInfo=$this->getAreaInfo($id);
        // print_r($aresInfo);die;
        echo json_encode($aresInfo);
    }
    //添加收货地址
    public function addressdo(){
    	$data=request()->all();
        $user_id=session('u_id');
        // dd($id);
        $data['user_id']=$user_id;
        //添加时修改状态
        if($data['is_default']==1){
            $where=[
                ['user_id','=',$user_id],
                ['is_del','=',1]
            ];
            DB::table('address')->where($where)->update(['is_default'=>2]);
        }
            $res=DB::table('address')->insert($data);
            if($res){
                return ['code'=>1,'content'=>'添加收货地址成功'];
            }else{
                return ['code'=>0,'content'=>'加入收货地址失败'];
            }
        
    }
}
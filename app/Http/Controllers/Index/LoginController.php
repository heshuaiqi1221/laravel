<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Login;
use DB;
class LoginController extends Controller
{
	//登录
    public function login(){
    	return view('/index/login/login');
    }
    //判断登录
    public function loginDo(Request $request){
        $u_email=request()->u_email;
        $u_pwd=request()->u_pwd;
        $u_pwd=md5($u_pwd);
        $where=[
            'u_email'=>$u_email
        ];
        $userInfo=DB::table('user')->where($where)->first();
        // print_r($userInfo);die;
        $u_id=$userInfo->u_id;
        if(empty($userInfo)){
            // echo "用户错误";
            return ['code'=>0,'count'=>'用户或密码错误'];
        }else{
            // echo "用户正确";
            if($userInfo->u_pwd==$u_pwd){
                // echo "密码正确";
                session(['u_id'=>$u_id]);
                return ['code'=>1,'count'=>'登陆成功'];
            }else{
                // echo "密码错误";
                return ['code'=>0,'count'=>'用户或密码错误'];
            }
            
        }	
    }
    //注册
    public function register(){

    	return view('/index/login/register');
    }
    //执行注册
    public function registerDo(Request $request){
    	$data=$request->input();
    	// dd($data);
    	$data['u_pwd']=md5($data['u_pwd']);
    	$data['create_time']=time();
    	$res = Login::insert($data);
    	if($res){
    		return ['code'=>1,'count'=>'注册成功'];
    	}else{
    		return ['code'=>0,'count'=>'注册失败'];
    	}
    }
    //发送邮件
    public function sendCode(Request $request){
    	$u_email=request()->u_email;
    	$rand=rand(1000,9999);
    	session(['u_email'=>$u_email]);
    	session(['rand'=>$rand]);
    	$res = $this->send($u_email,$rand);
    	if(!$res){
    		return ['code'=>1,'count'=>'发送成功'];

    	}else{
    		return ['code'=>0,'count'=>'发送失败'];
    	}
    }
    //调用方法
    public function send($u_email,$rand){
    	 \Mail::raw('验证码:'.$rand,function($message)use($u_email){
        //设置主题
            $message->subject("验证码");
        //设置接收方
            $message->to($u_email);
        });
    }
    public function checkName(){
    	// echo 1;die;
        $u_email=request()->u_email;
        // dd($u_email);
        if($u_email){
            $where['u_email']=$u_email;
            $count=DB::table('user')->where($where)->count();
            return ['code'=>1,'count'=>$count];
        }
    }
    //判断验证码
    public function checkYzm(){
    	$u_code=request()->u_code;
    	if($u_code==session('rand')){
    		return ['code'=>1];
    	}else{
    		return ['code'=>0];
    	}
    }
}

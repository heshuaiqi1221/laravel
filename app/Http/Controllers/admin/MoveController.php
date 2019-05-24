<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DB;
use App\model\Clas;
use App\model\Move;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    /**
     * Display a listing of the resource.
     *展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query=request()->all();
        $where=[];
        if(($query['move_name']??'')){
            $where[]=[
                'move_name','like',"%$query[move_name]%"
            ];
        }
        $PageSize=config('app.PageSize');
        $data=Move::join('clas','move.c_id','=','clas.c_id')->where($where)->orderBy('move_id','asc')->paginate($PageSize);
        return view('admin/move/lists',['data'=>$data,'query'=>$query]);
    }
    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $res = Clas::get();
        return view('admin/move/add',['data'=>$res]);
    }

    
    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    // public function store(StoreBrandPost $request)
    {
        $data = $request->except(['_token']);
        //验证
        $validator = \Validator::make($request->all(),[
            'move_name'=>'required|unique:move',
            'move_desc'=>'required',
            'is_show'=>'required',
            'move_logo'=>'required'
        ],[
            'move_name.required'=>'move名称不能为空',
            'move_name.unique'=>'move标题不的重复',
            'move_desc.required'=>'内容不能为空'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return ['code'=>0,'data'=>$errors];
            // return redirect('move/add')
            // ->withErrors($validator)
            // ->withInput();
        }
        //文件上传
        if($request->hasFile('move_logo')){
            $res=$this->upload($request,'move_logo');
            // dd($res);
            if($res['code']){
                $data['move_logo']=$res['imgurl'];
            }
        }
        $data['add_time']=time();
        $res = Move::insert($data);
        if($res){
            return ['code'=>1,'msg'=>'成功'];
        }

        // if($res){
        //     return redirect('/move/lists');
        // }else{
        //     return error('添加失败','/move/add');
        // }
    }
    public function upload(Request $request,$file)
    {
        if($request->file($file)->isValid()){
            $photo = $request->file($file);
            // dump($photo);die;
            // $extension = $photo->extension();
            $store_result = $photo->store(date('Ymd'));
            // dump($store_result);die;
            // $store_result = $photo->storeAs('photo', 'test.jpg');
            
            return ['code'=>1,'imgurl'=>$store_result];
        }else{
            return ['code'=>0,'message'=>'上传过程出错'];
        }
    }

    public function destroy(Request $request)
    {
        $move_id = request()->move_id;
        $res =Move::destroy($move_id);
        if($res){
            return ['code'=>1,'msg'=>'删除成功',];
        }else{
            return ['code'=>0,'msg'=>'删除失败'];
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *修改
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res=DB::table('clas')->get();
        $where=[
            'move_id'=>$id
        ];
        $data = DB::table('move')->where($where)->first();
        // dump($data);die;
        return view('admin/move/edit',compact('data','res'));
    }

    /**
     * Update the specified resource in storage.
     *执行修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=request()->except('_token');
         //验证
        $validator = \Validator::make($request->all(),[
            'move_name'=>'required|unique:move',
            'move_desc'=>'required',
            'is_show'=>'required',
            'move_logo'=>'required'
        ],[
            'move_name.required'=>'move名称不能为空',
            'move_name.unique'=>'move标题不的重复',
            'move_desc.required'=>'内容不能为空'
        ]);
        if ($validator->fails()) {
            // $errors = $validator->errors();
            // return ['code'=>0,'data'=>$errors];
            return redirect('move/edit/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        //文件上传
        if($request->hasFile('move_logo')){
            $res=$this->upload($request,'move_logo');
            // dd($res);
            if($res['code']){
                $data['move_logo']=$res['imgurl'];
            }
        }
        $res = Move::where('move_id',$id)->update($data);
        // dd($res);
        if($res){
            return redirect('/move/lists');
        }
    }
    //唯一性验证
    public function checkName(Request $request){
        $move_name = request()->move_name;
        if($move_name){
            $where['move_name'] = $move_name;
            $count = Move::where($where)->count();
            return ['code'=>1,'count'=>$count];
        }
    }
}

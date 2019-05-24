<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreBrandPost;
use DB;
use App\model\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $keywords=request()->keywords;
        $where=[];
        if($keywords){
            $where[]=[
                'cate_name','like',"%$keywords%"
            ];
        }

        $PageSize=config('app.PageSize');
        // $data=DB::table('admin')->where($where)->paginate($PageSize);
        $data=Category::where($where)->paginate($PageSize);
        // dd($data);
        return view('admin.category.lists',['data'=>$data,'keywords'=>$keywords]);
    }

    /**
     * Show the form for creating a new resource.
     *添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo '添加';
        $res = Category::get();
        $res = $this -> createTree($res);
        // dd($res);
        return view('admin.category.add',['data'=>$res]);
    }

    // 无限极分类
    function createTree($data,$field='cate_id',$parent_id = 0,$level = 1)
    {
        static $result = [];
        if ($data) {
            foreach ($data as $key => $val) {
                if ($val['parent_id'] == $parent_id) {
                    $val['level'] = $level;
                    $result[] = $val;
                    $this -> createTree($data,$field='cate_id',$val[$field],$level+1);
                }
            }
            return $result;
        }
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
        $data=$request->input();
        // dd($data);
        $data['addtime']=time();
        // $res=DB::table('admin')->insert($data);
        $res=Category::insert($data);
        
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

}

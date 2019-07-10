<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        return view();
    }
    function add(){
        $data=input("post.");
        $data['start_time']=time();
        $res=Db::table("Goods_one")->insert($data);
        if($res){
            $this->success("添加成功",'show');
        }else{
            $this->error("添加失败");
        }
    }
    function show(){

        $page=input("post.page")!=""?input("post.page"):1;
        $size=3;
        $count=Db::table("Goods_one")->count();
        $end=ceil($count/$size);
        $forset=($page-1)*$size;
        $res=Db::table("Goods_one")->limit($forset,$size)->select();

        return view("show",['list'=>$res,'end'=>$end]);

    }
    function show_json(){
        $sear=input("post.sear");
        $page=input("post.page")!=""?input("post.page"):1;
        $size=3;
        if(empty($sear)){
            $count=Db::table("Goods_one")->count();
            $end=ceil($count/$size);
            $forset=($page-1)*$size;
            $res=Db::table("Goods_one")->limit($forset,$size)->select();
        }else{
        $count=Db::table("Goods_one")->where("name|start_time","like", "%$sear%")->order("price","desc")->count();
        $end=ceil($count/$size);
        $forset=($page-1)*$size;
        $res=Db::table("Goods_one")->where("name|start_time","like", "%$sear%")->order("price","desc")->limit($forset,$size)->select();

    }
        return json($res);
    }
    function sav(){
        $id=input("post.id");
        $fd=input("post.fd");
        $new_val=input("post.new_val");
        $res=Db::table("Goods_one")->where("id='$id'")->update([$fd=>$new_val]);
        if($res){
            return 1;
        }else{
            return 2;
        }
    }

    function ssa(){
        $id=input("post.id");
        $name=input("post.name");
        $re=[];
        if($name=="是"){
            $re['ye']="否";
        }else{
            $re['ye']="是";
        }
        $res=Db::table("Goods_one")->where("id='$id'")->update($re);
        if($res){
            $arr['code']=1;
            $arr['message']=$re['ye'];
           return json($arr);
        }else{
            $arr['code']=2;
            $arr['message']="修改失败";
            return json($arr);
        }

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: tangliangdong
 * Date: 2017/10/22
 * Time: 15:27
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndentController extends Controller{

    public function indent(){
        return view('indent/indent',['name' => 'Taylor']);
    }

    public function getIndentByStatus(Request $request){
        $status = $request->input('status');
        $indents = DB::table('order')
            ->where('status',$status)
            ->get();
        for($i = 0;$i < count($indents);$i++){
            $indents[$i]->addTime = date("Y-m-d H:i:s",$indents[$i]->add_time);
        }
        return $indents;
    }

    public function getDishByIndent(Request $request){
        $id = $request->input('id');
        $indent = DB::table('order')
            ->where('id',$id)
            ->first();
        $indent->addTime = date("Y-m-d H:i:s",$indent->add_time);

        $dishes = DB::table('order_dish')
            ->where('order_id', $id)
            ->get();
        $indent->list = $dishes;
        return json_encode($indent);
    }
    public function handle(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');
        $remark = $request->input('remark');
        $num = DB::table('order')
            ->where('id',$id)
            ->update([
               'status'=>$status,
                'remark'=>$remark,
            ]);
        $arr = [];
        if($num>0){
            $arr = ['status'=>1];
        }else{
            $arr = ['status'=>0];
        }
        return json_encode($arr);
    }

    public function complete(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');
        $num = DB::table('order')
            ->where('id',$id)
            ->update([
               'status'=>$status,
            ]);
        $arr = [];
        if($num>0){
            $arr = ['status'=>1];
        }else{
            $arr = ['status'=>0];
        }
        return json_encode($arr);
    }

}
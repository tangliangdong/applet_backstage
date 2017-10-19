<?php
/**
 * Created by PhpStorm.
 * User: tangliangdong
 * Date: 2017/10/17
 * Time: 19:51
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller {

    public function menu_list(){
        $menus = DB::table('menu')
            ->get();

        foreach ($menus as $item){
            $dish_list = DB::table('menu_dish')
                ->where('menu_id',$item->id)
                ->get();

            $item->list = $dish_list;
        }
        return json_encode($menus);
    }

    public function menu_dishes($id){
        $menus = DB::table('menu_dish')
            ->where('menu_id',$id)
            ->get();
        return json_encode($menus);
    }

    public function create_order($userId,Request $request){
        $ids = $request->input('ids');
        $sum_price = $request->input('sumPrice');
        $arr = explode(',',$ids);
        $time = time();
        $order_number = $time.$userId;
        $id = DB::table('complete_order')->insertGetId(
            ['order_number' => $order_number, 'user_id' => $userId,'sum_price'=>$sum_price,'add_time'=>$time,'status'=>1]
        );
        if ($id>0){
            foreach ($arr as $item){
                $arr2 = explode(':',$item);

                $dish = DB::table('menu_dish')
                    ->where('id',$arr2[0])
                    ->first();
                $num = DB::table('order_dish')
                    ->insert([
                        'dish_price'=>$dish->dish_price,
                        'dish_name'=>$dish->dish_name,
                        'dish_count'=>$arr2[1],
                        'src'=>$dish->src,
                        'complete_order_id'=>$id,
                    ]);
            }
            $data = Array('status'=>1);
            return json_encode($data);
        }
    }

    public function getIndent(Request $request){
        $userId = $request->input('userId');
        $indents = DB::table('complete_order')
            ->where('user_id',$userId)
            ->get();
//        date_default_timezone_set('PRC');
        for($i = 0;$i < count($indents);$i++){
            $indents[$i]->addTime = date("Y-m-d H:i:s",$indents[$i]->add_time);
        }
        return json_encode($indents);
    }

    public function getDetailIndent(Request $request){
        $id = $request->input('id');
        $dishes = DB::table('order_dish')
            ->where('complete_order_id',$id)
            ->get();

        return json_encode($dishes);
    }

    public function getDishDetail(Request $request){
        $id = $request->input('id');
        $dishes = DB::table('menu_dish')
            ->where('id',$id)
            ->first();

        return json_encode($dishes);
    }
}
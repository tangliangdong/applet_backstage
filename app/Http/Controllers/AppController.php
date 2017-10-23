<?php
/**
 * Created by PhpStorm.
 * User: tangliangdong
 * Date: 2017/10/22
 * Time: 15:00
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppController extends Controller{

    private $appId = 'wx2ebe56119c49465b';
    private $secret = 'ec1f364a3bf69be1ddd7514328196c2d';
    private $grant_type = 'authorization_code';

    public function login(Request $request){
        $code = $request->input('code');
        $api_url = sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=%s",
            $this->appId, $this->secret, $code, $this->grant_type);
        $resp_contents = file_get_contents($api_url);
        $data = json_decode($resp_contents, TRUE);
        print_r($data);
//        $user = DB::table('user')
//            ->where('open_id',$data['openid'])
//            ->first();
//        if($user){
//            $res = ['status'=>1,'userId'=>$user->id];
//            return json_encode($res);
//        }else{
//            $time = time();
//            $num = DB::table('user')->insertGetId(
//                ['nikename' => 'Hello World', 'add_time'=>$time,'open_id'=>$data['openid']]
//            );
//            if ($num>0){
//                $res = ['status'=>1];
//            }else{
//                $res = ['status'=>0];
//            }
//            return json_encode($res);
//        }

    }
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

//    public function menu_dishes($id){
//        $menus = DB::table('menu_dish')
//            ->where('menu_id',$id)
//            ->get();
//        return json_encode($menus);
//    }

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
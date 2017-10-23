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

    public function menu(){
        $menus = DB::table('menu')
            ->get();

        foreach ($menus as $item){
            $dish_list = DB::table('menu_dish')
                ->where('menu_id',$item->id)
                ->get();

            $item->list = $dish_list;
        }
        return view('menu/menu',['list' => $menus]);
    }

    public function menu_type(){
        $menus = DB::table('menu')
            ->get();
        return json_encode($menus);
    }

    public function menu_dishes(Request $request){
        $id = $request->input('id');
        $menus = DB::table('menu_dish')
            ->where('menu_id',$id)
            ->get();
        return json_encode($menus);
    }

    public function getDish(Request $request){
        $id = $request->input('id');
        $menus = DB::table('menu_dish')
            ->where('id',$id)
            ->first();
        return json_encode($menus);
    }

    /**
     * 根据id获取菜单
     * @param Request $request
     * @return string
     */
    public function getMenu(Request $request){
        $id = $request->input('id');
        $menus = DB::table('menu')
            ->where('id',$id)
            ->first();
        return json_encode($menus);
    }

    public function edit(Request $request){
        $id = $request->input('dish_id');
        $price = $request->input('dish_price');
        $name = $request->input('dish_name');
        $status = $request->input('isShow');
        $menuType = $request->input('menu_type');

        $num = DB::table('menu_dish')
            ->where('id',$id)
            ->update(['dish_price'=> $price,'dish_name'=>$name,'status'=>$status,'menu_id'=>$menuType]);
        $arr = [];
        if ($num>0){
            $arr = ['status'=>1];
        }else{
            $arr = ['status'=>0];
        }
        return json_encode($arr);
    }

    public function menu_edit(Request $request){
        $id = $request->input('menu_id');
        $name = $request->input('menu_type_name');
        $status = $request->input('menu_isShow');

        $num = DB::table('menu')
            ->where('id',$id)
            ->update(['dish_type'=>$name,'status'=>$status]);
        $arr = [];
        if ($num>0){
            $arr = ['status'=>1];
        }else{
            $arr = ['status'=>0];
        }
        return json_encode($arr);
    }




}
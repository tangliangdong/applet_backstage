<?php
/**
 * Created by PhpStorm.
 * User: tangliangdong
 * Date: 2017/10/18
 * Time: 12:48
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{

    public function usermanage(){
        return view('user/usermanage',['name' => 'Taylor']);
    }

}

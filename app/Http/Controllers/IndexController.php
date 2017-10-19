<?php
/**
 * Created by PhpStorm.
 * User: tangliangdong
 * Date: 2017/10/18
 * Time: 21:41
 */

namespace App\Http\Controllers;


class IndexController extends Controller{

    public function index(){

        return view('public/index');
    }
}
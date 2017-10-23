<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微信点餐后台管理系统</title>

</head>
<body>
    @extends('layouts.app')

    @section('header')

    @section('sass')
        hello Sass
    @endsection

    @inject('controller', 'App\Http\Controllers\MenuController')
    @section('content')
        {!! $controller->menu() !!}
    @endsection

    @section('footer')
        @parent

    @endsection

    @section('js')

    @endsection

</body>
</html>
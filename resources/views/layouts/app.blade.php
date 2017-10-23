<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
    <title>微信点餐后台管理系统</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
</head>
<body>
    @section('header')
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo right">Logo</a>
                <ul id="nav-mobile" class="left hide-on-med-and-down">
                    <li><a id="nav_menu">菜单管理</a></li>
                    <li><a id="nav_indent">订单管理</a></li>
                    <li><a id="nav_usermanage">用户管理</a></li>
                </ul>
            </div>
        </nav>
    @show

    <div id="container">
        @yield('content')
    </div>

    @section('footer')
        <footer class="page-footer">
            <div class="footer-copyright">
                <div class="container">
                    © 2017 Copyright XiaoTang
                    {{--<a class="grey-text text-lighten-4 right" href="#!">More Links</a>--}}
                </div>
            </div>
        </footer>
    @show


    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.13'><\/script>".replace("HOST", location.hostname));
        //]]></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    @yield('js')
    <script>
        $(function () {

            $('#nav-mobile').on('click','a',function(event){
                var index =  $('#nav-mobile a').index(this);
                console.log(event);
                var id = event.currentTarget.id;
                switch(id){
                    case 'nav_menu':
                        $.ajax({
                            url: "{{url('menu')}}",
                            type: 'GET',
                            dataType: 'html',
                            success: function(data){
                                console.log(data);
                                $('#container').html(data);
                            }
                        });
                        break;
                    case 'nav_indent':
                        $.ajax({
                            url: "{{url('indent')}}",
                            type: 'GET',
                            dataType: 'html',
                            success: function(data){
                                console.log(data);
                                $('#container').html(data);
                            }
                        });
                        break;
                    case 'nav_usermanage':
                        $.ajax({
                            url: "{{url('user/usermanage')}}",
                            type: 'GET',
                            dataType: 'html',
                            success: function(data){
                                console.log(data);
                                $('#container').html(data);
                            }
                        });
                        break;
                }
            });

//            $('#nav-mobile a:eq(0)').click();

        });
    </script>
</body>
</html>

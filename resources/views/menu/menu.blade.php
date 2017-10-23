@section('title','菜单管理界面')

<link rel="stylesheet" href="{{asset('css/menu.css')}}">

<nav class="menu-nav">
    <div class="nav-wrapper">
        <div class="nav-list" id="menu_nav_list">
            <a href="#!" class="breadcrumb" id="menu_nav_type">{{$list[0]->dish_type}}</a>
            {{--<a href="#!" class="breadcrumb">鸡腿</a>--}}
        </div>

    </div>
</nav>

<!-- 菜单选择区 -->
<div class="row">
    <div class="col s4">
        <div class="collection" id="menu_type_list">
            @foreach ($list as $item)
                @if ($loop->first)
                    <a class="collection-item active-item" href="#" data-id="{{$item->id}}">
                        <span>{{$item->dish_type}}</span>
                        <i class="material-icons float-right">border_color</i>
                    </a>
                @else
                    <a class="collection-item" href="#" data-id="{{$item->id}}">
                        <span>{{$item->dish_type}}</span>
                        <i class="material-icons float-right">border_color</i>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
    <div class="col s8">
        <ul class="collection" id="menu_dishes">
            @foreach ($list[0]->list as $a)
                <li class="collection-item">
                    {{$a->dish_name}}
                    <a href="#" class="secondary-content" data-id="{{$a->id}}"><i class="material-icons">border_color</i></a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- 菜类信息修改 -->
<div id="menu_modal" class="modal">
    <form id="menu_form">
        <div class="modal-content">
            <h4>编辑菜单类信息</h4>
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="input-field">
                            <input value=" " id="menu_type_name" name="menu_type_name" type="text" class="validate">
                            <label for="menu_type_name">菜类名称：</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s3">
                            <label>是否显示：</label>
                        </div>
                        <div class="col s3">
                            <input name="menu_isShow" type="radio" id="menu_show" value="1" />
                            <label for="menu_show">显示</label>
                        </div>
                        <div class="col s3">
                            <input name="menu_isShow" type="radio" id="menu_hidden" value="0" />
                            <label for="menu_hidden">隐藏</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="menu_id" id="menu_id">
            {{ csrf_field() }}
            <button class="waves-effect waves-light btn" id="menu_edit_btn">提交</button>
            {{--<a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">提交</a>--}}
        </div>
    </form>
</div>

<!-- 菜信息修改 -->
<div id="modal1" class="modal">
    <form id="form">
        <div class="modal-content">
            <h4>编辑菜品信息</h4>
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                        <select name="menu_type" id="modal_menu_type_select">
                            <option value="" disabled>选择一个种类</option>
                        </select>
                        <label for="modal_menu_type_select">菜类：</label>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <input value=" " id="dish_name" name="dish_name" type="text" class="validate">
                            <label for="dish_name">菜名：</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <input value="0" id="dish_price" name="dish_price" type="number" class="validate">
                            <label for="dish_price">菜价￥：</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s3">
                            <label>是否显示：</label>
                        </div>
                        <div class="col s3">
                            <input name="isShow" type="radio" id="show" value="1" />
                            <label for="show">显示</label>
                        </div>
                        <div class="col s3">
                            <input name="isShow" type="radio" id="hidden" value="0" />
                            <label for="hidden">隐藏</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="dish_id" id="dish_id">
            {{ csrf_field() }}
            <button class="waves-effect waves-light btn" id="edit_btn">提交</button>
            {{--<a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">提交</a>--}}
        </div>
    </form>
</div>

<script>
    $(function () {
        $('.modal').modal();
        var prevClicked = $('#menu_type_list a:eq(0)');
        var prevDishClicked;
        $.ajax({
            url: "{{url('menu/menu_type')}}",
            type: 'POST',
            dataType: 'json',
            success: function(data){
                console.log(data);
                for(var i in data){
                    $('#modal_menu_type_select').append('<option value="'+data[i].id+'">'+data[i].dish_type+'</option>');
                }
            }
        });
        
        $('#menu_type_list .collection-item').on('click','i',function (event) {
            $('#menu_modal').modal('open');
            var id = $(this).parents('.collection-item').attr('data-id');
            $.ajax({
                url: "{{url('menu/getMenu')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function(data){
                    console.log(data);
                    $('#menu_type_name').val(data.dish_type);
                    $('#menu_id').val(id);
                    if (data.status===1){
                        $('#menu_hidden').attr('checked',false);
                        $('#menu_show').attr('checked',true);
                    } else {
                        $('#menu_show').attr('checked',false);
                        $('#menu_hidden').attr('checked',true);
                    }
                }
            });
        })

        $('#menu_type_list').on('click','a',function (event) {
            $('#menu_nav_dish').remove();
            var id = $(this).attr('data-id');
            var $this = $(this);
            prevClicked.removeClass('active-item');
            $this.addClass('active-item');
            prevClicked = $this;
            $.ajax({
                url: "{{url('menu/getDishes')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                  id: id,
                },
                success: function(data){
                    console.log(data);
                    $('#menu_nav_type').text($this.children('span').text());
                    var content = '';
                    for(var i in data){
                        content += '<li class="collection-item">'
                            + data[i].dish_name
                            +'<a href="#" class="secondary-content" data-id="'+data[i].id+'"><i class="material-icons">border_color</i></a>'
                            +'</li>'
                    }
                    $('#menu_dishes').html(content);
                }
            });
        });



        $('#menu_dishes').on('click','a',function (event) {
            var id = $(this).attr('data-id');
            prevDishClicked = $(this).parent();
            $.ajax({
                url: "{{url('menu/getDish')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function(data){
                    console.log(data);
                    $('#dish_id').val(id);
                    console.log($('#dish_id').val())
                    $('#modal_menu_type_select').each(function (index) {
                        if($(this).val()===data.menu_id){
                            $(this).attr('selected',true);
                            return;
                        }
                    })
                    $('#dish_name').val(data.dish_name);
                    $('#dish_price').val(data.dish_price);
                    if (data.status===1){
                        $('#hidden').attr('checked',false);
                        $('#show').attr('checked',true);
                    } else {
                        $('#show').attr('checked',false);
                        $('#hidden').attr('checked',true);
                    }
                    $('#menu_nav_dish').remove();
                    $('#menu_nav_type').after('<a href="#" class="breadcrumb" id="menu_nav_dish">'+data.dish_name+'</a>');
                    $('select').material_select();
                }
            });
            $('#modal1').modal('open');
        });

        // 禁用表单的默认提交
        $('#form,#menu_form').submit(function (event) {
            return false;
        });

        // 菜单编辑按钮
        $('#menu_edit_btn').click(function (event) {
            var form = new FormData(document.getElementById("menu_form"));
            var menuName = $('#menu_type_name').val();
            var id = $('#menu_id').val();
            $.ajax({
                url: "{{url('menu/menu_edit')}}",
                type: "post",
                data: form,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data){
                    console.log(data);
                    if(data.status===1){
                        Materialize.toast('修改成功', 3000,'rounded');
                        prevClicked.html('<span>'+menuName+'</span><i class="material-icons float-right">border_color</i>');
                        $('#menu_nav_type').text(menuName);

                    }else{
                        Materialize.toast('未修改信息', 3000,'rounded');
                    }
                    $('#menu_modal').modal('close');
                }
            });
        })

        // 编辑按钮
        $('#edit_btn').click(function(event){
            var form = new FormData(document.getElementById("form"));
            var dishName = $('#dish_name').val();
            var id = $('#dish_id').val();
            $.ajax({
                url: "{{url('menu/edit')}}",
                type: "post",
                data: form,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data){
                    console.log(data);
                    if(data.status===1){
                        Materialize.toast('修改成功', 3000,'rounded');
                        $('#menu_nav_dish').text(dishName);
                        prevDishClicked.html(dishName+'<a href="#" class="secondary-content" data-id="'+id+'"><i class="material-icons">border_color</i></a>');
                        $('#modal1').modal('close');
                    }else{
                        Materialize.toast('未修改信息', 3000,'rounded');
                        $('#modal1').modal('close');
                    }
                }
            });
        });
    });
</script>



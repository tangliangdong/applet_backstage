<link rel="stylesheet" href="{{asset('css/indent.css')}}">
<div class="row">
    <div class="col s4">
        <div class="collection" id="indent_type_list">
            <a class="collection-item active-item" href="#" data-status="0">
                未确认订单
            </a>
            <a class="collection-item" href="#" data-status="1">
                确认订单
            </a>
            <a class="collection-item" href="#" data-status="2">
                已完成订单
            </a>
            <a class="collection-item" href="#" data-status="3">
                用户撤销的订单
            </a>
            <a class="collection-item" href="#" data-status="4">
                管理员撤销的订单
            </a>
        </div>
    </div>
    <div class="col s8">
        <ul class="collection" id="indent_list">
        </ul>
    </div>
</div>

<!-- 未确认订单信息修改 -->
<div id="indent_modal_0" class="modal indent_modal">
    <div class="modal-content">
        <h5 class="center-align">订单号：<span class="indent_number"></span></h5>
        <h6 class="center-align">创建时间：<span class="indent_addTime"></span></h6>
        <ul class="collection indent_modal_collection">
            {{--<li class="collection-item avatar">--}}
                {{--<img src="images/yuna.jpg" alt="" class="circle">--}}
                {{--<span class="title">Title</span>--}}
                {{--<p>First Line <br>--}}
                    {{--Second Line--}}
                {{--</p>--}}
                {{--<a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>--}}
            {{--</li>--}}
        </ul>
        <div class="row">
            <p>用户备注信息：</p>
            <blockquote class="user_note"></blockquote>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea class="remarks" class="materialize-textarea"></textarea>
                <label>订单备注信息：</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="order_id" class="order_id">
        {{ csrf_field() }}
        <button class="waves-effect waves-light btn comfirm_btn" data-do="1">确认</button>
        <button class="waves-effect waves-light btn cancel_btn" data-do="4">取消</button>
        {{--<a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">提交</a>--}}
    </div>
</div>

<!-- 确认的订单 -->
<div id="indent_modal_1" class="modal indent_modal">
    <div class="modal-content">
        <h5 class="center-align">订单号：<span class="indent_number"></span></h5>
        <h6 class="center-align">创建时间：<span class="indent_addTime"></span></h6>
        <ul class="collection indent_modal_collection"></ul>
        <div class="row">
            <p>用户备注信息：</p>
            <blockquote class="user_note"></blockquote>
        </div>
        <div class="row">
            <p>订单备注信息：</p>
            <blockquote class="remarks"></blockquote>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="order_id" class="order_id">
        {{ csrf_field() }}
        <button class="waves-effect waves-light btn comfirm_btn" data-do="2">完成</button>
        <button class="waves-effect waves-light btn cancel_btn" data-do="4">撤销</button>
        {{--<a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">提交</a>--}}
    </div>
</div>

<div id="indent_modal_2" class="modal indent_modal">
    <div class="modal-content">
        <h5 class="center-align">订单号：<span class="indent_number"></span></h5>
        <h6 class="center-align">创建时间：<span class="indent_addTime"></span></h6>
        <ul class="collection indent_modal_collection"></ul>
        <div class="row">
            <p>用户备注信息：</p>
            <blockquote class="user_note"></blockquote>
        </div>
        <div class="row">
            <p>订单备注信息：</p>
            <blockquote class="remarks"></blockquote>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="order_id" class="order_id">
        {{ csrf_field() }}
        <button class="waves-effect waves-light btn close_btn">关闭</button>
        {{--<a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">提交</a>--}}
    </div>
</div>
<script>

    $(function () {
        $('.modal').modal();
        var prevIndentClicked = $('#indent_type_list a:eq(0)');

        $('#indent_type_list').on('click','a',function (event) {
            var $this = $(this);
            var status = $this.attr('data-status');
            prevIndentClicked.removeClass('active-item');
            $this.addClass('active-item');
            prevIndentClicked = $this;

            $.ajax({
                url: "{{url('indent/getIndentByStatus')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    status: status
                },
                success: function(data){
                    console.log(data);
                    var content = '';
                    for(var i in data){
                        content += '<li class="collection-item">'
                            + '<span>订单号：'+data[i].order_number+'</span>&nbsp;&nbsp;&nbsp;&nbsp;创建时间：<span>'+data[i].addTime+'</span>'
                            +'<a href="#" class="secondary-content" data-status="'+status+'" data-id="'+data[i].id+'"><i class="material-icons">border_color</i></a>'
                            +'</li>'
                    }
                    if(data.length===0){
                        content = '<li class="collection-item center-align">'
                            + '无订单'
                            +'<a href="#" class="secondary-content"></a>'
                            +'</li>'
                    }
                    $('#indent_list').html(content);
                }
            });
        });

        $('#indent_list').on('click','a',function (event) {
            var type = $(this).attr('data-status');
            console.log(type);
            switch(parseInt(type)){
                case 0:
                    popup_indent_0($(this));
                    break;
                case 1:
                    popup_indent_1($(this));
                    break;
                case 2:
                    popup_indent_2($(this));
                    break;
                case 3:
                    popup_indent_2($(this));
                    break;
                case 4:
                    popup_indent_2($(this));
                    break;
            }

        });

        $('#indent_modal_0 .modal-footer').on('click', 'button', function (event) {
            var $this = $(this);
            var status = $this.attr('data-do');
            var remark = $('#indent_modal_0').find('.remarks').val();
            var id = $('#indent_modal_0').find('.order_id').val();
            $.ajax({
                url: "{{url('indent/handle')}}",
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    remark: remark,
                },
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if(data.status===1){
                        prevIndentClicked.click();
                        Materialize.toast('成功完成', 3000,'rounded');
                    }else{
                        Materialize.toast('未进行修改', 3000,'rounded');
                    }
                    $('#indent_modal_0').modal('close');

                }
            });
        });

//      确认订单完成modal
        $('#indent_modal_1 .modal-footer').on('click', 'button', function (event) {
            var $this = $(this);
            var status = $this.attr('data-do');
            var id = $('#indent_modal_1').find('.order_id').val();
            $.ajax({
                url: "{{url('indent/complete')}}",
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                },
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if(data.status===1){
                        prevIndentClicked.click();
                        Materialize.toast('成功确认', 3000,'rounded');
                    }else{
                        Materialize.toast('未进行修改', 3000,'rounded');
                    }
                    $('#indent_modal_1').modal('close');

                }
            });
        });

        $('.close_btn').click(function (event) {
           $(this).parents('.modal').modal('close');
        });

        prevIndentClicked.click();
    });

    function popup_indent_0($this){
        $('#indent_modal_0').modal('open');
        var id = $this.attr('data-id');
        $('#indent_modal_0').find('.order_id').val(id);
        $.ajax({
            url: "{{url('indent/getDishByIndent')}}",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
            },
            success: function(data){
                console.log(data);
                var content = '';
                var list = data.list;
                for(var i in list){
                    content += '<li class="collection-item avatar">'
                        +'<img src="'+list[i].src+'" alt="" class="circle">'
                        +'<span class="title">'+list[i].dish_name+'</span>'
                        +'<p>单价：'+list[i].dish_price+'元<br>'
                        + '数量：'+list[i].dish_count
                        +'</p>'
                        +'<a href="#!" class="secondary-content">'
                        +'<i class="material-icons">grade</i></a>'
                        +'</li>'
                }

                $('#indent_modal_0').find('.indent_number').text(data.order_number);
                $('#indent_modal_0').find('.indent_addTime').text(data.addTime);
                var note = '';
                (data.user_note===''||data.user_note==null)?note='无':note=data.user_note;
                $('#indent_modal_0').find('.user_note').text(note);
                $('#indent_modal_0').find('.indent_modal_collection').html(content);
                $('#indent_modal_0').find('.remarks').trigger('autoresize');

            }
        });
    }

    function popup_indent_1($this){
        $('#indent_modal_1').modal('open');
        var id = $this.attr('data-id');
        $('#indent_modal_1').find('.order_id').val(id);
        $.ajax({
            url: "{{url('indent/getDishByIndent')}}",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
            },
            success: function(data){
                console.log(data);
                var content = '';
                var list = data.list;
                for(var i in list){
                    content += '<li class="collection-item avatar">'
                        +'<img src="'+list[i].src+'" alt="" class="circle">'
                        +'<span class="title">'+list[i].dish_name+'</span>'
                        +'<p>单价：'+list[i].dish_price+'元<br>'
                        + '数量：'+list[i].dish_count
                        +'</p>'
                        +'<a href="#!" class="secondary-content">'
                        +'<i class="material-icons">grade</i></a>'
                        +'</li>'
                }

                $('#indent_modal_1').find('.indent_number').text(data.order_number);
                $('#indent_modal_1').find('.indent_addTime').text(data.addTime);
                $('#indent_modal_1').find('.remarks').text(data.remark);
                var note = '';
                (data.user_note===''||data.user_note==null)?note='无':note=data.user_note;
                $('#indent_modal_1').find('.user_note').text(note);
                $('#indent_modal_1').find('.indent_modal_collection').html(content);

            }
        });
    }

    function popup_indent_2($this){
        $('#indent_modal_2').modal('open');
        var id = $this.attr('data-id');
        $('#indent_modal_2').find('.order_id').val(id);
        $.ajax({
            url: "{{url('indent/getDishByIndent')}}",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
            },
            success: function(data){
                console.log(data);
                var content = '';
                var list = data.list;
                for(var i in list){
                    content += '<li class="collection-item avatar">'
                        +'<img src="'+list[i].src+'" alt="" class="circle">'
                        +'<span class="title">'+list[i].dish_name+'</span>'
                        +'<p>单价：'+list[i].dish_price+'元<br>'
                        + '数量：'+list[i].dish_count
                        +'</p>'
                        +'<a href="#!" class="secondary-content">'
                        +'<i class="material-icons">grade</i></a>'
                        +'</li>'
                }

                $('#indent_modal_2').find('.indent_number').text(data.order_number);
                $('#indent_modal_2').find('.indent_addTime').text(data.addTime);
                $('#indent_modal_2').find('.remarks').text(data.remark);
                var note = '';
                (data.user_note===''||data.user_note==null)?note='无':note=data.user_note;
                $('#indent_modal_2').find('.user_note').text(note);
                $('#indent_modal_2').find('.indent_modal_collection').html(content);

            }
        });
    }
    
</script>

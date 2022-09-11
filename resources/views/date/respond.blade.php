@include('date.components.head')

    <style>
        .jumbotron{
            background-color:#c3a367;
            color:#2b2b2b;
            border-radius:0px;
        }
        body{
            background-color:#2b2b2b;
            color:#c3a367;
        }
        a{
            color:#c3a367;
        }
    </style>
</head>
<body>

<div style="padding-top:20px;padding-right:20px;" class="float-right">
    <span style="color:#2b2b2b;"><strong>會員 : {{ $data['username'] ?? ''}}</strong></span>&nbsp;&nbsp; 
    <a href="/date/data" class="btn btn-primary">回上頁</a>
</div>
<div class="jumbotron text-center" style="padding-top:80px;">
    <h2><strong>約會回應表</strong></h2>
</div>
        @if(count($data['invitation_data']) < 1)
            <h2  class='text-center' style="color:red;">目前沒有可回應的對象</h2>
        @endif
        <form action="/date/respond_post" method="post" id="respond_form">
            @csrf
            <br>
                @if(count($data['invitation_data']) >= 1)
                <div class="container">
                    <div class="box">
                        <h5>選擇回應對象 : </h5>
                        <hr style="background-color:#c3a367;">
                        @foreach($data['invitation_data'] as $key => $value)
                            <input type="hidden" name="respond_name[]" value="{{ $value['username'] }}">
                            <div class="col-md-12">
                                <h3><strong>{{ $value['username'] }}</strong></h3>
                                @if($data['show'] == 'd' || empty($value['data_url_simple']))
                                    <a href="{{ $value['data_url'] }}" target="__blank"><u>{{ $value['data_url'] }}</u></a>
                                @else
                                    <a href="{{ $value['data_url_simple'] }}" target="__blank"><u>{{ $value['data_url_simple'] }}</u></a>
                                @endif
                                <div>約會形式 : {{ $value['type'] }}</div>
                                @if($value['type'] == '餐廳約會')
                                    <span>餐廳地點 : {{ $value['restaurant'] }}</span>
                                    <div>選擇可以排約的時間(可複選)或選擇其他回應 : </div>
                                    <?php $datetime = explode('、', $value['datetime']); ?>
                                    @foreach($datetime as $val)
                                        <label>
                                            <input type="checkbox" class="get{{$key+1}}" item={{$key+1}} onClick="getTime(event,this);" name="respond{{$key}}[]"  value="{{ $val }}">
                                            @php 
                                                $week = date('w',strtotime($val)); 
                                                if($week == 0) $week = '日';
                                                if($week == 1) $week = '一';
                                                if($week == 2) $week = '二';
                                                if($week == 3) $week = '三';
                                                if($week == 4) $week = '四';
                                                if($week == 5) $week = '五';
                                                if($week == 6) $week = '六';
                                            @endphp
                                            {{ date('Y/m/d', strtotime($val)) }} ({{$week}}) {{ date('H點i分', strtotime($val)) }} ~ {{ date('H點i分', strtotime($val)+1*60*60) }}
                                        </label>
                                    @endforeach
                                @endif
                                @if($value['type'] == '視訊約會')
                                    <span>聊天方式 : {{ $value['chat_option'] }}</span>
                                    <div>選擇可以排約的時間(可複選)或選擇其他回應 : </div>
                                    <?php $datetime = explode('、', $value['datetime']); ?>
                                    @foreach($datetime as $val)
                                        <label>
                                            <input type="checkbox" class="get{{$key+1}}" item={{$key+1}} onClick="getTime(event,this);" name="respond{{$key}}[]"  value="{{ $val }}">
                                            @php
                                                $week = date('w',strtotime($val)); 
                                                if($week == 0) $week = '日';
                                                if($week == 1) $week = '一';
                                                if($week == 2) $week = '二';
                                                if($week == 3) $week = '三';
                                                if($week == 4) $week = '四';
                                                if($week == 5) $week = '五';
                                                if($week == 6) $week = '六';
                                            @endphp
                                            {{ date('Y/m/d', strtotime($val)) }} ({{$week}}) {{ date('H點i分', strtotime($val)) }} ~ {{ date('H點i分', strtotime($val)+1*60*30) }}
                                        </label>
                                    @endforeach
                                @endif
                                
                                <br>
                                <label>
                                    <input type="checkbox" class="no{{$key+1}}" item={{$key+1}} onClick="noTime(event,this);" name="respond{{$key}}[]"  value="noTime">
                                    <span>以上時間無法配合，要另約時間</span>
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" class="del{{$key+1}}" item={{$key+1}} onClick="delUser(event,this);" name="respond{{$key}}[]"  value="delete">
                                    <span>沒有意願排約</span>
                                    <!-- <a href="https://docs.google.com/forms/d/e/1FAIpQLScysr88Bo35rnkzy-5fAtrEfy9JSECGsHkgiXYHjjrQzaWP3A/viewform" target="__blank"><u>「拒絕邀約」調查表(女生用)</u></a>
                                    
                                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSee6YEBIOyGu3LnRzAqTIjYtPWOD1QkqumWMGC3yJDYZ-YLGQ/viewform" target="__blank"><u>「拒絕邀約」調查表(男生用)</u></a> -->
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" class="nosel{{$key+1}}" item={{$key+1}} onClick="nosel(event,this);" name="respond{{$key}}[]"  value="noSel">
                                    <span>暫不回應</span>
                                </label>
                                <br>
                                @if(!empty($value['appointment_respond']))
                                    @if($value['appointment_respond'] == 'delete')
                                        <h3 style="color:green">已回復 : 沒有意願排約</h3>
                                    @elseif($value['appointment_respond'] == 'noTime')
                                        <h3 style="color:green">已回復 : 以上時間無法配合，要另約時間</h3>
                                    @elseif($value['appointment_respond'] == 'noSel')
                                        <h3 style="color:green">暫不回應(對方不會看到訊息)</h3>    
                                    @else
                                        <h5 style="color:green"><strong>已回復 : </strong></h5>
                                        <h5 style="color:green">
                                            @php
                                                $data = explode("、", $value['appointment_respond']);
                                                foreach( $data as $val){
                                                    $week = date('w',strtotime($val)); 
                                                    if($week == 0) $week = '日';
                                                    if($week == 1) $week = '一';
                                                    if($week == 2) $week = '二';
                                                    if($week == 3) $week = '三';
                                                    if($week == 4) $week = '四';
                                                    if($week == 5) $week = '五';
                                                    if($week == 6) $week = '六';
                                                    if($value['type'] == '視訊約會'){
                                                        $res = date('Y/m/d', strtotime($val)).'('.$week.')  '.date('H點i分', strtotime($val)).'~'.date('H點i分', strtotime($val)+1*60*30);
                                                    }
                                                    if($value['type'] == '餐廳約會'){
                                                        $res = date('Y/m/d', strtotime($val)).'('.$week.')  '.date('H點i分', strtotime($val)).'~'.date('H點i分', strtotime($val)+1*60*60);
                                                    }
                                                    echo $res."<br>";
                                                }
 
                                            @endphp 
                                        </h5>
                                    @endif
                                @endif
                           
                            </div>

                            <hr style="border:1px solid #c3a367;width:100%;">
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary"
                    style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">送出</button>
                    <a type="button" class="btn btn-danger" href="/date/data"
                    style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">取消</a>
                </div>
                @endif
            <br>
        </form>

<br><br><br><br>

<script>
    function getTime(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".no" + item).prop('checked',false);
            $(".del" + item).prop('checked',false);
            $(".nosel" + item).prop('checked',false);
        }
        
    }
    function noTime(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".get" + item).prop('checked',false);
            $(".del" + item).prop('checked',false);
            $(".nosel" + item).prop('checked',false);
        }
    }
    function delUser(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".get" + item).prop('checked',false);
            $(".no" + item).prop('checked',false);
            $(".nosel" + item).prop('checked',false);
        }
    }
        
    function nosel(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".get" + item).prop('checked',false);
            $(".no" + item).prop('checked',false);
            $(".del" + item).prop('checked',false);
        }
    }
</script>

@include('date.components.footer')
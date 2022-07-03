@include('date.components.head')

    <style>
        .jumbotron{
            background-color:#c3a367;
            color:#2b2b2b;
        }
        body{
            background-color:#2b2b2b;
            color:#c3a367;
        }
    </style>
</head>
<body>

<div style="padding-top:20px;padding-right:20px;" class="float-right">
    <a href="/date/data" class="btn btn-primary">回上頁</a>
</div>
<div class="jumbotron text-center">
    <h2><strong>排約結果</strong></h2>
</div>

<div class="container">
    <h3>排約結果 : </h3>
    <div class="row">
    <div class="col-sm-12">
        @foreach($data['result'] as $value)
                @if($value['appointment_respond'] !=  null &&
                    $value['appointment_respond'] != "noTime" &&
                    $value['appointment_respond'] != "delete" &&
                    $value['appointment_respond'] != "noSel")
                <div class="col-md-4">
                    <h3>{{ $value['appointment_user'] }}</h3>
                    @if( $value['type'] == '視訊約會')
                        <div>排約類型 : <strong>{{ $value['type'] }}</strong></div>
                        <div>聊天類型 : <strong>{{ $value['chat_option'] }}</strong></div>
                    @endif
                    @if( $value['type'] == '餐廳約會')
                        <div>排約類型 : {{ $value['type'] }}</div>
                        <div>排約餐廳 : {{ $value['restaurant'] }}</div>
                    @endif

                    @php 
                        $week = date('w',strtotime($value['appointment_result'])); 
                        if($week == 0) $week = '日';
                        if($week == 1) $week = '一';
                        if($week == 2) $week = '二';
                        if($week == 3) $week = '三';
                        if($week == 4) $week = '四';
                        if($week == 5) $week = '五';
                        if($week == 6) $week = '六';
                    @endphp
                    @if( $value['type'] == '視訊約會')
                        排約時間 : <br>
                        {{ date('Y/m/d', strtotime($value['appointment_result'])) }} ({{$week}}) {{ date('H點i分', strtotime($value['appointment_result'])) }} ~ {{ date('H點i分', strtotime($value['appointment_result'])+1*60*30) }}
                    @else
                        排約時間 : <br>
                        {{ date('Y/m/d', strtotime($value['appointment_result'])) }} ({{$week}}) {{ date('H點i分', strtotime($value['appointment_result'])) }} ~ {{ date('H點i分', strtotime($value['appointment_result'])+2*60*60) }}
                    @endif

                    <br>
                    <br>
                </div>

                @else

                <div class="col-md-4">
                    <h3>{{ $value['appointment_user'] }}</h3>
                    <div>
                        @if($value['appointment_respond'] == "noTime")
                            <div>以上時間無法配合，要另約時間</div>
                        @elseif($value['appointment_respond'] == "delete")
                            <div>對方拒絕邀約</div>
                        @else
                            <div>對方未回應</div>
                        @endif
                    </div>
                    <br>
                    <br>
                </div>
            @endif

        @endforeach

    </div>
    </div>
</div>
<br><br>

<script>
</script>
</body>
</html>
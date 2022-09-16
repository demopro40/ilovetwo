@php
    $show1 = false;
    $show2 = false;
    $show3 = false;

    $w = date('w',time());
    $H = date('H',time());

    //星期一和星期二
    if($w == 1 || $w == 2){
        $show1 = true;
    }

    //星期三和星期四
    if($w == 3 || $w == 4){
        $show2 = true;
    }
    
    //星期五晚上七點之後 或 週六 或 週日
    //if(($w == 5 && $H >= 19 ) || $w == 6 || $w == 0){
        $show3 = true;
    //}

    if(env('TEST') == true){
        $show1 = true;
        $show2 = true;
        $show3 = true;
    }
@endphp

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
    </style>
</head>
<body>
			
<div style="padding-top:20px;padding-right:20px;" class="float-right">
    <span style="color:#2b2b2b;"><strong>會員 : {{ $data['username'] ?? ''}}</strong></span>&nbsp;&nbsp; 
    <a href="/date/logout" class="btn btn-danger">登出</a>
</div>

<div class="jumbotron text-center" style="padding-top:80px;">
    <h2><strong>愛樂Two排約系統</strong></h2>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
		<h5><strong>為了更加速服務大家，促成大家多多約會，請詳讀以下"約會配對"流程內容：</strong></h5>
		<h5>Step1 . 週一~週二：您若有想約的異性，請點擊下方"約會邀請表"選擇約會模式與時間，未操作則代表沒意願。</h5>
		<h5>Step2 . 週三~週四：有意願答應邀約，請點擊下方"約會回應表"，回應有空約會時間。</h5>
		<h5>Step3 . 週五晚上七點後，點擊下方"配對結果"，公布約會配對結果與時間。</h5>
		<br>
        @if($show1)
            <a class="btn btn-primary" href="/date/invitation"
            style="width:150px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;margin-top:5px;">
                約會邀請表
            </a>
        @endif

        @if($show2)
            <a class="btn btn-primary" href="/date/respond"
            style="width:150px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;margin-top:5px;">
                約會回應表
            </a>
        @endif

        @if($show3)
            <a class="btn btn-primary" href="/date/show_result"
            style="width:150px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;margin-top:5px;">
                配對結果
            </a>
        @endif
        
        <br><br>
    </div>
    <div class="col-sm-12">
        <h3>推播會員 :</h3>
        @foreach($data['push_data'] as $key => $value)
            <div @if($key == 0 || $key == 1)   @endif>
                <span>{{ $value['username'] }}</span>&nbsp;&nbsp;
                @if($data['show'] == 'd' || empty($value['data_url_simple']))
                    <a href="{{ $value['data_url'] }}" target="_blank" style="color:#c3a367;">
                        <u>詳細資料</u>
                    </a>
                @else
                    <a href="{{ $value['data_url_simple'] }}" target="_blank" style="color:#c3a367;">
                        <u>詳細資料</u>
                    </a>
                @endif
            </div>&nbsp;
        @endforeach
    </div>
  </div>
</div>
<br><br><br><br>

@include('date.components.footer')

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
    <span style="color:#2b2b2b;"><strong>會員 : {{ $data['username'] }}</strong></span>&nbsp;&nbsp; 
    <a href="/date/data" class="btn btn-primary">回上頁</a>
</div>
<div class="jumbotron text-center" style="padding-top:80px;">
    <h2><strong>約會時間表</strong></h2>
</div>
    @if (count($data['push_data']) < 1)
        <div class="text-center">
            <h2 style="color:red;">目前沒有可排約的對象</h2>
        </div>
    @endif
    <div class="container">
        <div class="row">
                @if (count($data['push_data']) >= 1)
                <div class="offset-md-3 col-md-8">

                @if ($errors->any())
                    <div class="text-center">
                        <div class="alert alert-danger" style="width:500px;">
                            @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="/date/invitation_post" method="post" id="invitation_form">
                    @csrf
                        <div class="form-group">
                            <h5>選擇約會形式:</h5>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="type2">
                                    <input type="radio" class="form-check-input" id="type2" name="type" value="type2" checked >餐廳約會
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="type1">
                                    <input type="radio" class="form-check-input" id="type1" name="type" value="type1">視訊約會
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="chat_option">
                            <strong>視訊約會流程選擇:</strong><br>
                            <div class="form-check-inline">
                            <label class="form-check-label" for="v_1">
                                <input type="radio" class="form-check-input" id="v_1" name="chat_option" value="v_1">自由聊天
                            </label>
                            </div>
                            <div class="form-check-inline">
                            <label class="form-check-label" for="v_2">
                                <input type="radio" class="form-check-input" id="v_2" name="chat_option" value="v_2">選擇話題聊天
                            </label>
                            </div>
                            <div class="form-check-inline">
                            <label class="form-check-label" for="v_3">
                                <input type="radio" class="form-check-input" id="v_3" name="chat_option" value="v_3">破冰遊戲>聊天
                            </label>
                            </div>
                        </div>
                   
                        <div class="form-group" id="restaurant" >
                            <label for="date_restaurant">約會餐廳:</label>&emsp;
                            <!-- <a href="/date/restaurant"> >>>>前往查看餐廳介紹</a> -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#restaurant_introduction">
                                前往查看餐廳介紹
                            </button>
                            <p></p>
                            <select class="form-control" id="date_restaurant" name="date_restaurant" style="max-width:500px;">
                                <option value="1">請選擇</option>
                                @foreach($data['restaurant'] as $value)
                                    <option value="{{ $value['place'] }}">{{ $value['place'] }}</option>
                                @endforeach
                                <!-- <option>有其他想約會的餐廳可主動通知顧問</option> -->
                            </select>
                        </div>

                        <div class="form-group">
                            <div id="datetime">
                                <strong>可約會時間(建議選四個時段以上，邀約成功率上升):</strong><br>
                                <div class="container">
                                    <div class="row">
                                        @foreach($data['video_date'] as $value)
                                        <div class="col-md-5">
                                            <label>
                                            <input type="checkbox" class="form-check-input" name="datetime[]" value="{{ $value['datetime'] }}">
                                                @php 
                                                    $week = date('w',strtotime($value['datetime'])); 
                                                    if($week == 0) $week = '日';
                                                    if($week == 1) $week = '一';
                                                    if($week == 2) $week = '二';
                                                    if($week == 3) $week = '三';
                                                    if($week == 4) $week = '四';
                                                    if($week == 5) $week = '五';
                                                    if($week == 6) $week = '六';
                                                @endphp
                                                {{ date('Y/m/d', strtotime($value['datetime'])) }} ({{$week}}) {{ date('H點i分', strtotime($value['datetime'])) }} ~ {{ date('H點i分', strtotime($value['datetime'])+1*60*30) }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="datetime2">
                                <strong>可約會時間(建議選四個時段以上，邀約成功率上升):</strong><br>
                                <div class="container">
                                    <div class="row">
                                    @foreach($data['restaurant_date'] as $value)
                                    <div class="col-md-5">
                                        <div>
                                            <label>
                                                <input type="checkbox" class="form-check-input" name="datetime2[]" value="{{ $value['datetime'] }}">
                                                @php 
                                                    $week = date('w',strtotime($value['datetime'])); 
                                                    if($week == 0) $week = '日';
                                                    if($week == 1) $week = '一';
                                                    if($week == 2) $week = '二';
                                                    if($week == 3) $week = '三';
                                                    if($week == 4) $week = '四';
                                                    if($week == 5) $week = '五';
                                                    if($week == 6) $week = '六';
                                                @endphp
                                                {{ date('Y/m/d', strtotime($value['datetime'])) }} ({{$week}}) {{ date('H點i分', strtotime($value['datetime'])) }} ~ {{ date('H點i分', strtotime($value['datetime'])+1*60*60) }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="push_user">
                            <h5>選擇排約對象 : (為促成高約會跟高脫單率，所以每週主約對象限制8名以內) </h5>
                            @if(!empty($data['registration_username']))
                                <div style="color:green;">已選擇 : 
                                    @foreach($data['registration_username'] as $key => $value)
                                        @if($key > 0)、@endif<span>{{$value}}</span>
                                    @endforeach
                                </div>
                            @endif
                            @foreach($data['push_data'] as $value) 
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="push_user[]"  value="{{ $value['username'] }}">
                                    <span>{{ $value['username'] }}</span>&nbsp;
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="">
                            <button type="submit" class="btn btn-primary"
                            style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">送出</button>
                            <a type="button" class="btn btn-danger" href="/date/data"
                            style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">取消</a>
                        </div>
                    @endif
                </form>
                </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="restaurant_introduction">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:#2b2b2b;">
            
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">餐廳介紹</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    @foreach($data['restaurant'] as $value)
                        <div>{{ $value['place'] }}</div>
                        <a href="{{ $value['url'] }}" target=' _blank'>{{ $value['url'] }}</a>
                        <br><br>
                    @endforeach
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
                </div>
                
            </div>
        </div>
    </div>

<br><br><br><br>

<script>
    $(document).ready(function(){
        $("#datetime").hide();
        //$("#datetime2").hide();
        //$("#restaurant").hide();
        $("#chat_option").hide();
        //$("#push_user").hide();
        $("#invitation_form").on('submit', function(e){
            if (!$('input[name="type"]').is(':checked')) {
                e.preventDefault();
                alert('未勾選約會方式');
            }
            if($("#type1").is(':checked')){
                if (!$('input[name="chat_option"]').is(':checked')) {
                    e.preventDefault();
                    alert('未勾選視訊約會流程');
                }
                if (!$('input[name="datetime[]"]').is(':checked')) {
                    e.preventDefault();
                    alert('未勾選視訊約會時間');
                }
                // if (!$('input[name="push_user[]"]').is(':checked')) {
                //     e.preventDefault();
                //     alert('未勾選排約對象');
                // }
            }
            if($("#type2").is(':checked')){
                if ($("#date_restaurant").val() == "1") {
                    e.preventDefault();
                    alert('未選擇約會餐廳');
                }
                if (!$('input[name="datetime2[]"]').is(':checked')) {
                    e.preventDefault();
                    alert('未勾選餐廳約會時間');
                }
                // if (!$('input[name="push_user[]"]').is(':checked')) {
                //     e.preventDefault();
                //     alert('未勾選排約對象');
                // }
            }

        });
        $('input[name="type"]').change(function() {
            if ($(this).is(':checked') && $(this).val() == "type1") {
                $("#datetime2").hide();
                $("#datetime").show();
                $("#restaurant").hide();
                $("#chat_option").show();
                //$("#push_user").show();
            }
            if ($(this).is(':checked') && $(this).val() == "type2") {
                $("#datetime").hide();
                $("#datetime2").show();
                $("#restaurant").show();
                $("#chat_option").hide();
                //$("#push_user").show();
            }
        });
    });
  
</script>

@include('date.components.footer')
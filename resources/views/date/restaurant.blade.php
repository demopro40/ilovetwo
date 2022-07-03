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
    <a href="/date/invitation" class="btn btn-primary">回上頁</a>
</div>
<div class="jumbotron text-center">
    <h2><strong>愛樂Two排約餐廳介紹</strong></h2>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
        @foreach($data['restaurant'] as $value)
            <div>{{ $value['place'] }}</div>
            <a href="{{ $value['url'] }}">{{ $value['url'] }}</a>
            <br><br>
        @endforeach
    </div>
  </div>
</div>
<br><br>

<script>
</script>
</body>
</html>
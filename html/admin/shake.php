<?php
include_once './commonBaseClass.php';

$calssa = new BaseClass();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>摇一摇</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
        <!--<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" media="screen">-->
        <!-- Custom styles for this template -->
        <link href="../css/setting.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .time-item strong{background:#C71C60;color:#fff;line-height:49px;font-size:36px;font-family:Arial;padding:0 10px;margin-right:10px;border-radius:5px;box-shadow:1px 1px 3px rgba(0,0,0,0.2);}
            #day_show{float:left;line-height:49px;color:#c71c60;font-size:32px;margin:0 10px;font-family:Arial, Helvetica, sans-serif;}
            .item-title .unit{background:none;line-height:49px;font-size:24px;padding:0 10px;float:left;}
        </style>
    </head>

    <body>
        <div id="wrapper">
            <div class="container">
                <div class="contents">
                    <div class="row">
                        <h1 class="text-center">摇一摇</h1>
                        <div class="col-xs-12 col-sm-4 col-md-4 setting-sidebar setting-wall">
                            <button class="btn-primary btn-start  btn-lg" role="button">开始</button>
                            <button class="btn-primary btn-end  btn-lg" role="button">结束</button>
                            <div class="time-item">
                                <!--<span id="day_show">0天</span>-->
                                <!--<strong id="hour_show">0时</strong>-->
                                <strong id="minute_show">0分</strong>
                                <strong id="second_show">0秒</strong>
                            </div><!--倒计时模块-->
                        </div>

                        <div class="col-xs-12 col-sm-8 col-md-8 pull-right setting-wall">

                            <div class="date-view">

                            </div>

                        </div>
                    </div><!--container-->
                </div>

            </div>
            <!-- /.wrapper -->
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src=".././js/jquery.min.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src=".././js/jquery-ui.js"></script>
        <!--<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>-->
        <script src=".././js/bootstrap.min.js"></script>
        <!--<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->

    </body>

</html>
<script>

    var intDiff = parseInt(30);//倒计时总秒数量
    var getdatatimes=50;
    $(function () {
        $(".btn-start").click(function () {
            timer(intDiff);
            $.ajax({
                url: "./cshake.php?a=start",
                async: true, //默认为true 异步 
                success: function (data) {

                },
            });
            
            //y异步刷新获取排名  每三秒执行一次
            getdata(getdatatimes);

        });
        $(".btn-end").click(function () {
            $.ajax({
                url: "./cshake.php?a=end",
                async: true, //默认为true 异步 
                success: function (data) {

                },
            });
        });


    });

    function getdata(getdatatimes){
        
        var getdata = window.setInterval(function () {
            if (getdatatimes < 2) {
                clearInterval(getdata);
                        console.log(getdatatimes);
            } else {
                getdatatimes--;
                $.ajax({
                    url: "./cshake.php?a=getDataList",
                    success: function (data) {
                        console.log(data);
                    },
                });

            }
        }, 3000);
    }

    function timer(intDiff) {
        var settime = window.setInterval(function () {
            var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;//时间默认值		
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            } else {
                //提示结束信息
                clearInterval(settime);
            }
            if (minute <= 9)
                minute = '0' + minute;
            if (second <= 9)
                second = '0' + second;
//	$('#day_show').html(day+"天");
//            $('#hour_show').html('<s id="h"></s>' + hour + '时');
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            intDiff--;
        }, 1000);
    }

</script>
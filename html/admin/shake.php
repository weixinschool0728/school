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
        <link href="../css/setting.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style>
            .time-item strong{background:#c71c60;color:#fff;line-height:49px;font-size:36px;font-family:Arial;padding:0 10px;margin-right:10px;border-radius:5px;box-shadow:1px 1px 3px rgba(0,0,0,0.2)}
            #day_show{float:left;line-height:49px;color:#c71c60;font-size:32px;margin:0 10px;font-family:Arial,Helvetica,sans-serif}
            .item-title .unit{background:0;line-height:49px;font-size:24px;padding:0 10px;float:left}
            .skillbar{position:relative;display:block;margin-bottom:15px;width:100%;background:#eee;height:35px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;-webkit-transition:.4s linear;-moz-transition:.4s linear;-ms-transition:.4s linear;-o-transition:.4s linear;transition:.4s linear;-webkit-transition-property:width,background-color;-moz-transition-property:width,background-color;-ms-transition-property:width,background-color;-o-transition-property:width,background-color;transition-property:width,background-color}
            .skillbar-title{position:absolute;top:0;left:0;width:110px;font-weight:bold;font-size:13px;color:#fff;background:#6adcfa;-webkit-border-top-left-radius:3px;-webkit-border-bottom-left-radius:4px;-moz-border-radius-topleft:3px;-moz-border-radius-bottomleft:3px;border-top-left-radius:3px;border-bottom-left-radius:3px}
            .skillbar-title span{display:block;background:rgba(0,0,0,0.1);padding:0 20px;height:35px;line-height:35px;-webkit-border-top-left-radius:3px;-webkit-border-bottom-left-radius:3px;-moz-border-radius-topleft:3px;-moz-border-radius-bottomleft:3px;border-top-left-radius:3px;border-bottom-left-radius:3px}
            .skillbar-bar{height:35px;width:0;background:#6adcfa;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px}
            .skill-bar-percent{position:absolute;right:10px;top:0;font-size:11px;height:35px;line-height:35px;color:#fff;color:rgba(0,0,0,0.4)}
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

        <script src=".././js/jquery.min.js"></script>
        <script src=".././js/jquery-ui.js"></script>
        <script src=".././js/bootstrap.min.js"></script>

    </body>

</html>
<script>

    var intDiff = parseInt(30);//倒计时总秒数量
    var getdatatimes = 50;
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

    function viewData() {
        jQuery('.skillbar').each(function () {
            jQuery(this).find('.skillbar-bar').animate({
                width: jQuery(this).attr('data-percent')
            }, 3000);
        });
    }

    function getdata(getdatatimes) {

        var getdata = window.setInterval(function () {
            if (getdatatimes < 2) {
                clearInterval(getdata);
            } else {
                getdatatimes--;
                $.ajax({
                    url: "./cshake.php?a=getDataList",
                    success: function (data) {

                        data = $.parseJSON(data);
                        var datacolor = new Array();
                       
                        var datacount = 0;
                        var str = '';

                        datacount = parseInt(100 / data.length);
                        for (var i = 0; i < data.length; i++) {

                            str += '<div class="skillbar clearfix " data-percent="' + parseInt(100 - i * (datacount)) + '%">';
                            str += ' <div class="skillbar-title" style="background: #d35400;"><span>' + data[i].name + '</span></div>';
                            str += '<div class="skillbar-bar" style="background: #e67e22;"></div>';
                            str += '<div class="skill-bar-percent">' + data[i].shake + '</div></div>';
                        }
                        $(".date-view").html(str);
                        viewData();
                    },
                });

            }
        }, 4000);
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

                clearInterval(settime);
            }
            if (minute <= 9)
                minute = '0' + minute;
            if (second <= 9)
                second = '0' + second;
            $('#minute_show').html('<s></s>' + minute + '分');
            $('#second_show').html('<s></s>' + second + '秒');
            intDiff--;
        }, 1000);
    }

</script>
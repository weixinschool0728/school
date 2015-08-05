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
        <link href="../css/time_css.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div id="wrapper">



            <div class="container">
                <div class="contents">
                    <div class="row">
                        <h1 class="text-center">摇一摇</h1>
                        <div class="col-xs-12 col-sm-3 col-md-2 setting-sidebar">
                            <button class="btn-primary btn-start  btn-lg" role="button">开始</button>
                            <div class="game_time" style="display:none">
                                <div class="hold">
                                    <div class="pie pie1"></div>
                                </div>
                                <div class="hold">
                                    <div class="pie pie2"></div>
                                </div>
                                <div class="bg"> </div>
                                <div class="time"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-9 col-md-10 data-list">
                        </div>
                    </div><!--container-->
                </div>
                <!--            <div class="col-xs-12 col-sm-3 col-md-2 setting-sidebar">
                                sadasdas
                            </div>-->
                <!--            </div>--jumbotron-->
            </div>
            <!-- /.wrapper -->
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src=".././js/jquery.min.js"></script>
        <script src=".././js/time_js.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src=".././js/jquery-ui.js"></script>
        <!--<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>-->
        <script src=".././js/bootstrap.min.js"></script>
        <!--<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->

    </body>

</html>
<script>
    $(function () {
        $(".btn-start").click(function(){
        $(this).hide();
        $.ajax({
            url:"./cshake.php?a=start",
            async: true, //默认为true 异步 
            success:function(data){

            },
        });
        // countDown();
        $(".game_time").show();
                //y异步刷新获取排名  每三秒执行一次

        time = setInterval(getdata(),300);
            
        });
//        function getdata(){
//
//                    i=i-3000;
//                    console.log(i);
////                    if(i==0){
////                        clearInterval(time);
////                    }
//        }
    });
</script>
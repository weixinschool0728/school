<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>手机摇一摇</title>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="./js/jquery.min.js"></script>
        <script type="text/javascript">
            var color = new Array('#fff', '#ff0', '#f00', '#000', '#00f', '#0ff');
            var id =<?php echo isset($_GET['id']) ? $_GET['id'] : '-1'; ?>;
            if (window.DeviceMotionEvent) {
                var speed = 25;
                var x = y = z = lastX = lastY = lastZ = 0;
                window.addEventListener('devicemotion', function() {
                    var acceleration = event.accelerationIncludingGravity;
                    x = acceleration.x;
                    y = acceleration.y;
                    if (Math.abs(x - lastX) > speed || Math.abs(y - lastY) > speed) {
                        //这里面写异步加载处理
                        $.getJSON("../control/shake.php?id=" + id, function(data) {
                            $("#info").html("");
                            var info = " <table>" +
                                    "<tr> <td> 开始时间 </td><td>"+data.start+"</td > </tr>" +
                                    "<tr> <td> 结束时间 </td><td>"+data.end+"</td > </tr>" +
                                    "<tr> <td> 累计摇一摇次数 </td><td>"+data.total+"</td> </tr>" +
                                    "</table>";
                            $("#info").html(info);

                        });
                        //结束异步加载
                        //document.body.style.backgroundColor = color[Math.round(Math.random() * 10) % 6];
                    }
                    lastX = x;
                    lastY = y;
                }, false);
            }
        </script>  
    </head>
    <body>
        手机摇一摇。 
        <div id="info">


        </div>
    </body>

</html>

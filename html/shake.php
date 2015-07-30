<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>HTML5 手机摇一摇</title>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="./js/jquery.min.js"></script>
        <script type="text/javascript">
            var color = new Array('#fff', '#ff0', '#f00', '#000', '#00f', '#0ff');
            if (window.DeviceMotionEvent) {
                var speed = 25;
                var x = y = z = lastX = lastY = lastZ = 0;
                window.addEventListener('devicemotion', function() {
                    var acceleration = event.accelerationIncludingGravity;
                    x = acceleration.x;
                    y = acceleration.y;
                    if (Math.abs(x - lastX) > speed || Math.abs(y - lastY) > speed) {
                        document.body.style.backgroundColor = color[Math.round(Math.random() * 10) % 6];
                    }
                    lastX = x;
                    lastY = y;
                }, false);
            }
        </script>  
    </head>
    <body>
      HTML 5 手机摇一摇，在手机上运行的。  
    </body>
</html>
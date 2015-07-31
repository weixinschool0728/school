<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="./js/jquery.min.js"></script>
        <style>
            #ilike{
                font-size: 16px;
                font-weight: 600;
                padding: 8px 40px;
                background-color: #d7000f;
                border: 1px solid #d7000f;
                color: #fff;
                background-color: #428bca;
                border-color: #357ebd;
            } 
        </style>
    </head>
    <body>
        <script>
            $(function() {
                function sleep(n) { //n表示的毫秒数
                    var start = new Date().getTime();
                    while (true)
                        if (new Date().getTime() - start > n)
                            break;
                }
                $("#ilike").click(function() {
                     $("#info").html("");
                    // 异步加载投票
                    var c_no = $("#c_no").val();
                    var opid = $("#opid").val();
                    $("#ilike").val('点赞中....');
                    $.getJSON("../control/ilike.php?c_no=" + c_no + "&opid=" + opid, function(data) {
                          sleep(1000);
                          $("#ilike").val('点赞');
                       
                        if (data.statu < 4) {
                            var str = " <table>" +
                                    "<tr><td>提示：</td><td>" + data.mesg + "</td></tr>" +
                                    "<tr><td>总得票：</td><td>" + data.total + "</td></tr>" +
                                    "</table>";
                            $("#info").html(str);
                        } else {
                            $("#info").html(data.mesg);
                        }
                    });//异步加载结束
                });
            });
        </script>
        <div>
            <input id="c_no" type="hidden" value="<?php echo isset($_GET['c_no']) ? $_GET['c_no'] : ''; ?>" />
            <input id="opid" type="hidden" value="<?php echo isset($_GET['opid']) ? $_GET['opid'] : ''; ?>" />
        </div>
        <div>
            <input id="ilike"  type="button" value="点赞"/>
        </div>
        <div id="m"></div>
        <div id="info">

        </div>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <title>投票</title>
        <meta charset="UTF-8">
        <meta name="description" content="大家快来给我投一票 呗"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="./js/jquery.min.js"></script>
                <script src="./js/jweixin.js"> </script>
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
        <script>
                wx.ready(function () {
            // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
//            document.querySelector('#onMenuShareTimeline').onclick = function () {
            var c_no=document.getElementById('c_no').value ;
            c_no=c_no?"?="+c_no:"";
            var url="http://"+"<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];?>"+c_no;
              wx.onMenuShareTimeline({
                title: '投票投票',
                link: url,
                imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
                trigger: function (res) {
                },
                success: function (res) {
                            alert('已分享');
                        },
                        cancel: function (res) {
                        },
                        fail: function (res) {
//                            alert(JSON.stringify(res));
                        }
                    });
//                };
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
        <!--<div id="onMenuShareTimeline">分享</div>-->
    <?php include_once './jsCommonInclude.php';?>
    </body>
    
</html>

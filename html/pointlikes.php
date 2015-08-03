<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="livequery,jquery" />
        <meta name="description" content="Helloweba演示平台，演示XHTML、CSS、jquery、PHP案例和示例" />
        <title>jQuery+PHP实现浏览更多内容</title>
        <link rel="stylesheet" type="text/css" href="../css/main.css" />
        <style type="text/css">
            #more{margin:10px auto;width: 560px;  border: 1px solid #999;}               
            .single_item{padding: 20px; border-bottom: 1px dotted #d3d3d3;}
            .author{position: absolute; left: 0px; font-weight:bold; color:#39f}
            .date{position: absolute; right: 0px; color:#999}
            .content{line-height:20px; word-break: break-all;}
            .element_head{width: 100%; position: relative; height: 20px;}
            .get_more{margin:10px; text-align:center}
            .more_loader_spinner{width:20px; height:20px; margin:10px auto; background: url(./img/loader.gif) no-repeat;}
        </style>
        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/jquery.more.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#more').more({'address': '../control/search_qrcode.php'})
            });
        </script>
    </head>
    <body>
        <div id="header">
           
        </div>
        <div id="main">
            <div id="more">
                <div class="single_item">
                    <div class="element_head">
                        <div class="c_no"></div>
                        <div class="created"></div>
                    </div>
                    <div class="content"></div>
                </div>
                <a href="javascript:;" class="get_more">::点击加载更多内容::</a>
            </div> 
            <br />
            <br />
            <br />

        </div>
        <div id="footer">
          
        </div>
       
    </body>
</html>

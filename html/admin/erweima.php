<?php
include_once './commonBaseClass.php';

class ErweimaClass extends BaseClass {
    
}

$erweima = new ErweimaClass();
?>
<?php include_once './commonheader.php'; ?>
<style>
    .btn-right {
        float: right;
        margin-right: 5px;
    }
    .table-tbody tr {
        border-spacing: 2px;
        border-bottom: 1px;
        border-top: 1px;
    }
    .table .table {
        background-color: rgba(0, 231, 161, 0.43);
    }
    .data-edit {
        display: none;
    }
</style>
<div class="wrapper settingwrap clearfix">

    <div class="container">
        <div class="contents">
            <div class="row">


                <!--菜单-->
                <div class="col-xs-12 col-sm-3 col-md-2 setting-sidebar">
                    <ul class="list-unstyled setting-list">
                        <li class=" setting-list-li" ><a href="./userlist.php">参赛人员管理</a>
                        <li class="active setting-list-li" ><a href="./erweima.php">二维码管理</a>
                        <li class=" setting-list-li"><a href="#">契約</a>
                        </li>
                        <li class=" setting-list-li"><a href="#">利用プラン</a>
                        </li>
                        <li class=" setting-list-li"><a href="#">支払方法</a>
                        </li>
                        <li><a href="#">連絡先情報</a>
                        </li>
                    </ul>
                </div>
                <!-- /.col-sm-3 菜单-->



                <div class="col-xs-12 col-sm-9 col-md-10 data-list">

                    <div class="setting-wall">
                        <div class="col-sm-offset-2">
                            <ul class="pager">

                            </ul>
                        </div><!--分页-->

                        <div class="">
                            <form class="form-horizontal data-search-form" role="form">
                                <div class="form-group">
                                    <label for="inputc_no" class="col-sm-2 control-label">编号</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="inputc_no" placeholder="编号">
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-primary btn-search btn-login btn-right">搜索</button>
                        </div>

                      
                        <div class="clearfix">
                        </div>

                    </div>
                    <!-- setting-wall -->
                </div>
                <!--//.col-sm-9-->



            </div>
            <!-- /.row -->
        </div>
        <!-- /.contents -->
    </div>
    <!-- /.container -->
    <?php include_once './commonfooter.php'; ?>
    <script>
        $(function () {
            getUser();

        });
        function closeDataEdit() {
            $(".data-edit").hide();
            $(".data-list").show();
        }
        function getUser(page) {
            page = page ? page : 1;
            $.ajax({
                url: "./cerweima.php?a=erweimalist",
                data: {'page': page},
                async: true, //默认为true 异步 
                success: function (data) {
                    data = $.parseJSON(data);

                    var str = '<li><a href="JavaScript:createers()">生成二维码</a></li>';
                    str += '<li><a href="JavaScript:printers()">打印' + data.p.c + '个二维码</a></li>';
//                        str += '<li class="disabled"><a href="#">(' + data.p.page + '/' + data.p.pages + ')</a></li>';   //创建分页

                    $(".pager").html(str);
                    //分页结束
                    //表格操作
//                    str = "";
//                    $(".table-mytable tr").remove();
//                    for (var i in data.data) {
//                        str += "<tr>";
//                        str += "<td>" + data.data[i].c_no + "</td>";
//                        str += "<td>" + data.data[i].c_username + "</td>";
//                        str += "<td><img src='" + data.data[i].c_head + "'></td>";
//                        str += '<td><img src="' + data.data[i].c_qrpath + '"></td>';
//                        str += '<td style="text-overflow:ellipsis;text-overflow: ellipsis;-ms-text-overflow: ellipsis;">' + data.data[i].content + '</td>';
//                        str += '<td>' + getLocalTime(data.data[i].created) + '</td>';
//                        str += '<td><button onclick="deleteuser(' + data.data[i].c_id + ',this)" class="btn">删除</button>' + '<button onclick="edituser(' + data.data[i].c_id + ')" class="btn">编辑</button>' + '</td>';
//                        str += "</tr>";
//                    }
//                    $(".table-mytable").html(str);
                },
            });
        }
        function createers() {

        }

        function printers() {
            alert(111);
        }

        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
        }
    </script>


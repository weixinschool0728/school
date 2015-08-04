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

    @media print {
        .printContent div{
            width: 100pt;
            height: 100pt;
            background-color: #00FF00;
        }
        .printContent div img{
            width: 90pt;
            height: 90pt;
            margin-right:auto; 
            margin-left:auto; 
        }
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

                    </ul>
                </div>
                <!-- /.col-sm-3 菜单-->



                <div class="col-xs-12 col-sm-9 col-md-10 data-list">

                    <div class="setting-wall">
                        <div class="col-sm-offset-2">
                            <ul class="pager">

                            </ul>
                        </div><!--分页-->


                        <!--<div class="">-->
                        <!--<form class="form-horizontal data-search-form" role="form">-->
                        <div class="form-group ">
                            <label for="inputc_no" class="col-sm-1 control-label offset-2">编号</label>
                            <div class="input-group col-sm-9">
                                <input type="text" class="form-control col-sm-7" name="inputc_no" id="inputc_no" placeholder="编号">
                                <span class="input-group-btn">
                                    <button class="btn btn-default  btn-search" type="button"onclick="searchCno();return false;">搜索</button>
                                </span>
                                <!--<button class="btn btn-search pull-right col-sm-1" onclick="searchCno();return false;">搜索</button>-->
                            </div>
                        </div>

                        <div id="erweimas" ></div>
                        <!--</form>-->

                        <!--</div>-->


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
    <script language="javascript" src="../js/jquery.PrintArea.js"></script>
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
                                                str += '<li><a href="JavaScript:printers()">打印' + '二维码</a></li>';

                                                $(".pager").html(str);
                                                //分页结束
                                                //二维码列表
                                                str = "";
                                                $("#erweimas").html();
                                                for (var i in data.data) {
                                                    str += "<div class='printContent pull-left'><div>";
                                                    str += "<img src='" + data.data[i].c_qrpath + "'>";
                                                    str += "<p>" + data.data[i].c_no + "</p>";
                                                    str += "</div></div>";
                                                }
                                                $("#erweimas").html(str);
                                            },
                                        });
                                    }
                                    function createers() {

                                        $.ajax({
                                            url: "./cerweima.php?a=createers",
                                            success: function (data) {
                                                alert(data);
                                            },
                                        });
                                    }

                                    function printers() {
                                        var probj = $(".printContent");
                                        $(".printContent").each(function (i) {
                                            $(probj[i]).printArea();
                                        });
                                    }
                                    function searchCno() {
                                        var cno = $("#inputc_no").val();
                                        if (cno) {
                                            $.ajax({
                                                url: "./cerweima.php?a=searchcno",
                                                data: {'cno': cno},
                                                type: "post",
                                                success: function (data) {
                                                    data = $.parseJSON(data);
                                                    if (data.state == 0) {
                                                        var str = "<div class='search-re printContent'><img src='" + data.c_qrpath + "'>";
                                                        str += "<p>" + data.c_no + "</p></div>";
                                                        $("#erweimas").remove();
                                                        $(".form-group").after(str);

                                                    } else {
                                                        alert("没找到");
                                                    }
                                                },
                                            });
                                        } else {
                                            alert("请输入编号 例如:sc20113110");
                                            return false;
                                        }
                                    }

                                    function getLocalTime(nS) {
                                        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
                                    }
    </script>


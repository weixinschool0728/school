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
                        <div>
                            <ul class="pager">
                                <li><a href="#">上一页</a></li>
                                <li><a href="#">下一页</a></li>
                            </ul>
                        </div><!--分页-->

                        <table class="table table-hover" id="table-mytable">
                            <thead class="table table-thead">
                                <tr>

                                    <td>编号</td>
                                    <td>姓名</td>
                                    <td>图片</td>
                                    <td>二维码</td>
                                    <td>介绍</td>
                                    <td>创建时间</td>
                                    <td>操作</td>
                                </tr>
                            </thead>
                            <tbody class="table-tbody table-striped table-mytable">

                            </tbody>
                        </table>

                        <button class="btn btn-primary btn-delate btn-login btn-right">shen</button>
                        <button class="btn btn-primary btn-edit btn-login btn-right">tianjia</button>
                        <div class="clearfix">
                        </div>

                    </div>
                    <!-- setting-wall -->
                </div>
                <!--//.col-sm-9-->

                <div class="col-xs-12 col-sm-9 col-md-10 data-edit">
                    <div class="setting-wall">
                        <div class="pull-right" onclick="closeDataEdit()">关闭</div>
                        <form class="form-horizontal data-edit-form" role="form">
                            <div class="form-group">
                                <label for="inputc_no" class="col-sm-2 control-label">编号</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputc_no" placeholder="编号">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" value="姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputHead" class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-5">
                                    <input type="file" class="form-control" id="inputHead" placeholder="头像">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-sm-2 control-label">パスワード</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="inputPassword" placeholder="パスワード">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputNumber" class="col-sm-2 control-label">社員番号</label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" id="inputNumber" placeholder="社員番号">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputTelInner" class="col-sm-2 control-label">内線電話</label>
                                <div class="col-sm-5">
                                    <input type="tel" class="form-control" id="inputTelInner" placeholder="phone">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputTelouter" class="col-sm-2 control-label">携帯電話</label>
                                <div class="col-sm-5">
                                    <input type="tel" class="form-control" id="inputTelouter" placeholder="phone">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-login btn-right btn-update">更新</button>
                        </form>
                        <button class="btn btn-primary btn-login btn-right btn-undo" onclick="closeDataEdit()">キャンセル</button>
                        <div class="clearfix"></div>

                    </div>
                    <!--.setting-wall-->
                </div>
                <!--.col-xs-12 data-edit--->

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
                url: "./cerweima.php?a=userlist",
                data: {'page': page},
                async: true, //默认为true 异步 
                success: function (data) {
                    data = $.parseJSON(data);

                    var str = '<li class="disabled"><a href="#">' + data.p.page + '/' + data.p.pages + '</a></li>';   //创建分页
                    var previous = data.p.page - 1;
                    var next = parseInt(data.p.page) + 1;
                    if (data.p.page == 1) {
                        str += '<li class="disabled"><a href="#">上一页</a></li>';
                    } else {
                        str += '<li><a href="javascript:getUser(' + previous + ')">上一页</a></li>';
                    }
                    if (data.p.page == data.p.pages) {
                        str += '<li class="disabled"><a href="#">下一页</a></li>';
                    } else {
                        str += '<li><a href="javascript:getUser(' + next + ')">下一页</a></li>';
                    }
                    $(".pager").html(str);
                    //分页结束
                    //表格操作
                    str = "";
                    $(".table-mytable tr").remove();
                    for (var i in data.data) {
                        str += "<tr>";
                        str += "<td>" + data.data[i].c_no + "</td>";
                        str += "<td>" + data.data[i].c_username + "</td>";
                        str += "<td><img src='" + data.data[i].c_head + "'></td>";
                        str += '<td><img src="' + data.data[i].c_qrpath + '"></td>';
                        str += '<td style="text-overflow:ellipsis;text-overflow: ellipsis;-ms-text-overflow: ellipsis;">' + data.data[i].content + '</td>';
                        str += '<td>' + getLocalTime(data.data[i].created) + '</td>';
                        str += '<td><button onclick="deleteuser(' + data.data[i].c_id + ',this)" class="btn">删除</button>' + '<button onclick="edituser(' + data.data[i].c_id + ')" class="btn">编辑</button>' + '</td>';
                        str += "</tr>";
                    }
                    $(".table-mytable").html(str);
                },
            });
        }
        function edituser(id, obj) {
            alert(id);
            $(".data-edit").show();
            $(".data-list").hide();
        }
        function deleteuser(id, obj) {
            if (confirm("确定删除吗？")) {
                $(obj).parent().parent().remove();
                $.ajax({
                    url: "./cerweima.php?a=deleteuser",
                    data: {'id': id},
                    type: "post",
                    success: function (data) {
                        alert(data);
                        data = $.parseJSON(data);

                        if (data.state == 0) {
                            alert("Chenggong");
                        }else{
                            alert("shibai ");
                        }

                    },
                });
            }

        }

        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
        }
    </script>


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
<style type="text/css">
    .btnf{position: relative;overflow: hidden;margin-right: 4px;display:inline-block;*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px;*line-height:20px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;background-color:#5bb75b;border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
    .btnf input {position: absolute;top: 0; right: 0;margin: 0;border: solid transparent;opacity: 0;filter:alpha(opacity=0); cursor: pointer;}
    .progress { position:relative; margin-left:100px; margin-top:-24px; width:200px;padding: 1px; border-radius:3px; display:none}
    .bar {background-color: green; display:block; width:0%; height:20px; border-radius: 3px; }
    .percent { position:absolute; height:20px; display:inline-block; top:3px; left:2%; color:#fff }
    .files{height:22px; line-height:22px; margin:10px 0}
    .delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
<div class="wrapper settingwrap clearfix">

    <div class="container">
        <div class="contents">
            <div class="row">


                <!--菜单-->
                <div class="col-xs-12 col-sm-3 col-md-2 setting-sidebar">
                    <ul class="list-unstyled setting-list">
                        <li class="active setting-list-li" ><a href="./userlist.php">参赛人员管理</a>
                        <li class="setting-list-li" ><a href="./erweima.php">二维码管理</a>

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

                        <!--                        <button class="btn btn-primary btn-delate btn-login btn-right">shen</button>
                                                <button class="btn btn-primary btn-edit btn-login btn-right">tianjia</button>-->
                        <div class="clearfix">
                        </div>

                    </div>
                    <!-- setting-wall -->
                </div>
                <!--//.col-sm-9-->

                <div class="col-xs-12 col-sm-9 col-md-10 data-edit">
                    <div class="setting-wall">
                        <button class="pull-right btn-primary" onclick="closeDataEdit()">关闭</button>
                        <form class="form-horizontal data-edit-form" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputc_no" class="col-sm-2 control-label">编号</label>
                                <div class="col-sm-5">
                                    <input type="text" name="no" class="form-control" id="inputc_no" placeholder="编号">
                                    <input type="hidden" name="id" class="form-control" id="inputc_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-5">
                                    <input type="text" name="name" class="form-control" id="inputName" placeholder="Name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputHead" class="col-sm-2 control-label">头像</label>
                                <div class="col-sm-5">
                                    <!--<input type="file" name="head" class="form-control" id="inputHead" placeholder="头像">-->
                                    <div class="demo">
                                        <div class="btnf">
                                            <span>添加附件</span>
                                            <input id="fileupload" type="file" name="mypic">
                                        </div>
                                        <div class="headres"><img id="head" src="" ></div>
                                        <div class="progress">
                                            <span class="bar"></span><span class="percent">0%</span >
                                        </div>
                                        <div class="files"></div>
                                        <div id="showimg"></div>
                                    </div>
                                    <!--异步上传-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputContent" class="col-sm-2 control-label">介绍</label>
                                <div class="col-sm-5">
                                    <textarea class="form-control" name="content" id="inputContent"></textarea> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state" class="col-sm-2 control-label">状态</label>
                                <div class="input-group">

                                    <div class="pull-right">
                                        <label for="statej" class="control-label">禁用</label>
                                        <input id="statej" type="radio" name="state[]" value="1">

                                    </div>  
                                    <div class="pull-right">
                                        <label for="statez" class="control-label">正常</label>
                                        <input id="statez" type="radio" name="state[]" checked="checked" value="0">

                                    </div>

                                </div><!-- /input-group -->
                            </div>


                        </form>
                        <button class="btn btn-primary btn-login btn-right btn-update" onclick="submitdata();
                                return false">更新</button>
                        <button class="btn btn-primary btn-login btn-right btn-undo" onclick="closeDataEdit()">返回</button>
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

                    str = "";
                    $(".table-mytable tr").remove();
                    for (var i in data.data) {
                        str += "<tr>";
                        str += "<td>" + data.data[i].c_no + "</td>";
                        str += "<td>" + data.data[i].c_username + "</td>";
                        str += '<td class="col-sm-2"><img class="col-sm-5" src="' + data.data[i].c_head + '"></td>';
                        str += '<td class="col-sm-2"><img class="col-sm-5" src="' + data.data[i].c_qrpath + '"></td>';
                        str += '<td style="text-overflow:ellipsis;text-overflow: ellipsis;-ms-text-overflow: ellipsis;">' + data.data[i].content + '</td>';
                        str += '<td>' + getLocalTime(data.data[i].created) + '</td>';
                        str += '<td><button onclick="deleteuser(' + data.data[i].c_id + ',this)" class="btn">删除</button>' + '<button onclick="edituser(' + data.data[i].c_id + ')" class="btn">编辑</button>' + '</td>';
                        str += "</tr>";
                    }
                    $(".table-mytable").html(str);
                },
            });
        }
        function edituser(id) {
            $.ajax({
                url: "./cerweima.php?a=getoneuser",
                data: {'cid': id},
                type: "post",
                success: function (data) {
                    data = $.parseJSON(data);
                    $("#inputc_no").val(data.c_no);
                    $("#inputc_id").val(data.c_id);
                    $("#inputName").val(data.c_username);
                    $("#showimg").html("<img class='uploadimgurl col-sm-5' src='" + data.c_head + "'>");
                    $("#inputContent").val(data.content);
                },
            });
            $(".data-edit").show();
            $(".data-list").hide();
        }
        function deleteuser(id, obj) {
            if (confirm("确定删除吗？")) {

                $.ajax({
                    url: "./cerweima.php?a=deleteuser",
                    data: {'id': id},
                    type: "post",
                    success: function (data) {
                        data = $.parseJSON(data);

                        if (data.state == 0) {
                            $(obj).parent().parent().remove();
                        } else {
                            alert("失败");
                        }

                    },
                });
            }

        }

        function submitdata() {
            var img = $(".uploadimgurl").attr("src");
            var id = $("#inputc_id").val();
            var no = $("#inputc_no").val();
            var name = $("#inputName").val();
            var content = $("#inputContent").val();
            var state = $("input[checked='checked']").val();
            $.ajax({
                url: "./cerweima.php?a=edituser",
                async: false,
                data: {'img': img, 'id': id, "no": no, "name": name, "content": content, "state": state},
                type: "post",
                success: function (data) {
                    data = $.parseJSON(data);
                    if (data.state == 1) {
                        alert("修改失败");
                    } else {
                        window.location.href = window.location.href;
                    }
                },
            });
        }

        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/, ' ');
        }
    </script>
    <script>
        $(function () {
            var bar = $('.bar');
            var percent = $('.percent');
            var showimg = $('#showimg');
            var progress = $(".progress");
            var files = $(".files");
            var btnf = $(".btnf span");
            $("#fileupload").wrap("<form id='myupload' action='./upload.php' method='post' enctype='multipart/form-data'></form>");
            $("#fileupload").change(function () {
                $("#myupload").ajaxSubmit({
                    dataType: 'json',
                    beforeSend: function () {
                        showimg.empty();
                        progress.show();
                        var percentVal = '0%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                        btnf.html("上传中...");
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                    },
                    success: function (data) {
                        $(".headres").remove();
                        files.html("<b>" + data.name + "(" + data.size + "k)</b> <span class='delimg' onclick='deleteImg(this)' rel='" + data.pic + "'>删除</span>");
                        var img = data.pic;
                        showimg.html("<img class='uploadimgurl col-sm-5' src='" + img + "'>");
                        btnf.html("添加附件");
                    },
                    error: function (xhr) {
                        btnf.html("上传失败");
                        bar.width('0');
                        files.html(xhr.responseText);
                    }
                });
            });

            function deleteImg(obj) {
                alert(111);
                var pic = $(obj).attr("rel");
                alert(pic);
                $.post("./upload.php?act=delimg", {imagename: pic}, function (msg) {
                    if (msg == 1) {
                        files.html("删除成功.");
                        showimg.empty();
                        progress.hide();
                    } else {
                        alert(msg);
                    }
                });
            }
        });
    </script>
    <script type="text/javascript" src="../js/jquery.form.js"></script>


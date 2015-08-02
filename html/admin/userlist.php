
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
                        <li class="active setting-list-li" ><a href="./userlist.php">参赛人员管理</a>
                        <li class=" setting-list-li" ><a href="./erweima.php">二维码管理</a>
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
                        <table class="table table-hover" id="table-mytable">
                            <thead class="table table-thead">
                                <tr>
                                    <td></td>
                                    <td>ID</td>
                                    <td>名前</td>
                                    <td>電話</td>
                                    <td>部門</td>
                                    <td>役職</td>
                                </tr>
                            </thead>
                            <tbody class="table-tbody table-striped">
                                <tr>
                                    <td>
                                        <input type="radio" name="table-select" value="0">
                                    </td>
                                    <td>suzuki@hogehoge.jp1</td>
                                    <td>鈴木一郎</td>
                                    <td>090-1111-2221</td>
                                    <td>営業部</td>
                                    <td>部長</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" name="table-select" value="1">
                                    </td>
                                    <td>suzuki@hogehoge.jp2</td>
                                    <td>鈴木一郎</td>
                                    <td>090-1111-2221</td>
                                    <td>営業部</td>
                                    <td>部長</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="radio" name="table-select" value="2">
                                    </td>
                                    <td>suzuki@hogehoge.jp3</td>
                                    <td>鈴木一郎</td>
                                    <td>090-1111-2221</td>
                                    <td>営業部</td>
                                    <td>部長</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-delate btn-login btn-right">削除</button>
                        <button class="btn btn-primary btn-edit btn-login btn-right">編集</button>
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
                                <label for="inputEmail3" class="col-sm-2 control-label">メールアドレス</label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">名前</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" value="mingqian">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputVoice" class="col-sm-2 control-label">フリガナ</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="inputVoice" placeholder="フリガナ">
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
        $(function () {// 显示编辑界面并且为编辑页面赋值
            $(".btn-edit").click(function () {
                var a = $("input[type='radio']:checked").val();
                if (a == undefined) {
                    alert("请选择");
                } else {
                    var values = Array();
                    a++;
                    var table_tr_obj = $("#table-mytable tr:eq(" + a + ") td:gt(0)");
                    $(table_tr_obj).each(function (i) {
                        values[i] = $(this).text();
                    });
                    $("#inputEmail3").val(values[0]);
                    $("#inputName").val(values[1]);
                    $("#inputTelInner").val(values[2]);

                    $(".data-edit").show();
                    $(".data-list").hide();
                }

            });
        });

        function closeDataEdit() {
            $(".data-edit").hide();
            $(".data-list").show();
        }
    </script>


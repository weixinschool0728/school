<?php 
error_reporting(E_ERROR);
include_once './commonheader.php'; ?>
<style>

</style>
<div class="wrapper settingwrap clearfix">

    <div class="container">
        <div class="contents">
            <div class="row">


                <!--菜单-->
                <div class="col-xs-12 col-sm-3 col-md-2 setting-sidebar">
                    <ul class="list-unstyled setting-list">
                        <li class="active setting-list-li"><a href="#">メンバー管理</a>
                        </li>
                        <li class=" setting-list-li"><a href="./settings_profile_services.html">サービス設定</a>
                        </li>
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
                        <form id="myform" action="./clogin.php" method="post" class="form-horizontal data-user-form" role="form">
                            <div class="form-group">
                                <label for="inputname" class="col-sm-2 control-label">用户名：</label>
                                <div class="col-sm-5">
                                    <input name="inputname" type="text" class="form-control" id="inputname" placeholder="用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputpass" class="col-sm-2 control-label">密　码：</label>
                                <div class="col-sm-5">
                                    <input type="password" name="pass" class="form-control" id="inputpass" placeholder="密码" >
                                </div>
                            </div>
                            <!--<input type="hidden" name="ref" value="<?php if(isset($_GET['ref'])){echo $_GET['ref'];}?>">-->
                                
                            <button type="reset" class="btn btn-primary btn-edit btn-login pull-right">取消</button>
                        </form>
                        <button class="btn btn-primary btn-submit btn-login pull-right">登陆</button>
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
            $(".btn-submit").click(function () {
                if ($('#inputpass').val() != '' && $('#inputname').val() != '') {
                    $("#myform").submit();

                } else {
                    alert("有必填数据。请您检查下");
                    return false;
                }
            });
        });
    </script>
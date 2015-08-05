<!DOCTYPE html>
<html>

	<head>
		<title>school管理</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

		<!-- Bootstrap core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<!--<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" media="screen">-->
		<!-- Custom styles for this template -->
		<link href="../css/setting.css" rel="stylesheet">

		<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
	</head>

	<body>
		<div id="wrapper">
			<div class="header clearfix">
				<div class="navbar .navbar-defaul navbar-fixed-top bg-black">
					<!-- Fixed navbar -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<p class="logo">
							<a href="index.html">
								<img src="../img/logo.png" height="30" width="156" alt="logo">
							</a>
						</p>
					</div>
					<div class="navbar-collapse collapse navbar-right">
						<ul class="nav navbar-nav utility">
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ico_user"></i>
									<span><?php echo $_SESSION['user']['username'];?> <i class="caret"></i></span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header bg-light-blue">
										<img src="./img/user.jpg" class="img-circle" alt="User Image" />
									</li>
									<!-- Menu Body -->
									<li class="user-body">
										<div class="col-xs-6 text-center">
											<a href="#">head</a>
										</div>
										<div class="col-xs-6 text-center">
											<a href="#">利用規約</a>
										</div>
									</li>
									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left">
											<a href="#" class="btn btn-default btn-flat">个人中心</a>
										</div>
										<div class="pull-right">
                                            <a href="./logout.php" class="btn btn-default btn-flat">注销</a>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
			</div>
			<!-- /.header -->
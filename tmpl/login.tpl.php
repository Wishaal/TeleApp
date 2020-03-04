<!DOCTYPE html>
<html class="bg-white">
    <head>
        <meta charset="UTF-8">
        <title><?php echo APP_TITLE; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="assets/_layout/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="assets/_layout/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="assets/_layout/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="form-box" id="login-box">
		<center><img src="assets/_layout/img/logo_gps.png" /></center><p>
            <div class="header">Sign In</div>
            <form action="index.php" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
					<?php if(isset($error)) { echo $error['msg']; } else { echo 'Enter your credentials'; } ?>
                        <input type="text" name="username" required class="form-control" placeholder="User ID" value="<?php echo $_POST['username']; ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required class="form-control" placeholder="Password"/>
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-blue btn-block">Sign me in</button>  
                </div>
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
		<script src="assets/_layout/js/jquery.min.js" type="text/javascript"></script>  
        <!-- Bootstrap -->
        <script src="assets/_layout/js/bootstrap.min.js" type="text/javascript"></script>        
    </body>
</html>
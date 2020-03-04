<?php
	session_start();
	//mis database connection
	$mis_servername = '';
  	$mis_conn_info 	= array( 'database' => '', 'ReturnDatesAsStrings' => true);
  	$mis_conn 		= sqlsrv_connect( $mis_servername, $mis_conn_info) or die('Could not connect to the server!');
	define('MIS_CONN', $mis_conn);
	
	/*echo '<pre>';
	var_dump($_SESSION);
	echo '</pre>';*/
	
	if(!empty($_SESSION['mis']['user'])){
		header('Location: main.php');	
	} 
	
	//logic goes here
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$error = array();
		
		//check if use exists in the database and is active
		$query = '	SELECT * 
					FROM users 
					WHERE username = \'' . $_POST['username'] . '\' 
					AND status = \'1\'';
					
		$resultset 	= sqlsrv_query($mis_conn, $query); 
		$row = sqlsrv_fetch_array($resultset);
		sqlsrv_free_stmt($resultset);
		
		if(empty($row) || empty($_POST['username']) || empty($_POST['password'])){
			$error['msg'] = 'Login failed!';
		} else {
			//check if it's a valid LDAP user
			$ldapconn = ldap_connect("") or die("Could not connect to LDAP server.");
			
			$ldaprdn	= $_POST['username'] . '@domain.com';
			$ldappass	= $_POST['password'];
			
			if ($ldapconn) {

				$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

				if ($ldapbind) {
					$_SESSION['userName'] = $_POST['username'];
					$_SESSION['mis']['user']['id'] = $row['id'];
					$_SESSION['mis']['user']['username'] = $row['username'];
					$_SESSION['mis']['user']['email'] = $row['email'];
					$_SESSION['mis']['user']['badgenr'] = $row['badge'];
					
					header('location: main.php');
				} else {
					$error['msg'] = 'LDAP Login failed!';
				}
			}
			ldap_unbind($ldapconn);
		}

	}
?>
<!DOCTYPE html>
<html class="lockscreen">
    <head>
		<META content="IE=11.0000" http-equiv="X-UA-Compatible">
        <meta charset="UTF-8">
        <title>TeleApp | Lockscreen</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="login/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="login/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="login/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    <body>
        <!-- Automatic element centering using js -->
        <div class="center" style="position: absolute; top: 316px; left: 747px;">            
            <center><img src="./login/logo.png" alt="user image"><h3> Your session has timed out.</h3></center>
			<div class="headline text-center" id="time">11:19:12 AM</div><!-- /.headline -->
            
            <!-- User name -->
            <div class="lockscreen-name"><?php echo $_GET['id']; ?></div>
            
            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
                <!-- lockscreen image -->
                <div class="lockscreen-image">
                    <img src="./login/avatar5.png" style="width: 500px; alt="user image">
                </div>
                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <form method="post" action="login.php">
				<div class="lockscreen-credentials">   
					<input type="hidden" name="username" id="username" value="<?php echo $_GET['id'];?>" >
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="password" autocomplete="off" style="padding: 8px 90px;cursor: auto; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QsPDhss3LcOZQAAAU5JREFUOMvdkzFLA0EQhd/bO7iIYmklaCUopLAQA6KNaawt9BeIgnUwLHPJRchfEBR7CyGWgiDY2SlIQBT/gDaCoGDudiy8SLwkBiwz1c7y+GZ25i0wnFEqlSZFZKGdi8iiiOR7aU32QkR2c7ncPcljAARAkgckb8IwrGf1fg/oJ8lRAHkR2VDVmOQ8AKjqY1bMHgCGYXhFchnAg6omJGcBXEZRtNoXYK2dMsaMt1qtD9/3p40x5yS9tHICYF1Vn0mOxXH8Uq/Xb389wff9PQDbQRB0t/QNOiPZ1h4B2MoO0fxnYz8dOOcOVbWhqq8kJzzPa3RAXZIkawCenHMjJN/+GiIqlcoFgKKq3pEMAMwAuCa5VK1W3SAfbAIopum+cy5KzwXn3M5AI6XVYlVt1mq1U8/zTlS1CeC9j2+6o1wuz1lrVzpWXLDWTg3pz/0CQnd2Jos49xUAAAAASUVORK5CYII=); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
                        <div class="input-group-btn">
                            <button class="btn btn-flat"><i class="fa fa-arrow-right text-muted"></i></button>
                        </div>
                    </div>
                </div><!-- /.lockscreen credentials -->
				</form>
            </div><!-- /.lockscreen-item -->

            <div class="lockscreen-link">
                <a href="index.php">Or sign in as a different user</a>
            </div>            
        </div><!-- /.center -->

        <!-- jQuery 2.0.2 -->
        <script src="login/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="login/bootstrap.min.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                startTime();
                $(".center").center();
                $(window).resize(function() {
                    $(".center").center();
                });
            });

            /*  */
            function startTime()
            {
                var today = new Date();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();

                // add a zero in front of numbers<10
                m = checkTime(m);
                s = checkTime(s);

                //Check for PM and AM
                var day_or_night = (h > 11) ? "PM" : "AM";

                //Convert to 12 hours system
                if (h > 12)
                    h -= 12;

                //Add time to the headline and update every 500 milliseconds
                $('#time').html(h + ":" + m + ":" + s + " " + day_or_night);
                setTimeout(function() {
                    startTime()
                }, 500);
            }

            function checkTime(i)
            {
                if (i < 10)
                {
                    i = "0" + i;
                }
                return i;
            }

            /* CENTER ELEMENTS IN THE SCREEN */
            jQuery.fn.center = function() {
                this.css("position", "absolute");
                this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                        $(window).scrollTop()) - 30 + "px");
                this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                        $(window).scrollLeft()) + "px");
                return this;
            }
        </script>
    
</body></html>
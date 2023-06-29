<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
<!--    <link rel="icon" href="../../../../favicon.ico">-->

    <title>IPL</title>

    <!-- Bootstrap core CSS -->
<!--    <link href="../../../../dist/css/bootstrap.min.css" rel="stylesheet">-->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous" >-->
    <link rel="stylesheet" href="<?php echo SITE_CSS_URL; ?>bootstrap.min.css" crossorigin="anonymous" >
    <script src="<?php echo ASSET_URL; ?>_vendor/jquery/dist/jquery.min.js"></script>
    <!-- Custom styles for this template -->

      <!--    <link href="signin.css" rel="stylesheet">-->
<style>
    html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: -webkit-box;
  display: flex;
  -ms-flex-align: center;
  -ms-flex-pack: center;
  -webkit-box-align: center;
  align-items: center;
  -webkit-box-pack: center;
  justify-content: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
#m-notification {
    border-radius: 0;
    line-height: 3;
    position: fixed;
    right: 0px;
    top: 3px;
    min-width: 35%;
    display: none;
}
</style>
  </head>

  <body class="text-center">
      <form class="form-signin" action="<?php echo SITE_URL; ?>login/index" method="post">
      <!--<img class="mb-4" src="<?php //echo SITE_IMG_URL; ?>logo.png" alt="" width="128" height="128">-->
      <h1 class="h3 mb-3 font-weight-normal">IPL-2022</h1>
      <input type="text" id="txt_username" name="txt_username" class="form-control" placeholder="Email address" autofocus value="<?php echo (get_cookie("email") == "") ? "@iplface.in" : get_cookie("email"); ?>">
      <input type="password" name="txt_password" id="txt_password" class="form-control" placeholder="Password" value="<?php echo get_cookie("pass"); ?>" >
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; <?php echo date("Y"); ?> (mAYUR)</p>
<div class="text-muted">v 1.0.2</div>
    </form>
	 <div id="form_error" style="display:none" >
      <?php
	 echo  validation_errors();
	 if($login_error != "")
		 echo $login_error;
	 $flash = $this->session->flashdata('login_error');
	 if($flash != "")
	 echo "<p>". $flash . "</p>";
      ?></div>
	 <div id="m-notification" class="alert alert-danger alert-dismissable col-12 col-lg-3">
            <button aria-hidden="true" class="close" type="button">×</button>
            <span id="m-notification-text">Default Text.</span>
        </div>
  </body>

<script>
	function showMotification(type, msg, time)
	{
		//set default parameter for time...
		time = typeof time !== 'undefined' ? time : 5000;
		//show notification...
		$("#m-notification").slideDown();
		//scroll to notification...
		$('html,body').animate({scrollTop: $("body").offset().top}, 'slow');
		//remove all existing classes and set new type...
		$("#m-notification").removeClass();
		$("#m-notification").addClass("alert alert-dismissable col-12 col-lg-3 alert-" + type);
		//set message...
		$("#m-notification-text").html(msg);
		//hide after "time" interval...
		setTimeout(function() {
		 $("#m-notification").hide("blind");
		}, 7000);
	}
		$(function() {
			$("#form_error p").each(function(){
				showMotification("danger", $(this).html());
				return false;
			});
		});

	  </script>
</html>

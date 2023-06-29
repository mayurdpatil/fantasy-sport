<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Leaderboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="<?php echo SITE_CSS_URL; ?>bootstrap.css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_CSS_URL; ?>leaderboard.css">
<style>
	.dash_icon
	{
	    max-width: 100%;
	}
	.strong{font-weight: bold;}
	.strips{padding: 5px;border: 5px solid gray;margin-top: 10px;}
	.txt_center{text-align: center;}
	.submit_btn{width: 100%;background: #1e3344;border: none; margin-top: 10px;border-radius: 0px;}
	.backbtn{width: 50px;float: left;background: white; cursor: pointer;}
	.logoutbtn{width: 50px;float: right;background: white; cursor: pointer;}
	</style>
  </head>
  <body>

<hr>
<?php
	date_default_timezone_set('Asia/Kolkata');
?>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-12 col-lg-6 col-md-6 offset-md-3">
            <div class="main-box clearfix">
                <div class="main-box-body clearfix" style="border-radius:0px;">
                    <div class="">
                        <table class="table user-list">
                            <tr style="background: #1e3344;color: white;text-align: center;">
                                <td colspan="4">
					<h3>
						<img class="backbtn" src="<?php echo SITE_IMG_URL; ?>back.png?id=1" onclick="window.location='<?php echo SITE_URL; ?>home/play'">
						MATCH &mdash; <?php echo $matchId;?>
						<img class="logoutbtn" src="<?php echo SITE_IMG_URL; ?>logout.png" onclick="window.location='<?php echo SITE_URL; ?>home/logout'">
					</h3>
				</td>
                            </tr>
			</table>
			<div class="row" style="padding-top:15px;	">
				<div class="col-lg-12">
					<div class="btn-group btn-group-toggle col-md-12" data-toggle="buttons" >
					    <label class="btn btn-primary col-md-6" style="min-height: 150px;display: flex;align-items: center;justify-content: center;"  >
						   <img class="dash_icon" src="<?php echo SITE_IMG_URL; ?>logo/<?php echo $matches[0]['t1_logo']; ?>" alt="<?php echo $matches[0]['t1_name']; ?>" title="<?php echo $matches[0]['t1_name']; ?>" >
					    </label>
					    <label class="btn btn-primary col-md-6" style="min-height: 150px;display: flex;align-items: center;justify-content: center;">
						   <img class="dash_icon" src="<?php echo SITE_IMG_URL; ?>logo/<?php echo $matches[0]['t2_logo']; ?>" alt="<?php echo $matches[0]['t2_name']; ?>" title="<?php echo $matches[0]['t2_name']; ?>" >
					    </label>
					</div>
				  </div>
			  </div>
				    <table class="col-12 col-md-12 col-lg-12">
				<?php
				$i = 1;
				foreach($users as $user)
				{ ?>
					<tr class="<?php echo ($user['usr_id'] == $this->session->userdata("ipl_usr_id")) ? "table-success" : ""; ?>" style="height:60px; text-align: center; <?php echo ($user['tm_logo'] == NULL) ? "background: #E67E22; color: #FFFFFF" : "" ; ?>">
					    <td ><?php echo $i++; ?></td>
					    <td>
						   <?php echo $user['usr_fname'] . " " . $user['usr_lname']; ?> (<?php echo $user['usr_rating']; ?>)
					    </td>
					    <td>
						   <?php
						   if($user['tm_logo'] != NULL) { ?>
							<img src="<?php echo SITE_IMG_URL; ?>logo/<?php echo $user['tm_logo']; ?>" alt="" width="50px">
						   <?php } else echo "&mdash;"; ?>
					    </td>
					    <td>
						   <?php //echo $user['usr_rating']; ?>
					    </td>
					</tr>
				<?php
				} ?>
			</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <script src="<?php echo ASSET_URL; ?>_vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo ASSET_URL; ?>_vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
	 function logout()
	{
		if(confirm("Are you sure you want to logout ?"))
		{
			window.location='<?php echo SITE_URL; ?>home/logout';
		}
	}
</script>
  </body>
</html>

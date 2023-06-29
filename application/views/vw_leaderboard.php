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
	.logoutbtn{width: 50px;float: right;background: white; cursor: pointer;}
    </style>
  </head>
  <body>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-12 col-lg-6 col-md-6 offset-md-3">
            <div class="main-box clearfix">
                <div class="main-box-body clearfix" style="border-radius:0px;">
                    <div class="table-responsive">
                        <table class="table user-list">
                            <tr style="background: #1e3344;color: white;text-align: center;">
                                <td colspan="4"><h3>LEADERBOARD<img class="logoutbtn" src="<?php echo SITE_IMG_URL; ?>logout.png" onclick="logout();"></h3></td>
                            </tr>
                            <tbody>
				<?php
				$i = 1;
				foreach($users as $user)
				{ ?>
					<tr class="<?php echo ($user['usr_id'] == $this->session->userdata("ipl_usr_id")) ? "table-success" : ""; ?>">
					    <td><?php echo $i++; ?></td>
					    <td>
						   <img src="<?php echo SITE_IMG_URL . strtolower($user['usr_gender']); ?>.png" alt="">
					    </td>
					    <td>
						   <?php echo $user['usr_fname'] . " " . $user['usr_lname']; ?>
					    </td>
					    <td>
						   <?php echo $user['usr_rating']; ?>
					    </td>
					</tr>
				<?php
				} ?>
                               <tr style="background: #1e3344;color: white;text-align: center;">
                                   <td colspan="4" style="padding:4px;">
                                       <a href="<?php echo SITE_URL; ?>home/play" class="btn btn-primary" style="width: 100%;background: #1e3344;border: none;">PLAY</a>
                                   </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

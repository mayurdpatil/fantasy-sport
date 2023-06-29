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
		
		function mDatediff($endTime, $nowTime)
		{
			$delta_T = ($endTime - $nowTime);
			$hours = round((($delta_T % 604800) % 86400) / 3600); 
			$minutes = round(((($delta_T % 604800) % 86400) % 3600) / 60); 
			$sec = round((((($delta_T % 604800) % 86400) % 3600) % 60));

			return array("h" => $hours, "m" => $minutes, "s" => $sec);	
		}
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
						<img class="backbtn" src="<?php echo SITE_IMG_URL; ?>back.png?id=1" onclick="window.location='<?php echo SITE_URL; ?>home'">
						Matches
						<img class="logoutbtn" src="<?php echo SITE_IMG_URL; ?>logout.png" onclick="window.location='<?php echo SITE_URL; ?>home/logout'">
					</h3>
				</td>
                            </tr>
			</table>
			<?php
//trace($matches);
			foreach($matches as $match)
			{ ?>
				 <div class="row">
				  <div class="col-lg-12">
					 <h3 class="txt_center col-md-12">MATCH <?php echo $match['mat_id']; ?></h3>
						<div class="btn-group btn-group-toggle col-md-12" data-toggle="buttons" >
						    <label id="lbl_local_<?php echo $match['mat_id']; ?>" class="btn btn-primary col-md-6 <?php echo ($match['sc_team'] == $match['t1_id']) ? "active" : ""; ?>" style="min-height: 150px;display: flex;align-items: center;justify-content: center;" >
							   <img class="dash_icon" src="<?php echo SITE_IMG_URL; ?>logo/<?php echo $match['t1_logo']; ?>" alt="<?php echo $match['t1_name']; ?>" title="<?php echo $match['t1_name']; ?>" >
							   <input  type="radio" name="options" id="option1"  > 
							   <input type="hidden" name="team[]" id="team_<?php echo $match['mat_id']; ?>_L" value="<?php echo $match['t1_id']; ?>" >
						    </label>
						    <label id="lbl_visitor_<?php echo $match['mat_id']; ?>"  class="btn btn-primary col-md-6 <?php echo ($match['sc_team'] == $match['t2_id']) ? "active" : ""; ?>" style="min-height: 150px;display: flex;align-items: center;justify-content: center;">
							   <img class="dash_icon" src="<?php echo SITE_IMG_URL; ?>logo/<?php echo $match['t2_logo']; ?>" alt="<?php echo $match['t2_name']; ?>" title="<?php echo $match['t2_name']; ?>" >
							  <input type="radio" name="options" id="option3"  > 
							  <input type="hidden" name="team[]" id="team_<?php echo $match['mat_id']; ?>_V" value="<?php echo $match['t2_id']; ?>" >
						    </label>
						</div>
					 <div class="txt_center strong strips col-md-12">
						Venue: <?php echo $match['mat_city'];
							$diffTime = mDatediff(strtotime($match['time']), strtotime(date('H:i:s')));
						?><br>
						Closing Time: <?php echo date("g:i A", strtotime($match['time']));?> [<?php echo (strtotime(date('H:i:s')) < strtotime(date($match['time']))) ? ($diffTime['h']." : ". $diffTime['m'] . " : ". $diffTime['s']) : "Expired"; ?>]
					 </div>
					 <?php
					 //if((strtotime(date('H:i:s')) < strtotime(date('13:00:00'))))
					if((strtotime(date('H:i:s')) < strtotime(date($match['time']))))
					 {
						if($match['sc_attempt'] == NULL || $match['sc_attempt'] < 3)
						{ ?>
						    <a href="<?php echo SITE_URL; ?>home/submit" class="btn btn-primary submit_btn" onclick="return submitScore('<?php echo $match['mat_id']; ?>','<?php echo $this->session->userdata('ipl_usr_id'); ?>');" >Submit [Attempt: <?php echo ($match['sc_attempt'] == NULL) ? "3" : ( 3 - $match['sc_attempt']); ?>]</a>
						<?php }else{ ?>
						    <a href="javascript:void(0);" class="btn btn-warning muted submit_btn" disabled  onclick="alert('Attempt limit exceeded.')">Submit [Attempt: 0]</a>
						<?php }
					 }
					 else {?> 
						    <a href="<?php echo SITE_URL; ?>match/get_selection/<?php echo $match['mat_id']; ?>" class="btn btn-warning submit_btn" >View Selection</a>
					<?php }
					if($this->session->userdata("ipl_usr_id") ==1)
					{?>
					    <a href="<?php echo SITE_URL; ?>match/get_selection/<?php echo $match['mat_id']; ?>" class="btn btn-warning submit_btn" >View Selection</a>
					    <a href="<?php echo SITE_URL; ?>home/result_admin" class="btn btn-warning submit_btn" >Result</a>
					<?php }
					?>
				  </div>
			  </div>
			<?php
			} 
			if(count($matches) == 0)
			{?>
				<div class="txt_center strong strips col-md-12">
				    Relax!, No Match Today.
				</div>
			<?php
			}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <script src="<?php echo ASSET_URL; ?>_vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo ASSET_URL; ?>_vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
	    function submitScore(mat_id, usr_id)
	    {
		var local = $("#lbl_local_" + mat_id).hasClass("active");
		var visitor = $("#lbl_visitor_" + mat_id).hasClass("active");

		if(local == false && visitor == false)
		{
			alert("Team selection required.");
			return false;
		}
		else
		{
			if(confirm("Are you sure you want to submit your Team?"))
			{
				var team = (local == true) ? "L" : "V";

				$.post("<?php echo SITE_URL; ?>home/submit",
				{mat_id:mat_id, usr_id:usr_id,team:$("#team_" + mat_id + "_" + team).val()},
				function(return_data){

					if(return_data == 1)
					{
						alert("Match selection submitted successfully.");
						window.location ="<?php echo SITE_URL; ?>home/play";
					}
					else if(return_data == 2)
					{
						alert("Match selection updated successfully.");
						window.location ="<?php echo SITE_URL; ?>home/play";
					}
					else if(return_data = "Expired")
					{
						alert("Match submission line closed for today.");
					}
					else
					{
						alert("Something went wrong.");
					}
				});
			}
		}
		return false;
	    }
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

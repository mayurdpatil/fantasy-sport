<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Leaderboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="<?php echo SITE_CSS_URL; ?>bootstrap.css" media="screen">
    <link rel="stylesheet" href="<?php echo SITE_CSS_URL; ?>leaderboard.css">

  </head>
  <body>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-12 col-lg-12 col-md-12">
            <div class="main-box clearfix">
                <div class="main-box-body clearfix" style="border-radius:0px;">
                    <div class="table-responsive">
                        <button type="button" class="btn btn-success" onclick="set_match();">SET MATCH</button>
                        <table class="table table-hover">
			<thead>
			  <tr>
			    <th scope="col">#</th>
			    <th scope="col">Match</th>
			    <th scope="col">Result</th>
			    <th scope="col">Action</th>
			  </tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach($results as $res) 
				{ ?>
					<tr class="table-<?php echo ($res['mat_result'] == "P") ? "active" : "success"; ?>">
						<th scope="row"><?php echo $i++; ?></th>
						<td>
							<?php echo $res['t1_name']; ?> VS <?php echo $res['t2_name']; ?>
							<input type="hidden" name="local_<?php echo $res['mat_id']; ?>" id="team_<?php echo $res['mat_id']; ?>_<?php echo $res['t1_id']; ?>" value="<?php echo $res['t1_name']; ?>">
							<input type="hidden" name="local_<?php echo $res['mat_id']; ?>" id="team_<?php echo $res['mat_id']; ?>_<?php echo $res['t2_id']; ?>" value="<?php echo $res['t2_name']; ?>">
						</td>
						<td>
						    <select name="mat_result[]" id="sel_result_<?php echo $res['mat_id']; ?>" style="width:220px;">
							   <option value="">TBD</option>
							   <option value="<?php echo $res['t1_id']; ?>" <?php echo ($res['mat_wining_tm_id'] == $res['t1_id']) ? "selected" : ""; ?>><?php echo $res['t1_name']; ?></option>
							   <option value="<?php echo $res['t2_id']; ?>" <?php echo ($res['mat_wining_tm_id'] == $res['t2_id']) ? "selected" : ""; ?>><?php echo $res['t2_name']; ?></option>
							   <option value="D" <?php echo ($res['mat_result'] == "D") ? "selected" : ""; ?>>Draw</option>
						    </select>
						</td>
						<td>
						    <?php 
						    if($res['mat_result'] == "P") { ?>
							<button type="button" class="btn btn-success" onclick="set_result('<?php echo $res['mat_id']; ?>', '<?php echo $res['mat_score']; ?>');">SET RESULT</button>
						    <?php }else{ ?>
							<button type="button" class="btn btn-active muted" style="cursor: no-drop;" >SET RESULT</button>
						    <?php } ?>
						</td>
					</tr>
				<?php } ?>			  
			</tbody>
		   </table> 
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
        <script src="<?php echo ASSET_URL; ?>_vendor/jquery/dist/jquery.min.js"></script>

<script>
	function set_result(mat_id, mat_score)
	{
		if($("#sel_result_" + mat_id).val() == "")
		{
			alert("please select Result");
		}
		else
		{
			if($("#sel_result_" + mat_id).val() == "D")
			{
				if(confirm("Are you sure you want to draw this match?"))
					return false;
			}
			else if(confirm("Are you sure you want to submit result as " + $("#team_" + mat_id + "_" + $("#sel_result_" + mat_id).val()).val() + " is Winning Team ?"))
			{
				$.post("<?php echo SITE_URL; ?>home/submit_result",
				{mat_id:mat_id, win_team:$("#sel_result_" + mat_id).val(), mat_score:mat_score},
				function(return_data){
					alert("result updated successfully");
					window.location ="<?php echo SITE_URL; ?>home/result_admin";
				});
			}
		}
	}

	function set_match()
	{
	    window.location ="<?php echo SITE_URL; ?>match/schedule";
	}
	</script>
  </body>
</html>

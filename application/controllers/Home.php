<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
         parent::__construct();
    }
    
    public function index()
    {
        try
        {
		$arr['users'] = $this->mdgeneraldml->get_leaderboard("SELECT * FROM `tbl_users` WHERE usr_status = 'A' ORDER BY `tbl_users`.`usr_rating`  DESC");
		$this->load->view('vw_leaderboard', $arr);

        } catch (Exception $e) {
            log_message('error', 'Error in : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            return FALSE;
        }
    }
    public function play()
    {
        try
        {
            
		date_default_timezone_set('Asia/Kolkata');
		if($this->session->userdata("ipl_usr_id") == "")
		{
			$this->session->set_flashdata('login_error', 'Your session has been expired.');
			redirect("login");
		}

/*SELECT m.mat_id, m.mat_city, TIME(m.mat_start_time) as time, DATE(m.mat_start_time) as date, mat_score, t1.tm_name as t2_logo, t2.tm_name as t2_name, t1.tm_logo as t1_logo, t2.tm_logo as t2_logo ,s.sc_score
FROM tbl_matches as m 
INNER join tbl_teams as t1 on m.mat_local_tm_id = t1.tm_id 
INNER join tbl_teams as t2 on m.mat_visitor_tm_id = t2.tm_id 
left join tbl_score as s on s.sc_match_id = m.mat_id and s.sc_player_id = 1
where (1=1 AND (DATE(mat_start_time) = '2018-04-04') AND 1=1)
*/

		   $join[1] = array("tableName" => "tbl_teams as t1", "columnNames" => "m.mat_local_tm_id = t1.tm_id");
		   $join[2] = array("tableName" => "tbl_teams as t2", "columnNames" => "m.mat_visitor_tm_id = t2.tm_id");
		   $join[3] = array("tableName" => "tbl_score as s", "columnNames" => "s.sc_match_id = m.mat_id and s.sc_player_id = " . $this->session->userdata("ipl_usr_id"), "joinType" => "LEFT");
		   $where[1] = array("columnName" => "DATE(mat_start_time)", "value" => date("Y-m-d"), "islike" =>0);
		$arr['matches'] = $this->mdgeneraldml->core_select(
			   "m.mat_id, m.mat_city, TIME(m.mat_start_time) as time, DATE(m.mat_start_time) as date, mat_score, t1.tm_name as t1_name, t2.tm_name as t2_name, t1.tm_id as t1_id, t2.tm_id as t2_id, t1.tm_logo as t1_logo, t2.tm_logo as t2_logo, s.sc_score, s.sc_team, s.sc_attempt", 
			   "tbl_matches as m",
			   $where, array('colname' => "mat_id", 'type' => "ASC"), NULL, NULL, $join);

		$this->load->view('vw_team_selection', $arr);
        } catch (Exception $e) {
            log_message('error', 'Error in : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            return FALSE;
        }
    }
    
    function submit()
    {
		date_default_timezone_set('Asia/Kolkata');

	$matData = $this->mdgeneraldml->select("mat_start_time", "tbl_matches", array("mat_id" => $this->input->post("mat_id")));

	    if(strtotime(date('H:i:s')) > strtotime(date($matData[0]['mat_start_time']))){
		    echo "Expired";
		    exit;
	    }

	    $res = $this->mdgeneraldml->select("*", "tbl_score", array("sc_match_id" => $this->input->post("mat_id"), "sc_player_id" => $this->input->post("usr_id")));
	if(count($res) == 0)
	{
	    $insert = array("sc_match_id" => $this->input->post("mat_id"),
		   "sc_player_id" => $this->input->post("usr_id"), 
		   "sc_team" => $this->input->post("team"));

	    $res = $this->mdgeneraldml->insert("tbl_score", $insert);
	    echo $res['affectedRow'];
	}
	 else {
	    $res = $this->mdgeneraldml->match_update(array("sc_match_id" => $this->input->post("mat_id"), "sc_player_id" => $this->input->post("usr_id")), "tbl_score", $this->input->post("team"));
	    echo "2";
	}
    }
    
	public function result_admin()
	{
		try
		{
			$join[1] = array("tableName" => "tbl_teams as t1", "columnNames" => "m.mat_local_tm_id = t1.tm_id");
			$join[2] = array("tableName" => "tbl_teams as t2", "columnNames" => "m.mat_visitor_tm_id = t2.tm_id");
			//$join[3] = array("tableName" => "tbl_score as s", "columnNames" => "s.sc_match_id = m.mat_id ", "joinType" => "LEFT");

			$arr['results'] = $this->mdgeneraldml->core_select(
			"m.mat_id, m.mat_city, TIME(m.mat_start_time) as time, DATE(m.mat_start_time) as date, mat_score, t1.tm_name as t1_name, t2.tm_name as t2_name, t1.tm_id as t1_id, t2.tm_id as t2_id, t1.tm_logo as t1_logo, t2.tm_logo as t2_logo, mat_result, mat_score, mat_wining_tm_id", 
			"tbl_matches as m", NULL, array("colname" => "m.mat_id", "type" => "DESC"), NULL, NULL, $join);

			$this->load->view('vw_result', $arr);

		} catch (Exception $e) {
		    log_message('error', 'Error in : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
		    return FALSE;
		}
	 }
	 
	 function submit_result()
	 {
		 //update users score...
		$sql =  "update tbl_users as u join  tbl_score as s on u.usr_id = s.sc_player_id
				set usr_rating = usr_rating + " . $this->input->post("mat_score") . "
			WHERE s.sc_match_id = '" . $this->input->post("mat_id") . "' AND sc_team = '" . $this->input->post("win_team") . "'";
		$res = $this->mdgeneraldml->core_update($sql);
	
		//udpate match data...
		$updateData = array("mat_result" => 'C', "mat_wining_tm_id" => $this->input->post("win_team"));
		$res = $this->mdgeneraldml->update(array("mat_id" => $this->input->post("mat_id")), "tbl_matches", $updateData);
//		 draw is pending
//		 back button is pending
//		 navigation is pending...
	 }
	 
	 function logout()
	 {
		 $this->session->sess_destroy();
		redirect("login"); 
	 }

	function time()
	{
	

		echo date("d-m-y H:i:s");
	}
}

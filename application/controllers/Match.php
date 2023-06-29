<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Match extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
//        checkLogin($this->session->userdata('bustle_usr_id'));
        $this->module_name = "Match";
    }
    
    //Schedule Match...
    function schedule()
    {
        try {
            //load validation library...
            $this->load->library('form_validation');

            //set rules for form validation.
//            $this->form_validation->set_rules('league_id', 'Name', 'required|trim|callback_check_unique');
            $this->form_validation->set_rules('txt_local_team', 'Team 1', 'required|trim|numeric');
            $this->form_validation->set_rules('txt_visitor_team', 'Team 2', 'required|trim|numeric');
            $this->form_validation->set_rules('sel_venue', 'Venue', 'required|trim');
            $this->form_validation->set_rules('txt_match_date', 'Match Time', 'required|trim');
            $this->form_validation->set_rules('sel_score', 'Score', 'required|trim|numeric');

            if ($this->form_validation->run() == FALSE)
            {
                $arr['teams'] = $this->mdgeneraldml->select("tm_id, tm_name, tm_logo", TBL_TEAMS, array("tm_status" => "A"));
				$arr['venues'] = $this->mdgeneraldml->select("ven_name", TBL_VENUES, array("ven_status" => "A"));

                $this->load->view('vw_header');
                $this->load->view('vw_schedule_match', $arr);
                $this->load->view('vw_footer');
            }
            else
            {
                $this->mdgeneraldml->insert("tbl_matches",
                array("mat_league_id" => 1,
                            "mat_local_tm_id" => $this->input->post("txt_local_team"),
                            "mat_visitor_tm_id" => $this->input->post("txt_visitor_team"),
                            "mat_city" => $this->input->post("sel_venue"),
                            "mat_start_time" => $this->input->post("txt_match_date"),
                            "mat_bid_stop_time" => "0000-00-00 00:00:00.000000",
                            "mat_result" => "P",
                            "mat_wining_tm_id" => '',
                            "mat_score" => $this->input->post("sel_score")));
                $this->session->set_flashdata("flash_success", "Match Added successfully.");
                redirect(base_url() . "index.php/home/result_admin");
            }
        }
        catch (Exception $e) {
            log_message('error', 'Error in : ' . $this->router->fetch_class() . "->" . $this->router->fetch_method());
            return FALSE;
        }
    }    
    
	function get_selection($matchId=NULL)
	{date_default_timezone_set('Asia/Kolkata');
		$res['matchId'] = $matchId;
		//return if invalid match...
		//
		//
		//
		//validate url by being access without login...
		if($this->session->userdata("ipl_usr_id") == "")
		{
			$this->session->set_flashdata('login_error', 'Your session has been expired.');
			redirect("login");
		}
		//get match details...
			$join[1] = array("tableName" => "tbl_teams as t1", "columnNames" => "m.mat_local_tm_id = t1.tm_id");
			$join[2] = array("tableName" => "tbl_teams as t2", "columnNames" => "m.mat_visitor_tm_id = t2.tm_id");
			$join[3] = array("tableName" => "tbl_score as s", "columnNames" => "s.sc_match_id = m.mat_id and s.sc_player_id = " . $this->session->userdata("ipl_usr_id"), "joinType" => "LEFT");
			$where[1] = array("columnName" => "m.mat_id", "value" => $matchId, "islike" =>0);
//			$where[1] = array("columnName" => "m.usr_status", "value" => 'A', "islike" =>0);

			$res['matches'] = $this->mdgeneraldml->core_select(
				   "m.mat_id, m.mat_city, TIME(m.mat_start_time) as time, DATE(m.mat_start_time) as date, mat_score, t1.tm_name as t1_name, t2.tm_name as t2_name, t1.tm_id as t1_id, t2.tm_id as t2_id, t1.tm_logo as t1_logo, t2.tm_logo as t2_logo, s.sc_score, s.sc_team, s.sc_attempt", 
				   "tbl_matches as m", $where, array('colname' => "mat_id", 'type' => "ASC"), NULL, NULL, $join);


		if(count($res['matches']) == 0)
		{
			$this->session->set_flashdata('login_error', 'Invalid URL.');
			redirect("login");
		}	
		//Fetch result for match...
		$res['users'] = $this->mdgeneraldml->getMatchSelection($matchId);

			if((strtotime(date('H:i:s')) < strtotime(date($res['matches'][0]['time']))))
			{
				if($this->session->userdata("ipl_usr_id") != 1)
					redirect("home");
			}

		//draw view...
		$this->load->view("vw_match_selection", $res);
	}
}

/* End of file manage_trivias.php */
/* Location: ./application/controllers/manage_trivias.php */
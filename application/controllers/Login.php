<?php

/*

 * Login Controller
 * 
 * Author: mAYUR
 *  */
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$arr['error'] = "";
		$arr["login_error"] = "";
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->form_validation->set_rules("txt_username", "Username", "required|trim|valid_email");
		$this->form_validation->set_rules("txt_password", "Password", "required|trim");

		if ($this->form_validation->run() == FALSE)
			$this->load->view('vw_login', $arr);
		else
		{
			$arr = $this->mdgeneraldml->select("*", "tbl_users",
				   array("usr_email" => $this->input->post("txt_username"), "usr_password" => md5($this->input->post("txt_password")) ));

			if(count($arr) == 0)
			{
			    $arr["login_error"] = "<p>Invalid Credentials.</p>";
			    $this->load->view('vw_login', $arr);
			}
			else
			{

			    if($arr[0]['usr_status'] == "I")
			    {
			        $arr["login_error"] = "<p>Inactive Player.</p>";
                    $this->load->view('vw_login', $arr);
			    }
			    else
			    {
                    //set session...
                    $this->session->set_userdata(array('ipl_usr_id' => $arr[0]['usr_id'],
                        'is_admin' => $arr[0]['usr_type'],
                        'ipl_user_name' => $arr[0]['usr_fname'],
                        'ipl_email' => $arr[0]['usr_email'],
                        'bustle_last_login' => $arr[0]['usr_last_login']));

                    //set cookies...
                    $cookie = array('name'   => 'email',
                            'value'  => $arr[0]['usr_email'],
                            'expire' => '8650000');
                    set_cookie($cookie);
                    $cookie = array('name'   => 'pass',
                            'value'  => $this->input->post("txt_password"),
                            'expire' => '8650000');
                    set_cookie($cookie);

                    $this->mdgeneraldml->update(array("usr_id" => $arr[0]['usr_id']),
                           "tbl_users", array("usr_last_login" => date("Y-m-d H:i:s")));
                    $this->session->set_flashdata("flash_success", "Welcome, <b>" . $arr[0]['usr_fname'] . "</b> You are logged-in successfully.");
                    redirect(SITE_URL . "login/login_success");
                }
			}
		}
	}
	function login_success()
	{
		redirect(SITE_URL . "home");
	}
}

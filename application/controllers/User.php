<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends User_Controller
{
	public function index()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
		} else {
			redirect('userlogin');
		}
	}

	//user-login 
	public function login()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('/');
		}

		$this->setTabUrl($mod = 'login');

		$data['title'] = "login";

		$this->form_validation->set_rules('userEmail', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('userPwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('user/login');
			$this->load->view('templates/footer');
		} else {
			$validate = $this->Usermodel->login();

			if ($validate == FALSE) {
				$log = "Failed Login Attempt - Wrong Credentials [ Email: " . htmlentities($this->input->post('userEmail')) . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('wrong_pwd_uname'));
				redirect('user');
			}
			if ($validate == "not_active") {
				$log = "Failed Login Attempt - Account deactivated [ Email: " . htmlentities($this->input->post('userEmail')) . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('acct_deact'));
				redirect('user');
			}
			if ($validate == "not_verified") {
				$log = "Failed Login Attempt - Account unverified [ Email: " . htmlentities($this->input->post('userEmail')) . " ]";
				$this->log_act($log);

				$fk = $this->Usermodel->login_get_key();
				if ($fk) {
					$this->setFlashMsg('error', 'Your account is not verified');
					redirect('emailverify/' . $fk);
				}
			}
			//if valid, create sessions via user details
			if ($validate) {
				$id = $validate->id;
				$uname = $validate->username;

				//sessionData
				$user_sess = array(
					'id' => $id,
					'uname' => $uname,
					'role' => 'User',
					'logged_in' => TRUE,
				);
				$this->session->set_userdata($user_sess);

				$log = "Logged In [ Username: " . $this->session->userdata('uname') . " ]";
				$this->log_act($log);

				redirect('dashboard');
			}
		}
	}


	
}

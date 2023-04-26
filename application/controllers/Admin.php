<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . "libraries/razorpay/Razorpay.php");

use Razorpay\Api\Api;

class Admin extends Admin_Controller
{
	public function index()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
		} else {
			redirect('adminlogin');
		}
	}

	//admin-login 
	public function login()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('/');
		}

		$this->setTabUrl($mod = 'login');

		$data['title'] = "login";

		$this->form_validation->set_rules('adminEmail', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('adminPwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('admin/login');
			$this->load->view('templates/footer');
		} else {
			$validate = $this->Adminmodel->login();

			if ($validate == FALSE) {
				$log = "Failed Login Attempt - Wrong Credentials [ Email: " . htmlentities($this->input->post('userEmail')) . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('wrong_pwd_uname'));
				redirect('admin');
			}
			if ($validate == "not_active") {
				$log = "Failed Login Attempt - Account deactivated [ Email: " . htmlentities($this->input->post('userEmail')) . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('acct_deact'));
				redirect('admin');
			}
			if ($validate == "not_verified") {
				$log = "Failed Login Attempt - Account unverified [ Email: " . htmlentities($this->input->post('userEmail')) . " ]";
				$this->log_act($log);

				$fk = $this->Adminmodel->login_get_key();
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
					'role' => 'Admin',
					'logged_in' => TRUE,
				);
				$this->session->set_userdata($user_sess);

				$log = "Logged In [ Username: " . $this->session->userdata('uname') . " ]";
				$this->log_act($log);

				redirect('dashboard');
			}
		}
	}


	//activity logs
	public function logs()
	{
		$this->is_admin();

		$this->setTabUrl($mod = 'logs');

		$data['title'] = "logs";

		$data['activityLogs'] = $this->Adminmodel->get_activityLogs();
		$data['feedbackLogs'] = $this->Adminmodel->get_feedbacks();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/logs');
		$this->load->view('templates/footer');
	}

	public function clear_activityLogs()
	{
		if ($this->ajax_is_admin() === true) {

			$res = $this->Adminmodel->clear_activityLogs();

			if ($res !== true) {
				$this->setFlashMsg('error', 'Error clearing data');

				$log = "Error clearing data - Activity Logs [ Username: " . $this->session->userdata('uname') .  " ]";
				$this->log_act($log);
			} else {
				$this->setFlashMsg('success', 'Data cleared ');

				$log = "Data cleared - Activity Logs [ Username: " . $this->session->userdata('uname') .  " ]";
				$this->log_act($log);
			}
		}

		redirect('logs');
	}


	public function clear_feedbackLogs()
	{
		if ($this->ajax_is_admin() === true) {

			$res = $this->Adminmodel->clear_feedbackLogs();

			if ($res !== true) {
				$log = "Error clearing data - Contact us LogsContact us Logs [ Username: " . $this->session->userdata('uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Error clearing data');
			} else {
				$log = "Data cleared - Contact us Logs [ Username: " . $this->session->userdata('uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('success', 'Data cleared!');
			}
		}

		redirect('logs');
	}

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . "libraries/razorpay/Razorpay.php");

use Razorpay\Api\Api;

class Admin extends Admin_Controller
{
	public function index()
	{
		$this->is_admin();

		$this->setTabUrl('url', 'home');
        $this->setTabUrl('suburl', '');

		redirect('');
	}

	//admin-login 
	public function login()
	{
		if ($this->session->userdata('logged_in')) {
			redirect('/');
		}

		$this->setTabUrl('url', 'login');
		$this->setTabUrl('suburl', '');

		$data['title'] = "login";

		$this->form_validation->set_rules('adminEmail', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('adminPwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
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
}

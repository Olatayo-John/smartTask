<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends Admin_Controller
{
	public function index()
	{
		$this->is_admin();

		$this->setTabUrl($mod = 'settings');

		$data['title'] = "settings";

		$data['settings'] = $this->Settingsmodel->get_settings();

		$this->load->view('templates/header', $data);
		$this->load->view('settings/index');
		$this->load->view('templates/footer');
	}

	public function save()
	{
		$this->is_admin();

		$this->setTabUrl($mod = 'settings');

		$data['title'] = "settings";

		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|html_escape');
		$this->form_validation->set_rules('site_title', 'Site Title', 'trim|html_escape');
		$this->form_validation->set_rules('site_desc', 'Site Description', 'trim|html_escape');
		$this->form_validation->set_rules('site_keywords', 'Site Keywords', 'trim|html_escape');
		$this->form_validation->set_rules('site_logo', 'Site Logo', 'trim|html_escape');
		$this->form_validation->set_rules('site_fav_icon', 'Site Fav Icon', 'trim|html_escape');
		// $this->form_validation->set_rules('new_user_reg', 'Registration Type', 'trim|html_escape|required');
		// $this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|html_escape|required');
		// $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'trim|html_escape|required');
		// $this->form_validation->set_rules('rz_key_id', 'Razorpay Key', 'trim|html_escape');
		// $this->form_validation->set_rules('rz_key_secret', 'Razorpay Secret Key', 'trim|html_escape');
		// $this->form_validation->set_rules('payu_key', 'PayU Key', 'trim|html_escape');
		// $this->form_validation->set_rules('payu_salt', 'PayU Salt', 'trim|html_escape');
		$this->form_validation->set_rules('captcha_site_key', 'reCAPTCHA Site Key', 'trim|required|html_escape');
		$this->form_validation->set_rules('captcha_secret_key', 'reCAPTCHA Secret Key', 'trim|required|html_escape');
		$this->form_validation->set_rules('protocol', 'Protocol', 'trim|html_escape');
		$this->form_validation->set_rules('smtp_user', 'SMTP User', 'trim|html_escape');
		$this->form_validation->set_rules('smtp_pwd', 'SMTP Password', 'trim|html_escape');
		$this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|html_escape');
		$this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->setFlashMsg('error', validation_errors());
			redirect('settings');
		} else {

			//site-logo
			if ($_FILES['site_logo']['name']) {

				$file_name = 'logo';

				$config['upload_path'] = './assets/images';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = '2048';
				$config['max_height'] = '3000';
				$config['max_width'] = '3000';
				$config['file_name'] = $file_name;
				$config['overwrite'] = true;
				$config['remove_spaces'] = false;

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('site_logo')) {
					$upload_error = array('error' => $this->upload->display_errors());
					$this->setFlashMsg('error', $this->upload->display_errors());
					redirect('settings');
				} else {
					$logo_uploaded = $_FILES['site_logo']['name'];
					$logo_ext = htmlentities(strtolower(pathinfo($logo_uploaded, PATHINFO_EXTENSION)));
					$upload_data = array('upload_data' => $this->upload->data());
					$site_logo = $file_name . "." . $logo_ext;
				}
			} else {
				$site_logo = $this->input->post('current_site_logo');
			}

			//site-icon
			if ($_FILES['site_fav_icon']['name']) {

				$file_name = 'fav_icon';

				$config['upload_path'] = './assets/images';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = '2048';
				$config['max_height'] = '3000';
				$config['max_width'] = '3000';
				$config['file_name'] = $file_name;
				$config['overwrite'] = true;
				$config['remove_spaces'] = false;

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('site_fav_icon')) {
					$upload_error = array('error' => $this->upload->display_errors());
					$this->setFlashMsg('error', $this->upload->display_errors());
					redirect('settings');
				} else {
					$logo_uploaded = $_FILES['site_fav_icon']['name'];
					$logo_ext = htmlentities(strtolower(pathinfo($logo_uploaded, PATHINFO_EXTENSION)));
					$upload_data = array('upload_data' => $this->upload->data());
					$site_fav_icon = $file_name . "." . $logo_ext;
				}
			} else {
				$site_fav_icon = $this->input->post('current_site_fav_icon');
			}

			//all validation done and checked
			$sData = array(
				'site_name' => ($this->input->post('site_name')),
				'site_title' => ($this->input->post('site_title')),
				'site_desc' => ($this->input->post('site_desc')),
				'site_keywords' => ($this->input->post('site_keywords')),
				'site_logo' => $site_logo,
				'site_fav_icon' => $site_fav_icon,
				// 'new_user_reg' => ($this->input->post('new_user_reg')),
				// 'payment_type' => ($this->input->post('payment_type')),
				// 'payment_mode' => ($this->input->post('payment_mode')),
				// 'rz_key_id' => ($this->input->post('rz_key_id')),
				// 'rz_key_secret' => ($this->input->post('rz_key_secret')),
				// 'payu_key' => ($this->input->post('payu_key')),
				// 'payu_salt' => ($this->input->post('payu_salt')),
				'captcha_site_key' => ($this->input->post('captcha_site_key')),
				'captcha_secret_key' => ($this->input->post('captcha_secret_key')),
				'protocol' => ($this->input->post('protocol')),
				'smtp_user' => ($this->input->post('smtp_user')),
				'smtp_pwd' => ($this->input->post('smtp_pwd')),
				'smtp_host' => ($this->input->post('smtp_host')),
				'smtp_port' => ($this->input->post('smtp_port')),
			);
			// print_r($sData);die;
			$res = $this->Settingsmodel->update_settings($sData);

			if ($res !== TRUE) {
				$log = "Error upating settings [ Username: " . $this->session->userdata('uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Error updating settings');
			} else {
				$log = "Updated settings [ Username: " . $this->session->userdata('uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('success', 'Settings updated');
			}
		}

		redirect('settings');
	}

	public function reset()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			//reset values
			$rData = array(
				'site_name' => 'Site Name',
				'site_title' => '',
				'site_desc' => '',
				'site_keywords' => '',
				'site_logo' => '',
				'site_fav_icon' => '',
				// 'new_user_reg' => '1',
				// 'payment_type' => 'razorpay',
				// 'payment_mode' => 'test',
				// 'rz_key_id' => 'rzp_test_uP60TO9iD0CFDe',
				// 'rz_key_secret' => '8H2wF3AZSmbw2yCxCgdTBXXQ',
				// 'payu_key' => 'gMBh5o',
				// 'payu_salt' => 'dBUXALRJ0BEhgQM1xIYEwcqVzgrwBbnv',
				'captcha_site_key' => '6Lec4E4aAAAAAJT5safjmk0rJsc27feWrQgFwq50',
				'captcha_secret_key' => '6Lec4E4aAAAAAE572v5dAT3Qwn9B-IreUdtlHgHi',
				'protocol' => '',
				'smtp_user' => '',
				'smtp_pwd' => '',
				'smtp_host' => '',
				'smtp_port' => '',
			);
			$res = $this->Settingsmodel->update_settings($rData);

			if ($res !== TRUE) {
				$log = "Error resetting settings [ Username: " . $this->session->userdata('uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Error resetting settings');

				$data['status'] = false;
				$data['msg'] = 'Error resetting settings';
			} else {
				$log = "Settings Reset [ Username: " . $this->session->userdata('uname'). " ]";
				$this->log_act($log);

				$this->setFlashMsg('success', 'Settings Reset');
				$data['status'] = true;
				$data['msg'] = 'Settings Reset';
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

}

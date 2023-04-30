<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adminmodel extends CI_Model
{
	public function login()
	{
		$email = htmlentities($this->input->post('adminEmail'));
		$pwd = $this->input->post('adminPwd');

		$user = $this->db->get_where('admin', array('email' => $email))->row();
		if (!$user) {
			return false;
			exit();
		}
		if ($user->active == "0") {
			return "not_verified";
			exit();
		}
		if ($user->active == "2") {
			return "not_active";

			exit();
		}
		//verify passwords
		if (password_verify($pwd, $user->password)) {
			$userinfo = $this->db->get('admin')->row();

			return $userinfo;
		} else {
			return false;
		}
	}

	public function login_get_key()
	{
		$email = htmlentities($this->input->post('adminEmail'));

		$user = $this->db->get_where('admin', array('email' => $email))->row();
		if ($user->active == "0") {
			return $user->form_key;
			exit();
		}
	}
	
}

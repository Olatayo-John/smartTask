<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermodel extends CI_Model
{
	public function login()
	{
		$email = htmlentities($this->input->post('userEmail'));
		$pwd = $this->input->post('userPwd');

		$user = $this->db->get_where('user', array('email' => $email))->row();
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
			$userinfo = $this->db->get('user')->row();

			return $userinfo;
		} else {
			return false;
		}
	}

	public function login_get_key()
	{
		$email = htmlentities($this->input->post('userEmail'));

		$user = $this->db->get_where('user', array('email' => $email))->row();
		if ($user->active == "0") {
			return $user->form_key;
			exit();
		}
	}



	
}

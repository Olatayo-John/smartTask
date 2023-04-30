<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Dashboard_Controller
{
	public function index()
	{
		$data['title'] = "dashboard";

		$this->setTabUrl('url', 'dashboard');
		$this->setTabUrl('suburl', '');

		if (!$this->session->userdata('logged_in')) {
			redirect('/');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('dashboard');
			$this->load->view('templates/footer');
		}
	}
}

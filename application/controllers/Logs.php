<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends Admin_Controller
{
	public function index()
	{
		$this->is_admin();

		$this->setTabUrl('url', 'logs');
		$this->setTabUrl('suburl', '');

		$data['title'] = "logs";
		$data['activityLogs'] = $this->Logsmodel->get_activityLogs();
		$data['feedbackLogs'] = $this->Logsmodel->get_feedbacks();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/logs/index');
		$this->load->view('templates/footer');
	}

	public function activityLogs()
	{
		$this->is_admin();

		$this->setTabUrl('url','logs');
		$this->setTabUrl('suburl', 'activity-logs');

		$data['title'] = "activity logs";
		$data['activityLogs'] = $this->Logsmodel->get_activityLogs();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/logs/activityLogs');
		$this->load->view('templates/footer');
	}

	public function feedbackLogs()
	{
		$this->is_admin();

		$this->setTabUrl('url','logs');
		$this->setTabUrl('suburl', 'feedback-logs');

		$data['title'] = "feedback logs";
		$data['feedbackLogs'] = $this->Logsmodel->get_feedbacks();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/logs/feedbackLogs');
		$this->load->view('templates/footer');
	}

	public function clear_activityLogs()
	{
		if ($this->ajax_is_admin() === true) {

			$res = $this->Logsmodel->clear_activityLogs();

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

			$res = $this->Logsmodel->clear_feedbackLogs();

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

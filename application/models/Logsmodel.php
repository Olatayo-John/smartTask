<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logsmodel extends CI_Model
{
	public function get_activityLogs()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('activity');
		return $query;
	}
	
	public function get_feedbacks()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('contact');
		return $query;
	}

	public function clear_activityLogs()
	{
		$this->db->truncate('activity');
		return true;
	}

	public function clear_feedbackLogs()
	{
		$this->db->truncate('contact');
		return true;
	}
	
}

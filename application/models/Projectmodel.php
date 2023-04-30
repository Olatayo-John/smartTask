<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Projectmodel extends CI_Model
{
    public function get_projects()
    {
        $q = $this->db->get('project');
        return $q;
    }

    public function get_categories()
    {
        $this->db->order_by('category', 'asc');
        $q = $this->db->get('project_categories');
        return $q;
    }

    public function get_category($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('project_categories');

        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return false;
        }
    }

    public function add_category()
    {
        $data = array(
            'category' => $this->input->post('project_category_name')
        );
        $q = $this->db->insert('project_categories', $data);
        return $q;
    }

    public function update_category($project_category_id)
    {
        $data = array(
            'category' => $this->input->post('project_category_name')
        );
        $this->db->where('id', $project_category_id);
        $q = $this->db->update('project_categories', $data);
        return $q;
    }

    public function delete_category($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->delete('project_categories');
        return $q;
    }

    //
    public function get_activities()
    {
        $this->db->select('project_activities.id as p_a_id,project_activities.activity,project_activities.category_id,project_categories.*');
        $this->db->order_by('project_activities.activity', 'asc');
        $this->db->join('project_categories', 'project_categories.id = project_activities.category_id');
        $q = $this->db->get('project_activities');
        return $q;
    }

    public function get_activity($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('project_activities');

        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return false;
        }
    }

    public function add_activity()
    {
        $data = array(
            'activity' => $this->input->post('project_activity_name'),
            'category_id' => $this->input->post('project_activity_category_id')
        );
        $q = $this->db->insert('project_activities', $data);
        return $q;
    }

    public function update_activity($project_activity_id)
    {
        $data = array(
            'activity' => $this->input->post('project_activity_name'),
            'category_id' => $this->input->post('project_activity_category_id')
        );
        $this->db->where('id', $project_activity_id);
        $q = $this->db->update('project_activities', $data);
        return $q;
    }

    public function delete_activity($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->delete('project_activities');
        return $q;
    }
}

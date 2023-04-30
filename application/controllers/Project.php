<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project extends Admin_Controller
{
    public function index()
    {
        $this->is_admin();

        $this->setTabUrl('url', 'project');
        $this->setTabUrl('suburl', 'index');

        $data['title'] = "projects";
        $data['projects'] = $this->Projectmodel->get_projects();

        $this->load->view('templates/header', $data);
        $this->load->view('admin/project/index');
        $this->load->view('templates/footer');
    }

    public function add()
    {
        $this->is_admin();

        $this->setTabUrl('url', 'project');
        $this->setTabUrl('suburl', 'add-project');

        $data['title'] = "add project";
        $data['innertitle'] = "Add project";
        $data['projectCategories'] = $this->Projectmodel->get_categories();
        $data['projectActivities'] = $this->Projectmodel->get_activities();

        $this->load->view('templates/header', $data);
        $this->load->view('admin/project/create');
        $this->load->view('templates/footer');
    }

    public function categories($id = null)
    {
        $this->is_admin();

        $this->setTabUrl('url', 'project');
        $this->setTabUrl('suburl', 'project-categories');

        $data['title'] = "project categories";
        $data['innertitle'] = "Add";
        $data['projectCategories'] = $this->Projectmodel->get_categories();

        $data['projectCategory'] = new stdClass;
        $data['projectCategory']->id = '';
        $data['projectCategory']->category = '';

        if ($id && isset($id) && !empty($id)) {
            $resD = $this->Projectmodel->get_category($id); //return object
            if ($resD !== false) {
                $data['projectCategory'] = $resD;
                $data['innertitle'] = "Edit";
            }
        }

        if ($id && isset($id) && !empty($id)) {
            $this->form_validation->set_rules('project_category_id', 'Category ID', 'required|trim|html_escape');
        }
        $this->form_validation->set_rules('project_category_name', 'Category', 'required|trim|html_escape');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/project/categories');
            $this->load->view('templates/footer');
        } else {
            $project_category_id = $_POST['project_category_id'];

            if ($project_category_id && isset($project_category_id) && !empty($project_category_id)) {
                $res = $this->Projectmodel->update_category($project_category_id);

                if ($res === true) {
                    $log = "Updated Project Category' [ Username: " . $this->session->userdata('uname') . ", Project Category: " . $this->input->post('project_category_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('success', 'Updated Project Category');
                } else {
                    $log = "Error updating Project Category' [ Username: " . $this->session->userdata('uname') . ", Project Category: " . $this->input->post('project_category_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('error', 'Error upating Project Category');
                }
            } else {
                $res = $this->Projectmodel->add_category();

                if ($res === true) {
                    $log = "Created Project Category' [ Username: " . $this->session->userdata('uname') . ", Project Category: " . $this->input->post('project_category_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('success', 'Created Project Category');
                } else {
                    $log = "Error creating Project Category' [ Username: " . $this->session->userdata('uname') . ", Project Category: " . $this->input->post('project_category_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('error', 'Error creating Project Category');
                }
            }

            redirect('project-categories');
        }
    }

    public function delete_category()
    {
        if ($this->ajax_is_admin()) {
            $id = htmlentities($_POST['id']);
            $cName = htmlentities($_POST['cName']);

            $res = $this->Projectmodel->delete_category($id);

            if ($res === false) {
                $log = "Error deleting Project Category [ Username: " . $this->session->userdata('uname') . ", Project Category: " . $cName . " ]";
                $this->log_act($log);

                $data['status'] = false;
                $data['msg'] = "Error deleting Project Category";
            } else {
                $log = "Project Category Deleted [ Username: " . $this->session->userdata('uname') . ", Project Category: " . $cName . " ]";
                $this->log_act($log);

                $data['status'] = true;
                $data['msg'] = "Project Category Deleted";
            }
        } else {
            $data['status'] = false;
            $data['msg'] = lang('acc_denied');
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    public function activities($id = null)
    {
        $this->is_admin();

        $this->setTabUrl('url', 'project');
        $this->setTabUrl('suburl', 'project-activities');

        $data['title'] = "project activities";
        $data['innertitle'] = "Add";
        $data['projectCategories'] = $this->Projectmodel->get_categories();
        $data['projectActivities'] = $this->Projectmodel->get_activities();

        $data['projectActivity'] = new stdClass;
        $data['projectActivity']->id = '';
        $data['projectActivity']->activity = '';
        $data['projectActivity']->category_id = '';

        if ($id && isset($id) && !empty($id)) {
            $resD = $this->Projectmodel->get_activity($id); //return object
            if ($resD !== false) {
                $data['projectActivity'] = $resD;
                $data['innertitle'] = "Edit";
            }
        }

        if ($id && isset($id) && !empty($id)) {
            $this->form_validation->set_rules('project_activity_id', 'Activity ID', 'required|trim|html_escape');
        }
        $this->form_validation->set_rules('project_activity_name', 'Activity', 'required|trim|html_escape');
        $this->form_validation->set_rules('project_activity_category_id', 'Category', 'required|trim|html_escape');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/project/activities');
            $this->load->view('templates/footer');
        } else {
            $project_activity_id = $_POST['project_activity_id'];

            if ($project_activity_id && isset($project_activity_id) && !empty($project_activity_id)) {
                $res = $this->Projectmodel->update_activity($project_activity_id);

                if ($res === true) {
                    $log = "Updated Project Activity' [ Username: " . $this->session->userdata('uname') . ", Project Activity: " . $this->input->post('project_activity_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('success', 'Updated Project Category');
                } else {
                    $log = "Error updating Project Activity' [ Username: " . $this->session->userdata('uname') . ", Project Activity: " . $this->input->post('project_activity_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('error', 'Error upating Project Category');
                }
            } else {
                $res = $this->Projectmodel->add_activity();

                if ($res === true) {
                    $log = "Created Project Activity' [ Username: " . $this->session->userdata('uname') . ", Project Activity: " . $this->input->post('project_activity_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('success', 'Created Project Activity');
                } else {
                    $log = "Error creating Project Activity' [ Username: " . $this->session->userdata('uname') . ", Project Activity: " . $this->input->post('project_activity_name') . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('error', 'Error creating Project Activity');
                }
            }

            redirect('project-activities');
        }
    }

    public function delete_activity()
    {
        if ($this->ajax_is_admin()) {
            $id = htmlentities($_POST['id']);
            $aName = htmlentities($_POST['aName']);

            $res = $this->Projectmodel->delete_activity($id);

            if ($res === false) {
                $log = "Error deleting Project Activity [ Username: " . $this->session->userdata('uname') . ", Project Activity: " . $aName . " ]";
                $this->log_act($log);

                $data['status'] = false;
                $data['msg'] = "Error deleting Project Activity";
            } else {
                $log = "Project Activity Deleted [ Username: " . $this->session->userdata('uname') . ", Project Activity: " . $aName . " ]";
                $this->log_act($log);

                $data['status'] = true;
                $data['msg'] = "Project Activity Deleted";
            }
        } else {
            $data['status'] = false;
            $data['msg'] = lang('acc_denied');
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends Pages_Controller
{
    //home page
    public function index()
    {
        $this->setTabUrl($mod = 'home');

        $data['title'] = "home";

        $data['settings'] = $this->Settingsmodel->get_settings();

        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        } else {

            $this->load->view('templates/header', $data);
            $this->load->view('pages/index');
            $this->load->view('templates/footer');
        }
    }

    //profile
    public function account()
    {
        $this->checklogin();

        $this->setTabUrl($mod = 'account');

        $data['title'] = "account";

        $data['user_info'] = $this->Pagesmodel->get_userinfo();

        $this->load->view('templates/header',$data);
        $this->load->view('pages/account');
        $this->load->view('templates/footer');
    }

    public function account_edit()
    {
        $this->checklogin();

        $this->setTabUrl($mod = 'account');

        $this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|exact_length[10]|html_escape');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|html_escape');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|html_escape');

        if ($this->form_validation->run() === FALSE) {
            $this->setFlashMsg('error', validation_errors());
        } else {
            $res = $this->Pagesmodel->personal_edit();
            if ($res !== TRUE) {
                $log = "Error updating profile [ Username: " . $this->session->userdata('uname') .  " ]";
                $this->log_act($log);

                $this->setFlashMsg('error', lang('update_failed'));
            } else {
                $log = "Profile Updated [ Username: " . $this->session->userdata('uname') .  " ]";
                $this->log_act($log);

                $this->setFlashMsg('success', lang('profile_updated'));

                $this->session->set_userdata('email', htmlentities($this->input->post('email')));
                $this->session->set_userdata('mobile', htmlentities($this->input->post('mobile')));
            }
        }

        redirect('account');
    }


    public function password_update()
    {
        $this->checklogin();

        $this->form_validation->set_rules('c_pwd', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('n_pwd', 'New Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('rtn_pwd', 'Re-type Password', 'required|trim|min_length[6]|matches[n_pwd]');

        if ($this->form_validation->run() == false) {
            $this->setFlashMsg('error', validation_errors());
        } else {
            $pwd_res = $this->Pagesmodel->check_pwd();
            if ($pwd_res == false) {
                $log = "Error updating password [ Username: " . $this->session->userdata('uname') . " ]";
                $this->log_act($log);

                $this->setFlashMsg('error', lang('incorrect_pwd_provided'));
            } else {
                $log = "Password updated [ Username: " . $this->session->userdata('uname') . " ]";
                $this->log_act($log);

                $this->setFlashMsg('success', lang('pwd_updated'));
            }
        }

        redirect('account');
    }

    //send verification code to user email
    public function resetpassword_vcode()
    {
        $email = htmlentities($_POST['useremail']);
        $act_key = htmlentities($_POST['vcode_init']);
        $userid = htmlentities($_POST['userid']);

        $this->load->library('emailconfig');
        $eres = $this->emailconfig->resetpassword_vcode($email, $act_key, $userid);

        if ($eres !== true) {
            $log = "Error sending mail - Verification [ Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('useremail')) . ", MailError: " . $eres . " ]";
            $this->log_act($log);

            $data['status'] = false;
            $data['msg'] = "Error sending mail";
        } else {
            $log = "Mail sent - Verification [ Username: " . $this->session->userdata('uname') . ", Email: " . htmlentities($this->input->post('useremail')) . " ]";
            $this->log_act($log);

            $res = $this->Pagesmodel->updateact_key($userid, $act_key, $email);
            if ($res === false) {
                $log = "Error saving to Database - Password Reset [ Username: " . $this->session->userdata('uname') . " ]";
                $this->log_act($log);

                $data['status'] = true;
                $data['msg'] = "Error saving to Database";
            } else {
                $data['status'] = true;
                $data['msg'] = "Mail sent";
            }
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    //verify verification code
    public function verifyvcode()
    {
        $vecode = $_POST['vecode'];
        $userid = $_POST['userid'];

        $res = $this->Pagesmodel->verifyvcode($userid, $vecode);

        if ($res === false) {
            $log = "Invalid verfication code provided - Password Reset [ Username: " . $this->session->userdata('uname') . " ]";
            $this->log_act($log);

            $data['status'] = false;
            $data['msg'] = "Invalid verfication code provided";
        } else {
            $log = "Code verified - Password Reset [ Username: " . $this->session->userdata('uname') . " ]";
            $this->log_act($log);

            $data['status'] = true;
            $data['msg'] = "Code Verified";
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }

    //after vcode is verified, change password
    public function changepassword()
    {
        $newpwd = $_POST['newpwd'];
        $userid = $_POST['userid'];

        $this->load->library('emailconfig');
        $eres = $this->emailconfig->resetpassword($userid, $newpwd, $user_name = $this->session->userdata('uname'));

        if ($eres === true) {

            $res = $this->Pagesmodel->changepassword($userid, $newpwd);

            if ($res === false) {
                $log = "Error updating password [ Username: " . $this->session->userdata('uname') . " ]";
                $this->log_act($log);

                $data['status'] = false;
                $data['msg'] = "Error updating password";
            } else {
                $log = "Password updated [ Username: " . $this->session->userdata('uname') . " ]";
                $this->log_act($log);

                $data['status'] = true;
                $data['msg'] = "Password updated!";
            }
        } else {
            $log = "Error sending mail - New Password [ Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('useremail')) . ", MailError: " . $eres . " ]";
            $this->log_act($log);

            $data['status'] = false;
            $data['msg'] = "Error sending mail";
        }

        $data['token'] = $this->security->get_csrf_hash();
        echo json_encode($data);
    }
    //profile end


    //email verification after registration
    public function emailverify($key)
    {
        $this->setTabUrl($mod = 'login');

        $data['title'] = "Email Verification";

        $check_res = $this->Pagesmodel->check_verification($key);
        if ($check_res == false) {
            $this->setFlashMsg('error', 'Wrong credentials');
            redirect('login');
        } else {
            $active = $check_res->active;
            if ($active == '1') {
                $this->setFlashMsg('success', 'Your account is verified.');
                redirect('login');
            }

            $this->form_validation->set_rules('sentcode', 'Verification Code', 'required|trim|html_escape');

            if ($this->form_validation->run() == false) {
                $data['key'] = $key;
                $data['email'] = $check_res->email;
                $this->load->view('templates/header', $data);
                $this->load->view('templates/emailverify', $data);
                $this->load->view('templates/footer');
            } else {
                $validate = $this->Pagesmodel->emailverify($key);

                if ($validate == false) {
                    $log = "Invalid verfication code provided [ Username: " . $check_res->uname . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('error', 'Invalid code');
                    redirect('emailverify/' . $key);
                } else {
                    if ($validate->active !== "1") {
                        $log = "Error verifying account [ Username: " . $check_res->uname  . " ]";
                        $this->log_act($log);

                        $this->setFlashMsg('error', 'Error verifying account ');
                        redirect('emailverify/' . $key);
                    } else if ($validate->active == "1") {
                        $log = "Account verified [ Username: " . $check_res->uname  . " ]";
                        $this->log_act($log);

                        $this->setFlashMsg('success', 'Account verified');
                        redirect('login');
                    }
                }
            }
        }
    }

    //resend verification email
    public function resendemailverify($key)
    {
        $check_res = $this->Pagesmodel->check_verification($key);

        if ($check_res == false) {
            $this->setFlashMsg('error', 'Wrong credentials');
            redirect($_SERVER['HTTP_REFERRER']);
        } else {
            $active = $check_res->active;
            if ($active == '1') {
                $this->setFlashMsg('success', 'Your account is already verified and active.');
                redirect('login');
            } else {
                $res = $this->Pagesmodel->check_verification($key);

                $email = $res->email;
                $uname = $res->uname;
                $link = base_url() . "emailverify/" . $res->form_key;
                $act_key =  mt_rand(0, 1000000);

                $this->load->library('emailconfig');
                $mail_res = $this->emailconfig->send_email_code($email, $uname, $act_key, $link);

                if ($mail_res !== TRUE) {
                    $log = "Error sending mail - Verification [ Username: " . $uname . ", Email: " . $email . ", MailError: " . $mail_res . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('error', 'Error sending mail');
                    redirect($link);
                } else {
                    $log = "Mail sent - Verification [ Username: " . $uname . ", Email: " . $email . " ]";
                    $this->log_act($log);

                    $this->Pagesmodel->code_verify_update($act_key, $key);

                    $this->setFlashMsg('success', 'Verification mail sent');
                    redirect($link);
                }
            }
        }
    }

    //contact-us
    public function support()
    {
        $data['title'] = "support";

        $this->setTabUrl($mod = 'support');

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim|html_escape');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
        $this->form_validation->set_rules('msg', 'Message', 'required|trim|html_escape');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('pages/support');
            $this->load->view('templates/footer');
        } else {
            $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
            $userIp = $this->input->ip_address();
            $secret = $this->st->captcha_secret_key;

            $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);

            $status = json_decode($output, true);

            if ($status['success']) {
                $name = htmlentities($this->input->post('name'));
                $user_mail = htmlentities($this->input->post('email'));
                $bdy = htmlentities($this->input->post('msg'));

                $this->load->library('emailconfig');
                // $mail_res = $this->emailconfig->support_mail($name, $user_mail, $bdy);
                $mail_res = true;

                if ($mail_res !== true) {
                    $log = "Error sending mail - Contact Us [ Name: " . htmlentities($this->input->post('name')) . ", Email: " . htmlentities($this->input->post('email')) . ", MailError: " . $mail_res . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('error', 'Error sending your message');
                } else {
                    $res = $this->Pagesmodel->save_support_msg();

                    $log = "Mail sent - Contact Us [ Name: " . htmlentities($this->input->post('name')) . ", Email: " . htmlentities($this->input->post('email')) . " ]";
                    $this->log_act($log);

                    $this->setFlashMsg('success', 'Message sent. We will get back to you as soon as possible');
                }
            } else {
                $this->setFlashMsg('error', 'Google Recaptcha Unsuccessfull');
            }

            redirect('support');
        }
    }


    //invalid url link
    public function fof()
    {
        $data['title'] = "404 | Page Not Found";

        $this->load->view('templates/header', $data);
        $this->load->view('templates/fof');
        $this->load->view('templates/footer');
    }
}

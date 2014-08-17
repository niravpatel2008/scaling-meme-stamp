<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct(){
        parent::__construct();

        $this->front_session = $this->session->userdata('front_session');
        $this->form_validation->set_error_delimiters('<div id="errorMsg" class="12u errorMsg">','</div>');

        is_front_login();
    }

    public function edit()
    {
        $post = $this->input->post();
        if ($post) {
            $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');

            if ($this->form_validation->run()) {
                $data = array('Firstname' => $post['firstname'],
                                'Lastname' => $post['lastname'],
                                'EmailId' => $post['email'],
                                'City' => $post['city'],
                                'State' => $post['state']
                            );
                $ret = $this->common_model->updateData(TBLUSER, $data, array('id' => $this->front_session['id']) );
                if ($ret > 0) {
                    $flash_arr = array('flash_type' => 'success',
                                        'flash_msg' => 'Profile updated successfully.'
                                    );

                }else{
                    $flash_arr = array('flash_type' => 'error',
                                        'flash_msg' => 'An error occurred while processing.'
                                    );
                }
                $data['flash_arr'] = $flash_arr;
            }

        }

        $data['user_profile'] = $this->common_model->selectData(TBLUSER, '*', array('id' => $this->front_session['id']) );
        $data['view'] = "edit";
        $this->load->view('content', $data);
    }

    public function changepassword()
    {

        $post = $this->input->post();
        if ($post) {
            $this->form_validation->set_rules('old_password', 'Old password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|matches[new_password]');

            if ($this->form_validation->run()) {
                $data = array('Password' => md5($post['new_password']) );
                $ret = $this->common_model->updateData(TBLUSER, $data, array('id' => $this->front_session['id']) );
                if ($ret > 0) {
                    $data['flash_msg'] = 'Password changed successfully.';
                }else{
                   $data['flash_msg'] = 'An error occurred while processing.';
                }

            }
        }

        $data['view'] = "change_password";
        $this->load->view('content', $data);
    }
}

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
}

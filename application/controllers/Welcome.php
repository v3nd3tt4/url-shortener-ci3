<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function index() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('url/dashboard');
        }
        $this->load->view('login');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $query = $this->db->get_where('admin', ['username' => $username]);
        $admin = $query->row();
        if ($admin && password_verify($password, $admin->password)) {
            $this->session->set_userdata('admin_logged_in', true);
            $this->session->set_userdata('admin_username', $admin->username);
            echo json_encode(['status' => 'success', 'redirect' => site_url('url/dashboard')]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Login gagal! Username atau password salah.']);
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('admin_username');
        $this->session->sess_destroy();
        redirect('welcome/index');
    }
}
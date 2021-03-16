<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        $this->authRedirect();
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if (!$this->form_validation->run()) {
            $data['title'] = "Login";
            $this->load->view("templates/auth_header", $data);
            $this->load->view("auth/login");
            $this->load->view("templates/auth_footer");
        } else {
            $this->login();
        }
    }

    public function register()
    {
        $this->authRedirect();
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => "Password doesn't match.",
            'min_length' => "Password too short."
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]', [
            'matches' => "Password doesn't match."
        ]);

        if (!$this->form_validation->run()) {
            $data['title'] = "Registration";
            $this->load->view("templates/auth_header", $data);
            $this->load->view("auth/register");
            $this->load->view("templates/auth_footer");
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role')
            ];
            // Insert our user data to the user table.
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Account successfully registered.</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully logged out.</div>');
        redirect('auth');
    }

    private function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            // exist
            if (password_verify($password, $user['password'])) {
                $data = [
                    'email' => $user['email'],
                    'role_id' => $user['role_id']
                ];
                $this->session->set_userdata($data);
                if (isset($_POST["remember"])) {
                    $hour = time() + 3600 * 24 * 30;
                    setcookie('email', $user['email'], $hour);
                    setcookie('password', $user['password'], $hour);
                }
                if ($data['role_id'] == 1)
                    redirect('admin');
                else if ($data['role_id'] == 2)
                    redirect('kantor');
                else
                    redirect('toko');
                // correct password
            } else {
                // wrong password
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password.</div>');
                redirect('auth');
            }
        } else {
            // fail
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered.</div>');
            redirect('auth');
        }
    }

    private function authRedirect()
    {
        if ($this->session->userdata('email')) {
            $role_id = $this->session->userdata('role_id');
            switch ($role_id) {
                case 1:
                    redirect('admin');
                    break;
                case 2:
                    redirect('kantor');
                    break;
                case 3:
                    redirect('toko');
                    break;
            }
        }
    }
}

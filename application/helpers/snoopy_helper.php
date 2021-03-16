<?php

function loginCheck()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        $queryMenu = $ci->db->get_where('menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];
        $userAccess = $ci->db->get_where('menu_access', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
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

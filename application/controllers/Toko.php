<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        loginCheck();

        $this->load->model('menu');

        $this->data = array(
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
        );

        $this->data['grooming_monthly'] = $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 month")), $this->data['user']['id']);
        $this->data['grooming_daily'] = $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 days")), $this->data['user']['id']);
        $this->data['grooming_weekly'] = $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 week")), $this->data['user']['id']);
        $this->data['grooming_annual'] = $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 year")), $this->data['user']['id']);
        $this->data['grooming_january'] = $this->menu->getGroomingEarnings("January", $this->data['user']['id']);
        $this->data['grooming_february'] = $this->menu->getGroomingEarnings("February", $this->data['user']['id']);
        $this->data['grooming_march'] = $this->menu->getGroomingEarnings("March", $this->data['user']['id']);
        $this->data['grooming_april'] = $this->menu->getGroomingEarnings("April", $this->data['user']['id']);
        $this->data['grooming_may'] = $this->menu->getGroomingEarnings("May", $this->data['user']['id']);
        $this->data['grooming_june'] = $this->menu->getGroomingEarnings("June", $this->data['user']['id']);
        $this->data['grooming_july'] = $this->menu->getGroomingEarnings("July", $this->data['user']['id']);
        $this->data['grooming_august'] = $this->menu->getGroomingEarnings("August", $this->data['user']['id']);
        $this->data['grooming_september'] = $this->menu->getGroomingEarnings("September", $this->data['user']['id']);
        $this->data['grooming_october'] = $this->menu->getGroomingEarnings("October", $this->data['user']['id']);
        $this->data['grooming_november'] = $this->menu->getGroomingEarnings("November", $this->data['user']['id']);
        $this->data['grooming_december'] = $this->menu->getGroomingEarnings("December", $this->data['user']['id']);


        $queryInventory = "SELECT inventory.id, user.name AS shop_name, item_barcode, item_name, item_brand, item_type, item_amount, item_price, item_buy_price, item_wholesaler_price FROM `inventory` JOIN user ON user.id = shop_id WHERE shop_id = " . $this->data['user']['id'];
        $queryGrooming = "SELECT grooming.id, member.name, member.phone, animal, race, price, paid, description, created_at FROM `grooming` JOIN `member` ON member.id = grooming.member_id JOIN user ON grooming.shop_id = user.id WHERE grooming.shop_id = " .  $this->data['user']['id'];
        $queryMembers = "SELECT member.id, member.name, shop_id, phone, address FROM member JOIN user ON user.id = member.shop_id WHERE member.shop_id = "  . $this->data['user']['id'];
        $queryExpenditure = "SELECT * FROM `expenditure` WHERE shop_id = " . $this->data['user']['id'];
        $this->data['members'] = $this->db->query($queryMembers)->result_array();
        $this->data['expenditure'] = $this->db->query($queryExpenditure)->result_array();
        $this->data['groom'] = $this->db->query($queryGrooming)->result_array();
        $this->data['inv'] = $this->db->query($queryInventory)->result_array();
        $this->data['expenditure_requests'] = count($this->data['expenditure']);

        date_default_timezone_set('Asia/Makassar');
    }

    public function index()
    {
        $data = $this->data;
        $data['title'] = "Dashboard";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('toko/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function grooming()
    {
        $data = $this->data;
        $data['title'] = "Grooming";
        $this->form_validation->set_rules('member_id', 'Member Name', 'required|trim');
        $this->form_validation->set_rules('animal', 'Animal', 'required|trim');
        $this->form_validation->set_rules('race', 'Animal Race', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|trim|greater_than[0]|numeric');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/grooming/grooming', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $addGroom = [
                'member_id' => $this->input->post('member_id'),
                'animal' => htmlspecialchars($this->input->post('animal', true)),
                'race' => htmlspecialchars($this->input->post('race', true)),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'shop_id' => $data['user']['id'],
                'paid' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ];
            // Insert our user data to the user table.
            $this->db->insert('grooming', $addGroom);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New grooming added.</div>');
            redirect('toko/grooming');
        }
    }

    public function accounting()
    {
        $data = $this->data;
        $data['title'] = "Accounting";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('toko/accounting/accounting', $data);
        $this->load->view('templates/footer', $data);
    }

    public function expenditurerequest()
    {
        $data = $this->data;
        $data['title'] = "Expenditure Request";

        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('amount_requested', 'Amount', 'required|trim');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/expenditure/expenditure', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $addExpenditure = [
                'shop_id' => $this->data['user']['id'],
                'description' => htmlspecialchars($this->input->post('description', true)),
                'amount_requested' => $this->input->post('amount_requested'),
                'status' => 0
            ];
            // Insert our user data to the user table.
            $this->db->insert('expenditure', $addExpenditure);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New request added.</div>');
            redirect('toko/expenditurerequest');
        }
    }


    public function editexpenditure($exp_id = null)
    {
        $data = $this->data;
        $data['title'] = "Edit Expenditure";
        if (isset($exp_id)) {
            $query = "SELECT * FROM `expenditure` WHERE expenditure.id = " . $exp_id;
            $exp_data = $this->db->query($query)->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/expenditure/editexpenditure', $exp_data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function saveexpenditure($exp_id = null)
    {
        if (isset($exp_id)) {
            $editExp = [
                'shop_id' => $this->data['user']['id'],
                'description' => htmlspecialchars($this->input->post('description', true)),
                'amount_requested' => $this->input->post('amount_requested'),
                'status' => 0
            ];
            $this->db->where('id', $exp_id);
            $this->db->update('expenditure', $editExp);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request edited.</div>');
            redirect('toko/expenditurerequest');
        }
    }

    public function deleteexpenditure($exp_id = null)
    {
        if (isset($exp_id)) {
            $this->db->where('id', $exp_id);
            $this->db->delete('expenditure');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request deleted.</div>');
            redirect('toko/expenditurerequest');
        }
    }

    public function groomresults()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        if (!($start_date > 0 && $end_date > 0)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">One or more fields was not filled.</div>');
            redirect('toko/accounting');
            return;
        }
        $data = $this->data;
        $data['title'] = "Accounting - Grooming Report";
        $queryGrooming = "SELECT grooming.id, member.name, member.phone, animal, race, price, paid, created_at, description
        FROM `grooming` JOIN `member` ON member.id = grooming.member_id
        JOIN `user` ON grooming.shop_id = user.id WHERE grooming.shop_id = " . $this->data['user']['id'] . " AND created_at >= '" . $start_date . "' AND created_at <= '" . $end_date . "'";
        $data['groom_results'] = $this->db->query($queryGrooming)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('toko/accounting/accountingdetails', $data);
        $this->load->view('templates/footer', $data);
    }

    public function editgroom($grooming_id = null)
    {
        if (isset($grooming_id)) {
            $data = $this->data;
            $data['title'] = "Edit Grooming";
            $query = "SELECT grooming.id AS groom_id, member.id, member.name, member.phone, animal, race, price, paid, description, payment_method, created_at FROM `grooming` JOIN `member` ON member.shop_id = grooming.shop_id JOIN user ON grooming.shop_id = user.id WHERE member.id = grooming.member_id AND grooming.id = " . $grooming_id;
            $d_groom = $this->db->query($query)->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/grooming/editgrooming', $d_groom);
            $this->load->view('templates/footer', $data);
        }
    }

    public function savegroom($grooming_id = null)
    {
        if (isset($grooming_id)) {
            $editGroom = [
                'member_id' => $this->input->post('member_id'),
                'animal' => htmlspecialchars($this->input->post('animal', true)),
                'race' => htmlspecialchars($this->input->post('race', true)),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'payment_method' => $this->input->post('payment_method'),
                'paid' => $this->input->post('paid')
            ];

            $this->db->where('id', $grooming_id);
            $this->db->update('grooming', $editGroom);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Grooming edited.</div>');
            redirect('toko/grooming');
        }
    }

    public function deletegroom($grooming_id = null)
    {
        if (isset($grooming_id)) {
            $this->db->where('id', $grooming_id);
            $this->db->delete('grooming');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Grooming deleted.</div>');
            redirect('toko/grooming');
        }
    }

    public function inventory()
    {
        $data = $this->data;
        $data['title'] = "Inventory";

        $this->form_validation->set_rules('item_barcode', 'Item Barcode', 'required|trim');
        $this->form_validation->set_rules('item_name', 'Item Name', 'required|trim');
        $this->form_validation->set_rules('item_brand', 'Item Brand', 'required|trim');
        $this->form_validation->set_rules('item_type', 'Item Type', 'required|trim');
        $this->form_validation->set_rules('item_amount', 'Item Amount', 'required|trim|greater_than[0]|numeric');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/inventory/inventory', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $addItem = [
                'shop_id' => $data['user']['id'],
                'item_barcode' => htmlspecialchars($this->input->post('item_barcode', true)),
                'item_name' => $this->input->post('item_name'),
                'item_brand' => $this->input->post('item_brand'),
                'item_type' => $this->input->post('item_type'),
                'item_amount' => $this->input->post('item_amount')
            ];
            // Insert our user data to the user table.
            $this->db->insert('inventory', $addItem);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item added.</div>');
            redirect('toko/inventory');
        }
    }

    public function editinventory($item_id = null)
    {
        $data = $this->data;
        $data['title'] = "Edit Item";
        if (isset($item_id)) {
            $query = "SELECT inventory.id AS item_id, user.name AS shop_name, shop_id AS shopid, item_barcode, item_name, item_brand, item_type, item_amount, item_price, item_buy_price, item_wholesaler_price FROM `inventory` JOIN user ON user.id = shop_id WHERE inventory.id = " . $item_id;
            $item_data = $this->db->query($query)->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/inventory/editinventory', $item_data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function saveinventory($item_id = null)
    {
        if (isset($item_id)) {
            $editItem = [
                'shop_id' => $this->data['user']['id'],
                'item_barcode' => htmlspecialchars($this->input->post('item_barcode', true)),
                'item_name' => $this->input->post('item_name'),
                'item_brand' => $this->input->post('item_brand'),
                'item_type' => $this->input->post('item_type'),
                'item_amount' => $this->input->post('item_amount')
            ];
            $this->db->where('id', $item_id);
            $this->db->update('inventory', $editItem);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item edited.</div>');
            redirect('toko/inventory');
        }
    }

    public function deleteinventory($item_id = null)
    {
        if (isset($item_id)) {
            $this->db->where('id', $item_id);
            $this->db->delete('inventory');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item deleted.</div>');
            redirect('toko/inventory');
        }
    }

    public function member()
    {
        $data = $this->data;
        $data['title'] = "Members";

        $this->form_validation->set_rules('name', 'Member Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/member/member', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $addMember = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'shop_id' => $this->data['user']['id'],
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            ];
            // Insert our user data to the user table.
            $this->db->insert('member', $addMember);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New member added.</div>');
            redirect('toko/member');
        }
    }

    public function editmember($member_id = null)
    {
        $data = $this->data;
        $data['title'] = "Edit Member";
        if (isset($member_id)) {
            $query = "SELECT member.id, name, phone, address FROM `member` WHERE member.id = " . $member_id;
            $member_data = $this->db->query($query)->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebartoko', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('toko/member/editmember', $member_data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function savemember($member_id = null)
    {
        if (isset($member_id)) {
            $editMember = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            ];
            $this->db->where('id', $member_id);
            $this->db->update('member', $editMember);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Member edited.</div>');
            redirect('toko/member');
        }
    }

    public function deletemember($member_id = null)
    {
        if (isset($member_id)) {
            $this->db->where('id', $member_id);
            $this->db->delete('member');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Member deleted.</div>');
            redirect('toko/member');
        }
    }
}

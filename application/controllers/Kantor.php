<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kantor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        loginCheck();

        $queryInventory = "SELECT inventory.id, user.name 
        AS shop_name, item_barcode, item_name, item_brand, item_type, item_amount
        FROM `inventory` JOIN user ON user.id = shop_id";

        $queryShipping = "SELECT shipping.id, shipping.shipping_id, user.name, shipping.created_at, shipping.status FROM `shipping` JOIN user ON shipping.shop_id = user.id ORDER BY shipping.created_at DESC";
        $querySender = "SELECT user.name AS sender FROM `user` JOIN shipping ON shipping.shop_sender_id = user.id ORDER BY shipping.created_at DESC";

        $queryExpenditure = "SELECT user.name, expenditure.id, shop_id, description, amount_requested, status FROM `expenditure` JOIN user ON shop_id = user.id";

        $this->load->model('menu');

        $this->data = array(
            'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'users' => $this->db->get_where('user')->result_array(),
            'inv' => $this->db->query($queryInventory)->result_array(),
            'shops' => $this->db->query('SELECT user.id, name FROM user WHERE role_id = 3')->result_array(),
            'shipping' => $this->db->query($queryShipping)->result_array(),
            'sender_shipping' => $this->db->query($querySender)->result_array(),
            'grooming_monthly' => $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 month"))),
            'grooming_daily' => $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 days"))),
            'grooming_weekly' => $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 week"))),
            'grooming_annual' => $this->menu->getGroomingIncome(date("Y-m-d H:i:s", strtotime("-1 year"))),
            'grooming_january' => $this->menu->getGroomingEarnings("January"),
            'grooming_february' => $this->menu->getGroomingEarnings("February"),
            'grooming_march' => $this->menu->getGroomingEarnings("March"),
            'grooming_april' => $this->menu->getGroomingEarnings("April"),
            'grooming_may' => $this->menu->getGroomingEarnings("May"),
            'grooming_june' => $this->menu->getGroomingEarnings("June"),
            'grooming_july' => $this->menu->getGroomingEarnings("July"),
            'grooming_august' => $this->menu->getGroomingEarnings("August"),
            'grooming_september' => $this->menu->getGroomingEarnings("September"),
            'grooming_october' => $this->menu->getGroomingEarnings("October"),
            'grooming_november' => $this->menu->getGroomingEarnings("November"),
            'grooming_december' => $this->menu->getGroomingEarnings("December"),
            'expenditure' => $this->db->query($queryExpenditure)->result_array()
        );

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
        $this->load->view('kantor/index', $data);
        $this->load->view('templates/footer', $data);
        //echo 'Selamat datang, ' . $data['user']['name'] . '!';
    }

    public function expenditurerequest()
    {
        $data = $this->data;
        $data['title'] = "Expenditure Requests";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kantor/expenditure/expenditure', $data);
        $this->load->view('templates/footer', $data);
    }

    public function confirmexpenditure($id = null)
    {
        if (isset($id)) {
            $editExp = [
                'status' => 1
            ];
            $this->db->where('id', $id);
            $this->db->update('expenditure', $editExp);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request confirmed.</div>');
            redirect('kantor/expenditurerequest');
        }
    }

    public function rejectexpenditure($id = null)
    {
        if (isset($id)) {
            $editExp = [
                'status' => 2
            ];
            $this->db->where('id', $id);
            $this->db->update('expenditure', $editExp);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request rejected.</div>');
            redirect('kantor/expenditurerequest');
        }
    }

    public function shipping()
    {
        $data = $this->data;
        $data['title'] = "Shipping";
        $this->form_validation->set_rules('shop_sender_id', 'Shop Sender Name', 'required|trim');
        $this->form_validation->set_rules('shop_receiver_id', 'Shop Receiver Name', 'required|trim');
        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/shipping/shipping', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $query = "SELECT COUNT(id) as count FROM shipping";
            $current_count = $this->db->query($query)->row_array();
            $addShipping = [
                'shipping_id' => "INV/" . date("Ymd") . "/KIRIM/" . $this->menu->numberToRomanRepresentation(date('d')) . "/" . $this->menu->numberToRomanRepresentation(date('m')) . "/" . (intval($current_count['count']) + 1),
                'shop_sender_id' => $this->input->post('shop_sender_id'),
                'shop_id' => $this->input->post('shop_receiver_id'),
                'created_at' => date("Y-m-d H:i:s")
            ];
            // Insert our user data to the user table.
            $this->db->insert('shipping', $addShipping);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item added.</div>');
            redirect('kantor/shipping/');
        }
    }

    public function viewshipping($shipping_id = NULL)
    {
        if (!isset($shipping_id))
            return;

        $data = $this->data;
        $data['title'] = "Shipping Details";
        $data['current_id'] = $shipping_id;
        $this->form_validation->set_rules('item_id', 'Item Name', 'required|trim');
        $this->form_validation->set_rules('item_jumlah', 'Item Amount', 'required|trim|greater_than[0]|numeric');

        if (!$this->form_validation->run()) {
            $query = "SELECT shipping_details.id, shipping_details.shipping_id, shipping.shipping_id AS invoice, inventory.item_name, shipping_details.item_jumlah, shipping_details.item_id 
            FROM `shipping` JOIN shipping_details 
            ON shipping.id = shipping_details.shipping_id JOIN inventory ON shipping_details.item_id = inventory.id 
            JOIN user ON shipping.shop_id = user.id WHERE shipping_details.shipping_id = " . $shipping_id;

            $queryInventory = "SELECT inventory.id, item_name FROM `inventory` JOIN shipping ON shipping.shop_sender_id = inventory.shop_id WHERE shipping.id = " . $shipping_id . " AND inventory.item_amount > 0";

            $data['shipping_details'] = $this->db->query($query)->result_array();
            $data['inventory_shop'] = $this->db->query($queryInventory)->result_array();

            if ($data['shipping_details'])
                $data['title'] = "Shipping Details - " . $data['shipping_details'][0]['invoice'];
            else {
                $data['title'] = "Shipping Details - " . $this->db->query("SELECT shipping_id AS invoice from shipping WHERE id = " . $shipping_id)->row_array()['invoice'];
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/shipping/shipping_details', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $addItem = [
                'shipping_id' => $shipping_id,
                'item_id' => $this->input->post('item_id'),
                'item_jumlah' => $this->input->post('item_jumlah')
            ];
            // Insert our user data to the user table.
            $this->db->insert('shipping_details', $addItem);
            $this->db->query("UPDATE `inventory` SET `item_amount` = item_amount-" . $this->input->post('item_jumlah') . " WHERE `id` = " . $addItem['item_id'] . "");
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item added.</div>');
            redirect('kantor/viewshipping/' . $shipping_id);
        }
    }

    public function editshipping($shipping_id = NULL, $item_id = NULL)
    {
        if (!isset($item_id) && !isset($shipping_id))
            return;

        $data = $this->data;
        $data['current_shipping_id'] = $shipping_id;
        $data['current_item_id'] = $item_id;
        $data['title'] = "Edit Item";

        $query = "SELECT shipping_details.id, inventory.item_name, shipping_details.item_jumlah, shipping_details.item_id 
        FROM shipping_details JOIN shipping ON shipping_details.shipping_id = " . $shipping_id . "
        JOIN inventory ON shipping_details.item_id = inventory.id WHERE shipping_details.item_id = " . $item_id;

        $item_details = $this->db->query($query)->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kantor/shipping/editshipping', $item_details);
        $this->load->view('templates/footer', $data);
    }

    public function saveshipping($shipping_id = NULL, $shipping_detail_id = NULL)
    {
        if (isset($shipping_id) && isset($shipping_detail_id)) {
            // Restore old item amount.
            $item = $this->db->query("SELECT item_id, item_jumlah FROM shipping_details WHERE shipping_details.id = " . $shipping_detail_id . "")->row_array();

            $this->db->query("UPDATE inventory SET item_amount = item_amount + " . intval($item["item_jumlah"]) . " WHERE id = " . $item["item_id"] . "");

            // Then reduce the amount properly.
            $this->db->query("UPDATE `inventory` SET `item_amount` = item_amount - " . $this->input->post('item_jumlah') . " WHERE `id` = " . $item["item_id"] . "");

            // Then update the shipping details table.
            $editItem = [
                'item_id' => $this->input->post('item_id'),
                'item_jumlah' => $this->input->post('item_jumlah')
            ];
            $this->db->where('id', $shipping_detail_id);
            $this->db->update('shipping_details', $editItem);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item edited.</div>');
            redirect('kantor/viewshipping/' . $shipping_id);
        }
    }

    public function deleteshipping($id = null)
    {
        if (isset($id)) {
            $item = $this->db->query("SELECT item_id, item_jumlah FROM shipping_details WHERE shipping_id = " . $id . "")->result_array();
            foreach ($item as $i) :
                $this->db->query("UPDATE inventory SET item_amount = item_amount + " . intval($i["item_jumlah"]) . " WHERE id = " . $i["item_id"] . "");
            endforeach;
            $this->db->where('id', $id);
            $this->db->delete('shipping');
            $this->db->where('shipping_id', $id);
            $this->db->delete('shipping_details');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Shipping deleted.</div>');
            redirect('kantor/shipping');
        }
    }

    public function confirmshipping($id = null)
    {
        if (isset($id)) {
            $editShipping = [
                'status' => 1
            ];
            $this->db->where('id', $id);
            $this->db->update('shipping', $editShipping);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Shipping confirmed.</div>');
            redirect('kantor/shipping');
        }
    }

    public function deleteshippingdetail($shipping_id = null, $id = null)
    {
        if (isset($id) && isset($shipping_id)) {
            $originalItemAmount = $this->db->query("SELECT item_id, item_jumlah FROM shipping_details WHERE id = " . $id . "")->row_array();
            $this->db->where('id', $id);
            $this->db->delete('shipping_details');
            $this->db->query("UPDATE inventory SET item_amount = item_amount + " . intval($originalItemAmount["item_jumlah"]) . " WHERE id = " . $originalItemAmount["item_id"] . "");
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item deleted.</div>');
            redirect('kantor/viewshipping/' . $shipping_id);
        }
    }

    public function accounting()
    {
        $data = $this->data;
        $data['title'] = "Accounting";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kantor/accounting/accounting', $data);
        $this->load->view('templates/footer', $data);
    }

    public function groomresults()
    {
        $shop_id = $this->input->post('shop_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        if (!(isset($shop_id) && $start_date > 0 && $end_date > 0)) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">One or more fields was not filled.</div>');
            redirect('kantor/accounting');
            return;
        }
        $data = $this->data;
        $data['title'] = "Accounting - Grooming Report";
        $queryGrooming = "SELECT user.name 
        AS shop_name, grooming.id, member.name, member.phone, animal, race, price, paid, created_at, description
        FROM `grooming` JOIN `member` ON member.id = grooming.member_id
        JOIN `user` ON grooming.shop_id = user.id WHERE grooming.shop_id = " . $shop_id . " AND created_at >= '" . $start_date . "' AND created_at <= '" . $end_date . "'";
        $data['groom_results'] = $this->db->query($queryGrooming)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('kantor/accounting/accountingdetails', $data);
        $this->load->view('templates/footer', $data);
    }

    public function inventory()
    {
        $data = $this->data;
        $data['title'] = "Inventory";

        $this->form_validation->set_rules('shop_id', 'Shop Name', 'required|trim');
        $this->form_validation->set_rules('item_barcode', 'Item Barcode', 'required|trim');
        $this->form_validation->set_rules('item_name', 'Item Name', 'required|trim');
        $this->form_validation->set_rules('item_brand', 'Item Brand', 'required|trim');
        $this->form_validation->set_rules('item_type', 'Item Type', 'required|trim');
        $this->form_validation->set_rules('item_amount', 'Item Amount', 'required|trim|greater_than[0]|numeric');

        if (!$this->form_validation->run()) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/inventory/inventory', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $addItem = [
                'shop_id' => $this->input->post('shop_id'),
                'item_barcode' => htmlspecialchars($this->input->post('item_barcode', true)),
                'item_name' => $this->input->post('item_name'),
                'item_brand' => $this->input->post('item_brand'),
                'item_type' => $this->input->post('item_type'),
                'item_amount' => $this->input->post('item_amount')
            ];
            // Insert our user data to the user table.
            $this->db->insert('inventory', $addItem);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New item added.</div>');
            redirect('kantor/inventory');
        }
    }

    public function editinventory($item_id = null)
    {
        $data = $this->data;
        $data['title'] = "Edit Item";
        if (isset($item_id)) {
            $query = "SELECT inventory.id AS item_id, user.name AS shop_name, shop_id AS shopid, item_barcode, item_name, item_brand, item_type, item_amount FROM `inventory` JOIN user ON user.id = shop_id WHERE inventory.id = " . $item_id;
            $item_data = $this->db->query($query)->row_array();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('kantor/inventory/editinventory', $item_data);
            $this->load->view('templates/footer', $data);
        }
    }

    public function saveinventory($item_id = null)
    {
        if (isset($item_id)) {
            $editItem = [
                'shop_id' => $this->input->post('shop_id'),
                'item_barcode' => htmlspecialchars($this->input->post('item_barcode', true)),
                'item_name' => $this->input->post('item_name'),
                'item_brand' => $this->input->post('item_brand'),
                'item_type' => $this->input->post('item_type'),
                'item_amount' => $this->input->post('item_amount')
            ];
            $this->db->where('id', $item_id);
            $this->db->update('inventory', $editItem);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item edited.</div>');
            redirect('kantor/inventory');
        }
    }

    public function deleteinventory($item_id = null)
    {
        if (isset($item_id)) {
            $this->db->where('id', $item_id);
            $this->db->delete('inventory');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item deleted.</div>');
            redirect('kantor/inventory');
        }
    }
}

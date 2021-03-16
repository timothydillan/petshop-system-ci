<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Model
{
    function numberToRomanRepresentation($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    function getGroomingIncome($date, $id = NULL)
    {
        if (isset($id)) {
            $groomIncome = 0;
            $this->db->select('price');
            $this->db->from('grooming');
            $this->db->where("created_at >= '" . $date . "'");
            $this->db->where("shop_id = " . $id);
            foreach ($this->db->get()->result_array() as $price) {
                $groomIncome += $price['price'];
            }
        } else {
            $groomIncome = 0;
            $this->db->select('price');
            $this->db->from('grooming');
            $this->db->where("created_at >= '" . $date . "'");
            foreach ($this->db->get()->result_array() as $price) {
                $groomIncome += $price['price'];
            }
        }
        return $groomIncome;
    }

    function getGroomingEarnings($month, $id = NULL)
    {
        if (isset($id)) {
            $groomEarning = 0;
            $this->db->select('price');
            $this->db->from('grooming');
            $this->db->where("created_at >= '" . date("Y-m-d H:i:s", strtotime("1st " . $month)) . "'");
            $this->db->where("created_at <= '" . date('Y-m-d H:i:s', strtotime('+1 month', strtotime('1st ' . $month))) . "'");
            $this->db->where("shop_id = " . $id);
            foreach ($this->db->get()->result_array() as $price) {
                $groomEarning += $price['price'];
            }
        } else {
            $groomEarning = 0;
            $this->db->select('price');
            $this->db->from('grooming');
            $this->db->where("created_at >= '" . date("Y-m-d H:i:s", strtotime("1st " . $month)) . "'");
            $this->db->where("created_at <= '" . date('Y-m-d H:i:s', strtotime('+1 month', strtotime('1st ' . $month))) . "'");
            foreach ($this->db->get()->result_array() as $price) {
                $groomEarning += $price['price'];
            }
        }
        return $groomEarning;
    }

    public function getMenu()
    {
        $role_id = $this->session->userdata('role_id');
        $queryMenu = "SELECT `menu`.`id`, `menu` FROM `menu` 
        JOIN `menu_access` ON `menu`.`id` = `menu_access`.`menu_id` 
        WHERE `menu_access`.`role_id` = $role_id 
        ORDER BY menu_access.`menu_id` ASC;";

        return $this->db->query($queryMenu)->result_array();
    }

    public function getSubMenu()
    {
        $querySubMenu = "SELECT * FROM `sub_menu` 
        JOIN `menu` ON `sub_menu`.`menu_id` = `menu`.`id` 
        WHERE `sub_menu`.`menu_id` = `menu`.`id`;";

        return $this->db->query($querySubMenu)->result_array();
    }
}

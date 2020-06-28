<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {

	public function index()
	{
        $data['title'] = "Dashboard";

        $data['maincontent'] = $this->load->view('reports/dashboard', '', true);
        $this->load->view('reports/master', $data);
	}

    public function orderProgressReport(){
        $data['title'] = "Order Progress";

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");
        $data['orders'] = $this->Access_model->selectData('tb_order', '*', "");

        $data['maincontent'] = $this->load->view('reports/order_progress', $data, true);
        $this->load->view('reports/master', $data);
    }

    public function getOrderProgressFilterList(){
        $order_code = $this->input->post('order_code');
        $brands = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

//        if($brands_array != NULL){
//            $brands = implode("', '", $brands_array);
//        }

        $where = '';

        if($order_code != ''){
            $where .= " AND order_code='$order_code'";
        }

        if($brands != ''){
            $where .= " AND brand='$brands'";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        $data['orders'] = $this->Access_model->getOrderProgressFilterList($where);

        $data['maincontent'] = $this->load->view('reports/order_progress_filter_list', $data);
    }

}

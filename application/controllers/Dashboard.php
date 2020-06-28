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

    public function getStyles(){
        $brands = $this->input->post('brands');

//        if($brands_array != NULL){
//            $brands = implode("', '", $brands_array);
//        }

        $where='';

        if($brands != ""){
            $where .= " AND brand='$brands' GROUP BY style_no, style_name";
        }

        $styles = $this->Access_model->selectData('tb_order', '*', $where);

        $style_options = '<option value="">Style</option>';

        foreach($styles AS $v){
            $style_options .= '<option value="'.$v['style_name'].'">'.$v['style_name'].'</option>';
        }

        echo $style_options;
    }

    public function getOrderProgressFilterList(){
        $style = $this->input->post('style');
        $brands = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

//        if($brands_array != NULL){
//            $brands = implode("', '", $brands_array);
//        }

        $where = '';

        if($style != ''){
            $where .= " AND style_name='$style'";
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

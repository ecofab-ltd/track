<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Access extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('user_agent');
        $this->load->library('excel');

        $agent = $this->agent->browser();

        if($agent != 'Chrome'){
            echo "<span style='color: red; background-color: yellow; font-size: 30px;'>Please Use Google Chrome Browser!</span>";
            die();
        }

        $user_id = $this->session->userdata('id');
        $user_name = $this->session->userdata('username');
        $access_level = $this->session->userdata('access_level');

        if ($user_id == NULL && $user_id == 0 && $user_id == '' && $user_name == NULL && $user_name == 0 && $user_name == '' && $access_level == 0 && $access_level == '' && $access_level == NULL) {
            redirect('Welcome', 'refresh');
        }
        $this->method_call = &get_instance();

    }

	public function index()
	{
        $data['title'] = 'Dashboard';
        $user_id = $this->session->userdata('id');
        $floor_id = $this->session->userdata('floor_id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['maincontent'] = $this->load->view('dashboard', $data, true);
        $this->load->view('master', $data);
	}

	public function userList(){
        $data['title'] = 'Users';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['users'] = $this->Access_model->selectData('tb_user', '*', '');

        $data['maincontent'] = $this->load->view('users', $data, true);
        $this->load->view('master', $data);
    }

    public function getUnit($unit_id){
        return $this->Access_model->selectData('tb_unit', '*', " AND id=$unit_id");
    }

    public function getFloor($floor_id){
        return $this->Access_model->selectData('tb_unit', '*', " AND id=$floor_id");
    }

    public function getUnitFloor(){
        $unit = $this->input->post('unit');
        $res_floor = $this->Access_model->selectData('tb_unit', '*', " AND unit_id=$unit AND floor_id=0 AND status=1");

        $select_option = '<option value="">Select Floor</option>';

        foreach($res_floor AS $v){
            $select_option .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
        }

        echo $select_option;
    }

	public function brandList(){
        $data['title'] = 'Brands';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', '');

        $data['maincontent'] = $this->load->view('brands', $data, true);
        $this->load->view('master', $data);
    }

    public function editBrand($id){
        $data['title'] = 'Brands';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND id=$id");

        $data['maincontent'] = $this->load->view('edit_brand', $data, true);
        $this->load->view('master', $data);
    }

    public function updateBrand(){
        $brand_id = $this->input->post('brand_id');
        $brand = $this->input->post('brand');
        $status = $this->input->post('status');

        $fields = " brand='$brand', status=$status";
        $where = " AND id=$brand_id";

        $this->Access_model->updateData('tb_brand', $fields, $where);

        $data['message'] = "Successfully Updated!";
        $this->session->set_userdata($data);
        redirect('Access/brandList', 'refresh');
    }

    public function addNewUser(){
        $data['title'] = 'New User';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', ' AND status=1');

        $data['maincontent'] = $this->load->view('new_user', $data, true);
        $this->load->view('master', $data);
    }

    public function orderCutProgress(){
        $data['title'] = 'Cutting Progress';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');
        $unit_id = $this->session->userdata('unit_id');

        $data['orders'] = $this->Access_model->selectData('tb_order', 'order_code', " AND unit_id=$unit_id GROUP BY order_code");
        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', ' AND status=1');

        $data['maincontent'] = $this->load->view('order_cut_progress', $data, true);
        $this->load->view('master', $data);
    }

    public function getRequiredFields(){
        $access_level = $this->input->post('access_level');

        if($access_level == 0){
            $data['maincontent'] = $this->load->view('administrator_fields');
        }

        if($access_level == 1){
            $data['units'] = $this->Access_model->selectData('tb_unit', '*', ' AND status=1 AND unit_id=0');

            $data['maincontent'] = $this->load->view('planner_fields', $data);
        }

        if($access_level == 2){
            $data['units'] = $this->Access_model->selectData('tb_unit', '*', ' AND status=1 AND unit_id=0');

            $data['maincontent'] = $this->load->view('sd_fields', $data);
        }

        if($access_level == 3){
            $data['units'] = $this->Access_model->selectData('tb_unit', '*', ' AND status=1 AND unit_id=0');

            $data['maincontent'] = $this->load->view('floor_planner_fields', $data);
        }

        if($access_level == 4){
            $data['units'] = $this->Access_model->selectData('tb_unit', '*', ' AND status=1 AND unit_id=0');

            $data['maincontent'] = $this->load->view('cutting_mis_fields', $data);
        }

        if($access_level == 5){
            $data['units'] = $this->Access_model->selectData('tb_unit', '*', ' AND status=1 AND unit_id=0');

            $data['maincontent'] = $this->load->view('floor_mis_fields', $data);
        }
    }

    public function saveNewUser(){
        $access_level = $this->input->post('access_level');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $unit = $this->input->post('unit');
        $floor = $this->input->post('floor');
        $brands = $this->input->post('brand');
        $status = $this->input->post('status');

        if($access_level != ''){
            $data['access_level'] = $access_level;
        }

        if($username != ''){
            $data['username'] = $username;
        }

        if($password != ''){
            $data['password'] = $password;
        }

        if($unit != ''){
            $data['unit_id'] = $unit;
        }

        if($floor != ''){
            $data['floor_id'] = $floor;
        }

        if($status != ''){
            $data['status'] = $status;
        }

        $insert_id = $this->Access_model->insertData('tb_user', $data);

        if ($insert_id > 0){
            if(sizeof($brands) > 0){
                foreach($brands as $v){
                    $data_1 = array(
                        'user_id' => $insert_id,
                        'brand_id' => $v
                    );
                    $this->Access_model->insertData('tb_user_brand_assign', $data_1);
                }
            }
        }


        $data['message'] = "User Creation Successful!";
        $this->session->set_userdata($data);
        redirect('Access/addNewUser', 'refresh');
    }

    public function editUser($id, $access_level){
        $data['title'] = 'Edit Brand';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['user_id'] = $id;

        $where = '';

        if($id != ''){
            $where .= " AND id=$id";
        }

        $data['user_info'] = $this->Access_model->selectData('tb_user', '*', $where);
        $data['units'] = $this->Access_model->selectData('tb_unit', '*', ' AND status=1 AND unit_id=0');
        $user_unit = $data['user_info'];
        $unit = $user_unit[0]['unit_id'];
        $data['floors'] = $this->Access_model->selectData('tb_unit', '*', " AND unit_id=$unit AND floor_id=0 AND status=1");
        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', ' AND status=1');
        $data['user_brands'] = $this->Access_model->selectData('tb_user_brand_assign', 'brand_id', " AND user_id=$id");

        if($access_level == 0){
            $data['maincontent'] = $this->load->view('edit_administrator', $data, true);
        }

        if($access_level == 1){
            $data['maincontent'] = $this->load->view('edit_planner', $data, true);
        }

        if($access_level == 2){
            $data['maincontent'] = $this->load->view('edit_sd', $data, true);
        }

        if($access_level == 3){
            $data['maincontent'] = $this->load->view('edit_floor_planner', $data, true);
        }

        $this->load->view('master', $data);
    }

    public function updateUser(){
        $access_level = $this->input->post('access_level');
        $user_id = $this->input->post('user_id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $unit = $this->input->post('unit');
        $floor = $this->input->post('floor');
        $brands = $this->input->post('brand');
        $status = $this->input->post('status');

        $where = '';
        $fields_update = '';

        if(isset($user_id)){
            $where .= " AND id=$user_id";
        }

        if($access_level == 0){

            $fields_update = " password='$password', status=$status";

        }

        if($access_level == 1){

            $fields_update = " password='$password', unit_id=$unit, status=$status";

        }

        if($access_level == 2){

            $fields_update = " password='$password', status=$status";

            $is_del_complete = $this->Access_model->deleteData('tb_user_brand_assign', 'user_id', $user_id);

            if($is_del_complete == 1){

                foreach($brands as $b){

                    $data=array(
                        'user_id' => $user_id,
                        'brand_id' => $b
                    );

                    $this->Access_model->insertData('tb_user_brand_assign', $data);

                }

            }

        }

        if($access_level == 3){

            $fields_update = " password='$password', unit_id=$unit, floor_id=$floor, status=$status";

        }

        $this->Access_model->updateData('tb_user', $fields_update, $where);

        $data['message'] = "$username Successfully Updated!";
        $this->session->set_userdata($data);
        redirect('Access/userList', 'refresh');
    }

    public function addNewBrand(){
        $data['title'] = 'New Brand';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['maincontent'] = $this->load->view('new_brand', $data, true);
        $this->load->view('master', $data);
    }

    public function saveNewBrand(){
        $data['brand'] = $this->input->post('brand');
        $data['status'] = $this->input->post('status');

        $this->Access_model->insertData('tb_brand', $data);

        $data['message'] = "Successfully Saved!";
        $this->session->set_userdata($data);
        redirect('Access/addNewBrand', 'refresh');
    }

    public function changeBrandStatus($id, $status){
        $fields_update = " status=$status";
        $where = " AND id=$id";

        $data['brands'] = $this->Access_model->updateData('tb_brand', $fields_update, $where);

        redirect('Access/brandList', 'refresh');
    }

    public function changeUserStatus($id, $status){
        $fields_update = " status=$status";
        $where = " AND id=$id";

        $data['brands'] = $this->Access_model->updateData('tb_user', $fields_update, $where);

        redirect('Access/userList', 'refresh');
    }

    public function isBrandAlreadyExist(){
        $brand = $this->input->post('brand');

        $res = $this->Access_model->selectData('tb_brand', '*', " AND brand='$brand'");

        echo json_encode($res);
    }

    public function isUserAlreadyExist(){
        $username = $this->input->post('username');

        $res = $this->Access_model->selectData('tb_user', '*', " AND username='$username'");

        echo json_encode($res);
    }

    public function orderFloorAssign(){
        $data['title'] = 'Floor Assign';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');
        $unit_id = $this->session->userdata('unit_id');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");

        $data['maincontent'] = $this->load->view('order_floor_assign', $data, true);
        $this->load->view('master', $data);
    }

    public function orderLineAssign(){
        $data['title'] = 'Line Assign';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");
        $data['lines'] = $this->Access_model->selectData('tb_unit', '*', " AND status=1 AND unit_id=$unit_id AND floor_id=$floor_id");

        $data['maincontent'] = $this->load->view('order_line_assign', $data, true);
        $this->load->view('master', $data);
    }

    public function orderFinishingProgress(){
        $data['title'] = 'Finishing Progress';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");

        $where='';
        $where_1='';

        if($unit_id != "" && $unit_id != 0){
            $where .= " AND unit_id = $unit_id";
        }

        if($floor_id != "" && $floor_id != 0){
            $where_1 .= " AND floor_id = $floor_id";
        }

        $data['orders'] = $this->Access_model->getOrderFloorPlanInfo($where, $where_1);
        $data['maincontent'] = $this->load->view('order_finishing_progress', $data, true);
        $this->load->view('master', $data);
    }

    public function orderLineProgress(){
        $data['title'] = 'Line Progress';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");

        $where='';
        $where_1='';

        if($unit_id != "" && $unit_id != 0){
            $where .= " AND unit_id = $unit_id";
        }

        if($floor_id != "" && $floor_id != 0){
            $where_1 .= " AND floor_id = $floor_id";
        }

        $data['orders'] = $this->Access_model->getOrderFloorPlanInfo($where, $where_1);
        $data['maincontent'] = $this->load->view('order_line_progress', $data, true);
        $this->load->view('master', $data);
    }

    public function orderUnitAssign(){
        $data['title'] = 'Unit Assign';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");
        $data['units'] = $this->Access_model->selectData('tb_unit', '*', " AND status=1 AND unit_id=0");

        $data['maincontent'] = $this->load->view('order_unit_assign', $data, true);
        $this->load->view('master', $data);
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

    public function editPoInfo($order_code){
        $data['title'] = 'Edit Order';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['order_info'] = $this->Access_model->selectData('tb_order', '*', " AND order_code='$order_code'");

        $data['maincontent'] = $this->load->view('edit_order', $data, true);
        $this->load->view('master', $data);
    }

    public function updateOrderInfo(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');

        $order_code = $this->input->post('order_code');
        $brand = $this->input->post('brand');
        $unit_id = $this->input->post('unit_id');
        $upload_unit_id = $this->input->post('upload_unit_id');
        $purchase_order = $this->input->post('purchase_order');
        $item = $this->input->post('item');
        $quality = $this->input->post('quality');
        $color = $this->input->post('color');
        $style_no = $this->input->post('style_no');
        $style_name = $this->input->post('style_name');
        $description = $this->input->post('description');
        $ex_factory_date = $this->input->post('ex_factory_date');
        $previous_ex_factory_date = $this->input->post('previous_ex_factory_date');
        $fabric_in_house_date = $this->input->post('fabric_in_house_date');
        $accessories_in_house_date = $this->input->post('accessories_in_house_date');
        $pp_approval_date = $this->input->post('pp_approval_date');

        $ids = $this->input->post('id');
        $sizes = $this->input->post('size');
        $quantities = $this->input->post('quantity');
        $previous_quantities = $this->input->post('previous_quantity');

        foreach($sizes AS $k => $v){
            $id = $ids[$k];
            $size = $v;
            $quantity = $quantities[$k];
            $previous_quantity = $previous_quantities[$k];

            $data['purchase_order'] = $purchase_order;
            $data['item'] = $item;
            $data['quality'] = $quality;
            $data['color'] = $color;
            $data['style_no'] = $style_no;
            $data['style_name'] = $style_name;
            $data['description'] = $description;

            $data['ex_factory_date'] = $ex_factory_date;

            if($ex_factory_date != $previous_ex_factory_date){
                $data['previous_ex_factory_date'] = $previous_ex_factory_date;
                $data['ex_factory_date_changed_by'] = $user_id;
            }

            $data['fabric_in_house_date'] = $fabric_in_house_date;
            $data['accessories_in_house_date'] = $accessories_in_house_date;
            $data['pp_approval_date'] = $pp_approval_date;

            $data['size'] = $size;
            $data['quantity'] = $quantity;

            if($quantity != $previous_quantity){
                $data['previous_quantity'] = ($previous_quantity != '' ? $previous_quantity : 0);
                $data['quantity_changed_by'] = $user_id;
            }

            if($id != ''){
                $data['update_date'] = $date;
                $data['updated_by'] = $user_id;

                $this->Access_model->updateDataActiveRecord('tb_order', 'id', $id, $data);
            }else{
                $data['order_code'] = $order_code;
                $data['brand'] = $brand;
                $data['upload_date'] = $date;
                $data['upload_by'] = $user_id;
                $data['unit_id'] = $unit_id;
                $data['upload_unit_id'] = $upload_unit_id;

                $this->Access_model->insertData('tb_order', $data);
            }

        }

        redirect('Access/editPoInfo/'.$order_code);

    }

    public function orderList(){
        $data['title'] = 'Order List';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        if($data['access_level'] != 2){
            $data['brands'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");
        }else{
            $data['brands'] = $this->getAuthorizedBrands($user_id);
        }

        $data['maincontent'] = $this->load->view('order_list', $data, true);
        $this->load->view('master', $data);
    }

    public function getOrderList(){
        $data['access_level'] = $this->session->userdata('access_level');

        $style = $this->input->post('style');
        $brands = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

//        if($brands_array != NULL){
//            $brands = implode("', '", $brands_array);
//        }

        $where='';

        if($style != ""){
            $where .= " AND style_name='$style'";
        }

        if($brands != ""){
            $where .= " AND brand='$brands'";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        $data['orders'] = $this->Access_model->getOrderInfo($where);

        $this->load->view('order_filter_list', $data);
    }

    public function getOrderFloorAssignFilterList(){
        $unit_id = $this->session->userdata('unit_id');

        $brands_array = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        if($brands_array != NULL){
            $brands = implode(", ", $brands_array);
        }

        $where='';

        if($brands != ""){
            $where .= " AND brand IN ($brands)";
        }

        if($unit_id != "" && $unit_id != 0){
            $where .= " AND unit_id = $unit_id";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        $data['orders'] = $this->Access_model->getOrderInfo($where);

        $data['floors'] = $this->Access_model->selectData('tb_unit', '*', " AND status=1 AND unit_id=$unit_id AND floor_id=0");

        $this->load->view('order_floor_assign_filter_list', $data);
    }

    public function getOrderFinishingProgressFilterList(){
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $order_code = $this->input->post('order_code');
        $brands_array = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $operation_date = $this->input->post('operation_date');

        $data['operation_date'] = $operation_date;

        $brands = '';

        if(sizeof($brands_array) > 0){
            $brands = implode(", ", $brands_array);
        }

        $where='';
        $where_1='';

        if($brands != ""){
            $where .= " AND brand IN ($brands)";
        }

        if($order_code != ""){
            $where .= " AND order_code = '$order_code'";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        if($floor_id != "" && $floor_id != 0){
            $where_1 .= " AND floor_id = $floor_id";
        }

        $data['orders'] = $this->Access_model->getOrderFloorPlanOutputInfo($where, $where_1);

        $this->load->view('order_finishing_progress_filter_list', $data);
    }

    public function orderFloorOutputSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $operation_date = $this->input->post('operation_date');
        $order_code = $this->input->post('order_code');
        $wash_send = $this->input->post('wash_send');
        $wash_rcv = $this->input->post('wash_rcv');
        $emb_send = $this->input->post('emb_send');
        $emb_rcv = $this->input->post('emb_rcv');
        $print_send = $this->input->post('print_send');
        $print_rcv = $this->input->post('print_rcv');
        $poly_qty = $this->input->post('poly_qty');
        $carton_qty = $this->input->post('carton_qty');
        $ship_qty = $this->input->post('ship_qty');

        $fields = '';
        $fields_1 = '';
        $where = '';
        $where_1 = '';

        foreach ($order_code as $k => $v){

            $res = $this->Access_model->getOrderFloorDailyOutputReport($order_code[$k], $operation_date, $floor_id);

            if(sizeof($res) == 0){
                $data = array(
                    'order_code' => $order_code[$k],
                    'operation_date' => $operation_date,
                    'entry_date' => $date,
                    'unit_id' => $unit_id,
                    'floor_id' => $floor_id,
                    'wash_send_qty' => $wash_send[$k],
                    'wash_receive_qty' => $wash_rcv[$k],
                    'embroidery_send_qty' => $emb_send[$k],
                    'embroidery_receive_qty' => $emb_rcv[$k],
                    'print_send_qty' => $print_send[$k],
                    'print_receive_qty' => $print_rcv[$k],
                    'poly_qty' => $poly_qty[$k],
                    'carton_qty' => $carton_qty[$k],
                    'ship_qty' => $ship_qty[$k],
                    'inserted_by' => $user_id
                );

                $this->Access_model->insertData('tb_daily_finishing', $data);
            }

            if(sizeof($res) > 0){
                $data = array(
                    'order_code' => $order_code[$k],
                    'operation_date' => $operation_date,
                    'entry_date' => $date,
                    'unit_id' => $unit_id,
                    'floor_id' => $floor_id,
                    'wash_send_qty' => ($wash_send[$k] != '' ? $wash_send[$k] : 0),
                    'wash_receive_qty' => ($wash_rcv[$k] != '' ? $wash_rcv[$k] : 0),
                    'embroidery_send_qty' => ($emb_send[$k] != '' ? $emb_send[$k] : 0),
                    'embroidery_receive_qty' => ($emb_rcv[$k] != '' ? $emb_rcv[$k] : 0),
                    'print_send_qty' => ($print_send[$k] != '' ? $print_send[$k] : 0),
                    'print_receive_qty' => ($print_rcv[$k] != '' ? $print_rcv[$k] : 0),
                    'poly_qty' => ($poly_qty[$k] != '' ? $poly_qty[$k] : 0),
                    'carton_qty' => ($carton_qty[$k] != '' ? $carton_qty[$k] : 0),
                    'ship_qty' => ($ship_qty[$k] != '' ? $ship_qty[$k] : 0),
                    'inserted_by' => $user_id
                );

                $fields = " wash_send_qty=$wash_send[$k], wash_receive_qty=$wash_rcv[$k], embroidery_send_qty=$emb_send[$k], embroidery_receive_qty=$emb_rcv[$k], print_send_qty=$print_send[$k], print_receive_qty=$print_rcv[$k], poly_qty=$poly_qty[$k], carton_qty=$carton_qty[$k], ship_qty=$ship_qty[$k]";

                $where = " AND order_code = '$order_code[$k]' AND operation_date='$operation_date' AND floor_id='$floor_id'";

                $this->Access_model->updateData('tb_daily_finishing', $fields, $where);
            }

            if($order_code[$k] != ''){
                $fields_1 = " order_code, SUM(wash_send_qty) AS total_wash_send_qty, SUM(wash_receive_qty) AS total_wash_receive_qty, 
                SUM(embroidery_send_qty) AS total_embroidery_send_qty, SUM(embroidery_receive_qty) AS total_embroidery_receive_qty, 
                SUM(print_send_qty) AS total_print_send_qty, SUM(print_receive_qty) AS total_print_receive_qty, 
                SUM(poly_qty) AS total_poly_qty, SUM(carton_qty) AS total_carton_qty, SUM(ship_qty) AS total_ship_qty ";

                $where_1 = " AND order_code='$order_code[$k]' GROUP BY order_code";
            }

            $order_floor_summary = $this->Access_model->selectData('tb_daily_finishing', $fields_1, $where_1);

            $data_1['poly_qty'] = ($order_floor_summary[0]['total_poly_qty'] != '' ? $order_floor_summary[0]['total_poly_qty'] : 0);
            $data_1['carton_qty'] = ($order_floor_summary[0]['total_carton_qty'] != '' ? $order_floor_summary[0]['total_carton_qty'] : 0);
            $data_1['wash_send_qty'] = ($order_floor_summary[0]['total_wash_send_qty'] != '' ? $order_floor_summary[0]['total_wash_send_qty'] : 0);
            $data_1['wash_receive_qty'] = ($order_floor_summary[0]['total_wash_receive_qty'] != '' ? $order_floor_summary[0]['total_wash_receive_qty'] : 0);
            $data_1['embroidery_send_qty'] = ($order_floor_summary[0]['total_embroidery_send_qty'] != '' ? $order_floor_summary[0]['total_embroidery_send_qty'] : 0);
            $data_1['embroidery_receive_qty'] = ($order_floor_summary[0]['total_embroidery_receive_qty'] != '' ? $order_floor_summary[0]['total_embroidery_receive_qty'] : 0);
            $data_1['print_send_qty'] = ($order_floor_summary[0]['total_print_send_qty'] != '' ? $order_floor_summary[0]['total_print_send_qty'] : 0);
            $data_1['print_receive_qty'] = ($order_floor_summary[0]['total_print_receive_qty'] != '' ? $order_floor_summary[0]['total_print_receive_qty'] : 0);
            $data_1['ship_qty'] = ($order_floor_summary[0]['total_ship_qty'] != '' ? $order_floor_summary[0]['total_ship_qty'] : 0);

            $this->Access_model->updateDataActiveRecord('tb_order_summary', 'order_code', $order_code[$k], $data_1);

        }

        $data['message'] = "Successfully Updated";
        $this->session->set_userdata($data);
        redirect('Access/orderFinishingProgress', 'refresh');
    }

    public function getOrderLineAssignFilterList(){
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $brands_array = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $brands = '';

        if(sizeof($brands_array) > 0){
            $brands = implode(", ", $brands_array);
        }

        $where='';
        $where_1='';

        if($brands != ""){
            $where .= " AND brand IN ($brands)";
        }

        if($unit_id != "" && $unit_id != 0){
            $where .= " AND unit_id = $unit_id";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        if($floor_id != "" && $floor_id != 0){
            $where_1 .= " AND floor_id = $floor_id";
        }

        $data['orders'] = $this->Access_model->getOrderFloorPlanInfo($where, $where_1);

        $data['lines'] = $this->Access_model->selectData('tb_unit', '*', " AND status=1 AND unit_id=$unit_id AND floor_id=$floor_id");

        $this->load->view('order_line_assign_filter_list', $data);
    }

    public function getOrderLineProgressFilterList(){
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $order_code = $this->input->post('order_code');
        $brands_array = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $operation_date = $this->input->post('operation_date');

        $data['operation_date'] = $operation_date;

        $brands = '';

        if(sizeof($brands_array) > 0){
            $brands = implode(", ", $brands_array);
        }

        $where='';
        $where_1='';

        if($brands != ""){
            $where .= " AND brand IN ($brands)";
        }

        if($order_code != ""){
            $where .= " AND order_code = '$order_code'";
        }

        if($unit_id != "" && $unit_id != 0){
            $where .= " AND unit_id = $unit_id";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        if($floor_id != "" && $floor_id != 0){
            $where_1 .= " AND floor_id = $floor_id";
        }

        $data['orders'] = $this->Access_model->getOrderFloorPlanInfo($where, $where_1);

        $data['lines'] = $this->Access_model->selectData('tb_unit', '*', " AND status=1 AND unit_id=$unit_id AND floor_id=$floor_id");

        $this->load->view('order_line_progress_filter_list', $data);
    }

    public function getOrderCutProgressFilterList(){
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $order_code = $this->input->post('order_code');
        $brands_array = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $brands = '';

        if(sizeof($brands_array) > 0){
            $brands = implode(", ", $brands_array);
        }

        $where='';
        $where_1='';

        if($brands != ""){
            $where .= " AND brand IN ($brands)";
        }

        if($order_code != ""){
            $where .= " AND order_code = '$order_code'";
        }

        if($unit_id != "" && $unit_id != 0){
            $where .= " AND unit_id = $unit_id";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        if($floor_id != "" && $floor_id != 0){
            $where_1 .= " AND floor_id = $floor_id";
        }

        $data['orders'] = $this->Access_model->getOrderInfo($where);

        $data['lines'] = $this->Access_model->selectData('tb_unit', '*', " AND status=1 AND unit_id=$unit_id AND floor_id=$floor_id");

        $this->load->view('order_cut_progress_filter_list', $data);
    }

    public function orderCutProgressSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');

        $order_codes = $this->input->post('order_code');
        $operation_date = $this->input->post('operation_date');
        $size_set_cut_qtys = $this->input->post('size_set_cut_qty');
        $trial_qty_cut_qtys = $this->input->post('trial_qty_cut_qty');
        $bulk_cut_qtys = $this->input->post('bulk_cut_qty');
        $package_ready_qtys = $this->input->post('package_ready_qty');

        $total_cut_qty = 0;
        $total_package_ready_qty = 0;

        foreach($order_codes AS $k => $v){

            $size_set_cut_qty = ($size_set_cut_qtys[$k] != '' ? $size_set_cut_qtys[$k] : 0);
            $trial_qty_cut_qty = ($trial_qty_cut_qtys[$k] != '' ? $trial_qty_cut_qtys[$k] : 0);
            $bulk_cut_qty = ($bulk_cut_qtys[$k] != '' ? $bulk_cut_qtys[$k] : 0);
            $package_ready_qty = ($package_ready_qtys[$k] != '' ? $package_ready_qtys[$k] : 0);

            if($size_set_cut_qty > 0  || $trial_qty_cut_qty > 0 || $bulk_cut_qty > 0 || $package_ready_qty > 0){

                $res = $this->Access_model->getOrderCutOperationDateReport($v, $operation_date);

                if(sizeof($res) > 0){

                    $this->Access_model->deleteData2('tb_daily_cut', 'order_code', $v, 'operation_date', $operation_date);

                    $data = array(
                        'order_code' => $v,
                        'operation_date' => $operation_date,
                        'entry_date' => $date,
                        'size_set_cut_qty' => $size_set_cut_qty,
                        'trial_cut_qty' => $trial_qty_cut_qty,
                        'bulk_cut_qty' => $bulk_cut_qty,
                        'package_ready_qty' => $package_ready_qty,
                        'inserted_by' => $user_id
                    );

                    $this->Access_model->insertData('tb_daily_cut', $data);

                }else{
                    $data = array(
                        'order_code' => $v,
                        'operation_date' => $operation_date,
                        'entry_date' => $date,
                        'size_set_cut_qty' => $size_set_cut_qty,
                        'trial_cut_qty' => $trial_qty_cut_qty,
                        'bulk_cut_qty' => $bulk_cut_qty,
                        'package_ready_qty' => $package_ready_qty,
                        'inserted_by' => $user_id
                    );

                    $this->Access_model->insertData('tb_daily_cut', $data);
                }

                $res_2 = $this->Access_model->selectData('tb_daily_cut', 'order_code, SUM(size_set_cut_qty) AS total_size_set_cut_qty, SUM(trial_cut_qty) AS total_trial_cut_qty, SUM(bulk_cut_qty) AS total_bulk_cut_qty, SUM(package_ready_qty) AS total_package_ready_qty', " AND order_code='$v' GROUP BY order_code");

                foreach ($res_2 AS $v_2){
                    $total_cut_qty = $v_2['total_size_set_cut_qty']+$v_2['total_trial_cut_qty']+$v_2['total_bulk_cut_qty'];
                    $total_package_ready_qty = $v_2['total_package_ready_qty'];
                }

                $res_3 = $this->Access_model->selectData('tb_order_summary', '*', " AND order_code='$v'");

                if(sizeof($res_3) > 0){
                    $data_1['cut_qty'] = $total_cut_qty;
                    $data_1['package_ready_qty'] = $total_package_ready_qty;
                    $this->Access_model->updateDataActiveRecord('tb_order_summary', 'order_code', $v, $data_1);
                }else{
                    $data_1['order_code'] = $v;
                    $data_1['cut_qty'] = $total_cut_qty;
                    $data_1['package_ready_qty'] = $total_package_ready_qty;
                    $this->Access_model->insertData('tb_order_summary', $data_1);
                }

            }

        }

        $data['message'] = "Successfully Saved!";
        $this->session->set_userdata($data);
        redirect('Access/orderCutProgress', 'refresh');
    }

    public function getOrderUnitFloorPlan($order_code){
        return $res = $this->Access_model->getOrderUnitFloorPlan($order_code);
    }

    public function getOrderUnitLinePlan($order_code, $unit_id, $floor_id){
        return $res = $this->Access_model->getOrderUnitLinePlan($order_code, $unit_id, $floor_id);
    }

    public function getOrderUnitLinePlanOutput($order_code, $unit_id, $floor_id){
        return $res = $this->Access_model->getOrderUnitLinePlanOutput($order_code, $unit_id, $floor_id);
    }

    public function getOrderUnitLinePlanOutputByOperationDate($order_code, $unit_id, $floor_id, $operation_date){
        return $res = $this->Access_model->getOrderUnitLinePlanOutputByOperationDate($order_code, $unit_id, $floor_id, $operation_date);
    }

    public function getOrderUnitAssignFilterList(){
        $brands_array = $this->input->post('brands');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        if($brands_array != NULL){
            $brands = implode(", ", $brands_array);
        }

        $where='';

        if($brands != ""){
            $where .= " AND brand IN ($brands)";
        }

        if($from_date != '' && $to_date != ''){
            $where .= " AND ex_factory_date BETWEEN '$from_date' AND '$to_date'";
        }

        $data['orders'] = $this->Access_model->getOrderInfo($where);

        $this->load->view('order_unit_assign_filter_list', $data);
    }

    public function orderAssignUnitSave(){
        $unit = $this->input->post('unit');
        $order_codes = $this->input->post('select_order');

        foreach($order_codes as $v){
            $data = array(
                'unit_id' => $unit
            );

            $this->Access_model->updateDataActiveRecord('tb_order', 'order_code', "$v", $data);
        }

        $data['message'] = "Successfully Unit Assigned!";
        $this->session->set_userdata($data);
        redirect('Access/orderUnitAssign', 'refresh');
    }

    public function orderAssignFloorSave(){
        $order_codes = $this->input->post('order_code');
        $floors = $this->input->post('floor');
        $floor_qtys = $this->input->post('floor_qty');


        foreach($order_codes as $k => $v){
            $data['order_code'] = $v;
            $floor_quantity = $floor_qtys[$k];
            $floor_id = $floors[$k];

            if($floor_quantity != '' && $floor_id != ''){
                $this->Access_model->deleteData('tb_floor_assign', 'order_code', $v);
            }
        }

        foreach($order_codes as $k1 => $v1){
            $data1['order_code'] = $v1;
            $data1['floor_quantity'] = $floor_qtys[$k1];
            $data1['unit_id'] = $this->session->userdata('unit_id');
            $data1['floor_id'] = $floors[$k1];

            if($data1['floor_quantity'] != '' && $data1['floor_id'] != ''){
                $this->Access_model->insertData('tb_floor_assign', $data1);
            }

        }

        redirect('Access/orderFloorAssign', 'refresh');

    }

    public function orderAssignLineSave(){
        $order_codes = $this->input->post('order_code');
        $lines = $this->input->post('line');
        $line_qtys = $this->input->post('line_qty');
        $floor_id = $this->session->userdata('floor_id');

        foreach($order_codes as $k => $v){
            $data['order_code'] = $v;
            $line_quantity = $line_qtys[$k];
            $line_id = $lines[$k];

            if($line_quantity != '' && $line_id != ''){
                $this->Access_model->deleteData2('tb_line_assign', 'order_code', $v, 'floor_id', $floor_id);
            }
        }

        foreach($order_codes as $k1 => $v1){
            $data1['order_code'] = $v1;
            $data1['line_quantity'] = $line_qtys[$k1];
            $data1['unit_id'] = $this->session->userdata('unit_id');
            $data1['floor_id'] = $floor_id;
            $data1['line_id'] = $lines[$k1];

            if($data1['line_quantity'] != '' && $data1['line_id'] != ''){
                $this->Access_model->insertData('tb_line_assign', $data1);
            }

        }

        redirect('Access/orderLineAssign', 'refresh');
    }

    public function orderLineOutputSave(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $user_id = $this->session->userdata('id');
        $unit_id = $this->session->userdata('unit_id');
        $floor_id = $this->session->userdata('floor_id');

        $operation_date = $this->input->post('operation_date');
        $order_code = $this->input->post('order_code');
        $line_id = $this->input->post('line_id');
        $line_input = $this->input->post('line_input');
        $line_output = $this->input->post('line_output');

        $fields = '';
        $fields_1 = '';
        $where = '';
        $where_1 = '';

        foreach ($line_id AS $k => $v){

            $res = $this->Access_model->checkOperationDateLineSewEntry($operation_date, $line_id[$k], $order_code[$k]);

            if(sizeof($res) == 0){

                if(($line_input[$k] != '' && $line_input[$k] != 0) || ($line_output[$k] != '' && $line_output[$k] != 0)){

                    $data = array(
                        'order_code' => $order_code[$k],
                        'operation_date' => $operation_date,
                        'entry_date' => $date,
                        'unit_id' => $unit_id,
                        'floor_id' => $floor_id,
                        'line_id' => $line_id[$k],
                        'line_input' => $line_input[$k],
                        'sew_qty' => $line_output[$k],
                        'inserted_by' => $user_id
                    );

                    $this->Access_model->insertData('tb_daily_sew', $data);
                }

            }

            if(sizeof($res) > 0){

                $fields = " line_input='$line_input[$k]', sew_qty='$line_output[$k]', inserted_by='$user_id'";
                $where = " AND order_code='$order_code[$k]' AND operation_date='$operation_date' AND line_id='$line_id[$k]'";

                $this->Access_model->updateData('tb_daily_sew', $fields, $where);
            }

            if($order_code[$k] != ''){
                $fields_1 = " order_code, SUM(line_input) AS total_line_input_qty, SUM(sew_qty) as total_line_sew_qty ";
                $where_1 = " AND order_code='$order_code[$k]' GROUP BY order_code";
            }

            $order_line_summary = $this->Access_model->selectData('tb_daily_sew', $fields_1, $where_1);
            $data_1['line_input_qty'] = $order_line_summary[0]['total_line_input_qty'];
            $data_1['line_output_qty'] = $order_line_summary[0]['total_line_sew_qty'];

            $this->Access_model->updateDataActiveRecord('tb_order_summary', 'order_code', $order_code[$k], $data_1);
        }

        $data['message'] = "Successfully Updated";
        $this->session->set_userdata($data);
        redirect('Access/orderLineProgress', 'refresh');
    }

    public function selectUnitToUploadOrder(){
        $data['title'] = 'Order Upload';
        $user_id = $this->session->userdata('id');
        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');

        $data['units'] = $this->Access_model->selectData('tb_unit', '*', " AND unit_id=0");

        $data['maincontent'] = $this->load->view('select_unit_to_upload_order', $data, true);
        $this->load->view('master', $data);
    }

	public function orderUpload($unit_id){
        $data['title'] = 'Order Upload';
        $user_id = $this->session->userdata('id');

        $data['username'] = $this->session->userdata('username');
        $data['access_level'] = $this->session->userdata('access_level');
        $data['unit_id'] = $unit_id;
        $data['user_id'] = $user_id;

        $username = $data['username'];

        $module_control_info_check = $this->Access_model->selectData('tb_order_module_control', '*', " AND unit_id = $unit_id AND user_id != $user_id");

        if(sizeof($module_control_info_check) > 0){
            $data['module_control_info'] = $module_control_info_check;

            $data['maincontent'] = $this->load->view('order_upload_user_list', $data, true);

        }else{

            $module_already_in_user_check = $this->Access_model->selectData('tb_order_module_control', '*', " AND unit_id = $unit_id AND user_id = $user_id");
            if(sizeof($module_already_in_user_check) == 0){
                $data_1 = array(
                    'unit_id' => $unit_id,
                    'user_id' => $user_id,
                    'username' => $username
                );

                $this->Access_model->insertData('tb_order_module_control', $data_1);
            }


            if($data['access_level'] != 2){
                $data['brand'] = $this->Access_model->selectData('tb_brand', '*', " AND status=1");
            }else{
                $data['brand'] = $this->getAuthorizedBrands($user_id);
            }

            $data['maincontent'] = $this->load->view('order_upload', $data, true);

        }

        $this->load->view('master', $data);
    }

    public function releaseUserFromOrderUpload($unit_id){
        $this->Access_model->releaseUserFromOrderUpload($unit_id);

        redirect('Access/selectUnitToUploadOrder');
    }

    public function getAuthorizedBrands($user_id){
	    return $this->Access_model->getAuthorizedBrands($user_id);
    }

//    public function uploadOrders(){
//        $brand = $this->input->post('brand');
//        $filename=$_FILES["file"]["tmp_name"];
//        $file_name_ext = $_FILES["file"]['name'];
//
//        if($file_name_ext== 'file_format.csv'){
//
//            if($_FILES["file"]["size"] > 0){
//                $file = fopen($filename, 'r');
//                fgetcsv($file);
//
//                while (!feof($file) ) {
//                    $line_of_text[] = fgetcsv($file);
//                }
//
//                $failed_list = "";
//
//                foreach ($line_of_text AS $k => $v){
//                    $order_code = $v[0];
//                    $purchase_order = $v[1];
//                    $item_destination = $v[2];
//                    $quality = $v[3];
//                    $color = $v[4];
//                    $style_no = $v[5];
//                    $style_name = $v[6];
//                    $description = $v[7];
//                    $size = $v[8];
//                    $quantity = $v[9];
//                    $ex_fac_date = $v[10];
//
//                    $where = "";
//
//                    if($order_code != '' && $purchase_order != '' && $item_destination != '' && $quality != '' && $color != '' && $style_no != '' && $style_name != '' && $brand != '' && $size != '' && $quantity != '' && $ex_fac_date != ''){
//
//                        $ex_factory_date = str_replace(".","-","$ex_fac_date");
//
//                        if(!empty($order_code))
//                        {
//                            $where .= " AND order_code='$order_code'";
//                        }
//
//                        if(!empty($size))
//                        {
//                            $where .= " AND size='$size'";
//                        }
//
//                        $res = $this->Access_model->selectData('tb_order', '*', $where);
//
//                        if(sizeof($res) == 0){
//                            $data = array(
//                                'order_code' => $order_code,
//                                'purchase_order' => $purchase_order,
//                                'item' => $item_destination,
//                                'quality' => $quality,
//                                'color' => $color,
//                                'style_no' => $style_no,
//                                'style_name' => $style_name,
//                                'description' => $description,
//                                'brand' => $brand,
//                                'size' => $size,
//                                'quantity' => $quantity,
//                                'ex_factory_date' => $ex_factory_date
//                            );
//
//                            $this->Access_model->insertData('tb_order', $data);
//                        }
//
//                    }else{
//                        if($order_code != ''){
//                            $failed_list .= $order_code.' Failed!<br />';
//                            $data['exception'] = $failed_list;
//                        }
//
//                    }
//                }
//
//                $data['message'] = "Upload Complete";
//                $this->session->set_userdata($data);
//                redirect('Access/orderUpload', 'refresh');
//            }
//        }else{
//            $data['exception'] = "Wrong File Format! Please Select the File: <span style='background-color: yellow; font-weight: 900'>file_format.csv</span>";
//            $this->session->set_userdata($data);
//
//            redirect('Access/orderUpload', 'refresh');
//        }
//
//    }

    public function uploadOrders(){
        $datex = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date_time=$datex->format('Y-m-d H:i:s');
        $date=$datex->format('Y-m-d');

        $brand = $this->input->post('brand');
        $unit_id = $this->input->post('unit_id');
        $user_id = $this->session->userdata('id');
        $path =$_FILES["file"]["tmp_name"];
        $file_name_ext = $_FILES["file"]['name'];

        if($file_name_ext== 'file_format.xls'){

            if($_FILES["file"]["size"] > 0) {

                $object = PHPExcel_IOFactory::load($path);
                foreach($object->getWorksheetIterator() as $worksheet)
                {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();

                    for($row=2; $row<=$highestRow; $row++)
                    {
                        $ex_fac_date = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $fabric_in_house_date = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $accessories_in_house_date = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $pp_approval_date = $worksheet->getCellByColumnAndRow(12, $row)->getValue();

                        $data[] = array(
                            'purchase_order' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                            'item' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                            'quality' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                            'color' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                            'style_no' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                            'style_name' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                            'description' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                            'brand' => $brand,
                            'size' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                            'quantity' => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                            'ex_factory_date' => date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($ex_fac_date)),
                            'fabric_in_house_date' => date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($fabric_in_house_date)),
                            'accessories_in_house_date' => date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($accessories_in_house_date)),
                            'pp_approval_date' => date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($pp_approval_date)),
                            'upload_date' => $date,
                            'upload_by' => $user_id,
                            'unit_id' => $unit_id,
                            'upload_unit_id' => $unit_id
                        );
                    }
                }

                $where = "";

//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';

                foreach ($data as $k => $v){

                    $res_last_order_code = $this->Access_model->selectData('tb_unit', '*', " AND id=$unit_id");
                    $unit_order_code_start_no =$res_last_order_code[0]['unit_order_code_start_no'];
                    $unit_order_code_max_no =$res_last_order_code[0]['unit_order_code_max_no'];

                    $purchase_order = $v['purchase_order'];
                    $item = $v['item'];
                    $quality = $v['quality'];
                    $color = $v['color'];
                    $style_no = $v['style_no'];
                    $style_name = $v['style_name'];
                    $description = $v['description'];
                    $brand = $v['brand'];
                    $size = $v['size'];
                    $quantity = $v['quantity'];
                    $ex_factory_date = $v['ex_factory_date'];

                    $where = "";

                    if($purchase_order != ''){
                        $where .= " AND purchase_order='$purchase_order'";
                    }

                    if($item != ''){
                        $where .= " AND item='$item'";
                    }

                    if($quality != ''){
                        $where .= " AND quality='$quality'";
                    }

                    if($color != ''){
                        $where .= " AND color='$color'";
                    }

                    if($style_no != ''){
                        $where .= " AND style_no='$style_no'";
                    }

                    if($color != ''){
                        $where .= " AND style_name='$style_name'";
                    }

                    if($brand != ''){
                        $where .= " AND brand='$brand'";
                    }

                    if($ex_factory_date != ''){
                        $where .= " AND ex_factory_date='$ex_factory_date'";
                    }

//                    echo '<pre>';
//                    print_r($where);
//                    echo '</pre>';

                    $res = $this->Access_model->selectData('tb_order', ' * ', " $where");


                    if(sizeof($res) > 0){

                        $order_code = $res[0]['order_code'];

                        if($size != $res[0]['size']){
                            $data_1 = array(
                                'order_code' => $order_code,
                                'purchase_order' => $purchase_order,
                                'item' => $item,
                                'quality' => $quality,
                                'color' => $color,
                                'style_no' => $style_no,
                                'style_name' => $style_name,
                                'description' => $description,
                                'brand' => $brand,
                                'size' => $size,
                                'quantity' => $quantity,
                                'ex_factory_date' => $ex_factory_date,
                                'upload_date' => $date,
                                'upload_by' => $user_id,
                                'unit_id' => $unit_id,
                                'upload_unit_id' => $unit_id
                            );

                            $this->Access_model->insertData('tb_order', $data_1);
                        }



                    }else{

                        $order_code = $unit_order_code_max_no+1;

                        $data_1 = array(
                            'order_code' => $order_code,
                            'purchase_order' => $purchase_order,
                            'item' => $item,
                            'quality' => $quality,
                            'color' => $color,
                            'style_no' => $style_no,
                            'style_name' => $style_name,
                            'description' => $description,
                            'brand' => $brand,
                            'size' => $size,
                            'quantity' => $quantity,
                            'ex_factory_date' => $ex_factory_date,
                            'upload_date' => $v['upload_date'],
                            'upload_by' => $v['upload_by'],
                            'unit_id' => $v['unit_id'],
                            'upload_unit_id' => $v['upload_unit_id']
                        );

                        $this->Access_model->insertData('tb_order', $data_1);

                        $this->Access_model->updateData('tb_unit', " unit_order_code_max_no=$order_code", " AND id=$unit_id");
                    }

                }

                $this->releaseUserFromOrderUpload($unit_id);

            }

        }else{
            $data['exception'] = "Wrong File Format! Please Select the File: <span style='background-color: yellow; font-weight: 900'>file_format.xls</span>";
            $this->session->set_userdata($data);

            redirect('Access/orderUpload', 'refresh');
        }

    }

    public function logout() {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('access_level');
        $this->session->unset_userdata('unit_id');
        $this->session->unset_userdata('floor_id');

//        session_destroy();
        $data['message'] = 'Successfully Logged out!';
        $this->session->set_userdata($data);

        redirect('Welcome', 'refresh');
    }
}

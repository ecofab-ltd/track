<?php

class Access_model extends CI_Model {
//put your code here

    public function insertData($tbl, $data){
        $this->db->insert($tbl, $data);
        return $insertId = $this->db->insert_id();
    }

    public function updateDataActiveRecord($tbl, $condition_column, $condition_value, $data){
        $this->db->where($condition_column, $condition_value);
        $this->db->update($tbl, $data);
    }

    public function getOrderProgressFilterList($where){
        $sql = "SELECT t1.*, t2.cut_qty, t2.package_ready_qty, t2.line_input_qty, t2.line_output_qty, t2.poly_qty, t2.carton_qty, 
                t2.wash_send_qty, t2.wash_receive_qty, t2.embroidery_send_qty, t2.embroidery_receive_qty, t2.print_send_qty, 
                t2.print_receive_qty, t2.ship_qty 
                
                FROM (SELECT order_code, purchase_order, item, quality, color, style_no, style_name, description, brand, 
                SUM(quantity) AS total_qty, ex_factory_date, fabric_in_house_date, accessories_in_house_date, pp_approval_date
                FROM `tb_order` WHERE 1 $where GROUP BY order_code) AS t1
                
                LEFT JOIN
                tb_order_summary AS t2
                ON t1.order_code=t2.order_code";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderCutOperationDateReport($order_code, $operation_date){
        $sql = "SELECT * FROM tb_daily_cut
                WHERE order_code='$order_code'
                AND operation_date='$operation_date'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function selectData($tbl, $fields, $where){
        $sql = "Select $fields From $tbl WHERE 1 $where";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderInfo($where){
        $sql = "SELECT t1.*, t2.name AS unit_name, t3.cut_qty, t3.package_ready_qty, 
                t3.line_input_qty, t3.line_output_qty, t3.poly_qty, t3.carton_qty,
                t3.wash_send_qty, t3.wash_receive_qty, t3.embroidery_send_qty, t3.embroidery_receive_qty,
                t3.print_send_qty, t3.print_receive_qty, t3.ship_qty
                
                FROM 
                (SELECT *, SUM(quantity) AS total_quantity 
                FROM `tb_order` 
                WHERE 1 $where
                GROUP BY order_code) AS t1
                
                LEFT JOIN
                tb_unit AS t2
                ON t1.unit_id=t2.id
                
                LEFT JOIN
                tb_order_summary AS t3
                ON t1.order_code=t3.order_code";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderFloorPlanInfo($where, $where_1){
        $sql = "SELECT t1.*, t2.floor_id, t2.floor_quantity, t3.name AS unit_name, 
                t4.name AS floor_name
                
                FROM 
                (SELECT *, SUM(quantity) AS total_quantity 
                FROM `tb_order` 
                WHERE 1 $where
                GROUP BY order_code) AS t1
                
                INNER JOIN
                (SELECT * FROM tb_floor_assign 
                WHERE 1 $where_1) AS t2
                ON t1.unit_id=t2.unit_id AND t1.order_code=t2.order_code
                
                INNER JOIN
                tb_unit AS t3
                ON t1.unit_id=t3.id
                
                INNER JOIN
                tb_unit AS t4
                ON t2.floor_id=t4.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderFloorPlanOutputInfo($where, $where_1){
        $sql = "SELECT t1.floor_id, t1.floor_quantity, t2.order_code, t2.purchase_order, t2.item, 
                t2.quality, t2.color, t2.style_no, t2.style_name, t2.brand, t2.total_quantity, t3.name AS unit_name,
                t4.name AS floor_name, t5.total_floor_line_input_qty, t5.total_floor_sew_qty,
                t6.total_wash_send_qty, t6.total_wash_receive_qty, 
                t6.total_embroidery_send_qty, t6.total_embroidery_receive_qty, 
                t6.total_print_send_qty, t6.total_print_receive_qty, 
                t6.total_poly_qty, t6.total_carton_qty, t6.total_ship_qty 
                
                FROM 
                (SELECT order_code, unit_id, floor_id, floor_quantity 
                FROM tb_floor_assign 
                WHERE 1 $where_1
                GROUP BY order_code, unit_id, floor_id) AS t1
                                
                INNER JOIN
                (SELECT *, SUM(quantity) AS total_quantity 
                FROM `tb_order` 
                WHERE 1 $where
                GROUP BY order_code) AS t2
                ON t1.order_code=t2.order_code
                
                LEFT JOIN
                tb_unit AS t3
                ON t1.unit_id=t3.id
                
                LEFT JOIN
                tb_unit AS t4
                ON t1.floor_id=t4.id
                
                LEFT JOIN
                (SELECT order_code, floor_id, SUM(line_input) AS total_floor_line_input_qty, 
                SUM(sew_qty) AS total_floor_sew_qty 
                FROM `tb_daily_sew` 
                WHERE 1 $where_1
                GROUP BY order_code, floor_id) AS t5
                ON t1.order_code=t5.order_code AND t1.floor_id=t5.floor_id
                
                LEFT JOIN
                (SELECT order_code, unit_id, floor_id, SUM(wash_send_qty) AS total_wash_send_qty, SUM(wash_receive_qty) AS total_wash_receive_qty, 
                SUM(embroidery_send_qty) AS total_embroidery_send_qty, SUM(embroidery_receive_qty) AS total_embroidery_receive_qty, 
                SUM(print_send_qty) AS total_print_send_qty, SUM(print_receive_qty) AS total_print_receive_qty, 
                SUM(poly_qty) AS total_poly_qty, SUM(carton_qty) AS total_carton_qty, SUM(ship_qty) AS total_ship_qty 
                FROM `tb_daily_finishing` 
                WHERE 1 $where_1
                GROUP BY order_code, unit_id, floor_id) AS t6
                ON t1.order_code=t6.order_code AND t1.floor_id=t6.floor_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderFloorDailyOutputReport($order_code, $operation_date, $floor_id){
        $sql = "SELECT * FROM
                tb_daily_finishing
                WHERE order_code='$order_code' 
                AND operation_date='$operation_date' 
                AND floor_id='$floor_id'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function releaseUserFromOrderUpload($unit_id){
        $sql = "DELETE FROM tb_order_module_control WHERE unit_id=$unit_id";
        $this->db->query($sql);
    }

    public function getOrderUnitFloorPlan($order_code){
        $sql = "SELECT A.*, B.name as floor_name FROM
                (SELECT * FROM tb_floor_assign
                WHERE order_code='$order_code'
                GROUP BY order_code, unit_id, floor_id) AS A
                
                LEFT JOIN
                tb_unit AS B
                ON A.floor_id=B.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderUnitLinePlan($order_code, $unit_id, $floor_id){
        $sql = "SELECT A.*, B.name as line_name

                FROM
                (SELECT * FROM tb_line_assign
                WHERE order_code='$order_code' AND unit_id=$unit_id AND floor_id=$floor_id
                GROUP BY order_code, unit_id, floor_id, line_id) AS A
                
                LEFT JOIN
                tb_unit AS B
                ON A.line_id=B.id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderUnitLinePlanOutput($order_code, $unit_id, $floor_id){
        $sql = "SELECT A.*, B.name as line_name, C.line_input_qty, C.line_sew_output

                FROM
                (SELECT * FROM tb_line_assign
                WHERE order_code='$order_code' AND unit_id=$unit_id AND floor_id=$floor_id
                GROUP BY order_code, unit_id, floor_id, line_id) AS A
                
                LEFT JOIN
                tb_unit AS B
                ON A.line_id=B.id
                
                LEFT JOIN
                (SELECT order_code, line_id, SUM(line_input) AS line_input_qty, SUM(sew_qty) AS line_sew_output
                FROM tb_daily_sew
                WHERE order_code='$order_code' AND unit_id=$unit_id AND floor_id=$floor_id
                GROUP BY order_code, unit_id, floor_id, line_id) AS C
                ON A.order_code=C.order_code AND A.line_id=C.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getOrderUnitLinePlanOutputByOperationDate($order_code, $unit_id, $floor_id, $operation_date){
        $sql = "SELECT A.*, B.name as line_name, C.line_input_qty, C.line_sew_output

                FROM
                (SELECT * FROM tb_line_assign
                WHERE order_code='$order_code' AND unit_id=$unit_id AND floor_id=$floor_id
                GROUP BY order_code, unit_id, floor_id, line_id) AS A
                
                LEFT JOIN
                tb_unit AS B
                ON A.line_id=B.id
                
                LEFT JOIN
                (SELECT order_code, line_id, SUM(line_input) AS line_input_qty, SUM(sew_qty) AS line_sew_output
                FROM tb_daily_sew
                WHERE order_code='$order_code' AND unit_id=$unit_id AND floor_id=$floor_id AND operation_date='$operation_date'
                GROUP BY order_code, unit_id, floor_id, line_id) AS C
                ON A.order_code=C.order_code AND A.line_id=C.line_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getAuthorizedBrands($user_id){
        $sql = "SELECT t1.*, t2.user_id FROM (SELECT * FROM `tb_brand`) AS t1
                INNER JOIN
                (SELECT * FROM tb_user_brand_assign WHERE user_id=$user_id) AS t2
                ON t1.id=t2.brand_id";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function checkOperationDateLineSewEntry($operation_date, $line_id, $order_code){
        $sql = "SELECT * FROM `tb_daily_sew` WHERE order_code='$order_code' AND operation_date='$operation_date' AND line_id='$line_id'";

        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function updateData($tbl, $fields, $where){
        $sql = "Update $tbl SET $fields WHERE 1 $where";

        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteData($tbl, $condition_column, $condition_value){
        $this->db->where($condition_column, $condition_value);
        return $this->db->delete($tbl);
    }

    public function deleteData2($tbl, $condition_column, $condition_value, $condition_column2, $condition_value2){
        $this->db->where($condition_column, $condition_value);
        $this->db->where($condition_column2, $condition_value2);
        return $this->db->delete($tbl);
    }

}

?>
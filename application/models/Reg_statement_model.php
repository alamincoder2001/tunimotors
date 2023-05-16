<?php
class Reg_statement_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->branch   = $this->session->userdata('BRANCHid');
    }
    public function insert_data($table, $attr = null)
    {
        $insert     = $this->db->insert($table, $attr);
        $insertID   = $this->db->insert_id();
        if ($insert) {
            return $insertID;
        }
    }

    // get search data===========
    public function get_search_reg_statement($type = null, $form = null, $to = null)
    {

        $clauses = "";

        if ($type != '' && $type != 0) {
            $clauses .= " and eg.customer_id = '$type'";
        }
        if ($form != '') {
            $clauses .= " and eg.date between '$form' and '$to'";
        }

        $query = $this->db->query(" select p.Product_SlNo,
		p.Product_Name,
            e.EngineNo,
            e.engine_id,
            c.Customer_Name,
            c.Customer_SlNo,
            e.chassisNo,
            eg.*
            from tbl_reg_statement eg
            INNER join tbl_customer c on c.Customer_SlNo = eg.customer_id
            INNER join tbl_engine e on e.engine_id = eg.engine_id
            INNER join tbl_product p on e.productId = p.Product_SlNo 
            where eg.Status = 'a'
            and e.status = 'a'
        $clauses
       ")->result();

        if ($query) {
            return $query;
        }
        return FALSE;
    }
    // get search data===========
    public function get_search_reg_total($type = null, $form = null, $to = null)
    {

        $clauses = "";

        if ($type != '' && $type != 0) {
            $clauses .= " and eg.customer_id = '$type'";
        }
        if ($form != '') {
            $clauses .= " and eg.date between '$form' and '$to'";
        }

        $query = $this->db->query(" 		
        select 
            eg.reg_id,
            (sum(eg.reg_fee + eg.driving_fee + eg.others_fees + eg.laicence_fee + eg.transfer_fee )) as fee,
            (sum(eg.reg_cost + eg.driving_cost + eg.laicence_cost + eg.transfer_cost)) as cost,
            (sum(eg.reg_fee + eg.driving_fee + eg.others_fees + eg.laicence_fee + eg.transfer_fee) - sum(eg.reg_cost + eg.driving_cost + eg.laicence_cost + eg.transfer_cost)) as profit
        from tbl_reg_statement eg
        INNER join tbl_customer c on c.Customer_SlNo = eg.customer_id
        INNER join tbl_engine e on e.engine_id = eg.engine_id
        INNER join tbl_product p on e.productId = p.Product_SlNo 
        where eg.Status = 'a'
        and e.status = 'a'
        $clauses
       ")->row();

        if ($query) {
            return $query;
        }
        return FALSE;
    }

    public function edit_data($id = null)
    {
        $res = $this->db->query("Select * from tbl_reg_statement where reg_id=?", $id)->row();
        if ($res)
            return $res;
        return FALSE;
    }

    // Update data===================
    public function delete_data($id)
    {
        $this->db->set('status', 'd')
            ->where('reg_id', $id)->update('tbl_reg_statement');

        if ($this->db->affected_rows())
            return TRUE;
    }
    public function update_data($attr, $id)
    {

        // $this->db->where('reg_id', $id);
        // $this->db->update('tbl_reg_statement', $attr);

        $query = $this->db->where('reg_id', $id)->update('tbl_reg_statement', $attr);

        if ($query) {
            return true;
        } else {
            return false;
        }


        // if($this->db->affected_rows() == 1)
        //     return TRUE;
        // return FALSE;
    }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reg_statement extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->brunch = $this->session->userdata('BRANCHid');
		$access = $this->session->userdata('userId');
		if ($access == '') {
			redirect("Login");
		}

		$this->load->model('Model_table', "mt", TRUE);
		$this->load->model('Reg_statement_model');
	}
	public function index()
	{
		$data['title'] = "Registration Statement";
		$data['content'] = $this->load->view('Administrator/reg_statement/reg_statement', $data, TRUE);
		$this->load->view('Administrator/index', $data);
	}

	public function get_customer_ways_products()
	{
		$customerId = $this->input->post('customerId');

		$clause = '';

		if ($customerId != '' && $customerId != 0 && $customerId != null) {
			$clause .= " and c.Customer_SlNo = '$customerId'";
		}

		$product = $this->db->query("
							SELECT
							p.Product_SlNo,
							p.Product_Name,
							e.EngineNo,
							e.engine_id,
							c.Customer_SlNo,
							c.Customer_Name,
							sd.SaleMaster_IDNo,
							e.chassisNo
						FROM tbl_saledetails sd
						LEFT JOIN tbl_product p ON p.Product_SlNo = sd.Product_IDNo
						LEFT JOIN tbl_salesmaster sm ON sm.SaleMaster_SlNo = sd.SaleMaster_IDNo
						LEFT JOIN tbl_customer c ON c.Customer_SlNo = sm.SalseCustomer_IDNo
						LEFT JOIN tbl_engine e ON e.salesID = sd.SaleDetails_SlNo
						WHERE sd.Status = 'a'
						and sd.SaleDetails_BranchId = ?
						$clause
						GROUP BY sd.SaleMaster_IDNo", $this->brunch)->result();

		echo json_encode($product);
	}
	// public function get_product_ways_engine(){
	// 	$productId = $this->input->post('productId');
	// 	$engine =	$this->db->query("
	// 	SELECT 
	// 	p.Product_SlNo,
	// 	p.Product_Name,
	//   e.EngineNo,
	//   sd.SaleMaster_IDNo,
	//   e.chassisNo from tbl_saledetails sd 
	//   INNER join tbl_product p on sd.Product_IDNo = p.Product_SlNo 
	//   INNER join tbl_engine e on e.salesID = sd.SaleMaster_IDNo
	//   where sd.Status = 'a'
	//   and e.status = 'a'
	//   and p.Product_SlNo = ?
	//   GROUP BY(sd.SaleMaster_IDNo)",$productId)->result();
	//   echo json_encode($engine);
	// }
	/*=============================*/
	public function insertReg()
	{
		try {
			$attr = $this->input->post();

			if ($attr['customer_id'] == 0) {
				$customer = [
					'Customer_Code'         => $this->mt->generateCustomerCode(),
					'Customer_Name'         => $attr['Customer_Name'],
					'Customer_Type'         => 'retail',
					'Customer_Mobile'       => $attr['Customer_Mobile'],
					'Customer_Address'      => $attr['Customer_Address'],
					'Customer_Credit_Limit' => 10000000,
					'previous_due'          => 0,
					'status'                => 'a',
					'AddBy'                 => $this->session->userdata("FullName"),
					'AddTime'               => date("Y-m-d H:i:s"),
					'Customer_brunchid'     => $this->session->userdata("BRANCHid"),
				];

				$this->db->insert('tbl_customer', $customer);
				$attr['customer_id'] = $this->db->insert_id();
			}
			unset($attr['Customer_Name']);
			unset($attr['Customer_Mobile']);
			unset($attr['Customer_Address']);

			$reg = array(
				"engine_id"            => $attr['engine_id'],
				"date"                 => $attr['date'],
				// "product_id"           => $attr['product_id'],
				"customer_id"          => $attr['customer_id'],
				"reg_fee"              => $attr['reg_fee'],
				"reg_cost"             => $attr['reg_cost'],
				"driving_fee"          => $attr['driving_fee'],
				"driving_cost"         => $attr['driving_cost'],
				"license_fee"          => $attr['license_fee'],
				"license_cost"         => $attr['license_cost'],
				"transfer_fee"         => $attr['transfer_fee'],
				"transfer_cost"        => $attr['transfer_cost'],
				"bike_bs_type"         => $attr['bike_bs_type'],
				"bike_lr_type"         => $attr['bike_lr_type'],
				"bike_dl_type"         => $attr['bike_dl_type'],
				"bike_nt_type"         => $attr['bike_nt_type'],
				"registration_dc_type" => $attr['registration_dc_type'],
				"description"          => $attr['description'],
				"addby"                => $attr['addby'],
				"status"               => "a",
			);

			$data = $this->db->insert("tbl_reg_statement", $reg);
			if ($data) {
				echo json_encode(["successMsg" => "Save Successfull"]);
			} else {
				echo json_encode(["errorMsg" => "Save Unsucccessfull"]);
			}
		} catch (Exception $th) {
			echo json_encode(["errorMsg" => $th->getMessage()]);
		}
	}

	public function getCustomers()
	{

		$customers = $this->db->query("
            select
                c.*,
                d.District_Name,
                concat(c.Customer_Code, ' - ', c.Customer_Name, ' - ', c.owner_name, ' - ', c.Customer_Mobile) as display_name
            from tbl_customer c
            left join tbl_district d on d.District_SlNo = c.area_ID
            where c.status = 'a'
            and c.Customer_Type != 'G'
            and (c.Customer_brunchid = ? or c.Customer_brunchid = 0)
          
            order by c.Customer_SlNo desc
        ", $this->session->userdata('BRANCHid'))->result();
		echo json_encode($customers);
	}


	/*=============================*/
	public function updateRegStatement($id = null)
	{
		$attr = $this->input->post();
		$id = $this->input->post('reg_id');


		if ($this->Reg_statement_model->update_data($attr, $id)) :
			$data['successMsg'] = "Update Successfully!";
			echo json_encode($data);
		else :
			$data['errorMsg'] = "Update Unsuccessfully!";
			echo json_encode($data);
		endif;
	}
	public function get_reg_statement()
	{
		$id = $this->input->post('id');
		$reg_id = $this->db->query("select reg_id from tbl_reg_statement where engine_id=? and status ='a'", $id)->row();
		if ($reg_id) {
			$data = "l";
			echo json_encode($data);
		} else {
			$data = "c";
			echo json_encode($data);
		}
	}
	/*=============================*/
	public function delete($id = null)
	{
		if ($this->Reg_statement_model->delete_data($id)) :
			$data['successMsg'] = "Delete Successfully!";
			echo json_encode($data);
		else :
			$data['errorMsg'] = "Delete Unsuccessfully!";
			echo json_encode($data);
		endif;
	}

	public function search()
	{
		$type  = $this->input->post('stype');
		$sDate = $this->input->post('sDate');
		$eDate = $this->input->post('eDate');
		if ($this->Reg_statement_model->get_search_reg_statement($type, $sDate, $eDate)) {
			$data['getData'] = $this->Reg_statement_model->get_search_reg_statement($type, $sDate, $eDate);
			$data['getDataTotal'] = $this->Reg_statement_model->get_search_reg_total($type, $sDate, $eDate);
			$this->load->view('Administrator/reg_statement/reg_search', $data);
		}
	}
	public function get_all_reg_statement()
	{
		$query = $this->db->query("SELECT 
								p.Product_SlNo,
								p.Product_Name,
								e.EngineNo,
								e.engine_id,
								c.Customer_Name,
								c.Customer_SlNo,
								e.chassisNo,
								eg.*,
    							(SELECT eg.reg_fee+eg.driving_fee+eg.license_fee+eg.transfer_fee) as total_fee,
    							(SELECT eg.reg_cost+eg.driving_cost+eg.license_cost+eg.transfer_cost) as total_cost,
    							(select total_fee - total_cost) as profit
								from tbl_reg_statement eg
								left join tbl_customer c on c.Customer_SlNo = eg.customer_id
								left join tbl_engine e on e.engine_id = eg.engine_id
								left join tbl_product p on p.Product_SlNo = e.productId
								where eg.status = 'a'
							")->result();


		echo json_encode($query);
	}


	public function edit($id = null)
	{
		$data['edit'] = $this->Reg_statement_model->edit_data($id);
		// $data['ExpHead'] 	= $this->Reg_statement_model->getExpenseHead();
		$data =  $this->load->view('Administrator/reg_statement/edit_reg_statement', $data);
	}
	// Update data===================
	public function update_data($table, $attr, $id)
	{
		$this->db->where('id', $id);
		$this->db->update($table, $attr);
		if ($this->db->affected_rows())
			return TRUE;
		return FALSE;
	}
	/* ========= Delete ========*/

	public function deleteRegStatement($id = null)
	{

		if ($this->Reg_statement_model->delete_data($id)) :
			$data['successMsg'] = "Delete Successfully!";
			echo json_encode($data);
		else :
			$data['errorMsg'] = "Delete Unsuccessfully!";
			echo json_encode($data);
		endif;
	}
}

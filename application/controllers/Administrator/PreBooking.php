<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PreBooking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        $this->accountType = $this->session->userdata('accountType');
         if($access == ''){
            redirect("Login");
        }  
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
    }

    public function savePreBooking()
    {
        $res = ['success'=>false, 'message'=>''];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $prebooking = (array)$data;
            $prebooking['status'] = 'a';
            $prebooking['created_by'] = $this->session->userdata("FullName");
            $prebooking['created_at'] = date('Y-m-d H:i:s');
            $prebooking['branch_id'] = $this->session->userdata('BRANCHid');
            $this->db->insert('tbl_pre_booking', $prebooking);
            $res = ['success' => true, 'message' => 'Pre Booking Successfully Added!'];
            
        } catch (\Exception $e) {
            $res = ['success'=>false, 'message'=>$e->getMessage()];
        }
        echo json_encode($res);
    }

    public function preBooking()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "PreBooking List";
        $data['content'] = $this->load->view('Administrator/sales/pre_booking', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function preBookingList() 
    {
        $data = json_decode($this->input->raw_input_stream);
        $cluses = "";

        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $cluses .= " and pb.delivery_date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->customerId) && $data->customerId != '') {
            $cluses .= " and pb.customer_id = '$data->customerId'";
        }

        if(isset($data->Delivery) && $data->Delivery != '') {
            $cluses .= " and pb.delivery_status = '$data->Delivery'";
        }

        $data = $this->db->query("
        select 
            pb.*,
            c.Customer_Name,
            p.Product_Name,
            co.color_name
        from tbl_pre_booking pb
        join tbl_customer c on c.Customer_SlNo = pb.customer_id
        join tbl_product p on p.Product_SlNo = pb.product_id
        left join tbl_color co on co.color_SiNo = p.color
        where pb.status = 'a' 
        and pb.branch_id = ?
        $cluses
        order by pb.id desc
        ",$this->session->userdata('BRANCHid'))->result();

        echo json_encode($data);
    }

    public function moveToDeliverd()
    {
        $res = ['success'=>false, 'message'=>''];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $this->db->query("update tbl_pre_booking set delivery_status = 'd' where id = ?
            ",$data->preBookingId);
            $res = ['success' => true, 'message' => 'Pre Booking Successfully Delivered!'];
        } catch (\Exception $e) {
            $res = ['success'=>false, 'message'=>$e->getMessage()];
        }
        echo json_encode($res);
    }

    public function PreBookingReport()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "PreBooking Report";
        $data['content'] = $this->load->view('Administrator/sales/pre_booking_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getDeliveryStatus()
    {
        $data = $this->db->query("
        select 
            pb.id,
            pb.delivery_status,
            case
                when pb.delivery_status = 'p' then 'Pending'
                else 'Delivered'
            end as deliveryStatus
        from tbl_pre_booking pb
        where pb.status = 'a'
        group by pb.delivery_status
        ")->result();

        echo json_encode($data);
    }
}
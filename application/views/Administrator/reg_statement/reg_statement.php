<script>
    function printContents(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        $('.actions').css('display', 'none');
        window.print();
        location.reload();
        document.body.innerHTML = restorepage;
    }
</script>


<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form id="ValidateForm" method="POST">
            <input type="hidden" name="addby" value="<?= $this->session->userdata('userId') ?>">
            <div class="form-horizontal">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="date"> Date </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" name="date" id="date" class="form-control date-picker" data-date-format="yyyy-mm-dd" reaDOnly value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Customer</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <select onchange="customer(this)" class=" form-control option" name="customer_id" id="option" required class="chosen-select form-control">

                            </select>
                        </div>
                    </div>
                    <div style="margin-top: 3px; display: none;" id="newCustomer">
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="Customer_Name"> Customer Name</label>
                            <label class="col-sm-1 control-label">:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="Customer_Name" name="Customer_Name" placeholder="customer name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="Customer_Mobile"> Mobile No</label>
                            <label class="col-sm-1 control-label">:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="Customer_Mobile" name="Customer_Mobile" placeholder="Mobile No">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="Customer_Address"> Address</label>
                            <label class="col-sm-1 control-label">:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="Customer_Address" name="Customer_Address" placeholder="address">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 3px;">
                        <label class="col-sm-4 control-label" for="engine_id"> Product</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <select onchange="checkId(this)" class="form-control" name="engine_id" id="engine_id" required class="chosen-select form-control">

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Registration Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="amount" required name="reg_fee" value="0" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="cus_name"> cost:</label>
                        <div class="col-sm-2">
                            <input type="text" id="amount" required name="reg_cost" value="0" placeholder="Amount" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Driving Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="amount" required name="driving_fee" value="0" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="cus_name"> cost:</label>
                        <div class="col-sm-2">
                            <input type="text" id="amount" required name="driving_cost" value="0" placeholder="Amount" class="form-control" />
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="license"> Driving License Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="license_fee" required name="license_fee" value="0" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="license_cost"> Cost:</label>
                        <div class="col-sm-2">
                            <input type="text" id="license_cost" required name="license_cost" value="0" placeholder="Amount" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="transfer_fee"> Name Transfer Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="transfer_fee" required name="transfer_fee" value="0" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="transfer_cost"> Cost:</label>
                        <div class="col-sm-2">
                            <input type="text" id="transfer_cost" required name="transfer_cost" value="0" placeholder="Amount" class="form-control" />
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Type </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-5">
                            <input type="checkbox" id="registration" name="bike_dc_type" value="R">
                            <label for="registration"> Registration Document</label><br>
                            <input type="checkbox" id="bsp" name="registration_dc_type" value="B">
                            <label for="bsp"> BSP </label><br>
                            <input type="checkbox" id="license" name="bike_dl_type" value="L">
                            <label for="license"> Driving License</label><br>
                            <input type="checkbox" id="transfer" name="bike_nt_type" value="T">
                            <label for="transfer"> Name Transfer</label><br>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="description"> Description </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <textarea placeholder="Sort Description" name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for=""> </label>
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-6">
                            <button type="button" onclick="InsertBill()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
                                Save
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row" style="padding-top: 15px; margin-top: 15px; border-top: 2px solid #2ca980;">
    <div class="col-xs-2">
        <select class="form-control option" name="customer_id" id="optiontb" required class="chosen-select  form-control">

        </select>
    </div>
    <div class="col-xs-2">
        <div class="input-group">
            <input class="form-control date-picker" id="sDate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
            <span class="input-group-addon" style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
                <i class="fa fa-calendar bigger-110"></i>
            </span>
        </div>
    </div>

    <div class="col-xs-2">
        <div class="input-group">
            <input class="form-control date-picker" id="eDate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
            <span class="input-group-addon" style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
                <i class="fa fa-calendar bigger-110"></i>
            </span>
        </div>
    </div>
    <div class="col-xs-2" style="margin-bottom: 10px;">
        <button style="padding: 0px 10px;" type="button" onclick="searchDoSales()" class="btn btn-sm btn-primary pull-left">Search
            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
        </button>
    </div>
    <div class="col-xs-1">
        <a style="cursor:pointer; float: left;" onclick="printContents('printPage')"> <i class="fa fa-print" style="font-size:20px;color:green"></i>
            Print</a>
    </div>
    <div class="col-xs-12">
        <div id="printPage">
            <div class="table-header">
                Registration Statement Information
            </div>

            <!-- div.table-responsive -->
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>SL.</th>
                        <th>Customer Name</th>
                        <th>product Name</th>
                        <th>engine & Chassis No</th>
                        <th>Registration fee</th>
                        <th>Driving fee</th>
                        <th>Laicence fee</th>
                        <th>Transfer fee</th>
                        <!-- <th>Others fee</th> -->
                        <th>total fee</th>
                        <th>total Cost fee</th>
                        <th>Profit</th>

                        <th>Driving</th>
                        <th>Registration</th>
                        <th>Laicence</th>
                        <th>Transfer</th>
                        <th class="actions">Action</th>
                    </tr>
                </thead>

                <tbody class="showResult">

                </tbody>
                <tfoot class="total">
                </tfoot>
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">
    function getCustomer() {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>get_customers",
            dataType: "JSON",
            success: function(data) {
                var options = '';
                options += `  <option value="" >Select Customer</option>`;
                options += `  <option value="0" >New Customer</option>`;
                for (let i = 0; i < data.length; i++) {
                    const item = data[i];
                    options += `
                    <option value="${item.Customer_SlNo}">${item.display_name}</option>`;
                }
                $('#option').html(options);
                $('#optiontb').html(options);
            }
        });
    }
    getCustomer();

    function searchDoSales() {

        var stype = $("#optiontb").val();
        var sDate = $("#sDate").val();
        var eDate = $("#eDate").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>searchReg",
            data: {
                stype: stype,
                sDate: sDate,
                eDate: eDate
            },
            dataType: "HTML",
            success: function(data) {
                $(".showResult").html(data);

            }
        });

    }


    function getAllReg() {

        $.ajax({
            type: "get",
            url: "<?= base_url(); ?>get_all_reg_statement",
            dataType: 'json',
            success: function(data) {
                var options = 0;
                var footer = 0;
                var j = 1;

                var totalFee = 0;
                var totalProfit = 0;
                var totalCost = 0;
                var display = '';

                for (let i = 0; i < data.length; i++) {
                    const item = data[i];

                    var total = (+item.driving_fee + +item.reg_fee + +item.others_fees + +item.laicence_fee + +item.transfer_fee);
                    var cost = (+item.driving_cost + +item.reg_cost + +item.laicence_cost + +item.transfer_cost);
                    var profit = total - cost;

                    totalFee += total;
                    totalCost += cost;
                    totalProfit += profit;


                    if (item.bike_dc_type == 'R') {
                        display = "contents";
                    } else {
                        display = "none";
                    }
                    if (item.registration_dc_type == 'B') {
                        display_r = "contents";
                    } else {
                        display_r = "none";
                    }
                    if (item.bike_dl_type == 'L') {
                        display_l = "contents";
                    } else {
                        display_l = "none";
                    }
                    if (item.bike_nt_type == 'T') {
                        display_t = "contents";
                    } else {
                        display_t = "none";
                    }
                    options += `
                    <tr>
                            <td>${j++}</td>
                            <td>${item.Customer_Name}</td>
                            <td>${item.Product_Name}</td>
                            <td>${item.EngineNo}</td>
                            <td>${item.reg_fee}</td>
                            <td>${item.driving_fee}</td>
                            <td>${item.laicence_fee}</td>
                            <td>${item.transfer_fee}</td>
                           
                             <td>${total}</td>
                             <td>${cost}</td>
                             <td>${profit} </td>
                             <td>  
                                <i style="display:${display_r}" class=" green ace-icon fa fa-check-circle bigger-130"></i>
                            </td>
                            <td>  
                                <i style="display:${display}" class=" green ace-icon fa fa-check-circle bigger-130"></i>
                            </td>
                            <td>  
                                <i style="display:${display_l}" class=" green ace-icon fa fa-check-circle bigger-130"></i>
                            </td>
                            <td>  
                                <i style="display:${display_t}" class=" green ace-icon fa fa-check-circle bigger-130"></i>
                            </td>
                            <td class="actions">
                                <div class="hidden-sm hidden-xs action-buttons">
                                
                                  
        
                                    <a class="green  fancybox fancybox.ajax"
                                       href="<?php echo base_url() ?>editRegStatement/${item.reg_id}">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <a class="red" href="#" onclick="deleted(${item.reg_id})">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>
                            </td>
                    </tr>
                    `;
                }
                options += `
                     <tr style="font-weight:bold;">
                        <td colspan="8" style="text-align:right;">Total</td>
                        <td style="text-align:right;">${totalFee}</td>
                        <td style="text-align:right;">${totalCost}</td>
                        <td style="text-align:right;">${totalProfit}</td
                    </tr>`;
                $('.showResult').html(options);
            }
        });
    }

    getAllReg();

    function customer(id) {
        var customerId = (id.value || id.options[id.selectedIndex].value);

        if (customerId == '') {
            alert("Select Customer");
            return
        }
        if (customerId == 0) {
            $("#newCustomer").show();
        } else {
            $("#newCustomer").hide();
        }

        $.ajax({
            url: location.origin + "/get_customer_ways_products",
            method: "POST",
            dataType: 'JSON',
            data: {
                customerId: customerId
            },
            success: data => {
                var options = '';
                options += `  <option value="0" >Select Product</option>`;
                $.each(data, (index, value) => {
                    options += `
                    <option value="${value.engine_id}">${value.Product_Name}-${value.EngineNo}</option>`;
                })
                $('#engine_id').html(options);
            }
        });
    }

    function checkId(id) {
        var id = (id.value || id.options[id.selectedIndex].value);
        $.ajax({
            url: "<?= base_url(); ?>get_reg_statement",
            method: 'POST',
            dataType: 'JSON',
            data: {
                id: id
            },
            success: function(data) {
                var id = data
                if (id == 'c') {
                    return true;
                } else {
                    alert("already Added");
                }
            }
        })

    }

    function InsertBill() {
        var isvalid = validationCheck();
        var g = $("#ValidateForm").serialize();
        $("#ValidateForm").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>insertReg",
            data: $("#ValidateForm").serialize(),
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                return
                if (data.successMsg) {
                    alert(data.successMsg);
                }
                if (data.errorMsg) {
                    alert(data.errorMsg);
                }
                // location.reload();
            }
        });
    }

    function deleted(id) {
        var confirmation = confirm("are you sure you want to delete this ?");
        if (confirmation) {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>deleteRegStatement/" + id,
                dataType: "JSON",
                success: function(data) {
                    if (data.successMsg) {
                        alert(data.successMsg);
                    }
                    if (data.errorMsg) {
                        alert(data.errorMsg);
                    }
                    location.reload();
                }
            });
        }
    }
</script>
<style>
    select {
        padding: 2px !important;
    }
</style>
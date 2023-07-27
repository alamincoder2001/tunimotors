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
                    <div class="form-group engine_id" style="margin-top: 3px;">
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
                        <label class="col-sm-4 control-label" for="cus_name"> Learner Fee</label>
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
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="bsp_fee"> BSP Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="bsp_fee" required name="bsp_fee" value="0" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="bsp_cost"> cost:</label>
                        <div class="col-sm-2">
                            <input type="text" id="bsp_cost" required name="bsp_cost" value="0" placeholder="Amount" class="form-control" />
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Type </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-5">
                            <input type="checkbox" id="registration" name="registration_dc_type" value="R">
                            <label for="registration"> Registration Document </label><br>
                            <input type="checkbox" id="bsp" name="bike_bs_type" value="B">
                            <label for="bsp"> BSP </label><br>
                            <input type="checkbox" id="learner" name="bike_lr_type" value="LR">
                            <label for="learner"> Learner </label><br>
                            <input type="checkbox" id="license" name="bike_dl_type" value="L">
                            <label for="license"> Driving License </label><br>
                            <input type="checkbox" id="transfer" name="bike_nt_type" value="T">
                            <label for="transfer"> Name Transfer</label>
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
            
            <!-- div.table-responsive -->
            <div class="card">
                <div class="card-header table-header">
                    Registration Statement Information
                </div>
                <div class="card-body" style="overflow-y: auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th style="width: 15%;">Date</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Engine & Chassis No</th>
                                <th>Registration fee</th>
                                <th>Learner fee</th>
                                <th>License fee</th>
                                <th>Transfer fee</th>
                                <th>BSP fee</th>
                                <th>Total fee</th>
                                <th>Total Cost</th>
                                <th>Profit</th>
                                <th>Learner</th>
                                <th>Registration</th>
                                <th>License</th>
                                <th>Transfer</th>
                                <th>BSP</th>
                                <th>Description</th>
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
            dataType: "json",
            beforeSend: () => {
                $(".showResult").html("");
            },
            success: function(data) {
                if (data.length > 0) {
                    $.each(data, (index, value) => {
                        Row(index, value);
                    })
                } else {
                    $(".showResult").html(`<tr><td colspan="16">Not found data</td></tr>`);
                }
            }
        });

    }

    function Row(index, value) {
        var raw = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${value.date}</td>
                            <td>${value.Customer_Name}</td>
                            <td>${value.Product_Name}</td>
                            <td>${value.EngineNo}-${value.chassisNo}</td>
                            <td>${value.reg_fee}</td>
                            <td>${value.driving_fee}</td>
                            <td>${value.license_fee}</td>
                            <td>${value.transfer_fee}</td>
                            <td>${value.bsp_fee}</td>
                            <td>${value.total_fee}</td>
                            <td>${value.total_cost}</td>
                            <td>${value.profit}</td>
                            <td>${value.bike_dl_type ? '<i class=" green ace-icon fa fa-check-circle bigger-130"></i>': ''}</td>
                            <td>${value.registration_dc_type ? '<i class=" green ace-icon fa fa-check-circle bigger-130"></i>': ''}</td>
                            <td>${value.bike_lr_type ? '<i class=" green ace-icon fa fa-check-circle bigger-130"></i>': ''}</td>
                            <td>${value.bike_nt_type ? '<i class=" green ace-icon fa fa-check-circle bigger-130"></i>': ''}</td>
                            <td>${value.bike_bs_type ? '<i class=" green ace-icon fa fa-check-circle bigger-130"></i>': ''}</td>
                            <td>${value.description}</td>
                            <td>
                            <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a class="green  fancybox fancybox.ajax" href="<?php echo base_url() ?>editRegStatement/${value.reg_id}">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <a class="red" href="#" onclick="deleted(${value.reg_id})">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                    `;

        $(".showResult").append(raw);
    }


    function getAllReg() {
        $.ajax({
            url: "<?= base_url(); ?>get_all_reg_statement",
            method: "POST",
            dataType: "JSON",
            data: {id: ''},
            beforeSend: () => {
                $(".showResult").html("");
            },
            success: res => {
                $.each(res, (index, value) => {
                    Row(index, value);
                })

                let reg_fee = res.reduce((acc, pre) => {return acc + + parseFloat(pre.reg_fee)}, 0).toFixed(2);
                let driving_fee = res.reduce((acc, pre) => {return acc + + parseFloat(pre.driving_fee)}, 0).toFixed(2);
                let license_fee = res.reduce((acc, pre) => {return acc + + parseFloat(pre.license_fee)}, 0).toFixed(2);
                let transfer_fee = res.reduce((acc, pre) => {return acc + + parseFloat(pre.transfer_fee)}, 0).toFixed(2);
                let bsp_fee = res.reduce((acc, pre) => {return acc + + parseFloat(pre.bsp_fee)}, 0).toFixed(2);
                let total_fee = res.reduce((acc, pre) => {return acc + + parseFloat(pre.total_fee)}, 0).toFixed(2);
                let total_cost = res.reduce((acc, pre) => {return acc + + parseFloat(pre.total_cost)}, 0).toFixed(2);
                let total_profit = res.reduce((acc, pre) => {return acc + + parseFloat(pre.profit)}, 0).toFixed(2);

                $('.total').html(`
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th>${reg_fee}</th>
                        <th>${driving_fee}</th>
                        <th>${license_fee}</th>
                        <th>${transfer_fee}</th>
                        <th>${bsp_fee}</th>
                        <th>${total_fee}</th>
                        <th>${total_cost}</th>
                        <th>${total_profit}</th>
                        <th colspan="5"></th>
                    </tr>
                `)
            }
        })
    }

    getAllReg();

    function customer(id) {
        var customerId = (id.value || id.options[id.selectedIndex].value);

        if (customerId == '') {
            alert("Select Customer");
            return
        }
        if (customerId == 0) {
            customerId = "";
            $("#newCustomer").show();
        } else {
            $("#newCustomer").hide();
        }

        $.ajax({
            url: "/get_customer_ways_products",
            method: "POST",
            dataType: 'JSON',
            data: {
                customerId: customerId
            },
            success: data => {
                if (data.length > 0 && customerId != '') {
                    var options = '';
                    options += `  <option value="0" >Select Product</option>`;
                    $.each(data, (index, value) => {
                        options += `
                        <option value="${value.engine_id}">${value.Product_Name}-${value.EngineNo}</option>`;
                    })
                    $('#engine_id').html(options);
                }else{
                    $('.engine_id').css({display: 'none'});
                }
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
                    location.reload();
                }
            }
        })

    }

    function InsertBill() {
        var g = $("#ValidateForm").serialize();
        $("#ValidateForm").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>insertReg",
            data: $("#ValidateForm").serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.successMsg) {
                    alert(data.successMsg);
                    setTimeout(() => {
                        location.reload();
                    }, 1000)
                }
                if (data.errorMsg) {
                    alert(data.errorMsg);
                }
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
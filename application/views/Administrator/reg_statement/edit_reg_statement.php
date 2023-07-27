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
<?php
$name = $this->db->query("
    select 
        rs.*,
        c.Customer_Name,
        p.Product_Name,
        e.EngineNo
    from tbl_reg_statement rs
    left join tbl_customer c on c.Customer_SlNo = rs.customer_id
    left JOIN tbl_engine e on e.engine_id = rs.engine_id
    left join tbl_product p on p.Product_SlNo = e.productId
    where rs.status ='a' 
    and rs.reg_id = ?
    ", $edit->reg_id)->row();

$customers = $this->db->query("
    select 
        c.*
    from tbl_customer c
    where c.status = 'a'
    ")->result();
?>

<div class="row">
    <div class="col-xs-12" style="margin-top: 20px; margin-bottom:10px;">
        <!-- PAGE CONTENT BEGINS -->
        <form id="ValidateForms" method="POST">
            <input type="hidden" name="addby" value="<?= $this->session->userdata('userId') ?>">
            <div class="form-horizontal">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="Customer_id"> Date </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="date" name="date" id="date" class="form-control" value="<?php echo $name->date; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Customer</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <select name="customer_id" class="chosen-select form-control">
                                <?php foreach ($customers as $item) { ?>
                                    <option value="<?php echo $item->Customer_SlNo; ?>" <?php echo $name->customer_id == $item->Customer_SlNo ? 'selected' : ''; ?>><?php echo $item->Customer_Name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Product</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="product_id" value="<?php echo $edit->product_id; ?>" required class="chosen-select form-control">
                                <option value="<?php echo $edit->product_id; ?>"><?php echo $name->Product_Name;
                                                                                echo '-';
                                                                                echo $name->EngineNo; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="reg_fee"> Regi. Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="amount" required name="reg_fee" value="<?php echo $edit->reg_fee; ?>" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="reg_cost"> cost:</label>

                        <div class="col-sm-2">
                            <input type="text" id="amount" required name="reg_cost" value="<?php echo $edit->reg_cost; ?>" placeholder="Amount" class="form-control" />
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="driving_fee"> Driving Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="amount" required name="driving_fee" value="<?php echo $edit->driving_fee; ?>" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="driving_cost"> cost:</label>

                        <div class="col-sm-2">
                            <input type="text" id="amount" required name="driving_cost" value="<?php echo $edit->driving_cost; ?>" placeholder="Amount" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="license_fee"> License Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="amount" required name="license_fee" value="<?php echo $edit->license_fee; ?>" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="license_cost"> cost:</label>

                        <div class="col-sm-2">
                            <input type="text" id="amount" required name="license_cost" value="<?php echo $edit->license_cost; ?>" placeholder="Amount" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="transfer_fee"> Transfer Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="amount" required name="transfer_fee" value="<?php echo $edit->transfer_fee; ?>" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="transfer_cost"> cost:</label>

                        <div class="col-sm-2">
                            <input type="text" id="amount" required name="transfer_cost" value="<?php echo $edit->transfer_cost; ?>" placeholder="Amount" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="bsp_fee"> BSP Fee</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-3">
                            <input type="text" id="bsp_fee" required name="bsp_fee" value="<?php echo $edit->bsp_fee; ?>" placeholder="Amount" class="form-control" />
                        </div>
                        <label class="col-sm-1 control-label" for="bsp_cost"> cost:</label>
                        <div class="col-sm-2">
                            <input type="text" id="bsp_cost" required name="bsp_cost" value="<?php echo $edit->bsp_cost; ?>" placeholder="Amount" class="form-control" />
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Type </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">

                            <?php if ($edit->registration_dc_type == 'R') { ?>
                                <input type="checkbox" id="bike" name="registration_dc_type" value="<?php echo $edit->registration_dc_type; ?>" <?php echo $edit->registration_dc_type == 'R' ? 'checked' : ''; ?>>
                                <label for="bike"> Registration Document </label><br>
                            <?php } else { ?>
                                <input type="checkbox" id="bike" name="registration_dc_type" value="R">
                                <label for="bike"> Registration Document </label><br>
                            <?php } ?>

                            <?php if ($edit->bike_lr_type == 'LR') { ?>
                                <input type="checkbox" id="Learner" name="bike_lr_type" value="<?php echo $edit->bike_lr_type; ?>" <?php echo $edit->bike_lr_type == 'LR' ? 'checked' : ''; ?>>
                                <label for="Learner"> Learner </label><br>
                            <?php } else { ?>
                                <input type="checkbox" id="Learner" name="bike_lr_type" value="LR">
                                <label for="Learner"> Learner </label><br>
                            <?php } ?>

                            <?php if ($edit->bike_bs_type == 'B') { ?>
                                <input type="checkbox" id="bsp" name="bike_bs_type" value="<?php echo $edit->bike_bs_type; ?>" <?php echo $edit->bike_bs_type == 'B' ? 'checked' : ''; ?>>
                                <label for="bsp"> BSP </label><br>
                            <?php } else { ?>
                                <input type="checkbox" id="bsp" name="bike_bs_type" value="B">
                                <label for="bsp"> BSP </label><br>
                            <?php } ?>

                            <?php if ($edit->bike_dl_type == 'L') { ?>
                                <input type="checkbox" id="license" name="bike_dl_type" value="<?php echo $edit->bike_dl_type; ?>" <?php echo $edit->bike_dl_type == 'L' ? 'checked' : ''; ?>>
                                <label for="laicence"> Driving License</label><br>
                            <?php } else { ?>
                                <input type="checkbox" id="license" name="bike_dl_type" value="L">
                                <label for="laicence"> Driving License</label><br>
                            <?php } ?>

                            <?php if ($edit->bike_nt_type == 'T') { ?>
                                <input type="checkbox" id="license" name="bike_nt_type" value="<?php echo $edit->bike_nt_type; ?>" <?php echo $edit->bike_nt_type == 'T' ? 'checked' : ''; ?>>
                                <label for="laicence"> Name Transfer</label><br>
                            <?php } else { ?>
                                <input type="checkbox" id="license" name="bike_nt_type" value="T">
                                <label for="laicence"> Name Transfer</label><br>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="reg_id" value="<?php echo $edit->reg_id; ?>" class="hidden">
                        <label class="col-sm-4 control-label" for=""> Description </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <textarea placeholder="Sort Description" name="description" class="form-control"><?php echo $edit->description; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for=""> </label>
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-6">
                            <button type="button" onclick="updateBill()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
                                Update
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function updateBill() {


        var a = $("#ValidateForms").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>updateRegStatement",
            data: $("#ValidateForms").serialize(),
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
</script>
<style>
    select {
        padding: 2px !important;
    }
</style>
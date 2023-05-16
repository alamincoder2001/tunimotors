<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
    }

    .v-select input[type="search"],
    .v-select input[type="search"]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }

    #branchDropdown .vs__actions button {
        display: none;
    }

    #branchDropdown .vs__actions .open-indicator {
        height: 15px;
        margin-top: 7px;
    }
</style>

<div class="row" id="purchase">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom: 1px #ccc solid; margin-bottom: 5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Invoice no </label>
                <div class="col-sm-2">
                    <input type="text" id="invoice" name="invoice" v-model="purchase.invoice" readonly style="height: 26px;" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right"> Purchase For </label>
                <div class="col-sm-3">
                    <v-select id="branchDropdown" v-bind:options="branches" v-model="selectedBranch" label="Brunch_name" disabled></v-select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right"> Date </label>
                <div class="col-sm-3">
                    <input class="form-control" id="purchaseDate" name="purchaseDate" type="date" v-model="purchase.purchaseDate" v-bind:disabled="userType == 'u' ? true : false" style="border-radius: 5px 0px 0px 5px !important; padding: 4px 6px 4px !important; width: 230px;" />
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-9 col-md-9 col-lg-9">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Supplier & Product Information</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Supplier </label>
                                <div class="col-sm-7">
                                    <v-select v-bind:options="suppliers" v-model="selectedSupplier" v-on:input="onChangeSupplier" label="display_name"></v-select>
                                </div>
                                <div class="col-sm-1" style="padding: 0;">
                                    <a href="<?= base_url('supplier') ?>" title="Add New Supplier" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank">
                                        <i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="form-group" style="display: none;" v-bind:style="{display: selectedSupplier.Supplier_Type == 'G' ? '' : 'none'}">
                                <label class="col-sm-4 control-label no-padding-right"> Name </label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="Supplier Name" class="form-control" v-model="selectedSupplier.Supplier_Name" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Mobile No </label>
                                <div class="col-sm-8">
                                    <input type="text" placeholder="Mobile No" class="form-control" v-model="selectedSupplier.Supplier_Mobile" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right"> Address </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" v-model="selectedSupplier.Supplier_Address" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? false : true"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <form v-on:submit.prevent="addToCart">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Product </label>
                                    <div class="col-sm-7">
                                        <v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="onChangeProduct"></v-select>
                                    </div>
                                    <div class="col-sm-1" style="padding: 0;">
                                        <a href="<?= base_url('product') ?>" title="Add New Product" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank">
                                            <i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-4 control-label no-padding-right"> Group Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="group" name="group" class="form-control" placeholder="Group name" readonly />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Pur. Rate </label>
                                    <div class="col-sm-3">
                                        <input type="text" id="purchaseRate" name="purchaseRate" class="form-control" placeholder="Pur. Rate" v-model="selectedProduct.Product_Purchase_Rate" v-on:input="productTotal" required />
                                    </div>

                                    <label class="col-sm-2 control-label no-padding-right"> Quantity </label>
                                    <div class="col-sm-3">
                                        <input type="text" id="quantity" name="quantity" class="form-control" placeholder="Quantity" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-7 col-xs-offset-4 control-label no-padding-right">Add Engine & Chassis number</label>
                                    <div class="col-sm-1" style="padding: 0;">
                                        <span class="btn btn-primary" data-toggle="modal" data-target="#cartModal" class="btn btn-xs btn-danger" style="height: 29px; border: 0; width: 34px; margin-bottom: 5px; margin-left: -14px;" target="_blank">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-4 control-label no-padding-right"> Cost </label>
                                    <div class="col-sm-3">
                                        <input type="text" id="cost" name="cost" class="form-control" placeholder="Cost" readonly />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Total Amount </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="productTotal" name="productTotal" class="form-control" readonly v-model="selectedProduct.total" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> Selling Price </label>
                                    <div class="col-sm-8">
                                        <input type="text" id="sellingPrice" name="sellingPrice" class="form-control" v-model="selectedProduct.Product_SellingPrice" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label no-padding-right"> </label>
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-default pull-right">Add Cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
            <div class="table-responsive">
                <table class="table table-bordered" style="color: #000; margin-bottom: 5px;">
                    <thead>
                        <tr>
                            <th style="width: 4%; color: #000;">SL</th>
                            <th style="width: 20%; color: #000;">Product Name</th>
                            <th style="width: 13%; color: #000;">Category</th>
                            <th style="width: 8%; color: #000;">Purchase Rate</th>
                            <th style="width: 5%; color: #000;">Quantity</th>
                            <th style="width: 13%; color: #000;">Total Amount</th>
                            <th style="width: 5%; color: #000;">Eng/Chassis</th>
                            <th style="width: 10%; color: #000;">Action</th>
                        </tr>
                    </thead>
                    <tbody style="display: none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                        <tr v-for="(product, sl) in cart">
                            <td>{{ sl + 1}}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.categoryName }}</td>
                            <td>{{ product.purchaseRate }}</td>
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.total }}</td>
                            <td>
                                <a v-on:click.prevent="getEngineFromProduct(product)" data-toggle="modal" data-target="#cartEngineinfo" href="">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                <a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="7"></td>
                        </tr>

                        <tr style="font-weight: bold;">
                            <td colspan="4">Note</td>
                            <td colspan="3">Sub Total</td>
                        </tr>

                        <tr>
                            <td colspan="4"><textarea style="width: 100%; font-size: 13px;" placeholder="Note" v-model="purchase.note"></textarea></td>
                            <td colspan="3" style="padding-top: 15px; font-size: 18px;">{{ purchase.subTotal }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Amount Details</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table style="color: #000; margin-bottom: 0px;">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Sub Total</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="subTotal" name="subTotal" class="form-control" v-model="purchase.subTotal" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"> Vat </label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="vatPercent" name="vatPercent" v-model="vatPercent" v-on:input="calculateTotal" style="width: 50px; height: 25px;" />
                                                    <span style="width: 20px;"> % </span>
                                                    <input type="number" id="vat" name="vat" v-model="purchase.vat" readonly style="width: 140px; height: 25px;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Discount</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="discount" name="discount" class="form-control" v-model="purchase.discount" v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Transport / Labour Cost</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="freight" name="freight" class="form-control" v-model="purchase.freight" v-on:input="calculateTotal" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Total</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="total" class="form-control" v-model="purchase.total" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Paid</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="paid" class="form-control" v-model="purchase.paid" v-on:input="calculateTotal" v-bind:disabled="selectedSupplier.Supplier_Type == 'G' ? true : false" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Previous Due</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="previousDue" name="previousDue" class="form-control" v-model="purchase.previousDue" readonly style="color: red;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right">Due</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="due" name="due" class="form-control" v-model="purchase.due" readonly />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="button" class="btn btn-success" value="Purchase" v-on:click="savePurchase" v-bind:disabled="purchaseOnProgress == true ? true : false" style="background: #000; color: #fff; padding: 3px; margin-right: 15px;" />
                                                    <input type="button" class="btn btn-info" onclick="window.location = '<?php echo base_url(); ?>purchase'" value="New Purchase" style="background: #000; color: #fff; padding: 3px;" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="apps" class="container">
            <!-- Modal -->
            <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Cart</h4>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-6 text-center" style="margin-top: 10px;">
                                    <div class="col-xs-5">
                                        <input v-model="items.EngineNo" type="text" class="form-control" placeholder="enginine number" min="1" />
                                    </div>
                                    <div class="col-xs-5">
                                        <input v-model="items.chassisNo" type="text" class="form-control" placeholder="Chassis number" min="1" />
                                    </div>
                                    <div class="col-xs-2">
                                        <button @click="addItems" class="btn btn-sm btn-primary" style="padding: 0px 10px;">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div>
                                <table class="table table-cart">
                                    <th>Engine Number</th>
                                    <th>Chassis Number</th>
                                    <tr v-for="(item, index) in cartItems">
                                        <td style="width: 220px;">
                                            <input v-model="item.EngineNo" class="form-control input-qty" type="text" readonly />
                                        </td>
                                        <td style="width: 220px;">
                                            <input v-model="item.chassisNo" class="form-control input-qty" type="text" readonly />
                                        </td>
                                        <td>
                                            <button @click="removeItem(index)"><span class="glyphicon glyphicon-trash"></span></button>
                                        </td>
                                    </tr>
                                    <tr v-show="cartItems.length === 0">
                                        <td colspan="4" class="text-center">Cart is empty</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button v-if="selectedProduct.quantity == cartItems.length" data-dismiss="modal" type="button" class="btn btn-default">Done</button>
                            <button v-else data-dismiss="modal" type="button" class="btn btn-default">Close</button>
                            <!-- <button  @click="saveitem(cartItems)" type="button" class="btn btn-default" >Save Data</button> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cartEngineinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 style="text-transform:uppercase;" class="modal-title" id="myModalLabel1">Engine and Chassis</h4>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-6 text-center" style="margin-top: 10px;">
                                    <div class="col-xs-12">
                                        <h5 style="color:#438eb9">{{ modalProductName }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div>
                                <table class="table table-cart">
                                    <th>Sl</th>
                                    <th>Engine Number</th>
                                    <th>Chassis Number</th>
                                    <th>Action</th>
                                    <tr v-for="(item, index) in engineArray">
                                        <td>
                                            {{ index+1 }}
                                        </td>
                                        <td>
                                            <input v-model="item.EngineNo" class="form-control input-qty" type="text" />
                                        </td>
                                        <td>
                                            <input v-model="item.chassisNo" class="form-control input-qty" type="text" />
                                        </td>
                                        <td>
                                            <button v-on:click="updateEng(item)" class="" type="button" v-bind:disabled="engineOnProgress == true ? true : false"><i class="fa fa-floppy-o" aria-hidden="true"></i>
                                            </button>

                                            <button v-on:click="deleteEng(item)" class="" type="button" v-bind:disabled="engineDeleteOnProgress == true ? true : false"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <!-- <button v-if="selectedProduct.quantity == cartItems.length" data-dismiss="modal" type="button" class="btn btn-default">Done</button> -->
                            <button data-dismiss="modal" type="button" class="btn btn-default">Close</button>
                            <!-- <button  @click="saveitem(cartItems)" type="button" class="btn btn-default" >Save Data</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

    <script>
        Vue.component("v-select", VueSelect.VueSelect);
        new Vue({
            el: "#purchase",
            data() {
                return {
                    purchase: {
                        purchaseId: parseInt("<?php echo $purchaseId; ?>"),
                        invoice: "<?php echo $invoice; ?>",
                        purchaseFor: "",
                        purchaseDate: moment().format("YYYY-MM-DD"),
                        supplierId: "",
                        subTotal: 0.0,
                        vat: 0.0,
                        discount: 0.0,
                        freight: 0.0,
                        total: 0.0,
                        paid: 0.0,
                        due: 0.0,
                        previousDue: 0.0,
                        note: "",
                    },
                    vatPercent: 0.0,
                    branches: [],
                    selectedBranch: {
                        brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
                        Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>",
                    },
                    suppliers: [],
                    selectedSupplier: {
                        Supplier_SlNo: null,
                        Supplier_Code: "",
                        Supplier_Name: "",
                        display_name: "Select Supplier",
                        Supplier_Mobile: "",
                        Supplier_Address: "",
                        Supplier_Type: "",
                    },
                    oldSupplierId: null,
                    oldPreviousDue: 0,
                    products: [],
                    selectedProduct: {
                        Product_SlNo: "",
                        Product_Code: "",
                        display_text: "Select Product",
                        Product_Name: "",
                        Unit_Name: "",
                        quantity: 0,
                        Product_Purchase_Rate: "",
                        Product_SellingPrice: 0.0,
                        total: "",
                    },

                    cart: [],
                    purchaseOnProgress: false,
                    engineOnProgress: false,
                    engineDeleteOnProgress: false,
                    userType: '<?php echo $this->session->userdata("accountType") ?>',

                    cartItems: [],
                    details: [],
                    items: {
                        EngineNo: "",
                        chassisNo: "",
                    },
                    engineArray: [],
                    modalProductName: '',

                    allEnginChassis: [],
                };
            },
            created() {
                this.getBranches();
                this.getSuppliers();
                this.getProducts();
                this.getAllEngins();

                if (this.purchase.purchaseId != 0) {
                    this.getPurchase();
                }
            },
            methods: {
                getAllEngins() {
                    axios.get("/get_engine").then((res) => {
                        this.allEnginChassis = res.data;
                    });
                },
                addItems() {
                    // console.log(this.selectedProduct.quantity);
                    if (this.selectedProduct.quantity == this.cartItems.length) {
                        alert("Product quantity more then cart items!");
                        return;
                    }
                    if (this.items.EngineNo == "" || this.items.chassisNo == "") {
                        alert("Engine & Chassis number is Empty");
                        return;
                    }
                    if (this.items.EngineNo == this.items.chassisNo) {
                        alert("Engine & Chassis number is Same");
                        return;
                    }

                    let existEngine = this.allEnginChassis.findIndex((e) => e.EngineNo == this.items.EngineNo);
                    let existChassis = this.allEnginChassis.findIndex((c) => c.chassisNo == this.items.chassisNo);

                    if (existEngine > -1) {
                        alert("Engine Already purchased");
                        return;
                    }
                    if (existChassis > -1) {
                        alert("Chassis Already purchased");
                        return;
                    }


                    let cartI = this.cartItems.findIndex((CI) => CI.EngineNo == this.items.EngineNo);
                    let cartJ = this.cartItems.findIndex((CI) => CI.chassisNo == this.items.chassisNo);
                    if (cartI > -1 || cartJ > -1) {
                        alert("Data Already exist");
                        return;
                    } else {
                        this.cartItems.push(this.items);
                        this.items = {
                            EngineNo: "",
                            chassisNo: "",
                        };
                        // console.log(this.cartItems.length);
                    }
                },
                updateEng(item) {
                    this.engineOnProgress = true;

                    if (this.purchase.purchaseId != 0) {
                        data = {
                            engine_id: item.engine_id,
                            EngineNo: item.EngineNo,
                            chassisNo: item.chassisNo
                        };
                        axios.post("/update_engine", data).then((res) => {
                            let r = res.data;
                            alert(r.message);
                            if (r.success) {
                                window.location.reload();
                            } else {
                                this.engineOnProgress = false;
                            }
                        });
                    } else {
                        alert("Won't work in data insert.");
                        return 0;

                    }


                },
                deleteEng(item) {
                    this.engineDeleteOnProgress = true;
                    if (this.purchase.purchaseId != 0) {
                        axios.post("/delete_engine", {
                            engine_id: item.engine_id
                        }).then((res) => {
                            let r = res.data;
                            alert(r.message);
                            if (r.success) {
                                window.location.reload();
                                // if (this.purchase.purchaseId != 0) {
                                //     this.getPurchase();
                                // }
                            } else {
                                this.engineDeleteOnProgress = false;
                            }
                        });
                    } else {
                        alert("Won't work in data insert.");
                        return 0;
                    }
                },
                removeItem(index) {
                    this.cartItems.splice(index, 1);
                },

                getBranches() {
                    axios.get("/get_branches").then((res) => {
                        this.branches = res.data;
                    });
                },
                getSuppliers() {
                    axios.get("/get_suppliers").then((res) => {
                        this.suppliers = res.data;
                        this.suppliers.unshift({
                            Supplier_SlNo: "S01",
                            Supplier_Code: "",
                            Supplier_Name: "",
                            display_name: "General Supplier",
                            Supplier_Mobile: "",
                            Supplier_Address: "",
                            Supplier_Type: "G",
                        });
                    });
                },
                getProducts() {
                    axios.post("/get_products", {
                        isService: "false"
                    }).then((res) => {
                        this.products = res.data;
                    });
                },
                onChangeSupplier() {
                    if (this.selectedSupplier.Supplier_SlNo == null) {
                        return;
                    }

                    if (event.type == "readystatechange") {
                        return;
                    }

                    if (this.purchase.purchaseId != 0 && this.oldSupplierId != parseInt(this.selectedSupplier.Supplier_SlNo)) {
                        let changeConfirm = confirm("Changing supplier will set previous due to current due amount. Do you really want to change supplier?");
                        if (changeConfirm == false) {
                            return;
                        }
                    } else if (this.purchase.purchaseId != 0 && this.oldSupplierId == parseInt(this.selectedSupplier.Supplier_SlNo)) {
                        this.purchase.previousDue = this.oldPreviousDue;
                        return;
                    }

                    axios.post("/get_supplier_due", {
                        supplierId: this.selectedSupplier.Supplier_SlNo
                    }).then((res) => {
                        if (res.data.length > 0) {
                            this.purchase.previousDue = res.data[0].due;
                        } else {
                            this.purchase.previousDue = 0;
                        }
                    });
                },
                onChangeProduct() {
                    this.$refs.quantity.focus();
                },
                productTotal() {
                    this.selectedProduct.total = this.selectedProduct.quantity * this.selectedProduct.Product_Purchase_Rate;
                },
                addToCart() {
                    // console.log(this.selectedProduct.quantity);
                    if (this.selectedProduct.quantity != this.cartItems.length) {
                        alert("Add Engine & Chassis NO");
                        return false;
                    }


                    // localStorage.setItem('itemsDetail', JSON.stringify(this.cartItems));

                    let cartInd = this.cart.findIndex((p) => p.productId == this.selectedProduct.Product_SlNo);
                    if (cartInd > -1) {
                        alert("Product exists in cart");
                        return;
                    }

                    // let itmess = this.cartItems
                    // this.details.push(itmess)
                    //  console.log(this.details);
                    // // let cartItems =localStorage.getItem('itemsDetail');

                    // // let cartItemsDetails = JSON.parse(cartItems);

                    let product = {
                        productId: this.selectedProduct.Product_SlNo,
                        name: this.selectedProduct.Product_Name,
                        categoryId: this.selectedProduct.ProductCategory_ID,
                        categoryName: this.selectedProduct.ProductCategory_Name,
                        purchaseRate: this.selectedProduct.Product_Purchase_Rate,
                        salesRate: this.selectedProduct.Product_SellingPrice,
                        quantity: this.selectedProduct.quantity,
                        total: this.selectedProduct.total,
                        cartItemsDetails: this.cartItems,
                    };

                    this.cart.push(product);
                    // let engineArrayVar = this.engineArray
                    // this.engineArray = engineArrayVar.concat(this.cartItems);
                    this.clearSelectedProduct();
                    this.calculateTotal();
                    this.cartItems = [];
                    // console.log(this.engineArray);
                    // console.log(this.cart);
                    // console.log(this.cartItems);
                },
                removeFromCart(ind) {

                    // axios.post("/get_sold_stock", this.cart[ind]).then((res) => {
                    //      console.log(res.data)
                    //     if(res.data.stock[0].sold_quantity > 0) {
                    //         alert("This product already sold. You can't edit that");
                    //     } else {
                    //         this.cart.splice(ind, 1);
                    //         this.calculateTotal();
                    //     }
                    // });

                    // console.log(this.cart[ind]);
                    let i = 0;
                    this.cart[ind].cartItemsDetails.forEach(element => {
                        if (element.status == 's') {
                            i += 1;
                        }
                    });
                    if (i > 0) {
                        alert("This product has sold item. click i button for edit. :-)")
                        return;
                    } else {
                        this.cart.splice(ind, 1);
                        this.calculateTotal();
                    }
                },
                getEngineFromProduct(product) {
                    this.modalProductName = product.name;
                    this.engineArray = product.cartItemsDetails;
                },
                clearSelectedProduct() {
                    this.selectedProduct = {
                        Product_SlNo: "",
                        Product_Code: "",
                        display_text: "Select Product",
                        Product_Name: "",
                        Unit_Name: "",
                        quantity: "",
                        Product_Purchase_Rate: "",
                        Product_SellingPrice: 0.0,
                        total: "",
                    };
                },
                clearCartItems() {
                    this.cartItems = [];
                },

                calculateTotal() {
                    this.purchase.subTotal = this.cart.reduce((prev, curr) => {
                        return prev + parseFloat(curr.total);
                    }, 0);
                    this.purchase.vat = (this.purchase.subTotal * this.vatPercent) / 100;
                    this.purchase.total = parseFloat(this.purchase.subTotal) + parseFloat(this.purchase.vat) + parseFloat(this.purchase.freight) - this.purchase.discount;
                    if (this.selectedSupplier.Supplier_Type == "G") {
                        this.purchase.paid = this.purchase.total;
                    } else {
                        this.purchase.due = (parseFloat(this.purchase.total) - parseFloat(this.purchase.paid)).toFixed(2);
                    }
                },
                savePurchase() {
                    if (this.selectedSupplier.Supplier_SlNo == null) {
                        alert("Select supplier");
                        return;
                    }

                    if (this.purchase.purchaseDate == "") {
                        alert("Enter purchase date");
                        return;
                    }

                    if (this.cart.lenginth == 0) {
                        alert("Cart is empty");
                        return;
                    }

                    this.purchase.supplierId = this.selectedSupplier.Supplier_SlNo;
                    this.purchase.purchaseFor = this.selectedBranch.brunch_id;

                    this.purchaseOnProgress = true;

                    //let cartItemsDetails= this.cart.artItemsDetails;

                    // let cartItems =localStorage.getItem('itemsDetail');

                    // let cartItemsDetails = JSON.parse(cartItems);

                    let data = {
                        purchase: this.purchase,
                        cartProducts: this.cart,
                    };

                    if (this.selectedSupplier.Supplier_Type == "G") {
                        data.supplier = this.selectedSupplier;
                    }

                    let url = "/add_purchase";
                    if (this.purchase.purchaseId != 0) {
                        url = "/update_purchase";
                    }

                    axios.post(url, data).then(async (res) => {
                        let r = res.data;
                        alert(r.message);
                        if (r.success) {
                            let conf = confirm("Do you want to view invoice?");
                            if (conf) {
                                window.open(`/purchase_invoice_print/${r.purchaseId}`, "_blank");
                                await new Promise((r) => setTimeout(r, 1000));
                                window.location = "/purchase";
                            } else {
                                window.location = "/purchase";
                            }
                        } else {
                            this.purchaseOnProgress = false;
                        }
                    });
                },
                getPurchase() {
                    axios.post("/get_purchases", {
                        purchaseId: this.purchase.purchaseId
                    }).then((res) => {
                        let r = res.data;
                        let purchase = r.purchases[0];

                        this.selectedSupplier.Supplier_SlNo = purchase.Supplier_SlNo;
                        this.selectedSupplier.Supplier_Code = purchase.Supplier_Code;
                        this.selectedSupplier.Supplier_Name = purchase.Supplier_Name;
                        this.selectedSupplier.Supplier_Mobile = purchase.Supplier_Mobile;
                        this.selectedSupplier.Supplier_Address = purchase.Supplier_Address;
                        this.selectedSupplier.Supplier_Type = purchase.Supplier_Type;
                        this.selectedSupplier.display_name = purchase.Supplier_Type == "G" ? "General Supplier" : `${purchase.Supplier_Code} - ${purchase.Supplier_Name}`;

                        this.purchase.invoice = purchase.PurchaseMaster_InvoiceNo;
                        this.purchase.purchaseFor = purchase.PurchaseMaster_PurchaseFor;
                        this.purchase.purchaseDate = purchase.PurchaseMaster_OrderDate;
                        this.purchase.supplierId = purchase.Supplier_SlNo;
                        this.purchase.subTotal = purchase.PurchaseMaster_SubTotalAmount;
                        this.purchase.vat = purchase.PurchaseMaster_Tax;
                        this.purchase.discount = purchase.PurchaseMaster_DiscountAmount;
                        this.purchase.freight = purchase.PurchaseMaster_Freight;
                        this.purchase.total = purchase.PurchaseMaster_TotalAmount;
                        this.purchase.paid = purchase.PurchaseMaster_PaidAmount;
                        this.purchase.due = purchase.PurchaseMaster_DueAmount;
                        this.purchase.previousDue = purchase.previous_due;
                        this.purchase.note = purchase.PurchaseMaster_Description;

                        this.oldSupplierId = purchase.Supplier_SlNo;
                        this.oldPreviousDue = purchase.previous_due;

                        this.vatPercent = (this.purchase.vat * 100) / this.purchase.subTotal;

                        r.purchaseDetails.forEach((product) => {
                            let cartProduct = {
                                productId: product.Product_IDNo,
                                name: product.Product_Name,
                                categoryId: product.ProductCategory_ID,
                                categoryName: product.ProductCategory_Name,
                                purchaseRate: product.PurchaseDetails_Rate,
                                salesRate: product.Product_SellingPrice,
                                quantity: product.PurchaseDetails_TotalQuantity,
                                total: product.PurchaseDetails_TotalAmount,
                                cartItemsDetails: product.engines
                            };

                            this.cart.push(cartProduct);
                        });
                    });
                },
            },
        });
    </script>
</div>
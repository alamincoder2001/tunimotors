<style>
	.v-select{
		margin-bottom: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
	#branchDropdown .vs__actions button{
		display:none;
	}
	#branchDropdown .vs__actions .open-indicator{
		height:15px;
		margin-top:7px;
	}
</style>

<div id="sales" class="row">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
		<div class="row">
			<div class="form-group">
				<label class="col-md-1 col-xs-4 control-label no-padding-right"> Invoice no </label>
				<div class="col-md-2 col-xs-8">
					<input type="text" id="invoiceNo" class="form-control" v-model="sales.invoiceNo" readonly />
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-1 col-xs-4 control-label no-padding-right"> Sales By </label>
				<div class="col-md-2 col-xs-8">
					<v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name" placeholder="Select Employee"></v-select>
				</div>
			</div>

			<div class="form-group" style="display: none;">
				<label class="col-md-1 col-xs-4 control-label no-padding-right"> Sales From </label>
				<div class="col-md-2 col-xs-8">
					<v-select id="branchDropdown" v-bind:options="branches" label="Brunch_name" v-model="selectedBranch" disabled></v-select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-1 col-xs-4 control-label no-padding-right" style="padding-left: 0px;"> Due Reminder </label>
				<div class="col-md-2 col-xs-8">
					<input class="form-control" id="salesDate" type="date" v-model="sales.due_reminder_date"/>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 col-xs-12">
					<input class="form-control" id="salesDate" type="date" v-model="sales.salesDate" v-bind:disabled="userType == 'u' ? true : false"/>
				</div>
			</div>
		</div>
	</div>


	<div class="col-xs-12 col-md-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Sales Information</h4>
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
						<div class="col-md-5 col-xs-12">
							<div class="form-group clearfix" style="margin-bottom: 8px;">
								<label class="col-xs-4 control-label no-padding-right"> Sales Type </label>
								<div class="col-xs-8">
									<input type="radio" name="salesType" value="retail" v-model="sales.salesType" v-on:change="onSalesTypeChange"> Retail &nbsp;
									<input type="radio" name="salesType" value="wholesale" v-model="sales.salesType" v-on:change="onSalesTypeChange"> Wholesale
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Customer </label>
								<div class="col-xs-7">
									<v-select v-bind:options="customers" label="display_name" v-model="selectedCustomer" v-on:input="customerOnChange"></v-select>
								</div>
								<div class="col-xs-1" style="padding: 0;">
									<a href="<?= base_url('customer')?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Customer"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
								</div>
							</div>

							<div class="form-group" style="display:none;" v-bind:style="{display: selectedCustomer.Customer_Type == 'G' ? '' : 'none'}">
								<label class="col-xs-4 control-label no-padding-right"> Name </label>
								<div class="col-xs-8">
									<input type="text" id="customerName" placeholder="Customer Name" class="form-control" v-model="selectedCustomer.Customer_Name" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Mobile No </label>
								<div class="col-xs-8">
									<input type="text" id="mobileNo" placeholder="Mobile No" class="form-control" v-model="selectedCustomer.Customer_Mobile" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right"> Address </label>
								<div class="col-sm-8">
									<textarea id="address" placeholder="Address" class="form-control" v-model="selectedCustomer.Customer_Address" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true"></textarea>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-md-5">
							<form v-on:submit.prevent="addToCart">
								<div class="form-group">
									<label class="col-xs-3 control-label no-padding-right"> Product </label>
									<div class="col-xs-8">
										<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="productOnChange"></v-select>
									</div>
									<div class="col-xs-1" style="padding: 0;">
										<a href="<?= base_url('product')?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-3 control-label no-padding-right">E & C No: </label>
									<div class="col-xs-9">
										<v-select v-bind:options="EnginNumber" v-model="selectEnginNo" label="display_text"  ></v-select>
									</div>
								</div>

								<div class="form-group" style="display: none;">
									<label class="col-xs-3 control-label no-padding-right"> Brand </label>
									<div class="col-xs-9">
										<input type="text" id="brand" placeholder="Group" class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-3 control-label no-padding-right"> Sale Rate </label>
									<div class="col-xs-9">
										<input type="number" id="salesRate" placeholder="Rate" step="0.01" class="form-control" v-model="selectedProduct.Product_SellingPrice" v-on:input="productTotal"/>
									</div>
								</div>
								<div class="form-group" style="display: none;">
									<label class="col-xs-3 control-label no-padding-right"> Quantity </label>
									<div class="col-xs-9">
										<input type="number" step="0.01" id="quantity" placeholder="Qty" class="form-control"  v-model="selectedProduct.quantity" v-on:input="productTotal"  autocomplete="off" />
									</div>
								</div>

								<div class="form-group" >
									<label class="col-xs-4 control-label no-padding-right">Offer Disc.</label>
									<div class="col-xs-8 no-padding-left">
										<input type="number" v-model="selectedProduct.productDiscount" v-on:input="productTotal"  class="form-control" placeholder="Discount" />
									</div>
								</div>
								<div class="form-group" >
									<label class="col-xs-3 control-label no-padding-right"> Amount </label>
									<div class="col-xs-9">
										<input type="text" id="productTotal" placeholder="Amount" class="form-control" v-model="selectedProduct.total" readonly />
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-3 control-label no-padding-right"> </label>
									<div class="col-xs-9">
										<button type="submit" class="btn btn-default pull-right">Add to Cart</button>
									</div>
								</div>
							</form>

						</div>
						<div class="col-xs-12 col-md-2">
							<div style="display:none;" v-bind:style="{display:sales.isService == 'true' ? 'none' : ''}">
								<div class="text-center" style="display:none;" v-bind:style="{color: productStock > 0 ? 'green' : 'red', display: selectedProduct.Product_SlNo == '' ? 'none' : ''}">{{ productStockText }}</div class="text-center">

								<input type="text" id="productStock" v-model="productStock" readonly style="border:none;font-size:20px;width:100%;text-align:center;color:green"><br>
								<input type="text" id="stockUnit" v-model="selectedProduct.Unit_Name" readonly style="border:none;font-size:12px;width:100%;text-align: center;"><br><br>
							</div>
							<input type="password" ref="productPurchaseRate" v-model="selectedProduct.Product_Purchase_Rate" v-on:mousedown="toggleProductPurchaseRate" v-on:mouseup="toggleProductPurchaseRate"  readonly title="Purchase rate (click & hold)" style="font-size:12px;width:100%;text-align: center;">

						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
					<thead>
						<tr class="">
							<th style="width:10%;color:#000;">Sl</th>
							<th style="width:25%;color:#000;">Category</th>
							<th style="width:20%;color:#000;">Product Name</th>
							<th style="width:7%;color:#000;">Qty</th>
							<th style="width:8%;color:#000;">Engine NO</th>
							<th style="width:8%;color:#000;">Chassis NO</th>
							<th style="width:8%;color:#000;">Discount</th>
							<th style="width:15%;color:#000;">Total Amount</th>
							<th style="width:15%;color:#000;">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart">
							<td>{{ sl + 1 }}</td>
							<td>{{ product.categoryName }}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.engin.EngineNo }}</td>
							<td>{{ product.engin.chassisNo }}</td>
							<td>{{ product.Discount_amount }}</td>
							<td>{{ product.total }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>

						<tr>
							<td colspan="7"></td>
						</tr>

						<tr style="font-weight: bold;">
							<td colspan="4">Note</td>
							<td colspan="3">Total</td>
						</tr>

						<tr>
							<td colspan="4"><textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="sales.note"></textarea></td>
							<td colspan="3" style="padding-top: 15px;font-size:18px;">{{ sales.total }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="col-xs-12 col-md-3 col-lg-3">
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
								<table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Sub Total</label>
												<div class="col-sm-12">
													<input type="number" id="subTotal" class="form-control" v-model="sales.subTotal" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right"> Vat </label>
												<div class="col-sm-4">
													<input type="number" id="vatPercent" class="form-control" v-model="vatPercent" v-on:input="calculateTotal"/>
												</div>
												<label class="col-sm-1 control-label no-padding-right">%</label>
												<div class="col-sm-7">
													<input type="number" id="vat"  class="form-control" v-model="sales.vat" v-on:input="calculateTotal"/>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Discount Persent</label>

												<div class="col-sm-4">
													<input type="number" id="discountPercent" class="form-control" v-model="discountPercent" v-on:input="calculateTotal"/>
												</div>

												<label class="col-sm-1 control-label no-padding-right">%</label>

												<div class="col-sm-7">
													<input type="number" id="discount" class="form-control" v-model="sales.discount" v-on:input="calculateTotal"/>
												</div>

											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Showroom Discount</label>

												<div class="col-sm-4">
													<input type="number" id="companydiscount" class="form-control" v-model="companydiscount" v-on:input="calculateTotal"/>
												</div>

												<label class="col-sm-1 control-label no-padding-right">%</label>

												<div class="col-sm-7">
													<input type="number" id="discount" class="form-control" v-model="sales.showroom_discount" v-on:input="calculateTotal"/>
												</div>

												<div class="col-sm-12">
													<input type="text" v-model="sales.showroom_discount_reference" class="form-control" placeholder="Reference Name">
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Special Discount</label>

												<div class="col-sm-4">
													<input type="number" id="specialDiscount" class="form-control" v-model="specialDiscount" v-on:input="calculateTotal"/>
												</div>

												<label class="col-sm-1 control-label no-padding-right">%</label>

												<div class="col-sm-7">
													<input type="number" id="discount" class="form-control" v-model="sales.special_discount" v-on:input="calculateTotal"/>
												</div>

											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Head Office Discount</label>

												<div class="col-sm-4">
													<input type="number" id="headOfficeDiscount" class="form-control" v-model="headOfficeDiscount" v-on:input="calculateTotal"/>
												</div>

												<label class="col-sm-1 control-label no-padding-right">%</label>

												<div class="col-sm-7">
													<input type="number" id="discount" class="form-control" v-model="sales.head_office_discount" v-on:input="calculateTotal"/>
												</div>

												<div class="col-sm-12">
													<input type="text" v-model="sales.head_office_discount_reference" class="form-control" placeholder="Reference Name">
												</div>

											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Agent Discount</label>

												<div class="col-sm-4">
													<input type="number" id="offerDiscount" class="form-control" v-model="offerDiscount" v-on:input="calculateTotal"/>
												</div>

												<label class="col-sm-1 control-label no-padding-right">%</label>

												<div class="col-sm-7">
													<input type="number" id="discount" class="form-control" v-model="sales.agent_discount" v-on:input="calculateTotal"/>
												</div>

											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Transport Cost</label>
												<div class="col-sm-12">
													<input type="number" class="form-control" v-model="sales.transportCost" v-on:input="calculateTotal"/>
												</div>
											</div>
										</td>
									</tr>

									<tr style="display:none;">
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Round Of</label>
												<div class="col-sm-12">
													<input type="number" id="roundOf" class="form-control" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Total</label>
												<div class="col-sm-12">
													<input type="number" id="total" class="form-control" v-model="sales.total" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Paid</label>
												<div class="col-sm-12">
													<input type="number" id="paid" class="form-control" v-model="sales.paid" v-on:input="calculateTotal" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? true : false"/>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label">Due</label>
												<div class="col-sm-6">
													<input type="number" id="due" class="form-control" v-model="sales.due" readonly/>
												</div>
												<div class="col-sm-6">
													<input type="number" id="previousDue" class="form-control" v-model="sales.previousDue" readonly style="color:red;"  />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<div class="col-sm-6">
													<input type="button" class="btn btn-default btn-sm" value="Sale" v-on:click="saveSales" v-bind:disabled="saleOnProgress ? true : false" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">
												</div>
												<div class="col-sm-6">
													<a class="btn btn-info btn-sm" v-bind:href="`/sales/${sales.isService == 'true' ? 'service' : 'product'}`" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">New Sale</a>
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
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#sales',
		data(){
			return {
				sales:{
					salesId: parseInt('<?php echo $salesId;?>'),
					invoiceNo: '<?php echo $invoice;?>',
					salesBy: '<?php echo $this->session->userdata("FullName"); ?>',
					salesType: 'retail',
					salesFrom: '',
					salesDate: '',
					due_reminder_date: moment().format('YYYY-MM-DD'),
					customerId: '',
					employeeId: null,
					subTotal: 0.00,
					discount: 0.00,
					showroom_discount: 0.00,
					showroom_discount_reference: '',
					special_discount: 0.00,
					head_office_discount: 0.00,
					head_office_discount_reference: '',
					agent_discount: 0.00,
					vat: 0.00,
					transportCost: 0.00,
					total: 0.00,
					paid: 0.00,
					previousDue: 0.00,
					due: 0.00,
					isService: '<?php echo $isService;?>',
					note: '', 
					reference: ''
				},
				vatPercent: 0,
				discountPercent: 0,
				companydiscount: 0,
				specialDiscount: 0,
				headOfficeDiscount: 0,
				offerDiscount: 0,
				cart: [],
				employees: [],
                selectedEmployee: null,
				branches: [],
				selectedBranch: {
					brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
					Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
				},
				customers: [],
				selectedCustomer:{
					Customer_SlNo: '',
					Customer_Code: '',
					Customer_Name: '',
					display_name: 'Select Customer',
					Customer_Mobile: '',
					Customer_Address: '',
					Customer_Type: ''
				},
				oldCustomerId: null,
				oldPreviousDue: 0,
				products: [],
				selectedProduct: {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: 1,
					productDiscount: 0.00,
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					vat: 0.00,
					total: 0.00
				},
				productPurchaseRate: '',
				productStockText: '',
				productStock: '',
				saleOnProgress: false,
				userType: '<?php echo $this->session->userdata("accountType");?>',
				EnginNumber:[],
				selectEnginNo: {
					enginNO:'',
					chassis:'',
					selectEngin:'Select Engin & chassis No',
					engine_id:'',
					display_text: 'Select Engine & Chassis'
				}
			}
		},
		created(){
			this.sales.salesDate = moment().format('YYYY-MM-DD');
			this.getEmployees();
			this.getBranches();
			this.getCustomers();
			this.getProducts();
			if(this.sales.salesId != 0){
				this.getSales();
			}
		},
		methods:{
			getEmployees(){
				axios.get('/get_employees').then(res => {
						this.employees = res.data;
				})
			},
			getBranches(){
				axios.get('/get_branches').then(res=>{
					this.branches = res.data;
				})
			},
			getCustomers(){
				axios.post('/get_customers', {customerType: this.sales.salesType}).then(res=>{
					this.customers = res.data;
					this.customers.unshift({
						Customer_SlNo: 'C01',
						Customer_Code: '',
						Customer_Name: '',
						display_name: 'General Customer',
						Customer_Mobile: '',
						Customer_Address: '',
						Customer_Type: 'G'
					})
				})
			},
			getProducts(){
				axios.post('/get_products', {isService: this.sales.isService}).then(res=>{
					if(this.sales.salesType == 'wholesale'){
						this.products = res.data.filter((product) => product.Product_WholesaleRate > 0);
						this.products.map((product) => {
							return product.Product_SellingPrice = product.Product_WholesaleRate;
						})
					} else {
						this.products = res.data;
					}
				})
			},
			productTotal(){
				// this.selectedProduct.total = (parseFloat(this.selectedProduct.Product_SellingPrice) - parseFloat(this.selectedProduct.productDiscount)).toFixed(2);
				// console.log(parseFloat(this.selectedProduct.Product_SellingPrice).toFixed(2))
				// console.log(parseFloat(this.selectedProduct.productDiscount).toFixed(2)

				let salePrice = this.selectedProduct.Product_SellingPrice == null || this.selectedProduct.Product_SellingPrice == '' ? 0 : this.selectedProduct.Product_SellingPrice;
				let discount = this.selectedProduct.productDiscount == null || this.selectedProduct.productDiscount == '' ? 0 : this.selectedProduct.productDiscount;
				this.selectedProduct.total = (parseFloat(salePrice) - parseFloat(discount)).toFixed(2)
			},
			onSalesTypeChange(){
				this.selectedCustomer = {
					Customer_SlNo: '',
					Customer_Code: '',
					Customer_Name: '',
					display_name: 'Select Customer',
					Customer_Mobile: '',
					Customer_Address: '',
					Customer_Type: ''
				}
				this.getCustomers();
				this.clearProduct();
				this.getProducts();
			},
			async customerOnChange(){
				if(this.selectedCustomer.Customer_SlNo == ''){
					return;
				}
				if(event.type == 'readystatechange'){
					return;
				}

				if(this.sales.salesId != 0 && this.oldCustomerId != parseInt(this.selectedCustomer.Customer_SlNo)){
					let changeConfirm = confirm('Changing customer will set previous due to current due amount. Do you really want to change customer?');
					if(changeConfirm == false){
						return;
					}
				} else if(this.sales.salesId != 0 && this.oldCustomerId == parseInt(this.selectedCustomer.Customer_SlNo)){
					this.sales.previousDue = this.oldPreviousDue;
					return;
				}
				await axios.post('/get_customer_due',{customerId: this.selectedCustomer.Customer_SlNo}).then(res=>{
					if(res.data.length > 0){
						this.sales.previousDue = res.data[0].dueAmount;
					} else {
						this.sales.previousDue = 0;
					}
				})
			},
			async productOnChange(){
				
				if((this.selectedProduct.Product_SlNo != '' || this.selectedProduct.Product_SlNo != 0) && this.sales.isService == 'false'){
					this.productStock = await axios.post('/get_product_stock', {productId: this.selectedProduct.Product_SlNo}).then(res => {
						// if (this.productStock > 0) {
						// 	alert('out of stock')
						// }
						return res.data;
					})
					this.EnginNumber = await axios.post('/get_engine_no', {productId: this.selectedProduct.Product_SlNo}).then(res => {
						return res.data;
					})
					this.selectedProduct.quantity = 1;
					// this.selectedProduct.productDiscount = 0.00;
					this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";
				}

				// this.$refs.quantity.focus();
				this.productTotal()
			},
			toggleProductPurchaseRate(){
				//this.productPurchaseRate = this.productPurchaseRate == '' ? this.selectedProduct.Product_Purchase_Rate : '';
				this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' : 'text';
			},
			addToCart(){
				
				if (this.cart.length >0) {
					let findEngine = this.cart.find(cp => cp.engin.engine_id == this.selectEnginNo.engine_id);
					if(findEngine != null && findEngine != undefined) {
						alert('Not found')
						return;
					}
				}
				
				if(this.selectEnginNo.engine_id == null || this.selectEnginNo.engine_id == "") {
					alert('Select Engine No. & Chassis No.');
					return;
				}
			
				let product = {
					productId : this.selectedProduct.Product_SlNo,
					categoryName: this.selectedProduct.ProductCategory_Name,
					name: this.selectedProduct.Product_Name,
					salesRate: this.selectedProduct.Product_SellingPrice,
					vat: this.selectedProduct.vat,
					quantity: this.selectedProduct.quantity, 
					Discount_amount: this.selectedProduct.productDiscount ? this.selectedProduct.productDiscount : 0.00,
					total:  this.selectedProduct.total,
					purchaseRate: this.selectedProduct.Product_Purchase_Rate,
					engin : this.selectEnginNo
				}
				

				if(product.productId == ''){
					alert('Select Product');
					return;
				}

				// if(product.quantity == 0 || product.quantity == ''){
				// 	alert('Enter quantity');
				// 	return;
				// }

				// if(product.salesRate == 0 || product.salesRate == ''){
				// 	alert('Enter sales rate');
				// 	return;
				// }
				if(product.quantity > this.productStock && this.sales.isService == 'false'){
					alert('Stock unavailable');
					return;
				}

				this.cart.unshift(product);
				this.clearProduct();
				this.calculateTotal();
				this.clearCartItems();
			},
			removeFromCart(ind){
				this.cart.splice(ind, 1);
				this.calculateTotal();
			},
			clearCartItems(){
				this.selectEnginNo = {}
				this.EnginNumber={}
				
			},
			clearProduct(){
				this.selectedProduct = {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: 1,
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					vat: 0.00,
					total: 0.00
				}
				this.productStock = '';
				this.productStockText = '';
			},
			calculateTotal(){
				this.sales.subTotal = this.cart.reduce((prev, curr) => { return prev + parseFloat(curr.total)}, 0).toFixed(2);
				// this.sales.vat = ((parseFloat(this.sales.subTotal) * parseFloat(this.vatPercent)) / 100).toFixed(2);
				if(event.target.id == 'discountPercent'){
					this.sales.discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
				} else {
					this.discountPercent = (parseFloat(this.sales.discount) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}

				if(event.target.id == 'companydiscount'){
					this.sales.showroom_discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.companydiscount)) / 100).toFixed(2);
				} else {
					this.companydiscount = (parseFloat(this.sales.showroom_discount) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}

				if(event.target.id == 'specialDiscount'){
					this.sales.special_discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.specialDiscount)) / 100).toFixed(2);
				} else {
					this.specialDiscount = (parseFloat(this.sales.special_discount) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}

				if(event.target.id == 'headOfficeDiscount'){
					this.sales.head_office_discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.headOfficeDiscount)) / 100).toFixed(2);
				} else {
					this.headOfficeDiscount = (parseFloat(this.sales.head_office_discount) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}
				
				if(event.target.id == 'offerDiscount'){
					this.sales.agent_discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.offerDiscount)) / 100).toFixed(2);
				} else {
					this.offerDiscount = (parseFloat(this.sales.agent_discount) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}

				if(event.target.id == 'vatPercent'){
					this.sales.vat = ((parseFloat(this.sales.subTotal) * parseFloat(this.vatPercent)) / 100).toFixed(2);
				} else {
					this.vatPercent = (parseFloat(this.sales.vat) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}
				let totalDiscount = (parseFloat(this.sales.discount) + parseFloat(this.sales.showroom_discount) + parseFloat(this.sales.special_discount) + parseFloat(this.sales.head_office_discount) + parseFloat(this.sales.agent_discount)).toFixed(2);
				this.sales.total = ((parseFloat(this.sales.subTotal) + parseFloat(this.sales.vat) + parseFloat(this.sales.transportCost)) - parseFloat(totalDiscount)).toFixed(2);
				if(this.selectedCustomer.Customer_Type == 'G'){
					this.sales.paid = this.sales.total;
				} else {
					this.sales.due = (parseFloat(this.sales.total) - parseFloat(this.sales.paid)).toFixed(2);
				}
			},
			async saveSales(){
				if(this.selectedCustomer.Customer_SlNo == ''){
					alert('Select Customer');
					return;
				}
				if(this.cart.length == 0){
					alert('Cart is empty');
					return;
				}

				let currentDate = moment().format('YYYY-MM-DD');
				if (this.sales.due_reminder_date == currentDate && this.selectedCustomer.Customer_Type != 'G' && this.sales.due != 0) {
					alert("You can't sale cuase Due Reminder date is Today!");
					return;
				}
				await this.customerOnChange();

				if(parseFloat(this.selectedCustomer.Customer_Credit_Limit) < (parseFloat(this.sales.due) + parseFloat(this.sales.previousDue))){
					alert(`Customer credit limit (${this.selectedCustomer.Customer_Credit_Limit}) exceeded`);
					return;
				}

				if(this.selectedEmployee != null && this.selectedEmployee.Employee_SlNo != null){
					this.sales.employeeId = this.selectedEmployee.Employee_SlNo;
				} else {
					this.sales.employeeId = null;
				}

				let url = "/add_sales";
				if(this.sales.salesId != 0){
					url = "/update_sales";
				}

				this.sales.customerId = this.selectedCustomer.Customer_SlNo;
				this.sales.salesFrom = this.selectedBranch.brunch_id;

				this.saleOnProgress = true;

				let data = {
					sales: this.sales,
					cart: this.cart
				}
				console.log(data);
				if(this.selectedCustomer.Customer_Type == 'G'){
					data.customer = this.selectedCustomer;
				}
				axios.post(url, data).then(async res=> {
					let r = res.data;
					if(r.success){
						let conf = confirm('Sale success, Do you want to view invoice?');
						if(conf){
							window.open('/sale_invoice_print/'+r.salesId, '_blank');
							await new Promise(r => setTimeout(r, 1000));
							window.location = this.sales.isService == 'false' ? '/sales/product' : '/sales/service';
						} else {
							window.location = this.sales.isService == 'false' ? '/sales/product' : '/sales/service';
						}
					} else {
						alert(r.message);
						this.saleOnProgress = false;
					}
				})
			},
			getSales(){
				axios.post('/get_sales', {salesId: this.sales.salesId}).then(res=>{
					let r = res.data;
					let sales = r.sales[0];
					this.sales.salesBy = sales.AddBy;
					this.sales.salesFrom = sales.SaleMaster_branchid;
					this.sales.salesDate = sales.SaleMaster_SaleDate;
					this.sales.salesType = sales.SaleMaster_SaleType;
					this.sales.customerId = sales.SalseCustomer_IDNo;
					this.sales.employeeId = sales.Employee_SlNo;
					this.sales.subTotal = sales.SaleMaster_SubTotalAmount;
					this.sales.discount = sales.SaleMaster_TotalDiscountAmount;
					this.sales.vat = sales.SaleMaster_TaxAmount;
					this.sales.transportCost = sales.SaleMaster_Freight;
					this.sales.total = sales.SaleMaster_TotalSaleAmount;
					this.sales.paid = sales.SaleMaster_PaidAmount;
					this.sales.previousDue = sales.SaleMaster_Previous_Due;
					this.sales.due = sales.SaleMaster_DueAmount;
					this.sales.note = sales.SaleMaster_Description;

					this.oldCustomerId = sales.SalseCustomer_IDNo;
					this.oldPreviousDue = sales.SaleMaster_Previous_Due;

					this.vatPercent = parseFloat(this.sales.vat) * 100 / parseFloat(this.sales.subTotal);
					this.discountPercent = parseFloat(this.sales.discount) * 100 / parseFloat(this.sales.subTotal);
					this.companydiscount = parseFloat(this.sales.discount) * 100 / parseFloat(this.sales.subTotal);

					this.selectedEmployee = {
						Employee_SlNo: sales.employee_id,
						Employee_Name: sales.Employee_Name
					}

					this.selectedCustomer = {
						Customer_SlNo: sales.SalseCustomer_IDNo,
						Customer_Code: sales.Customer_Code,
						Customer_Name: sales.Customer_Name,
						display_name: sales.Customer_Type == 'G' ? 'General Customer' : `${sales.Customer_Code} - ${sales.Customer_Name}`,
						Customer_Mobile: sales.Customer_Mobile,
						Customer_Address: sales.Customer_Address,
						Customer_Type: sales.Customer_Type
					}

					r.saleDetails.forEach(product => {
						let cartProduct = {
							productId: product.Product_IDNo,
							categoryName: product.ProductCategory_Name,
							name: product.Product_Name,
							salesRate: product.SaleDetails_Rate,
							vat: product.SaleDetails_Tax,
							quantity: product.SaleDetails_TotalQuantity,
							total: product.SaleDetails_TotalAmount,
							purchaseRate: product.Purchase_Rate,
							Discount_amount: product.SaleDetails_Discount,
							engin: {
								EngineNo: product.EngineNo,
								chassisNo: product.chassisNo,
								engine_id: product.Engin_Id
							}
						}

						this.cart.push(cartProduct);
					})

					this.getCustomers();
					this.getProducts();
				})

				
			}
		}
	})
</script>
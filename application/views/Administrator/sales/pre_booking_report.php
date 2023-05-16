<style>
	.v-select{
		margin-top:-2.5px;
        float: right;
        min-width: 180px;
        margin-left: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
        height: 25px;
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
	#customerprebookReport select{
		padding:0;
		border-radius: 4px;
	}
	#customerprebookReport .form-group{
		margin-right: 5px;
	}
	#customerprebookReport *{
		font-size: 13px;
	}
	.record-table{
		width: 100%;
		border-collapse: collapse;
	}
	.record-table thead{
		background-color: #0097df;
		color:white;
	}
	.record-table th, .record-table td{
		padding: 3px;
		border: 1px solid #454545;
	}
    .record-table th{
        text-align: center;
    }
</style>
<div class="row" id="customerprebookReport">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right"> Search Type </label>
			<div class="col-sm-2">
                <select class="form-control" v-model="searchType" @change="onChangeSearchType">
                    <option value="">All</option>
                    <option value="customer">By Customer</option>
                    <option value="delivery">By Delivery Status</option>
                </select>
			</div>
		</div>
		<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'customer' && customers.length > 0 ? '' : 'none'}">
			<div class="col-sm-2">
				<v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
			</div>
		</div>

		<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'delivery' && delivers.length > 0 ? '' : 'none'}">
			<div class="col-sm-2">
				<v-select v-bind:options="delivers" v-model="selectedDeliver" label="deliveryStatus"></v-select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right"> Date from </label>
			<div class="col-sm-2">
				<input type="date" class="form-control" v-model="dateFrom">
			</div>
			<label class="col-sm-1 control-label no-padding-right text-center" style="width:30px"> to </label>
			<div class="col-sm-2">
				<input type="date" class="form-control" v-model="dateTo">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-1">
				<input type="button" class="btn btn-primary" value="Show" v-on:click="getReport" style="margin-top:0px;border:0px;height:28px;">
			</div>
		</div>
	</div>

	<div class="col-sm-12" style="display:none;" v-bind:style="{display: showTable ? '' : 'none'}">
		<a href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
			<i class="fa fa-print"></i> Print
		</a>
		<div class="table-responsive" id="reportTable">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th style="text-align:center">Delivery Date</th>
						<th style="text-align:center">Customer</th>
						<th style="text-align:center">Mobile</th>
						<th style="text-align:center">Product Name</th>
						<th style="text-align:center">Color</th>
						<th style="text-align:center">Price</th>
						<th style="text-align:center">Advance</th>
						<th style="text-align:center">Delivery Status</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="prebook in prebookings">
                        <td>{{ prebook.delivery_date | formatDateTime('MMMM Do YYYY') }}</td>
						<td>{{ prebook.Customer_Name }}</td>
						<td>{{ prebook.mobile }}</td>
						<td>{{ prebook.Product_Name }}</td>
						<td>{{ prebook.color_name }}</td>
						<td>{{ prebook.price }}</td>
						<td>{{ prebook.advance }}</td>
						<td>
                            <span v-if="prebook.delivery_status == 'p'" class="badge badge-danger">Pending</span>
                            <span v-else class="badge badge-success">Delivered</span>
                        </td>
					</tr>
				</tbody>
				<tbody v-if="prebookings.length == 0">
					<tr>
						<td colspan="8">No records found</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5" style="text-align: right;">Total:</th>
						<th>{{ prebookings.reduce((prev, curr) => { return prev + parseFloat(curr.price)}, 0) }}</th>
						<th>{{ prebookings.reduce((prev, curr) => { return prev + parseFloat(curr.advance)}, 0) }}</th>
					</tr>
				</tfoot>
			</table>
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
		el: '#customerprebookReport',
		data(){
			return {
                searchType: '',
				customers: [],
				selectedCustomer: null,
				dateFrom: null,
				dateTo: null,
				prebookings: [],
				showTable: false,
				delivers: [],
				selectedDeliver: '',
			}
		},

        filters: {
			formatDateTime(dt, format) {
				return dt == '' || dt == null ? '' : moment(dt).format(format);
			}
		},

		created(){
			let today = moment().format('YYYY-MM-DD');
			this.dateTo = today;
			this.dateFrom = moment().format('YYYY-MM-DD');
			this.getCustomers();
			this.getDeliveryStatus();
		},
		methods:{
            onChangeSearchType(){
				if(this.searchType == 'customer'){
					this.getCustomers();
				}
				else if(this.searchType == 'delivery'){
					this.getDeliveryStatus();
				}
			},
			getCustomers(){
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
				})
			},
			getDeliveryStatus(){
				axios.get('/get_delivery_status').then(res => {
					this.delivers = res.data;
				})
			},
			getReport(){
				if(this.searchType != 'customer'){
					this.selectedCustomer = null;
				}
				if(this.searchType != 'delivery'){
					this.selectedDeliver = '';
				}
				let data = {
					dateFrom: this.dateFrom,
					dateTo: this.dateTo,
					customerId: this.selectedCustomer == null || this.selectedCustomer.Customer_SlNo == '' ? '' : this.selectedCustomer.Customer_SlNo,
					Delivery: this.selectedDeliver == '' || this.selectedDeliver.delivery_status == '' ? '' : this.selectedDeliver.delivery_status,
				}

				axios.post('/get_pre_booking', data).then(res => {
					this.prebookings = res.data;
					this.showTable = true;
				})
			},
			async print(){
				let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Customer PreBooking Report</h4 style="text-align:center">
					</div>
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

				var mywindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				mywindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				mywindow.document.body.innerHTML += reportContent;

				mywindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				mywindow.print();
				mywindow.close();
			}
		}
	})
</script>
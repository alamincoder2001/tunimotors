<style>
tr{
		border-right: 1px solid #000;
	}
	th{
		border-right: 1px solid #000;
	}
	tr td{
		border-right: 1px solid #000;
		padding: 4px;
	}
	</style>
<div id="balanceSheet">
    <form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
        <div class="form-horizontal">
            <div class="col-sm-12">

                <label class="col-sm-4 control-label" for="Customer_id"> Date </label>
                <label class="col-sm-1 control-label">:</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" v-model="dateTo">
                    <input type="submit" value="Search">
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12" style="padding-top:15px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div id="printContent">
        <div class="row">
            <div class="col-md-12">
                <div style="display:flex;">
                    <div style="width:70%;border:1px solid black;position:relative;">
                        <table class="day-book-table col-md-12">
                            <thead>
                                <tr style="border-bottom:1px solid black;">
                                    <th>Description</th>
                                    <th>    </th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template>
                                    <tr v-if="openingBalance.cashBalance != null">
                                        <td class="sub-heading"><strong>Cash in Hand</strong></td>
                                        <td class="sub-value"></td>
                                        <td class="sub-value"><?php echo number_format($transaction_summary->cash_balance, 2);?>
                                        </td>
                                    </tr>

                                </template>
                                <template>
                                    <tr>
                                        <td class="sub-heading"> <strong>Bank Accounts</strong></td>
                                        <td class="sub-value">{{ totalBankOpeningBalance }}</td>
                                        <td class="sub-value"></td>
                                    </tr>
                                    <template>
                                        <tr v-for="bankAccount in openingBalance.bankBalance">
                                            <td>{{ bankAccount.bank_name }} {{ bankAccount.account_name }}
                                                {{ bankAccount.account_number }}</td>
                                            <td>{{ bankAccount.balance | decimal }}</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{ bankBalance.reduce((prev, curr) => { return prev + parseFloat(curr.balance)}, 0) }}
                                            </td>
                                        </tr>


                                    </template>
                                </template>

                                <tr>
                                    <td class="main-heading"><strong>Stock Value</strong></td>
                                    <td class="sub-value"></td>
                                    <td class="sub-value">{{ stock || 0 }}</td>
                                </tr>
                                <template>
                                    <tr>
                                        <td class="sub-heading"><strong>Customer Due</strong></td>
                                        <td class="sub-value"></td>
                                        <td class="sub-value">
                                            {{ customerDue.reduce((prev, curr) => { return prev + parseFloat(curr.dueAmount)}, 0) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sub-heading"><strong>Supplier Due</strong></td>
                                        <td class="sub-value"></td>
                                        <td class="sub-value">{{ total || 0  }}</td>
                                    </tr>
                                    <!-- <tr v-for="sale in sales">
										<td>{{ sale.Customer_Name }}</td>
										<td>{{ sale.totalAmount | decimal }}</td>
									</tr> -->
                                </template>
                                <template >
									<tr>
										<td class="sub-heading">Offer Discount</td>
										<td class="sub-value">{{ discountOut || 0  }}</td>
										<td class="sub-value"></td>
									</tr>
									
                                    <tr>
										<td class="sub-heading">Special Discount</td>
										<td class="sub-value">{{ specialDiscount || 0  }}</td>
										<td class="sub-value"></td>
									</tr>
                                    <tr>
										<td class="sub-heading">Head Office Discount</td>
										<td class="sub-value">{{ HeadOfficeDiscount || 0  }}</td>
										<td class="sub-value"></td>
									</tr>
                                    <tr>
										<td class="sub-heading">Showroom Discount</td>
										<td class="sub-value">{{ ShowroomDiscount || 0  }}</td>
										<td class="sub-value"></td>
									</tr>
                                    <tr>
										<td class="sub-heading">Agent Discount</td>
										<td class="sub-value">{{ agentDiscount || 0  }}</td>
										<td class="sub-value"></td>
									</tr>

                                    <tr >
										<td> Received</td>
										<td>{{ discountIn.total_in || 0  }}</td>
										<td></td>
									</tr>
									<tr >
										<td> </td>
										<td> </td>
										<td>{{( discountIn.total_in ) - (discountOut)- specialDiscount - HeadOfficeDiscount - ShowroomDiscount - agentDiscount || 0 }}</td>
									</tr>
								</template>

                                <template >
									<tr>
										<td class="sub-heading">Tuni Motor (OUT)</td>
										<td class="sub-value">{{ clime.total_out || 0 }}</td>
										<td class="sub-value"></td>
									</tr>
									<tr >
										<td> Tuni Motor (IN)</td>
										<td>{{ clime.total_in || 0 }}</td>
										<td></td>
									</tr>
									<tr >
										<td> </td>
										<td> </td>
										<td>{{( clime.total_in ) + (clime.total_out) }}</td>
									</tr>
                                    
								</template>
							   
                            </tbody>
                        </table>
                        <!-- <div style="position:absolute;bottom:0px;left:0px;padding:5px 10px;display:none;width:100%;border-top:1px solid black;font-weight:bold;"
							v-bind:style="{display: _.isNumber(totalIn) ? 'flex' : 'none' }">
							<div style="width:50%;">Total</div>
							<div style="width:50%;text-align:right;">{{ totalIn | decimal }}</div>
						</div> -->
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
<script src="<?php echo base_url(); ?>assets/js/lodash.min.js"></script>

<script>
new Vue({
    el: '#balanceSheet',
    data() {
        return {
            dateTo: moment().format('YYYY-MM-DD'),
            openingBalance: [],
            bankBalance: [],
            totalBankOpeningBalance: '',
            sales: [],
            stock: null,
            customerDue: [],
            supplierDue: [],
            total: 0.00,
			discountOut:0.00,
			specialDiscount:0.00,
			HeadOfficeDiscount:0.00,
			ShowroomDiscount:0.00,
			agentDiscount:0.00,
			discountIn:{
				total_in:0.00
			},
			clime:{
				total_in:0.00,
				total_out:0.00,
			},


        }
    },
    created() {
       
    },
    methods: {

        totalSales() {
            return this.sales.reduce((prev, curr) => {
                return prev + parseFloat(curr.totalAmount)
            }, 0).toFixed(2);
        },

        customerDue() {
            return this.allcustomerDue.reduce((prev, curr) => {
                return prev + parseFloat(curr.dueAmount)
            }, 0).toFixed(2);
        },
        getSearchResult() {
            this.getBank();
            this.getStock();
            this.getCustomerDue();
            this.getSupplierDue();
			this.getTotalDiscount();

        },

        getBank() {
            let bank = {
                date: this.dateTo
            }
            let url = '/get_cash_and_bank_balance';
            axios.post(url, bank)
                .then(res => {
                    this.openingBalance = res.data;
                });
            let stock = {
                date: this.dateTo
            }
        },
        getStock() {
            let stock = {
                date: this.dateTo
            }
            let url = '/get_total_stock';
            axios.post(url, stock)
                .then(res => {
                    this.stock = res.data.totalValue;

                })
        },
        getCustomerDue() {
            let filter = {
                date: this.dateTo
            }
            let url = '/get_customer_due';
            axios.post(url, filter)
                .then(res => {
                    this.customerDue = res.data;
                })
        },
        getTotalDiscount() {
            let filter = {
                date: this.dateTo
            }
            let url = '/get_total_discount';
            axios.post(url, filter)
                .then(res => {
                    this.discountOut = res.data.discount.total_discount;
                    this.specialDiscount = res.data.discount.special_discount_total;
                    this.HeadOfficeDiscount = res.data.discount.head_office_discount;
                    this.ShowroomDiscount = res.data.discount.showroom_total_discount;
                    this.agentDiscount = res.data.discount.agent_total_discount;
                    this.discountIn = res.data.discountIn;
                    this.clime = res.data.ACIclime;
					
                })
        },

        getSupplierDue() {
            let filter = {
                date: this.dateTo
            }
            let url = '/get_supplier_due';
            axios.post(url, filter)
                .then(res => {
                    this.supplierDue = res.data;
                    this.supplierDue = res.data.filter(d => parseFloat(d.due) != 0);

                    this.total = this.supplierDue.reduce((prev, curr) => {
                        return prev + parseFloat(curr.due)
                    }, 0);
                })
        },
    
	async print(){
				let printContent = `
					<div class="container">
						<h4 style="text-align:center">Receipt and Payment</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-12 text-center">
								
							</div>
						</div>
					</div>
					<div class="container">
						${document.querySelector('#printContent').innerHTML}
					</div>
				`;

				var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				printWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				printWindow.document.body.innerHTML += printContent;
				printWindow.document.head.innerHTML += `
					<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
					<style>
						.day-book-table {
							width: 100%;
							margin-bottom: 50px;
						}
						.day-book-table thead {
							background: #ebebeb;
							border-bottom: 1px solid black;
						}
						.day-book-table th {
							padding: 5px 10px;
							text-align: left;
						}
						.day-book-table td {
							padding: 0px 30px;
						}
						.day-book-table tr td:last-child {
							text-align: right;
							padding-right: 50px;
						}
						.day-book-table .main-heading {
							padding-left: 10px;
							font-weight: bold;
						}
						.day-book-table .sub-heading {
							padding-left: 20px;
							font-weight: bold;
						}
						.day-book-table .sub-value {
							padding-right: 10px!important;
							font-weight: bold;
						}
						tr{
		border-right: 1px solid #000;
	}
	th{
		border-right: 1px solid #000;
	}
	tr td{
		border-right: 1px solid #000;
		padding: 4px;
	}
					</style>
	
				`;

				printWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				printWindow.print();
				printWindow.close();
			}
		}
	

})
</script>
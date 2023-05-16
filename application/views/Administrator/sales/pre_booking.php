<div id="PreBookingList">
	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="prebookings" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.Customer_Name }}</td>
							<td>{{ row.mobile }}</td>
							<td>{{ row.Product_Name }}</td>
							<td>{{ row.color_name }}</td>
							<td>{{ row.price }}</td>
							<td>{{ row.advance }}</td>
							<td>{{ row.delivery_date | formatDateTime('MMMM Do YYYY') }}</td>
							<td>
                                <span v-if="row.delivery_status == 'p'" class="badge badge-danger">Pending</span>
                                <span v-else class="badge badge-success">Delivered</span>
                            </td>
							<td>{{ row.created_by }}</td>
							<td>
								<?php if($this->session->userdata('accountType') != 'u'){?>
									<button v-if="row.delivery_status == 'p'" type="button" class="btn-primary" @click="moveToDeliverd(row.id)">
										move to deliver
									</button>
								<?php }?>
								<span v-else class="badge badge-success">Delivered</span>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
    var app = new Vue({
        el: "#PreBookingList",

        data: {
            prebookings: [],
            columns: [
                { label: 'Customer Name', field: 'Customer_Name', align: 'center' },
                { label: 'Mobile', field: 'mobile', align: 'center' },
                { label: 'Product', field: 'Product_Name', align: 'center' },
                { label: 'Color', field: 'color_name', align: 'center' },
                { label: 'Product Price', field: 'price', align: 'center' },
                { label: 'Advance', field: 'advance', align: 'center' },
                { label: 'Delivery Date', field: 'delivery_date', align: 'center' },
                { label: 'Delivery Status', field: 'delivery_status', align: 'center' },
                { label: 'Saved By', field: 'created_by', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 20,
            filter: ''
        },

		filters: {
			formatDateTime(dt, format) {
				return dt == '' || dt == null ? '' : moment(dt).format(format);
			}
		},

        created() {
            this.getPreBooking();
        },

        methods: {
            getPreBooking(){
                axios.get('/get_pre_booking').then(res => {
                    this.prebookings = res.data;
                })
            },
			moveToDeliverd(preBookingId) {
				let deliveredConfirm = confirm('are you sure?');
				if(deliveredConfirm == false) {
					return;
				}
				axios.post('/pre_booking_delivered', {preBookingId: preBookingId}).then(res => {
					let r = res.data;
					if(r.success) {
						alert(r.message);
						this.getPreBooking();
					}
				})
			}
        },


    });
</script>
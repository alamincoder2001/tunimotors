<div class="row" id="purchaseReturn">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
		<form @submit.prevent="getReminder">
            <div class="form-group" style="margin-top:10px;">
                <label class="col-sm-2 col-sm-offset-1 control-label no-padding-right" for="purchaseInvoiceno"> Reminder Date </label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" v-model="reminder_date">
                </div>
            </div>
            <div class="form-group" style="margin-top:10px;">
                <div class="col-sm-1">
                    <input type="submit" value="Search">
                </div>
            </div>
        </form>
	</div>
	<div class="col-xs-12 col-md-12 col-lg-12">
		<br>
		<div class="table-responsive">
			<br>
			<div class="col-md-6">
                <h4 class="text-center" style="margin-top: 0px;">Before Reminder Date</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Reminder</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Due Amount</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: beforeReminder.length > 0 ? '' : 'none'}">
                        <tr v-for ="data in beforeReminder">
                            <td>{{ data.due_reminder_date }}</td>
                            <td>{{ data.Customer_Name }}</td>
                            <td>{{ data.Customer_Mobile }}</td>
                            <td>{{ data.Customer_Address }}</td>
                            <td>{{ data.DueReminderAmount }}</td>
                        </tr>
                    </tbody>
                </table>
			</div>
			<div class="col-md-6">
                <h4 class="text-center" style="margin-top: 0px;">After Reminder Date</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Reminder</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Area</th>
                            <th>Due Amount</th>
                        </tr>
                    </thead>
                    <tbody style="display:none;" v-bind:style="{display: afterReminder.length > 0 ? '' : 'none'}">
                        <tr v-for ="data in afterReminder">
                            <td>{{ data.due_reminder_date }}</td>
                            <td>{{ data.Customer_Name }}</td>
                            <td>{{ data.Customer_Mobile }}</td>
                            <td>{{ data.Customer_Address }}</td>
                            <td>{{ data.DueReminderAmount }}</td>
                        </tr>
                    </tbody>
                </table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	new Vue({
		el: '#purchaseReturn',
		data(){
			return {
                beforeReminder: [],
                afterReminder: [],
				reminder_date: moment().format('YYYY-MM-DD'),
			}
		},
        created() {
            this.getReminder();
        },
		methods:{
			async getReminder() {
                await axios.post('/get_reminder', {reminderDate: this.reminder_date}).then(res => {
                    this.beforeReminder = res.data.beforeReminders;
                    this.afterReminder = res.data.afterReminders;
                })
            },
		}
	})
</script>
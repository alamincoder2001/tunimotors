<style>
    #branch .Inactive{
        color: red;
    }
</style>
<div id="branch">
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-12">
            <form class="form-horizontal" @submit.prevent="saveBranch">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Branch Name </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Branch Name" class="form-control" v-model="branch.name" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Branch Title </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Branch Title" class="form-control" v-model="branch.title" required/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Branch Address </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" placeholder="Branch Address" v-model="branch.address" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Branch Logo </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="file" class="form-control" @change="onChangeBranchLogo" ref="image" style="padding: 1px 12px !important;">
                        <span></span>
                        <img  :src="imageUrl" style="width:80px; height:70px; margin-bottom: 5px;" v-if="imageUrl">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"></label>
                    <label class="col-sm-1 control-label no-padding-right"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-sm btn-success">
                            Submit
                            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;display:none;" v-bind:style="{display: branches.length > 0 ? '' : 'none'}">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Branch Name</th>
                        <th>Branch Title</th>
                        <th>Branch Address</th>
                        <th>Branch Logo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(branch, sl) in branches">
                        <td>{{ sl + 1 }}</td>
                        <td>{{ branch.Brunch_name }}</td>
                        <td>{{ branch.Brunch_title }}</td>
                        <td>{{ branch.Brunch_address }}</td>
                        <td><img :src="`/uploads/Branch/${branch.Branch_logo}`" alt="" style="height: 40px; width:40px;"></td>
                        <td><span v-bind:class="branch.active_status">{{ branch.active_status }}</span></td>
                        <td>
                            <?php if($this->session->userdata('accountType') != 'u'){?>
                            <a href="" title="Edit Branch" @click.prevent="editBranch(branch)"><i class="fa fa-pencil"></i></a>&nbsp;
                            <a href="" title="Deactive Branch" v-if="branch.status == 'a'" @click.prevent="changeStatus(branch.brunch_id)"><i class="fa fa-trash"></i></a>
                            <a href="" title="Active Branch" v-else><i class="fa fa-check" @click.prevent="changeStatus(branch.brunch_id)"></i></a>
                            <?php }?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>

<script>
    new Vue({
        el: '#branch',
        data(){
            return {
                branch: {
                    branchId: 0,
                    name: '',
                    title: '',
                    address: ''
                },
                imageFile: null,
				imageUrl: '',
                branches: []
            }
        },
        created(){
            this.getBranches();
        },
        methods: {
            getBranches(){
                axios.get('/get_branches').then(res => {
                    this.branches = res.data;
                })
            },

            onChangeBranchLogo() {
				if(event.target.files.length > 0){
					this.imageFile = event.target.files[0];
					this.imageUrl = URL.createObjectURL(this.imageFile);
				} else {
					this.imageFile = null;
					this.imageUrl = '';
				}
            },

            saveBranch(){
                let fd = new FormData();
				fd.append('branch', JSON.stringify(this.branch));
                fd.append('Branch_logo', this.imageFile);

                let url = "/add_branch";
                if(this.branch.branchId != 0){
                    url = "/update_branch";
                }

                axios.post(url, fd).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if(r.success){
                        this.getBranches();
                        this.clearForm();
                    }
                })
            },

            editBranch(branch){
                this.branch.branchId = branch.brunch_id;
                this.branch.name = branch.Brunch_name;
                this.branch.title = branch.Brunch_title;
                this.branch.address = branch.Brunch_address;
                this.imageUrl = '/uploads/Branch/'+branch.Branch_logo;
            },

            changeStatus(branchId){
                let changeConfirm = confirm('Are you sure?');
                if(changeConfirm == false){
                    return;
                }
                axios.post('/change_branch_status', {branchId: branchId}).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if(r.success){
                        this.getBranches();
                    }
                })
            },

            clearForm(){
                this.branch = {
                    branchId: 0,
                    name: '',
                    title: '',
                    address: ''
                }
                this.imageFile = null;
				this.imageUrl = '';
				this.$refs.image.value = ''
            }
        }
    })
</script>

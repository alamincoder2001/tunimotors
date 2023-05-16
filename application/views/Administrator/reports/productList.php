<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
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
</style>
<div id="productList">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group" style="margin-top:10px;">
                    <label class="col-sm-1 col-sm-offset-1 control-label no-padding-right"> Select Type </label>
                    <div class="col-sm-2">
                        <v-select :options="searchTypes" v-model="selectedSearchType" label="text" v-on:input="onChangeSearchType"></v-select>
                    </div>
                </div>
        
                <div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'category'">
                    <div class="col-sm-2" style="margin-left:15px;">
                        <v-select :options="categories" v-model="selectedCategory" label="ProductCategory_Name"></v-select>
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'color'">
                    <div class="col-sm-2" style="margin-left:15px;">
                        <v-select v-bind:options="colors" v-model="selectedColor" label="color_name"></v-select>
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'unit'">
                    <div class="col-sm-2" style="margin-left:15px;">
                        <v-select :options="units" v-model="selectedUnit" label="Unit_Name"></v-select>
                    </div>
                </div>
        
                <div class="form-group">
                    <div class="col-sm-2"  style="margin-left:15px;">
                        <input type="button" class="btn btn-primary" value="Show Report" v-on:click="getProducts" style="margin-top:0px;border:0px;height:28px;">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <a href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="reportTable">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Color</th>
                                <th>Purchase Price</th>
                                <th>Sale Price</th>
                                <th>Wholesale Price</th>
                                <th>VAT</th>
                                <!-- <th>Is Service</th> -->
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, sl) in products">
                                <td style="text-align:center;">{{ sl + 1 }}</td>
                                <td>{{ product.Product_Code }}</td>
                                <td>{{ product.Product_Name }}</td>
                                <td>{{ product.ProductCategory_Name }}</td>
                                <td>{{ product.color_name }}</td>
                                <td>{{ product.Product_Purchase_Rate }}</td>
                                <td style="text-align:right;">{{ product.Product_SellingPrice }}</td>
                                <td>{{ product.Product_WholesaleRate }}</td>
                                <td>{{ product.vat }}</td>
                                <!-- <td>{{ product.is_service }}</td> -->
                                <td>{{ product.Unit_Name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#productList',
        data() {
            return {
                products: [],
                searchTypes: [
					{text: 'By Category', value: 'category'},
					{text: 'By Color', value: 'color'},
					{text: 'By Unit', value: 'unit'},
					//{text: 'Brand Wise Stock', value: 'brand'}
				],
				selectedSearchType: {
					text: 'select',
					value: ''
				},
				searchType: null,
				categories: [],
				selectedCategory: null,
				colors: [],
				selectedColor: null,
                units: [],
                selectedUnit: null
            }
        },
        created() {
            this.getProducts();
        },
        methods: {
            onChangeSearchType(){
				if(this.selectedSearchType.value == 'category' && this.categories.length == 0) {
					this.getCategories();
				} else if(this.selectedSearchType.value == 'color' && this.colors.length == 0) {
					this.getColors();
				} else if(this.selectedSearchType.value == 'unit' && this.units.length == 0) {
                    this.getUnits();
                }
			},

            getCategories(){
				axios.get('/get_categories').then(res => {
					this.categories = res.data;
				})
			},

			getColors() {
				axios.get('/get_color').then(res => {
					this.colors = res.data;
				})
			},

            getUnits() {
                axios.get('/get_units'). then(res => {
                    this.units = res.data;
                })
            },

            getProducts() {
                this.searchType = this.selectedSearchType.value;
                let parameters = null;

				if(this.searchType == 'category' && this.selectedCategory == null){
					alert('Select a category');
					return;
				} else if(this.searchType == 'category' && this.selectedCategory != null) {
					parameters = {
						categoryId: this.selectedCategory.ProductCategory_SlNo
					}
				}

				if(this.searchType == 'color' && this.selectedColor == null){
					alert('Select Color');
					return;
				} else if(this.searchType == 'color' && this.selectedColor != null) {
					parameters = {
						colorId: this.selectedColor.color_SiNo
					}
				}

				if(this.searchType == 'unit' && this.selectedUnit == null){
					alert('Select Unit');
					return;
				} else if(this.searchType == 'unit' && this.selectedUnit != null) {
					parameters = {
						unitId: this.selectedUnit.Unit_SlNo
					}
				}

                axios.post('/get_products', parameters).then(res => {
                    this.products = res.data;
                })
            },
            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Product List</h4 style="text-align:center">
                            </div>
                        </div>
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
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
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
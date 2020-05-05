<template>


    <div>
        <table class="table table-striped table-bordered table-hover "  v-if="msBuyerSellerInfo">
       <tr>
           <th>Seller</th>

           <td>
            {{this.msMaster.name}}<br>
               <small v-if="this.msMaster.address.line1">{{this.msMaster.address.line1}}<br></small>
               <small  v-if="this.msMaster.address.line2">{{this.msMaster.address.line2}}<br></small>
               <small v-if="this.msMaster.address.line3">{{this.msMaster.address.line3}}<br></small>
               <small>{{this.msMaster.city}},{{this.msMaster.district}},<br></small>
               <small>{{this.msMaster.state.name}}-{{this.msMaster.pincode}},India</small>

           </td>
           <th>Buyer</th>

           <td>
               {{msMaster.name}}<br>
               <small v-if="msMaster.address.line1">{{this.msMaster.address.line1}}<br></small>
               <small  v-if="this.msMaster.address.line2">{{this.msMaster.address.line2}}<br></small>
               <small v-if="this.msMaster.address.line3">{{this.msMaster.address.line3}}<br></small>
               <small>{{this.msMaster.city}},{{this.msMaster.district}},<br></small>
               <small>{{this.msMaster.state.name}}-{{this.msMaster.pincode}},India</small>

           </td>
       </tr>



        </table>
        <table class="table table-striped table-bordered table-hover table-responsive-xs table-responsive-sm ">



            <tr  class="table-info">
                <th>No.</th>
                <th class="d-print-none" style="position: sticky;flex: 1 0 300px; left: 0;  ">Action</th>
                <th style="position: sticky;flex: 1 0 300px; left: 48px;">

                    Product Name <br>Description</th>

                <th>Unit</th>
                <th>Unit Cost </th>
                <th>HSN Code <br> SAC Code</th>
                <th>SGST</th>
                <th>CGST</th>
                <th >Sub Total</th>
                <th style="position: sticky;flex: 1 0 300px; right: 0;">Total</th>

            </tr>
    <tr v-for="(product,key,index) in msProductMaster" v-if="checkNotDeleted(product)" class=" table-warning">
        <td>{{key+1}}</td>

        <td  class="d-print-none table-active" style="position: sticky;flex: 1 0 300px; left: 0; ">
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-success fa fa-pencil-alt " v-on:click="editProductbyId(key)"></button>
                <button type="button" class="btn btn-outline-danger fa fa-times btn-sm" v-on:click="removeProduct(key)"></button>
            </div>

        </td>
        <td style="position: sticky;flex: 1 0 300px; left: 48px;">{{msProductName[key]}}   </td>
        <td >
            <section class="float-right">
            {{msProductUnit[key].toLocaleString('en-IN')}}  <small class="float-right"> <br> {{msProductUnitName[key]}} </small> </section></td>
        <td>
            {{msProductUnitCost[key].toLocaleString('en-IN')}}₹ <small class="float-right"> <br>/ {{msProductUnitName[key]}} </small> </td>

        <td  ><section class="float-right"> {{msProductTAXCODE[key]}}</section></td>
        <td  ><section class="float-right">{{to2(msProductSGST[key]).toLocaleString('en-IN')}}₹</section></td>
        <td  ><section class="float-right">{{to2(msProductCGST[key]).toLocaleString('en-IN')}}₹</section></td>
        <td style="position: sticky;flex: 1 0 300px; right: 0;"> <strong class="float-right"> {{to2(msProductTotal[key]).toLocaleString('en-IN') }}₹ </strong>
        <td style="position: sticky;flex: 1 0 300px; right: 0;"> <strong class="float-right"> {{to2(msProductTotal[key] + msProductSGST[key] + msProductCGST[key]).toLocaleString('en-IN') }}₹ </strong>
        </td>


    </tr>


        </table>

            <table class="table table-striped table-bordered table-hover">
                <tr >
                    <td colspan="2">

                        <div class="btn-group btn-group-lg btn-block" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-warning fa fa-retweet " v-on:click="refreshInvoice()" style="border-radius: 0px"> Reset</button>
                            <button type="button" class="btn btn-success fa fa-plus-square " style="color: #1b1e21;border-radius: 0px" v-on:click="showProductModel()"> Add</button>
                            <button type="button" class="btn btn-info fa fa-print " style="color: #1b1e21;border-radius: 0px" v-on:click="generateInoice()"> Generate invoice</button>
                        </div>

                          </td>
                </tr>
            <tr>
                <td class="table-info">Sub total (excluding TAX)</td>
                <td class="table-success"> <strong class="float-right"> {{to2(msProductTotalwithOutTaxForDisplay).toLocaleString('en-IN')}}₹ </strong> </td>
            </tr>
            <tr>
                <td  class="table-info">SGST</td>
                <td  class="table-success"> <strong class="float-right"> {{to2(msProductSGSTForDisplay).toLocaleString('en-IN')}}₹ </strong> </td>
            </tr>

            <tr>
                <td  class="table-info">CGST</td>
                <td  class="table-success"> <strong class="float-right"> {{ to2(msProductCGSTForDisplay).toLocaleString('en-IN')}}₹ </strong> </td>
            </tr>
            <tr>
                <td  class="table-info">Total (including all TAX)</td>
                <td  class="table-success"> <strong class="float-right"> {{ to2( msProductTotalwithOutTaxForDisplay + msProductSGSTForDisplay + msProductCGSTForDisplay ).toLocaleString('en-IN')}}₹ </strong> </td>
            </tr>




        </table>

        <small class="text-muted float-right" style="margin-top:0px;">Powered by <a href="https://www.millionsllp.com">
            <img src="http://gst.msllp.in/images/logo_final.png" style="max-height: 30px;margin-top:-7px;margin-right:15px "></a></small>


        <div class="modal" tabindex="-1" role="dialog" id="msProductModel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="fa fa-times"></span>
                        </button>
                    </div>
                    <div class="modal-body">



                        <div class="container-fluid">
                            <div class=" row">


                            <div class="form-group col">
                                <label for="productName">Product Name</label>
                                <input type="text" v-model="msModel.name" class="form-control" id="productName" aria-describedby="productName" placeholder="Enter Product Name">
                                <small id="emailHelp" class="form-text text-muted">enter product name or service name.</small>
                            </div>

                            <div class="form-group col">
                                <label for="productHasSac">HSN/SAC Code</label>
                                <input pattern="[0-9]" type="number" v-model="msModel.taxcode" class="form-control" id="productHasSac" aria-describedby="productHasSac" placeholder="Enter Product HSN/SAC Code">
                                <small id="emailHelp" class="form-text text-muted">enter product's GST HSN/SAC Code.</small>
                            </div>
                            </div>
                            <div class=" row">

                            <div class="form-group col">
                                <label for="productQt">Quantity</label>
                                <input pattern="[0-9]" type="number" v-model="msModel.unit" class="form-control" id="productQt" aria-describedby="productQt" placeholder="Enter Product Quantity">
                                <small id="emailHelp" class="form-text text-muted">enter product Quantity or No. Unit pices.</small>
                            </div>
                            <div class="form-group col">
                                <label for="productUnitCost">Unit Cost</label>
                                <input pattern="[0-9]" type="number" v-model="msModel.unitcost" class="form-control" id="productUnitCost" aria-describedby="productUnitCost" placeholder="Enter Product Unit Cost">
                                <small id="emailHelp" class="form-text text-muted">product unit cost that x Quantity = total product cost without tax</small>
                            </div>
                                <div class="form-group col">
                                    <label for="productUnitName">Unit name</label>
                                    <input type="text" v-model="msModel.unitname" class="form-control" id="productUnitName" aria-describedby="productUnitName" placeholder="Enter Product Unit Name">
                                    <small id="emailHelp" class="form-text text-muted">name of unit</small>
                                </div>
                            </div>


                            <div class=" row">

                                <div class="form-group col">
                                    <label for="productSGST">SGST</label>
                                    <input pattern="[0-9]" type="number" v-model="msModel.SGST" class="form-control" id="productSGST" aria-describedby="productSGST" placeholder="Enter Product SGST">
                                    <small id="emailHelp" class="form-text text-muted">in % / leave 0 if not applicable.</small>
                                </div>
                                <div class="form-group col">
                                    <label for="productCGST">CGST</label>
                                    <input pattern="[0-9]" type="number" v-model="msModel.CGST" class="form-control" id="productCGST" aria-describedby="productCGST" placeholder="Enter Product CGST">
                                    <small id="emailHelp" class="form-text text-muted">in % /  leave 0 if not applicable.</small>
                                </div>


                            </div>


                        </div>



                    </div>
                    <div class="modal-footer">
                        <button v-if="msModelActionbtnAdd" type="button" class="btn btn-primary" v-on:click="addNewProductfromModel()">Add</button>
                        <button v-if="msModelActionbtnEdit" type="button" class="btn btn-success" v-on:click="editProductfromModel()">Edit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="toast" tabindex="-1024" v-if="msErrorCode" role="alert" aria-live="assertive" aria-atomic="true" id="msError" style="position: absolute; top: 0; right: 0;">
            <div class="toast-header">

                <strong class="mr-auto">Error : {{ msErrorCode }}</strong>
                <small class="text-muted"> {{ msErrorCodeArray[msErrorCode] }}</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                {{ msError }}
            </div>
        </div>

    </div>


    
</template>

<script>
    export default {
        name: "msinvoice",
        data: function () {
                return {
                    msProductName:[],
                    msProductTAXCODE:[],
                    msProductUnit:[],
                    msProductUnitCost:[],
                    msProductUnitName:[],
                    msProductSGST:[],
                    msProductCGST:[],
                    msProductTotal:[],
                    msProductMaster:[],
                    msProductTotalwithOutTaxForDisplay:0,
                    msProductCGSTForDisplay:0,
                    msProductSGSTForDisplay:0,
                    msTestData:[],
                    msMaster:{},
                    msMasterClient:{},
                    msModel:{},
                    msBuyerSellerInfo:false,
                    msModelActionbtnAdd:false,
                    msModelActionbtnEdit:false,
                    msCurrentProduct:0,
                    msError:"",
                    msErrorCode:"",
                    msErrorCodeArray:{
                        14002:"Duplicate Entry Found"
                    }


                }
            },
        mounted() {
         //   this.generateInoice();

            var masterUser={
                name:"Raghuvir Traderes",
                address:{
                    line1:"Line 1"
                   // line2:"Line 2"
                 //   line3:"Line 3"
                },
                city:"city/Town",
                district:"District",
                state:{name:"GJ",stateCode:20},
                pincode:"123456",
                tax:{
                    gst:"GST Number",
                    pan:"PAN Number",
                    tan:"TAN Number",
                    crn:"Company Registration Number"
                }

            };

            this.setMaster(masterUser);



            var product= [{
                name:"Demo",
                taxCode:"123",
                unit:"10",
                unitCost:"10",
                unitName:"KG",
                SGST:"10",
                CGST:"12",

            }
            ,{
                    name:"Demo 1",
                    taxCode:"564",
                    unit:"10",
                    unitCost:"15253",
                    unitName:"KG",
                    SGST:"15",
                    CGST:"0",

                },
                {
                    name:"Demo 2",
                    taxCode:"65465343",
                    unit:"125",
                    unitCost:"10000",
                    unitName:"KG",
                    SGST:"5",
                    CGST:"18.5",

                }


            ];


                for (var k = 0; k < product.length; k++) {
                    this.addProduct( product[k] );
                }

           // this.removeProduct();

            //this.addProduct(product);
        }

        ,
        methods:{
         addProduct:function(product,demo=false){
             if (demo) {

                 var product = {
                     name: "Demo",
                     taxCode: "123",
                     unit: "12",
                     unitCost: "10",
                     SGST: "10",
                     CGST: "12",

                 };
             }

             product.SGSTrate= product.SGST;
             product.CGSTrate= product.CGST;

                 var withTaxCost= this.to2(product.unit *  product.unitCost);
                 var SGST= this.to2( (withTaxCost )  * product.SGST / 100) ;
                 var CGST= this.to2((withTaxCost )  * product.CGST / 100) ;
                 var total=this.to2(withTaxCost + SGST +CGST);
                 this.msProductName.push(product.name);
                 this.msProductTAXCODE.push(product.taxCode);
                 this.msProductUnit.push(product.unit);
                 this.msProductUnitCost.push(product.unitCost);
                 this.msProductUnitName.push(product.unitName);
                 this.msProductSGST.push(SGST);
                 this.msProductCGST.push(CGST);
                 this.msProductTotal.push(withTaxCost);
                 this.msProductTotalwithOutTaxForDisplay=this.msProductTotalwithOutTaxForDisplay + withTaxCost;
                 this.msProductSGSTForDisplay=this.msProductSGSTForDisplay +SGST;
                 this.msProductCGSTForDisplay=this.msProductCGSTForDisplay +CGST;
                 product.CGST=CGST;
                 product.SGST=SGST;
                 product.total=total;
                 this.msProductMaster.push(product);
                 this.msTestData.push(product);




         },
            removeProduct(key,demo=false){
             if(demo)key=1;

                //var product =this.msProductMaster[key];
                //this.msProductMaster[key].delted =true;
                var withTaxCost=this.msProductUnit[key] *  this.msProductUnitCost [key];
                var SGST=  this.msProductSGST[key]  ;
                var CGST=  this.msProductCGST[key]  ;
                //console.log(SGST +": "+ CGST);
                this.msProductTotalwithOutTaxForDisplay= this.to2(this.msProductTotalwithOutTaxForDisplay - withTaxCost);
                console.log(this.msProductSGSTForDisplay+"-"+SGST );
                this.msProductSGSTForDisplay= this.to2(this.msProductSGSTForDisplay - SGST);
                //sconsole.log("="+this.msProductSGSTForDisplay );
                this.msProductCGSTForDisplay=this.to2(this.msProductCGSTForDisplay - CGST);

                this.msProductName.splice(key,1);
                this.msProductTAXCODE.splice(key,1)
                this.msProductUnit.splice(key,1)
                this.msProductUnitCost.splice(key,1)
                this.msProductUnitName.splice(key,1);
                this.msProductSGST.splice(key,1)
                this.msProductCGST.splice(key,1)
                this.msProductTotal.splice(key,1)
                this.msProductMaster.splice(key,1);

            }
            ,checkNotDeleted:function (product) {
                if(product.hasOwnProperty("deleted") && product.deleted == true) return false;
                return true;
            },
            to2(num){
             return this.roundToTwo(num);
            },
            setMaster(user){
             this.msMaster=user;
            },
            showProductModel(){
                this.msModel={};
                $('#msProductModel').modal('toggle');
                if(!this.msModelActionbtnAdd)this.msModelActionbtnAdd=true;
                if(this.msModelActionbtnEdit)this.msModelActionbtnEdit=false;

            },
            addNewProductfromModel(){

                var Newproduct = {
                    name:this.msModel.name,
                    taxCode: this.msModel.taxcode,
                    unit: this.msModel.unit,
                    unitCost: this.msModel.unitcost,
                    unitName:this.msModel.unitname,
                    SGST: this.msModel.SGST,
                    CGST: this.msModel.CGST,

                };
                if( this.check_uniq(this.msProductName,[this.msModel.name]) ){

                    this.addProduct(Newproduct);
                    $('#msProductModel').modal('toggle');
                }else{
                    this.msError=this.msModel.name + " Already exist in Current Invoice";
                    this.msErrorCode="14002";
                    $('#msError').toast('show');
//                    alert( );
                }




            },
            editProductbyId(id){

                this.resetModel()
                this.msCurrentProduct=id;
                if(!this.msModelActionbtnEdit)this.msModelActionbtnEdit=true;
                if(this.msModelActionbtnAdd)this.msModelActionbtnAdd=false;


                var product = this.msProductMaster[id];
                var totalProductCost=this.to2(product.unitCost * product.unit);
                //console.log(this.calc_get_prapotion( this.to2(product.unitCost *product.unit) ,product.SGST));
                $("#productName").val(product.name);
                $("#productHasSac").val(product.taxCode);
                $("#productQt").val(product.unit);
                $("#productUnitCost").val(product.unitCost);
                $("#productUnitName").val(product.unitName);
                $("#productSGST").val(this.calc_get_prapotion( totalProductCost ,product.SGST));
                $("#productCGST").val(this.calc_get_prapotion( totalProductCost ,product.CGST));
                $('#msProductModel').modal('toggle');
                this.msModel.name=product.name;
                this.msModel.taxcode=product.taxCode;
                this.msModel.unit=product.unit;
                this.msModel.unitcost=product.unitCost;
                this.msModel.unitname=product.unitName;
                this.msModel.SGST=this.calc_get_prapotion( totalProductCost ,product.SGST);
                this.msModel.CGST=this.calc_get_prapotion( totalProductCost ,product.CGST);
                //console.log(product->name);
               // console.log(this.msModel.name);


            },
            resetModel(){
                this.msModel.name="";
                this.msModel.taxcode="";
                this.msModel.unit=0;
                this.msModel.unitcost=0;
                this.msModel.unitname="";
                this.msModel.SGST=0;
                this.msModel.CGST=0;
                $("#productName").val("");
                $("#productHasSac").val("");
                $("#productQt").val(0);
                $("#productUnitCost").val(0);
                $("#productUnitName").val("");
                $("#productSGST").val(0);
                $("#productCGST").val(0);

            },
            editProductfromModel(){

                var Newproduct = {
                    name:this.msModel.name,
                    taxCode: this.msModel.taxcode,
                    unit: this.msModel.unit,
                    unitCost: this.msModel.unitcost,
                    unitName:this.msModel.unitname,
                    SGST: this.msModel.SGST,
                    CGST: this.msModel.CGST,

                };


                console.log(this.editProduct(this.msCurrentProduct,Newproduct) );

                $('#msProductModel').modal('toggle');



            }

            ,editProduct(key,data){

                var product = this.msProductMaster[key];

                var withTaxCost= this.to2 (data.unit *  data.unitCost);

                var SGSTRate=data.SGST;
                var CGSTRate=data.CGST;

                var SGST=  this.to2 ( data.SGST* withTaxCost / 100)    ;
                var CGST= this.to2 ( data.CGST* withTaxCost / 100  )   ;

                var withTaxCost_old=this.msProductUnit[key] *  this.msProductUnitCost [key];
                var SGST_old=  this.msProductSGST[key]  ;
                var CGST_old=  this.msProductCGST[key]  ;


                //console.log("New One "+SGST + " /  Old: "+ SGST_old);
               // console.log("New One "+CGST + " /  Old: "+ CGST_old);
                if(data.name != product.name) {
                    if (this.check_uniq(this.msProductName, [data.name])) {
                        this.msProductName[key]=data.name

                    } else {
                        alert(this.msModel.name + " Already exist in Current Invoice");
                        return false;
                    }
                }

                if(SGST_old != SGST){
                    this.msProductSGST[key]=SGST
                    this.msProductSGSTForDisplay= this.to2(this.msProductSGSTForDisplay - SGST_old);
                    this.msProductSGSTForDisplay= this.to2(this.msProductSGSTForDisplay + SGST);
                }
                if(CGST_old != CGST){
                    this.msProductCGST[key]=CGST
                    this.msProductCGSTForDisplay= this.to2(this.msProductCGSTForDisplay - CGST_old);
                    this.msProductCGSTForDisplay= this.to2(this.msProductCGSTForDisplay + CGST);
                }
                //console.log(SGST +": "+ CGST);
                this.msProductTotalwithOutTaxForDisplay= this.to2(this.msProductTotalwithOutTaxForDisplay - withTaxCost_old);
                this.msProductTotalwithOutTaxForDisplay= this.to2(this.msProductTotalwithOutTaxForDisplay + withTaxCost);

                //console.log(data);

                this.msProductTAXCODE[key]=data.taxCode;
                this.msProductUnit[key]=data.unit;
                this.msProductUnitCost[key]=data.unitCost;
                this.msProductUnitName[key]=data.unitName;
                this.msProductTotal[key]=withTaxCost;
                this.msProductMaster[key]={
                    name:data.name,
                    taxCode: data.taxCode,
                    unit: data.unit,
                    unitCost: data.unitCost,
                    unitName:data.unitName,
                    SGST: SGST,
                    CGST: CGST,
                    total:withTaxCost,
                    SGSTrate:SGSTRate,
                    CGSTrate:CGSTRate
                };



            },
            refreshInvoice(){
                location.reload();
            },
        generateInoice(){

            var self=this
            axios.post('/MAS/fromAppGenaratePdf', {
                msData: self.msProductMaster,
                msDataTotal:{
                    SGST:self.msProductSGSTForDisplay,
                    CGST:self.msProductCGSTForDisplay,
                    productTotal:self.msProductTotalwithOutTaxForDisplay,
                }
            })
                .then(function (response) {

                    if(response.headers['content-type'] == "application/pdf"){

                        window.open("document.pdf",'_blank');

                    }
                    console.log(response.headers);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        }

    }
</script>

<style scoped>
    .table td, .table th {

        padding: 1px;
    }
</style>

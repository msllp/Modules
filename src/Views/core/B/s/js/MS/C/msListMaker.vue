<template>
    <div class="bg-white">
        <!-- item add section start -->
        <div  class="flex flex-wrap">



            <div v-if="PriceMatters" class="flex-1 p-2 m-3 shadow border bg-gray-100 shadow">


                <div class="flex flex-wrap">
                    <div class="flex flex-wrap px-3 py-2">
                        <div class="flex flex-wrap p-1">
                            <label class="p-2">Client Name</label>
                            <input   name="curCustomer" class="border px-2" type="text" placeholder="Cline Name or Code Or Contact No" v-model="currentUserIdentifier"
                                     v-on:keyup.ctrl.up="plusUser($event)" v-on:keyup.ctrl.down="downUser($event)"
                                     v-on:keyup.alt.up="backUserPage" v-on:keyup.alt.down="nextUserPage"
                                     v-on:keyup.enter="onLytoggleFounUser"
                            >
                        </div>

                        <div class="flex flex-wrap p-1 cursor-pointer select-none">
                            <button v-if="foundUser.length>0" v-on:click="onLytoggleFounUser" class="flex-1 bg-blue-300 px-3 py-2">{{(msFounUserList)?'Hide':'View'}} Customer List</button>

                        </div>

                        <div class="w-full" v-if="foundUser.length>0 && msFounUserList" >
                            <div class="px-2 py-3 ">
                                <v-touch v-on:swipeleft="nextUserPage" v-on:swiperight="backUserPage">
                                    <table class="table-auto w-full table-bordered   text-xs">
                                        <tr >
                                            <td class="border shadow p-2"><input type="radio" disabled></td>
                                            <th class="border shadow p-2">Customer Name</th>
                                            <th class="border shadow p-2">Contact No</th>
                                            <th class="border shadow p-2">City</th>
                                        </tr>
                                        <tr v-on:click="selectUser(key)" :class="{ 'ms-list-row-highlight-on':(key==pickedUser), 'ms-list-row-highlight-off':!(key==pickedUser), }" class="border cursor-pointer " v-for="(item,key) in foundUser" >
                                            <td class="text-right p-2"><input class="" :value="key" type="radio" v-model="pickedUser"></td>
                                            <td>
                                                <div >
                                                    <span>{{item.name}}</span>
                                                </div>
                                            </td>
                                            <td>{{item.contactno}}</td>
                                            <td class="text-right p-2">{{item.city}}</td>
                                        </tr>
                                    </table>
                                </v-touch>
                            </div>

                        </div>
                    </div>

                </div>


                <div :class="{
                'ms-userForm-box'  :   msUserMode ,
                'ms-userForm-box-hidden'  :   !msUserMode
                }" class="flex-1 shadow bg-gray-200 mt-2 ml-4">
                    <div class="px-2 py-3 ">
                        <div class="w-full">
                            Customer Details
                            <table class="ms-table-auto text-xs">
                                <tr>
                                    <th>Customer Name :</th>
                                    <td><input v-model="forUserName" placeholder="Enter Customer Name"></td>
                                    <th>Contac No.:</th>
                                    <td><input v-model="forContactNo" placeholder="Enter Customer Name" type="number" ></td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td><input v-model="forAddress1" placeholder="Enter Block/Plot No."></td>
                                    <td><input v-model="forAddress2" placeholder="Enter Landmark"></td>
                                    <td><input v-model="forAddress3" placeholder="Enter Area"></td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><input v-model="forCity" type="text"  placeholder="Enter City"></td>
                                    <th>Pincode</th>
                                    <td><input type="number" v-model="forPincode"></td>
                                </tr>
                                <tr>
                                <th>GSTNo:</th>
                                <td colspan="2">
                                <span v-if="forGSTIN==''">
                               <input v-model="forGSTIN" placeholder="Enter GST Number">
                                </span>
                                    <span v-else>
                                             {{forGSTIN}}
                                    </span>

                                </td>

                            </tr>

                                <tr>
                                    <th>Date</th>
                                    <td><input type="date" v-model="forDate"></td>
                                    <th>Credit</th>
                                    <td><input type="date" v-model="forDate"></td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>

                <div :class="{
                'ms-userForm-box-default'  :   !msUserMode ,
                'ms-userForm-box-default-hidden'  :   msUserMode
                }" class="flex-1 ml-4 shadow bg-gray-200 mt-2">
                    <span class="pl-1">Please Enter Valid Customer Name or Contact No</span>

                </div>

            </div>


            <div class="flex-1 p-2 m-3 shadow border bg-gray-100 shadow">
            <div class="flex flex-wrap">
                <div class="flex flex-wrap px-3 py-2">
                    <div class="flex flex-wrap p-1">
                    <label class="p-2">Item Name</label>
                    <input ref="cI" v-on:keyup.alt.up="backItemPage" v-on:keyup.alt.down="nextItemPage" v-on:keyup.enter="addItem('enter')" v-on:keyup.shift.up="plusQt" v-on:keyup.shift.down="minusQt" v-on:keyup.ctrl.up="plusItem($event)" v-on:keyup.ctrl.down="downItem($event)" name="curItemName" class="border px-2" type="text" placeholder="Item Name or Code" v-model="currentItemName">
                    </div>
                    <div class="flex flex-wrap p-1">
                    <label  class="p-2 ">Qt.</label>
                    <input pattern="[0]" :min="1" ref="cQ" v-on:keyup.enter="addItem"  name="curItemQt" class="border px-2" type="number" placeholder="quantity" v-model="currentQt">
                    </div>
                    <div class="flex flex-wrap p-1">
                        <div v-on:click="plusQt" class="flex bg-green-300 px-3 py-2">+</div>
                        <div v-on:click="minusQt" class="flex bg-red-300 px-3 py-2">-</div>
                    </div>
                    <div class="flex flex-wrap p-1 cursor-pointer select-none">
                        <button v-on:click="addItem" class="flex-1 bg-blue-300 px-3 py-2">Add</button>
                        <button v-on:click="toggelBarcodeScaner"
                                :class="{
                            'bg-blue-300':baacodeMachineOn,
                            'bg-blue-100':!baacodeMachineOn,

                                }"
                                class="flex-1 px-3 py-2 shadow border ml-2"><i
                            :class="{
                            'flaticon-qr-code':baacodeMachineOn,
                            'flaticon-ui-2':!baacodeMachineOn,

                                }"
                            class="fi2 "> </i></button>

                    </div>
                </div>

            </div>


                <div v-if="hasItemFromServer" class="flex-1 shadow bg-gray-200 mt-2 ml-4">
               <div class="px-2 py-3 ">
                   <v-touch v-on:swipeleft="nextItemPage" v-on:swiperight="backItemPage">
                   <table class="table-auto w-full table-bordered  ms-item-found-box">
                       <tr >
                           <th class="border shadow p-2">Item Name</th>
                           <th class="border shadow p-2">Item Code</th>

                           <th class="border shadow p-2">HSN/SAC Code</th>
                       </tr>
                       <tr :class="{ 'ms-list-row-highlight-on':(key==pickedItem), 'ms-list-row-highlight-off':!(key==pickedItem), }" class="border cursor-pointer " v-for="(item,key) in foundItem" v-on:click="selectItem(key)">
                           <td class="text-right p-2"><input class="" :value="key" type="radio" v-model="pickedItem"></td>
                           <td>
                           <div >
                               <span>{{item.name}}</span>
                           </div>
                           </td>
                           <td class="text-right p-2">{{item.taxcode}}</td>
                       </tr>
                   </table>
                   </v-touch>
               </div>

                </div>

                <div v-else class="flex-1 ml-4 shadow bg-gray-200 mt-2">
                <span class="pl-1">Please Enter Item Name or Item Code</span>

                </div>

            </div>






        </div>
        <!-- item add section end -->

        <!-- item added section start -->
        <div  class="flex flex-wrap" >
            <div class="flex-1 p-2 m-3 shadow border bg-white">
                <div style=" display: block;
    overflow-x: auto;
    white-space: nowrap;">
                    <table class="ms-table-auto ">
                        <tr class="text-left">
                            <th>Item Name</th>
                            <th class="">Quantity</th>
                            <th class="text-right" v-if="PriceMatters">Unit rate</th>
                            <th class="text-right" v-if="PriceMatters">Taxable Amount</th>
                            <th class="text-right" v-if="PriceMatters" v-for="tax in defaultTax" >{{tax.name}}</th>
                            <th class="text-right" v-if="PriceMatters">Total</th>

                        </tr>
                        <tr class="border" v-for="(item,key) in currentListProcess">

                            <td class="">
                                <div  class="flex  cursor-pointer content-center flex-wrap ">
                                    <span class="flex" v-on:click="removeItemFromList(key)"><div class="bg-red-200 px-3 py-2"><i class="fi2 flaticon-delete"></i></div></span>
                                    <span class="flex-1 p-2">{{item.name}} {{item.taxcode}}</span>
                                    <span class="w-full border border-blue-300" v-if="itemDescription"> <input  v-model="item.description" type="text" > </span>
                                </div></td>
                            <td class=" ">
                                <div class="flex cursor-pointer select-none flex-wrap">
                                    <input class=" sm:w-full lg:w-1/6 shadow flex" min="1" type="number" v-model="item.qt">
                                    <div class="flex flex-wrap ">
                                        <div v-on:click="plusQtCurrent(key)" class="flex bg-green-300 px-3 py-2">+</div>
                                        <div v-on:click="minusQtCurrent(key)" class="flex bg-red-300 px-3 py-2">-</div>
                                    </div>

                                </div>

                            </td>

                            <td v-if="PriceMatters" class="text-right">
                                <input  class="shadow" min="0" type="number" v-model="item.price">
                            </td>
                            <td v-if="PriceMatters" class="text-right">
                                {{ roundToTwo(item.qt * item.price)}}
                            </td>
                            <td v-if="PriceMatters" class="text-right" v-for="tax in item.tax" >
                                {{ roundToTwo((tax.plus * (item.qt * item.price))/100) }}
                            </td>
                            <td v-if="PriceMatters" class="text-right">
                                {{ roundToTwo( (item.qt * item.price) + calculatTax(item.tax,item.qt * item.price))  }}
                            </td>

                        </tr>
                        <tr>
                            <td>Total Item Quantity </td>
                            <td>{{itemTotalQt}}</td>
                            <td v-if="PriceMatters" colspan="2" class="text-right">{{roundToTwo(itemTotalTaxable)}}</td>
                            <td v-if="PriceMatters" v-for="tax in defaultTax" >{{roundToTwo(itemTaxDetails[tax.name]) || 0}}</td>
                            <td v-if="PriceMatters">{{roundToTwo(itemTaxPlus)}}</td>

                        </tr>
                    </table>
                </div>

            </div>
        </div>
        <!-- item added section end -->

        <!-- item tax section  -->
        <div class="flex flex-wrap" v-if="PriceMatters">
            <div class="flex-1 p-2 m-3 shadow border bg-white">
                <table class="ms-table-auto">
                    <tr>
                        <th>HSN/SAC Code</th>
                        <th>Qt</th>
                        <th class="text-right" v-for="tax in defaultTax" >{{tax.name}}</th>
                        <th class="text-right">Total</th>


                    </tr>

                    <tr v-for="(taxCode,key) in itemTaxCodeWise">
                        <td>{{taxCode.taxcode}}</td>
                        <td>{{taxCode.qt}}</td>
                        <td v-for="(taxTypeCode,key2) in taxCode.taxdetail">{{roundToTwo(taxTypeCode)}}</td>
                        <td> {{ roundToTwo(getTotalOfTypeCode(taxCode.taxdetail))}} </td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <th>{{itemTaxCodeWiseTotalQt}}</th>
                        <th v-for="taxType in defaultTax">{{roundToTwo(itemTaxCodeWiseTotalTaxByType[taxType.name]|| 0)}}</th>
                        <th>{{roundToTwo(itemTaxCodeWiseTotalTaxAll)}}</th>
                    </tr>
                </table>
            </div>
        </div>
        <!-- item tax section  -->

        </div>
</template>

<script>
    import MS from './MS';
    export default {
        name: "mslistmaker",
        mixin: [MS],
        data:function (){
            return {
                forUserName:'',
                hasItemFromServer:false,
                hasUserFromServer:false,
                currentUserIdentifier:"",
                currentItemName:"",
                currentQt:1,
                currentList:[],
                foundItem:[],
                pickedItem:0,
                defaultTax:[
                    {
                        name:'CGST',
                    },
                    {
                        name:'SGST'
                    }
                ],
                finalTax:[],
                currentItemPage:1,
                maxItemPage:10,
         //       itemTotalTaxable:0,
                itemTotalTax:0,
           //     itemTotalQt:0,
        //        itemTaxDetails:{},
          //      itemTaxPlus:0,
                withData:false,
                withDataObj:{},
                oldCurrentList:[],
                itemDescription:false,
                baacodeMachineOn:false,
                msUserMode:false,
                foundUser:[],
                pickedUser:0,
                forUserName:'',
                forAddress1:'',
                forAddress2:'',
                forAddress3:'',
                forContactNo:'',
                forCity:'',
                forPincode:'',
                forGSTIN:'',
                forDate:'',
                msFounUserList:false,
                currentUserPage:1,
                allFoundData:{},
                PriceMatters:false,





        };
        },
        props:{
            'msData':{
                type: Object,
                required: true
            },

        },
        watch:{
            pickedUser(newVal,oldVal){
                this.selectUser(newVal);
            },
            currentUserIdentifier(newVal,oldVal){
                var url= this.msData.productApiUrl+"?msFor="+newVal;
                var th=this;

                if(newVal=="") {
                    th.resetUserSearch();
                }else{
                    var config={headers: {'MS-APP-Token': 'app'}} ;
                    if(!this.hasFoundData('users',1,newVal)){
                        this.setFoundUser([]);
                        window.axios.get(url,config).then((res)=>{
                            th.setFoundUser(res.data.msFor);
                            th.hasUserFromServer=true;
                            th.selectUser(0);
                            th.toggleFounUser(true);
                            th.setFoundData('users',1,newVal,res.data.msFor);
                        }).catch((e)=>{

                        });

                    }else {
                        var inData =this.getFoundData('users',1,newVal);
                        th.setFoundUser(inData  );
                        th.hasUserFromServer=true;
                        th.selectUser(0);
                        th.toggleFounUser(true);
                    }
                  //  console.log(this.hasFoundData('users',1,newVal));

                }
                },
            currentQt(newVal,oldVal){

                },
            currentItemName(newVal,oldVal){

                var url= this.msData.productApiUrl+"?name="+newVal;
                var th=this;


                if(newVal=="")
                {
                    th.hasItemFromServer=false;
                    th.foundItem=[];
                }else{
                    var config={headers: {'MS-APP-Token': 'app'}} ;
                    if(this.baacodeMachineOn ){

                        url=this.msData.productApiUrl+"?name="+newVal+"&barcode="+this.baacodeMachineOn;
                        if(newVal.length==13){
                            window.axios.get(url,config).then((res)=>{th.setFoundItem(res.data.msItem);th.hasItemFromServer=true})
                        }

                    }else {
                        window.axios.get(url,config).then((res)=>{th.setFoundItem(res.data.msItem);th.hasItemFromServer=true})

                    }


                }

               // th.setFoundItem(url);

            },


        }
        ,
        mounted(){
            this.loadSettings();
            this.$nextTick(() =>
            {
                this.$refs.cI.focus();
                this.$refs.cI.click();
            });
        },

        methods: {
            loadSettings(){

                if (this.msData.hasOwnProperty('msConfig')) {
                    if (this.msData['msConfig'].hasOwnProperty('priceMatters')) this.PriceMatters = this.msData.msConfig.priceMatters;
                    if (this.msData['msConfig'].hasOwnProperty('productDescription')) this.itemDescription = this.msData.msConfig.productDescription;
                    if (this.msData['msConfig'].hasOwnProperty('baacodeMachineOn')) this.baacodeMachineOn = this.msData.msConfig.baacodeMachineOn;
                }
            },
            setFoundData(key='',page=1,str='',fdata=[]){
             //   console.log(key!='');
                if(key=='' || str=='' ){
                //    console.log("1: "+this.allFoundData.hasOwnProperty(key));
                    return false;
                }else {
                    if(!this.allFoundData.hasOwnProperty(key)) {
                      //  console.log("2: "+!this.allFoundData.hasOwnProperty(key));
                        this.allFoundData[key]={};
                        if(!this.allFoundData[key].hasOwnProperty(str)){
                           // console.log("3: "+!this.allFoundData[key].hasOwnProperty(str));
                            this.allFoundData[key][str]={};
                            if(!this.allFoundData[key][str].hasOwnProperty(page)){
                              //  console.log("4:  "+!this.allFoundData[key][str].hasOwnProperty(page));
                                this.allFoundData[key][str][page]=fdata;
                                return true;
                            }
                        }else{
                            if(!this.allFoundData[key][str].hasOwnProperty(page)){
                                //  console.log("4:  "+!this.allFoundData[key][str].hasOwnProperty(page));
                                this.allFoundData[key][str][page]=fdata;
                                return true;
                            }
                        }

                    }else {
                        if(!this.allFoundData[key].hasOwnProperty(str)){
                            // console.log("3: "+!this.allFoundData[key].hasOwnProperty(str));
                            this.allFoundData[key][str]={};
                            if(!this.allFoundData[key][str].hasOwnProperty(page)){
                                //  console.log("4:  "+!this.allFoundData[key][str].hasOwnProperty(page));
                                this.allFoundData[key][str][page]=fdata;
                                return true;
                            }
                        }else{
                            if(!this.allFoundData[key][str].hasOwnProperty(page)){
                                //  console.log("4:  "+!this.allFoundData[key][str].hasOwnProperty(page));
                                this.allFoundData[key][str][page]=fdata;
                                return true;
                            }
                        }

                    }
                }
                //console.log("5: False");
                return false;
            },
            getFoundData(key='',page=1,str=''){
                var returnD=[];

                if (key!='' && str!='' && this.allFoundData.hasOwnProperty(key) &&this.allFoundData[key].hasOwnProperty(str) &&this.allFoundData[key][str].hasOwnProperty(page)){
                    returnD=this.allFoundData[key][str][page];
                }
                return returnD;
            },
            hasFoundData(key='',page=1,str=''){
              //  console.log('key : '+ key + " str: "+str);
                //console.log(key!='' && str!='' && this.allFoundData(key));
                if (key!='' && str!=''&& this.allFoundData.hasOwnProperty(key) &&this.allFoundData[key].hasOwnProperty(str)&&this.allFoundData[key][str].hasOwnProperty(page)){
                  return  true;
                }
                return false;
            },
            plusUser(event){
                event.preventDefault();
                if((this.foundUser.length <= this.pickedUser ) ||(this.pickedUser != 0))this.pickedUser--;
            },
            downUser(event){
                event.preventDefault();
                if((this.pickedUser  >= 0) && (this.foundUser.length-1 > this.pickedUser))this.pickedUser++;
            },
            getUsersFromServer(){
                var url= this.msData.productApiUrl+"?msFor="+this.currentUserIdentifier+"&page="+this.currentUserPage;
                var th=this;
                if(this.currentUserIdentifier=="") {th.resetUserSearch();}
                else{
                    var config={headers: {'MS-APP-Token': 'app'}} ;


                    if(!this.hasFoundData('users',th.currentUserPage,this.currentUserIdentifier)){
                        this.setFoundUser([]);
                        window.axios.get(url,config).then((res)=>{
                            th.setFoundUser(res.data.msFor);
                            th.hasUserFromServer=true;
                            th.selectUser(0);
                            th.toggleFounUser(true);
                            th.setFoundData('users',th.currentUserPage,th.currentUserIdentifier,res.data.msFor);
                        });

                    }else {
                        var inData =this.getFoundData('users',th.currentUserPage,this.currentUserIdentifier);
                        th.setFoundUser(inData);
                        th.hasUserFromServer=true;
                        th.selectUser(0);
                        th.toggleFounUser(true);
                    }
                     //   window.axios.get(url,config).then((res)=>{th.setFoundUser(res.data.msFor);th.hasUserFromServer=true;th.toggleFounUser(true);})

                }
            },
            backUserPage(){
                if(this.currentUserPage >1)
                {
                    this.currentUserPage--;
                    this.getUsersFromServer();
                }

            },
            nextUserPage(){

                if(this.maxItemPage > this.currentUserPage){
                    this.currentUserPage++;
                    this.getUsersFromServer();
                }




            },
            resetUserSearch(){
                this.hasUserFromServer=false;
                this.foundUser=[];
                this.msUserMode=false;
                this.msFounUserList=true;
            },
            setFoundUser(val){
                this.foundUser=val;
            },
            getDataFromUrl(th,url,methods=[]){
                var config={headers: {'MS-APP-Token': 'app'}} ;
                window.axios.get(url,config).then((res)=>{
                    th.setFoundItem(res.data.msItem);
                    th.hasItemFromServer=true
                })

            },
            calculatTax(tax,price){
              var taxFinal=0;

              for (var taxPlus in tax){

               taxFinal=taxFinal+((price*tax[taxPlus].plus)/100);
              }

              return taxFinal;
            },
            selectItem(val){
                this.pickedItem=val;
                this.addItemRaw(this.foundItem[val]);
            },
            selectUser(key){
               if(this.foundUser.length>0){
                   this.pickedUser=key;
                   this.setUser(this.foundUser[key]);
               }

            },
            setUser(data){
                this.toggleUserMode(true);
                    this.forUserName= data.name;
                    this.forAddress1=data.address1;
                    this.forAddress2=data.address1;
                    this.forAddress3=data.address3;
                    this.forContactNo=data.contactno;
                    this.forCity=data.city;
                    this.forPincode=data.pincode;
                    this.forGSTIN=data.gstno;
                    this.forDate=new Date().toISOString().slice(0,10);
            },
            setFoundItem(val,key=0){
                this.pickedItem=key;
              this.foundItem= val;
            },
            getItemName(){
                return this.currentItemName;
            },
            setItemName(name){
                this.currentItemName=name;
            },
            resetItemQt(){
                if(this.currentQt!=1)this.currentQt=1;
            },
            addItemRaw(item){

                if(typeof item != 'undefined'){

                    var itemF={
                            name:item.name,
                            qt:this.currentQt,
                            price:item.price,
                            tax:item.tax,
                            stock:item.stock,
                            taxcode:item.taxcode
                    };

                var taxI=0;
                var totalTaxable=itemF.price *itemF.qt;
                for (var tax in itemF.tax){
                    taxI=taxI+( (itemF.tax[tax].plus * totalTaxable)/100 );
                }
                //this.itemTotalTaxable=this.itemTotalTaxable+taxI;
                this.resetForNewItemSearch();
                this.currentList.push(itemF);
}



            },
            resetForNewItemSearch(){
                this.hasItemFromServer=false;
                this.currentItemPage=1;
                this.$refs.cI.focus();
                this.$refs.cI.click();
                this.setItemName("");
                this.resetItemQt();
                this.pickedItem=0;
                this.foundItem=this.foundItem.splice(0,this.foundItem.length);
                this.currentItemName="";
            },
            addItem(from=''){

                if(this.baacodeMachineOn){
                   // var qt=prompt('Quantity: ','1');
                   // this.currentQt=qt;

                   var th =this;

                    if(this.getItemName() !=""  && this.currentItemName.toString().length ==13){
                       var th=this;

                        if(this.hasItemFromServer){

                                th.addItemRaw(th.foundItem[th.pickedItem]);


                        }else{
                         //   console.log('i m here')
                            var url=this.msData.productApiUrl+"?name="+this.currentItemName+"&barscode="+this.baacodeMachineOn;


                              //th.addItemRaw(th.foundItem[th.pickedItem]);


                          //  if(from=='enter')  console.log(th.foundItem[th.pickedItem]);
                        }



                    }
                }else {
                    if(this.getItemName() !="" && this.currentItemName.length <10){
                        this.addItemRaw(this.foundItem[this.pickedItem]);
                    }
                }

            },
            plusQt(){
                this.currentQt++;
            },
            minusQt(){
                if(this.currentQt >1)this.currentQt--;
            },
            plusQtCurrent(key){
                var newVal=this.currentList;
                this.currentList=newVal.map(function (value, index) {
                    if(index==key)value.qt++;
                    return value;
                });
                //this.currentQt++;
            },
            minusQtCurrent(key){
                this.currentList=this.currentList.map(function (value, index) {
                    if(index==key && value.qt >1)value.qt--;
                    return value;
                });
                //this.currentQt++;
            },
            plusItem(event){
                event.preventDefault();
                if((this.foundItem.length <= this.pickedItem ) ||(this.pickedItem != 0))this.pickedItem--;
              },
            downItem(event){
                event.preventDefault();
                 if((this.pickedItem  >= 0) && (this.foundItem.length-1 > this.pickedItem))this.pickedItem++;
               },
            getItemsFromServer(){
                var url= this.msData.productApiUrl+"?name="+this.currentItemName+'&page='+this.currentItemPage;
                var th=this;
                if(this.currentItemName=="")
                {
                    th.hasItemFromServer=false;
                    th.foundItem=[];
                }else{
                    var config={headers: {'MS-APP-Token': 'app'}} ;
                    window.axios.get(url,config).then((res)=>{
                        if(res.data.hasOwnProperty('msItemPageData') )
                            th.maxItemPage= res.data.msItemPageData.maxPage;
                            if(th.maxItemPage==0)th.maxItemPage=1;
                        th.setFoundItem(res.data.msItem);th.hasItemFromServer=true})

                }
            },
            backItemPage(){
                if(this.currentItemPage >1)
                {
                    this.currentItemPage--;
                    this.getItemsFromServer();
                }

            },
            nextItemPage(){

                if(this.maxItemPage > this.currentItemPage){
                    this.currentItemPage++;
                    this.getItemsFromServer();
                }




            },

            getItemPage(page){

            },
            roundToTwo(val){
                return +(Math.round(val + "e+2")  + "e-2")
            },
            getTotalOfTypeCode(taxDetails){
                var total=0;
                for (var tax in taxDetails){
                    total+=taxDetails[tax];
                }
                return total;
            },
            removeItemFromList(key){
                this.currentList.splice(key, 1);
            },
            toggelBarcodeScaner(){
                this.baacodeMachineOn=(this.baacodeMachineOn)?false:true;

            },
            toggleUserMode(staticInput=''){
                if(staticInput==''){
                    this.msUserMode=(this.msUserMode)?false:true;
                }else{
                    this.msUserMode=staticInput;
                }

            },
            toggleFounUser(staticInput=''){
                if(staticInput=='' || staticInput=="object MouseEvent" ){
                    this.msFounUserList=(this.msFounUserList)?false:true;
                }else{
                    this.msFounUserList=staticInput;
                }
            },
            onLytoggleFounUser(event){
                 this.msFounUserList=(this.msFounUserList)?false:true;

            }

        },
        computed:{
        currentListProcess(vueCom){

           //   console.log(vueCom.currentList);
                this.oldCurrentList=vueCom.currentList;

              return this.currentList;
          },
        itemTotalTaxable(){
              var itemTotaltaxable=0;
             for(var rowKey in this.currentListProcess){
                  itemTotaltaxable+=this.currentListProcess[rowKey]['price']*this.currentListProcess[rowKey]['qt'];
             }
              return itemTotaltaxable;
            },
            itemTaxDetails(){
                var itemTotaltaxDetails={};

                for(var rowKey in this.currentListProcess){
                    var subTaxTotal=0;
                    for(var rowKey2 in this.currentListProcess[rowKey]['tax']){
                        var productTotal=this.currentListProcess[rowKey]['price']*this.currentListProcess[rowKey]['qt']
                        if(itemTotaltaxDetails.hasOwnProperty(this.currentListProcess[rowKey]['tax'][rowKey2]['name']))
                        {
                            itemTotaltaxDetails[this.currentListProcess[rowKey]['tax'][rowKey2]['name']]+= (productTotal*this.currentListProcess[rowKey]['tax'][rowKey2]['plus'])/100 ;

                        }
                        else{
                            itemTotaltaxDetails[this.currentListProcess[rowKey]['tax'][rowKey2]['name']]= (productTotal*this.currentListProcess[rowKey]['tax'][rowKey2]['plus'])/100 ;

                        }
                    }

                }
             //  console.log(itemTotaltaxDetails);
                return itemTotaltaxDetails;
            },
            itemTaxPlus(){
                var itemTotaltaxPlus=0;

                for(var rowKey in this.currentListProcess){
                    var productTotal=this.currentListProcess[rowKey]['price']*this.currentListProcess[rowKey]['qt']
                    var subTaxTotal=0;
                    for(var rowKey2 in this.currentListProcess[rowKey]['tax']){
                        subTaxTotal+= (productTotal*this.currentListProcess[rowKey]['tax'][rowKey2]['plus'])/100 ;
                    }
                    itemTotaltaxPlus+=productTotal+subTaxTotal;

                }
               //console.log(itemTotaltaxDetails);
                return itemTotaltaxPlus;
            },
            itemTotalQt(){
                var itemTotalQt=0;

                for(var rowKey in this.currentListProcess){
                    var msD=(typeof this.currentListProcess[rowKey]['qt'] != 'number')? parseInt(this.currentListProcess[rowKey]['qt']):this.currentListProcess[rowKey]['qt'];
                    itemTotalQt+=(typeof msD !='undefined')? msD: 0;


                }
                return itemTotalQt;
            },
            itemTaxCodeWise(){
                var itemTaxCodeWise={};

                for(var rowKey in this.currentListProcess){
                    var productTotal=this.currentListProcess[rowKey]['price']*this.currentListProcess[rowKey]['qt']
                    var subTaxTotal=0;


                    if(itemTaxCodeWise.hasOwnProperty('taxcode_'+this.currentListProcess[rowKey]['taxcode'])){
                        var oldData= itemTaxCodeWise['taxcode_'+this.currentListProcess[rowKey]['taxcode']];
                        itemTaxCodeWise['taxcode_'+this.currentListProcess[rowKey]['taxcode']]={
                            taxcode:this.currentListProcess[rowKey]['taxcode'],
                            taxdetail:oldData['taxdetail'],
                            qt:itemTaxCodeWise['taxcode_'+this.currentListProcess[rowKey]['taxcode']]['qt']+this.currentListProcess[rowKey]['qt']
                        };

                        for(var rowKey2 in this.currentListProcess[rowKey]['tax']){

                            itemTaxCodeWise['taxcode_'+this.currentListProcess[rowKey]['taxcode']]['taxdetail']
                                [this.currentListProcess[rowKey]['tax'][rowKey2]['name']]+=
                                (productTotal*this.currentListProcess[rowKey]['tax'][rowKey2]['plus'])/100;
                        }


                    }
                    else{
                        itemTaxCodeWise['taxcode_'+this.currentListProcess[rowKey]['taxcode']]={
                            taxcode:this.currentListProcess[rowKey]['taxcode'],
                            taxdetail:{},
                            qt:this.currentListProcess[rowKey]['qt']
                        };
                        itemTaxCodeWise['taxcode_'+this.currentListProcess[rowKey]['taxcode']]['taxdetail']={};

                        for(var rowKey2 in this.currentListProcess[rowKey]['tax']){

                            itemTaxCodeWise['taxcode_'+this.currentListProcess[rowKey]['taxcode']]['taxdetail']
                                [this.currentListProcess[rowKey]['tax'][rowKey2]['name']]=
                                (productTotal*this.currentListProcess[rowKey]['tax'][rowKey2]['plus'])/100;
                        }

                    }

                }

                return itemTaxCodeWise;
            },
            itemTaxCodeWiseTotalQt(){
                var itemTaxCodeWiseTotalQt=0;
                for (var hsn in this.itemTaxCodeWise){
                    itemTaxCodeWiseTotalQt+=this.itemTaxCodeWise[hsn]['qt'];
                }
                return itemTaxCodeWiseTotalQt;
            },
            itemTaxCodeWiseTotalTaxByType(){
                var itemTaxCodeWiseTotalTaxByType={};


                for (var hsn in this.itemTaxCodeWise){

                    for(var rowKey in this.defaultTax){
                      //  consoles.log( this.itemTaxCodeWise[hsn]['taxdetail'][this.defaultTax[rowKey]['name']]);
                        if(itemTaxCodeWiseTotalTaxByType.hasOwnProperty(this.defaultTax[rowKey]['name'])){
                            itemTaxCodeWiseTotalTaxByType[this.defaultTax[rowKey]['name']]+=this.itemTaxCodeWise[hsn]['taxdetail'][this.defaultTax[rowKey]['name']];
                        }else {
                            itemTaxCodeWiseTotalTaxByType[this.defaultTax[rowKey]['name']]=this.itemTaxCodeWise[hsn]['taxdetail'][this.defaultTax[rowKey]['name']];

                        }
                    }
                }


                    return itemTaxCodeWiseTotalTaxByType;
            },
            itemTaxCodeWiseTotalTaxAll(){
                var itemTaxCodeWiseTotalTaxAll=0;

                for (var hsn in this.itemTaxCodeWise){
                    var subTax=0;
                    for(var rowKey in this.defaultTax){
                  //      console.log(hsn);
                    //    console.log( this.defaultTax[rowKey]['name']);
                        subTax+= this.itemTaxCodeWise[hsn]['taxdetail'][this.defaultTax[rowKey]['name']];
                    }
                    itemTaxCodeWiseTotalTaxAll+=subTax;

                }

                return itemTaxCodeWiseTotalTaxAll;
            },

        }
    }
</script>

<style scoped>

</style>

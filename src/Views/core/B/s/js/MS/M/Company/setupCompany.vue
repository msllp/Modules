<template>
    <div>

        <div class="ms-company-setup-box  ">
            <div class="ms-company-setup-image">

                <img class="ms-company-setup-image-icon" src="/ms/company/setupCompany.svg">
            </div>
            <div  class="ms-company-setup-form">

                <div class="ms-company-setup-form-title" > Setup Company</div>

                <div class="ms-company-setup-form-body" >
                    <div class="ms-company-setup-form-section">
                        <div class="ms-company-setup-form-body-head"> Business Logo </div>
                        <div  class="ms-company-setup-form-body-row" @dragover.prevent v-on:drop="onDragLogo">

                            <div  class="ms-company-setup-form-body-row-col" >


                                <img v-on:click="$refs.logo.click()" v-if="logo!=''" :src="logo" class="ms-company-setup-form-body-row-logo">
                                <img v-on:click="$refs.logo.click()" v-if="logo==''" src="/ms/company/samplelogo.png" class="ms-company-setup-form-body-row-logo">
                                <div class="ms-company-setup-form-input-lable">Logo Preview
                                <small>preferred size logo :  200 px (width) X 100 px (height)</small>
                                </div>

                            </div>

                            <div  class="ms-company-setup-form-body-row-col">


                                <input ref="logo" v-on:change="setFile($event,'logo')" type="file" class="ms-company-setup-form-input" placeholder="Enter Logo">

                                <div class="ms-company-setup-form-input-lable">Logo
                                    <small>allowed file type:png,jpg,jpeg ,allowed file size: max 3MB</small>
                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="ms-company-setup-form-section">
                    <div class="ms-company-setup-form-body-head"> Business Basic Details </div>
                    <div v-for="rows in msForm" class="ms-company-setup-form-body-row">


                        <div v-for="col in rows" class="ms-company-setup-form-body-row-col">


                            <input :class="{
                                'ms-sucess-input':(col.hasOwnProperty('validation') && checkInputisValid(col.model)),
                                'ms-failure-input':(col.hasOwnProperty('validation') &&  !checkInputisValid(col.model) ) ,

                            }"  v-on:keyup="updateAllInput()" v-model="allInput[col.model]" v-if="col.type=='text'" type="text" class="ms-company-setup-form-input" :placeholder="'Enter '+col.name">
                            <div class="ms-company-setup-form-input" :class="{
                                'ms-sucess-input':checkInputisValid(col.model),
                                'ms-failure-input':!checkInputisValid(col.model),

                            }" v-if="col.type=='option'">
                                <select v-model="allInput[col.model]"   v-on:change="updateAllInput()">
                                    <option disabled selected value="disabled">Select {{col.name}}</option>
                                    <option v-for="op in  (col.hasOwnProperty('data'))?col.data:msDatafromServer[col.model]" :value="op.value">{{op.name}}</option>
                                </select>
                            </div>

                            <div v-if="checkInputisValid(col.model) && col.type!='option' && col.hasOwnProperty('validation')" class="ms-company-setup-form-input-ok"><i class="fas fa-check"></i></div>

                            <div :class="{
                                'ms-company-setup-form-input-lable':checkInputisValid(col.model),
                                'ms-company-setup-form-input-lable-have-error':!checkInputisValid(col.model),
                            }">{{col.name}}
                            <sup v-if="col.hasOwnProperty('required') && col.required" class="ms-company-setup-form-input-lable-required" >*</sup>

                            </div>


                            <div class="ms-company-setup-form-input-error" v-for="er in  getInputError(col.model)">

                                {{ er }}
                            </div>

                        </div>

                    </div>
                </div>

                    <div class="ms-company-setup-form-section">
                    <div class="ms-company-setup-form-body-head"> Business Registration Details</div>
                    <div v-for="rows in msCurrentCusomForm('typeOfBusiness')" class="ms-company-setup-form-body-row">


                        <div v-for="col in rows" class="ms-company-setup-form-body-row-col">


                            <input :class="{
                                'ms-sucess-input':(col.hasOwnProperty('validation') && checkInputisValid(col.model)),
                                'ms-failure-input':(col.hasOwnProperty('validation') &&  !checkInputisValid(col.model) ) ,

                            }"  v-on:keyup="updateAllInput()" v-model="allInput[col.model]" v-if="col.type=='text'" type="text" class="ms-company-setup-form-input" :placeholder="'Enter '+col.name">
                            <div class="ms-company-setup-form-input" :class="{
                                'ms-sucess-input':checkInputisValid(col.model),
                                'ms-failure-input':!checkInputisValid(col.model),

                            }" v-if="col.type=='option'">
                                <select v-model="allInput[col.model]" v-on:change="updateAllInput()">
                                    <option v-for="op in col.data" :value="op.value">{{op.name}}</option>
                                </select>
                            </div>

                            <div
                                :class="{
                                'ms-company-setup-form-input-lable':checkInputisValid(col.model),
                                'ms-company-setup-form-input-lable-have-error':!checkInputisValid(col.model),

                            }">{{col.name}}
                                <sup v-if="col.hasOwnProperty('required') && col.required" class="ms-company-setup-form-input-lable-required" >*</sup>

                            </div>
                            <div class="ms-company-setup-form-input-error" v-for="er in  getInputError(col.model)">

                                {{ er }}
                            </div>

                        </div>

                    </div>


                </div>

                    <div class="ms-company-setup-form-section">
                    <div class="ms-company-setup-form-body-head"  >Business Address & Contact Details </div>
                    <div v-for="rows in msForm2" class="ms-company-setup-form-body-row">


                        <div v-for="col in rows" class="ms-company-setup-form-body-row-col">



                            <input :class="{
                            'ms-sucess-input':(col.hasOwnProperty('validation') && checkInputisValid(col.model)),
                            'ms-failure-input':(col.hasOwnProperty('validation') && !checkInputisValid(col.model)),

                            }"  v-on:keyup="updateAllInput()" v-model="allInput[col.model]" v-if="col.type=='text' || col.type=='number' || col.type=='email'" :type="col.type" class="ms-company-setup-form-input" :placeholder="'Enter '+col.name">

                            <div class="ms-company-setup-form-input" :class="{
                                'ms-sucess-input':checkInputisValid(col.model),
                                'ms-failure-input':!checkInputisValid(col.model),}"  v-if="col.type=='option'">
                                <select v-model="allInput[col.model]"  v-on:change="updateAllInput()">
                                    <option disabled selected value="disabled">Select {{col.name}}</option>
                                    <option v-for="op in  (col.hasOwnProperty('data'))?col.data:msDatafromServer[col.model]" :value="op.value">{{op.name}}</option>
                                </select>
                            </div>

                            <div v-if="checkInputisValid(col.model)  && col.type!='option' && col.hasOwnProperty('validation')" class="ms-company-setup-form-input-ok"><i class="fas fa-check"></i></div>
                            <div
                                :class="{
                                'ms-company-setup-form-input-lable':checkInputisValid(col.model),
                                'ms-company-setup-form-input-lable-have-error':!checkInputisValid(col.model),

                            }"

                            >{{col.name}}
                                <sup v-if="col.hasOwnProperty('required') && col.required" class="ms-company-setup-form-input-lable-required" >*</sup>

                            </div>

                            <div class="ms-company-setup-form-input-error" v-for="er in  getInputError(col.model)">

                                {{ er }}
                            </div>

                        </div>

                    </div>
                </div>




                </div>

                <div class="ms-company-setup-form-footer">

                    <div
                         :class="{ 'ms-company-setup-form-footer-btn-save-diabled':!validToPost(),
                                    'ms-company-setup-form-footer-btn-save':validToPost()
                                    }"
                         v-on:click="postForm()"> Save </div>

                </div>


            </div>



            </div>


    </div>


</template>

<script>
    module.exports = {
        name:'setupcompany',
        data: function() {
            return {

                msForm:[
                        [
                           {
                               name:'Business Name',
                               type:'text',
                               model:'businessName',
                               required:true,
                               validation:{presence: {allowEmpty: false}}
                           },
                           {
                               name:'Short Business Name',
                               type:'text',
                               model:'shortBusinessName',
                               required:true,
                               validation:{presence: {allowEmpty: false}}
                           },

                        ],
                        [
                            {
                                name:'Type of Business',
                                type:'option',
                                model:'typeOfBusiness',
                                required:true,
                                validation:{presence: {allowEmpty: false}},
                                data:[
                                    {
                                        name:'Sole proprietorship',
                                        value:'solo'
                                    },
                                    {
                                        name:'Partnership Firm',
                                        value:'partnership'
                                    },
                                    {
                                        name:'Limited Liability Partnership (LLP)',
                                        value:'llp'
                                    },
                                    {
                                        name:'Private Ltd Company (Pvt. Ltd.)',
                                        value:'private'
                                    },
                                    {
                                        name:'Public Ltd Company',
                                        value:'public'
                                    },
                                    {
                                        name:'Co-operatives Firm',
                                        value:'coop'
                                    }
                                ]
                            },
                            {
                                name: 'Category of Business',
                                type:'option',
                                model:'categoryOfBusiness',
                                required:true,
                                validation:{presence: {allowEmpty: false}},
                                data:[
                                    {
                                        name:'Accounting Services',
                                        value:'as'
                                    },
                                    {
                                        name:'Consultants,Doctors,Lawyers & Similar',
                                        value:'consultants'
                                    },
                                    {
                                        name:'Information Technology',
                                        value:'it'
                                    },
                                    {
                                        name:'Manufacturing',
                                        value:'man'
                                    },
                                    {
                                        name:'Professional, Scientific & Technical Services ',
                                        value:'ts'
                                    },
                                    {
                                        name:'Resturants/Bars & Similar',
                                        value:'res'
                                    },
                                    {
                                        name:'Retail & Similar',
                                        value:'retail'
                                    },
                                    {
                                        name:'Other Financial Services',
                                        value:'ofs'
                                    },
                                    {
                                        name:'Other Services',
                                        value:'os'
                                    },
                                    {
                                        name:'Tours & Travel/Hospitality',
                                        value:'tours'
                                    },
                                    {
                                        name:'Wholesale Trade',
                                        value:'wt'
                                    },
                                    {
                                        name:'Logistics Transportation',
                                        value:'lt'
                                    },
                                    {
                                        name:'Other',
                                        value:'other'
                                    },
                                ]
                            }
                        ]
                ],
                msForm2:[
                    [
                        {
                            name:'Block No. / Plot No.  ',
                            type:'text',
                            model:'addressLine1',
                            required:true,
                            validation:{presence: {allowEmpty: false}}
                        },
                        {
                            name:'Building Name / Street Name  ',
                            type:'text',
                            model:'addressLine2',
                            required:true,
                            validation:{presence: {allowEmpty: false}}
                        },

                        {
                            name:'Landmark /  Area',
                            type:'text',
                            model:'addressLine3',
                            required:true,
                            validation:{presence: {allowEmpty: false}}
                        },


                    ],
                    [
                        {
                            name:'City/Town',
                            type:'text',
                            model:'city',
                            required:true,
                            validation:{presence: {allowEmpty: false}}

                        },
                        {
                            name:'State',
                            type:'option',
                            model:'state',
                            required:true,
                            dataUrl:window.msBackEnd+'/o3/Company/setup/company/get/states',
                            validation:{presence: {allowEmpty: false}}
                        },

                        {
                            name:'Pincode',
                            type:'number',
                            model:'pincode',
                            required:true,
                            validation:{presence: {allowEmpty: false},numericality: {strict: true},length: {maximum: 6}}
                        },


                    ],
                    [
                        {
                            name:'Contact No.',
                            type:'number',
                            model:'contactNo',


                        },
                        {
                            name:'Email',
                            type:'email',
                            model:'email',
                            required:true,

                        }


                    ],
                ],
                msConditionalForm:{
                    typeOfBusiness:{
                         'llp': [

                                    [
                                        {
                                            name: 'LLP No.',
                                            type: 'text',
                                            model:'llpNo',
                                            required:true,
                                            validation:{presence: {allowEmpty: false}}
                                        },
                                        {
                                            name: 'PAN',
                                            type: 'text',
                                            model:'pan',
                                            required:true,
                                            validation:{presence: {allowEmpty: false}}
                                        },

                                        {
                                            name: 'GST No.',
                                            type: 'text',
                                            model:'gst'
                                        },
                                   ]
                                ],
                         'solo': [

                                    [
                                        {
                                            name: 'PAN',
                                            type: 'text',
                                            model:'pan',
                                            required:true,
                                            validation:{presence: {allowEmpty: false}}
                                        },
                                        {
                                            name: 'GST No.',
                                            type: 'text',
                                            model:'gst'
                                        },
                                    ]
                                ],
                        'partnership':[
                                         [
                            {
                                name: 'PAN',
                                type: 'text',
                                model:'pan',
                                required:true,
                                validation:{presence: {allowEmpty: false}}
                            },
                            {
                                name: 'GST No.',
                                type: 'text',
                                model:'gst'
                            },
                        ]
                                      ],
                        'private':[
                            [
                                {
                                    name: 'CIN No',
                                    type: 'text',
                                    model:'cin',
                                    required:true,
                                    validation:{presence: {allowEmpty: false}}
                                },
                                {
                                    name: 'PAN',
                                    type: 'text',
                                    model:'pan',
                                    required:true,
                                    validation:{presence: {allowEmpty: false}}
                                },
                                {
                                    name: 'GST No.',
                                    type: 'text',
                                    model:'gst'
                                },
                            ]
                        ],
                        'public':[
                            [
                                {
                                    name: 'CIN No',
                                    type: 'text',
                                    model:'cin',
                                    required:true,
                                    validation:{presence: {allowEmpty: false}}
                                },
                                {
                                    name: 'PAN',
                                    type: 'text',
                                    model:'pan',
                                    required:true,
                                    validation:{presence: {allowEmpty: false}}
                                },
                                {
                                    name: 'GST No.',
                                    type: 'text',
                                    model:'gst'
                                },
                            ]
                        ],
                        'coop':[

                            [
                                {
                                    name: 'PAN',
                                    type: 'text',
                                    model:'pan',
                                    required:true,
                                    validation:{presence: {allowEmpty: false}}
                                },
                                {
                                    name: 'GST No.',
                                    type: 'text',
                                    model:'gst'
                                },
                            ]
                        ],
                    }
                },
                msFormDefaultValue:[
                    {
                        name:'typeOfBusiness',
                        value:'disabled'
                    },
                    {
                        name:'categoryOfBusiness',
                        value:'disabled'
                    },
                ],
                msDatafromServer:{},
             //   msCurrentCusomForm:[],
                allInput:{},
                logo:'',
                greeting: "Hello",
                validationInput:{},
                formPostedAndWaitingForData:false,
                valdidationInputError:{}
            };
        },
        methods:{
            onDragLogo(e){
                e.stopPropagation();
                e.preventDefault();
                var files = e.dataTransfer.files;
                this.showLogo(files[0]);

            },
            msCurrentCusomForm(formInput){
                switch (formInput) {
                    case 'typeOfBusiness':
                        return  (this.msConditionalForm.hasOwnProperty(formInput) && this.allInput.hasOwnProperty(formInput) && this.msConditionalForm[formInput].hasOwnProperty(this.allInput[formInput]))?this.msConditionalForm[formInput][this.allInput[formInput]]:[];

                        break;
                }

            },
            setFile(e,name){
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.showLogo(files[0]);
            },
            showLogo(file){
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.allInput.logo=e.target.result;
                    vm.logo = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            validateAll(val,form) {

                if (val == 'undfined' || typeof val=='undfined') val = this.allInput;
                if (form == 'undfined' || typeof form=='undfined') val = this.msForm;
                var verify = window.msValidate;
                var validated = {};
                var error={};
                for (var p in form) {
                    //console.log(p);

                    for (var i in form[p]) {
                     //   console.log(i);
                        var input = form[p][i];
                       // console.log(this.msForm[p][i]);
                        if (input.hasOwnProperty('validation') && this.allInput.hasOwnProperty(input.model)) {

                            var validInputState=verify.single(this.allInput[input.model], input.validation);
                        //   console.log(validInputState);
                            validated[input.model] = ((validInputState == 'undefined' || typeof validInputState == 'undefined') && this.allInput[input.model]!='disabled' ) ? true : false;
                       //     if(input.model=='state')console.log(validated[input.model]);
                            if(validated[input.model]){

                                error[input.model]= [];

                            }else {
                           //     if(input.model=='state')console.log(validated[input.model]);

                                error[input.model]= verify.single(this.allInput[input.model], input.validation);
                                if((error[input.model] == 'undefined' || typeof error[input.model] == 'undefined') && input.type=='option',val[input.model]=='disabled'){
                                    error[input.model]=["can't be blansk"];
                                }



                            }
                              //console.log((verify.single(this.allInput[this.msForm[p][i].model], input.validation) == 'undefined') ? true : false);
                        } else {

                            if(input.hasOwnProperty('validation')) error[form[p][i].model]=verify.single(this.allInput[form[p][i].model], input.validation);
                           validated[form[p][i].model] = (input.hasOwnProperty('validation')) ? false : true;
                        }
                    }

                }
                this.valdidationInputError={...this.valdidationInputError,...error};
                this.validationInput = {...this.validationInput,...validated};
            },
            checkInputisValid(name){

             return (this.validationInput.hasOwnProperty(name))?this.validationInput[name]:false;
            },
            getInputError(name){

                return (this.valdidationInputError.hasOwnProperty(name) )?this.valdidationInputError[name]:[];

            },
            updateAllInput(){
                var newVal=this.allInput;
                this.allInput={};
                this.allInput=newVal;
            },
            getDataForInput(input){
                var th=this;
                if(!th.msDatafromServer.hasOwnProperty(input.model)){
                    var url =input.dataUrl;
                    var client = window.msInstance;
                  //  console.log('Dta from Server');
                    th.msDatafromServer[input.model]
                    client.get(url).then(function (res) {
                        // console.log('data fetched from server')
                        th.msDatafromServer[input.model]=res.data.msData;
                        th.allInput[input.model]='disabled';
                        th.updateAllInput();
                    });
                }
            },
            setDataFromServer(form){

                for (var p in form ){
                    for (var i in form[p] ){
                        if(form[p][i].hasOwnProperty('dataUrl')){
                           this.getDataForInput(form[p][i]);
                        }
                    }
                }

            },

            postForm (){
                if(!this.formPostedAndWaitingForData && this.validToPost()){
                  // this.formPostedAndWaitingForData=true;
                   var client=window.msInstance;
                   var url=window.msBackEnd+"/o3/Company/setup/company";
                   var th=this;
                   if(this.logo!="")this.allInput['logo']=this.logo;
                   client.post(url,this.allInput).then(function (res) {

                       console.log(res.data);

                   }).catch(function (er) {
                        console.log(er);
                   });

                    console.log("form ");
                }

            },

            validToPost(){
                for (var i in this.validationInput){
                    if(!this.validationInput[i])return false;
                }
                return true;

            }


        },
        watch:{
            allInput(newVal,oldVal){
             //   console.log('validates');
                this.validateAll(newVal,this.msForm);
                this.validateAll(newVal,this.msForm2);
                //console.log(newVal.typeOfBusiness);
              //  console.log(this.msConditionalForm.typeOfBusiness[newVal.typeOfBusiness]);
                if(newVal.typeOfBusiness !='disabled')this.validateAll(newVal,this.msConditionalForm.typeOfBusiness[newVal.typeOfBusiness]);


                }


        },
        mounted(){
            var def={};
            for (var i in this.msFormDefaultValue){
                def[this.msFormDefaultValue[i].name]=this.msFormDefaultValue[i].value;
            }
            this.setDataFromServer(this.msForm2);
            this.allInput=def;

            this.validateAll(this.allInput,this.msConditionalForm[this.allInput.typeOfBusiness])

        },
        computed:{



        }
    };
</script>

<style scoped>

</style>

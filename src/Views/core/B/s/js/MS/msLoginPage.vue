<template>
    <div class="ms-login-div select-none">




        <div v-for="formGroup in  msPageData.fData.formData">


            <div class="ms-login-h" >

                <div class="ms-login-logo-box">
                    <img class="ms-msterlogo" v-if="false" :src="msPageData.cIcon" >
                    <img class="ms-clientlogo" :src="msPageData.cIcon" >
                </div>

                <hr>

                <div class="ms-login-form">
                    <div class="ms-form-title " v-if="!successLogin">{{msPageData.fData.formTitle}}</div>

                    <div class="ms-login-error-box text-xs" v-if="msError">
                        <ul>
                            <li  v-for="er in msErrorData"> {{er}} </li>
                        </ul>
                    </div>
            <hr v-if="!successLogin">
                    <table class="ms-login-table mt-2 mb-2" v-if="!waitingForData && !successLogin">

                    <tr class="text-gray-700 text-base" v-for="input in formGroup.inputs" >

                        <th> <i class="fi2 flaticon-key" v-if="(input.type == 'password')" > </i><i class="fi2 flaticon-user-2" v-if="input.type == 'text'"></i>    </th>

                        <td >        <input v-on:keyup.enter="sendDataToLoginData()" v-on:keyup="checkForm()" class="" v-model="msInputData[input.name]" :placeholder="input.vName" :type="input.type" :name="input.name"></td>


                    </tr>
                    </table>

                    <div v-if="successLogin">
                       <img class="ms-login-success" src="\images\welcome.svg">
                        You Sign in successfully. We are redirecting you to Dashboard.
                    </div>
                    <div v-if="waitingForData">
                        <img class="ms-login-loading" src="\images\loading.gif">

                    </div>

                </div>
                <div v-if="!successLogin" class="px-6 py-4  flex justify-center " >
                        <span v-if="formIsValid"
                            v-for="btn in msPageData.fData.actionButton"
                        class="ms-login-btn" v-on:click="sendDataToLoginData(btn)">
                        <i :class='{[btn.btnIcon]:true,"inline-flex":true}'></i>
                        <strong :class='{"inline-flex":true}'> {{btn.btnText}}</strong>
                        </span>

                        <span  v-if="!formIsValid"   v-for="btn in msPageData.fData.actionButton"
                              class="ms-login-btn-disable" >
                        <i :class='{[btn.btnIcon]:true,"inline-flex":true}'></i>
                        <strong :class='{"inline-flex":true}'> {{btn.btnText}}</strong>

                        </span>

                </div>



                <div class="ms-login-others-box" v-if="msPageData.os && !successLogin">
                    <div class="text-center">
                        <hr>
                        or <br> Sign in
                        with your social network
                        <div class="ms-login-others-btn-box ">

                        <div v-for="sor in msLoginAs" class="ms-login-others-btn">
                       <a :href="sor.VerifyUrl" class="ms-login-others-btn-contetnt">
                           <div class="ms-login-other-btn-icon">
                               <i :class="{[sor.VerifyIcon]:true}" ></i>
                           </div>
                          <div class="ms-login-other-btn-text" >{{sor.VerifyName}} Account</div>
                       </a>
                        </div>


                        </div>


                    </div>

                </div>

                <div class="ms-login-info-box">
                    <span>Don't have account Sign up<a :href="msFrontEnd+'/signup'"> here </a> |</span>
                    <span> Not able to login ? Reach us </span>
                    <hr>
                    <span class="ms-login-info-pre"> {{msData.helpLine}}</span>
                </div>

                <div class="ms-login-copyright-box">

                    <span class="ms-login-copyright-pre"> {{msPageData.copyrightPre}}</span>
                    <span class="ms-login-copyright-icon-class">

                        <a target="_blank" v-if="false" href="http://ms.ms/product/o3-erp"><img :src="msPageData.mIcon" class="ms-login-msater-icon"></a> </span>
                        <a target="_blank" v-if="true" href="https://www.millionsllp.com/product/o3-erp"><img :src="msPageData.mIcon" class="ms-login-msater-icon"></a> </span>
                    <span v-if="false" class="ms-login-copyright-per"> {{msPageData.copyrightPer}}</span>
                </div>
            </div>




<div v-if="false" class="ms-login-bottom-line">
    {{msPageData.inspire}}
</div>


        </div>



    </div>

</template>

<script>
    //TODO Make Post Request & Error Display and Show Forgot Password Button after 3 unsuccessful Try to login.
    export default {
        name: "msLoginPage",
        props:{
            'msData':{
                type:Object,
                required: true,
                default:{}
            }
        },
        data(){
            return {
                msPageData:{},
                waitingForData:false,
                msError:false,
                msErrorData:[],
                msInputData:{},
                formIsValid:false,
                successLogin:false,
                msPostResponseData:{},
                msFrontEnd:window.msFrontEnd,
                msLoginAs:{}
              //  loader:null

                    };
        },
        beforeMount() {
            var loader=[
                {
                    propName:'ClientIcon',
                    setPropName:'cIcon'
                },
                {
                    propName:'MasterIcon',
                    setPropName:'mIcon'
                },
                {
                    propName:'formData',
                    setPropName:'fData',
                    defualt:{}
                },
                {
                    propName:'inspire',
                    setPropName:'inspire'
                }
                ,
                {
                    propName:'copyrightPre',
                    setPropName:'copyrightPre'
                },
                {
                    propName:'copyrightPer',
                    setPropName:'copyrightPer'
                },
                {
                    propName:'bgImg',
                    setPropName:'bgImg'
                }

                ,{
                    propName:'bgImg',
                    setPropName:'bgImg'
                },
                {
                    propName:'OtherSource',
                    setPropName:'os'
                },
                {
                    propName:'AllSoucesData',
                    setPropName:'asd'
                },
                {
                    propName:'VerifyCallback',
                    setPropName:'vcurl'
                },
                {
                    propName:'VerifyUrl',
                    setPropName:'vurl'
                }



            ];
          //  this.loader=loader;
            var mThis=this;
            loader.forEach(function (load) {
             //   console.log(load);
                if(this.msData.hasOwnProperty(load.propName))
                {this.msPageData[load.setPropName]=this.msData[load.propName];}else {
                    if (load.hasOwnProperty('defualt')){
                        this.msPageData[load.setPropName]=load.defualt;}
                    else{
                        this.msPageData[load.setPropName]=null;
                    }


                }
            },this);
            //for (load ,key in loader)

         //   if(this.msData.hasOwnProperty('ClientIcon'))this.msPageData.cIcon=this.msData.ClientIcon;
        },
        mounted() {

            this.msLoginAs=this.msData.AllSoucesData;
            this.msLoginAs.shift();
            },
        methods:    {

            resetForm(){
                this.msInputData['passwordForLogin']='';
            },
            sendDataToLoginData(data=null){
            //  console.log(data.hasOwnProperty('route'));

                this.checkForm();

                if(this.formIsValid){
                    if (data==null){
                        var count=0;
                        for (var i in this.msPageData.fData.actionButton){
                            if(count==0)data=this.msPageData.fData.actionButton[i];
                        }

                    }

                    var link = (data.hasOwnProperty('route')) ? data.route : "";
                    if (link != ""){
                        // console.log(window.axios);
                        var t=this;
                        t.waitingForData=true;
                        t.msErrorData=[];
                        t.msError=(t.msError) ? false : false;
                        window.axios.post(link,t.msInputData)
                            .then(function (response) {
                                t.msError=false;
                                t.waitingForData=false;
                                t.successLogin=true;
                                t.msPostResponseData=response.data.msData;
                            })
                            .catch(function (error) {
                                t.msError=true;
                                t.waitingForData=false;
                                //t.msErrorData=;

                                t.setMSErrorData(error.response.data.errors);
                                //console.log();
                            });
                    }
                }

              //if()var link = data.route
            },
            setMSErrorData(data){

                var t =this;
                t.resetForm();
                Object.keys(data).forEach(function(key,index) {

                    console.log(data[key]);
                    // key: the name of the object key
                    // index: the ordinal position of the key within the object
                    t.msErrorData.push(data[key]);
                });
                //this.msErrorData=data;
            },
            checkForm(){
                for (var i in this.msPageData.fData.formData){
                    for(var i2 in this.msPageData.fData.formData[i]['inputs']){
                        var inputName=this.msPageData.fData.formData[i]['inputs'][i2]['name'];
                        var type=this.msPageData.fData.formData[i]['inputs'][i2]['type'];

                        this.formIsValid= (typeof msValidate.single(this.msInputData[inputName], {presence: true, length:{minimum:(type=='text')?5:6}})=='undefined')?true :false ;
                    }
                }
            }
        },
        watch:{
            msInputData(){
                this.checkForm();

            }
        }


    }
</script>

<style scoped>

</style>

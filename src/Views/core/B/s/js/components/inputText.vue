<template>
    <div >



        <div v-if="true">
            <section v-if="(inputType != 'locked')&&(inputType != 'radio')&&(inputType != 'checkbox')&&(inputType != 'option')&&(inputType != 'multioption')&&(inputType != 'file')&&(inputType != 'multifile')"  v-for="(input,key) in finalInput" :title="inputInfo">
                <div  class="row align-items-center form-group" >


                    <label class="col" :class="{
                    'ms-error':(msValid == 'is-invalid')
                    }">
                        <span class="row" >
                        <span class="col col-8">{{ forNice(inputVname) }}</span>
                        <span class="col col" ><span v-if="inputRequired" class=" text-danger fa fa-asterisk ms-spin"></span> </span>
                </span>
                    </label>

                    <div class="col col-8" style="margin-top: -7px;">

                        <div class="input-group" data-toggle="tooltip" data-placement="left">

                            <div v-if="input.inputPrefix" class="input-group-prepend">
                                <i :class="'fa fa-'+input.inputPrefix+ ' input-group-text' " ></i>
                            </div>

                            <input  :type="inputType" :list="inputName" :name="inputName"  :class="'form-control '+msValid" v-model="msValue" :aria-describedby="inputName" :placeholder="'Enter '+forNice(inputVname)+' here'">


                            <datalist :id="inputName" class="col-lg-12" v-if="(inputType != 'radio') && (inputType != 'checkbox') && (inputType != 'textarea')">
                                <option v-for ="autofiled in inputAuto" :value="autofiled[dValue]" > {{forNice(autofiled[dText])}} </option>

                            </datalist>

                            <div v-if="inputPerfix" class="input-group-append ">

                                <i :class="'fa fa-'+inputPerfix+ ' input-group-text' " >
                                    <span v-if="inputRequired" class=" text-danger fa fa-asterisk ms-spin"></span>
                                </i>
                            </div>

                        </div>
                    </div>

                </div>
            </section>






            <div  class="row form-group"  v-if="(inputType == 'radio')" :title="inputInfo">


                    <label class="col col " :class="{
                    'ms-error':(msValid == 'is-invalid')
                    }">
<span class="row" >
                        <span class="col col-8">{{ forNice(inputVname) }}</span>
                        <span class="col col" ><span v-if="inputRequired" class=" text-danger fa fa-asterisk ms-spin"></span> </span>
</span>
                        </label><br>

                    <div class="col col-8">
                        <div class="form-check-inline "  v-for ="(autofiled,index) in inputAuto" >
                            <input class="form-check-input" :name="inputName"  v-model="msValue"  :type="inputType" :value="autofiled[dValue]" :id="inputName+index"  >
                            <label class="form-check-label" :for="inputName+index" >
                                {{forNice(autofiled[dText])}}
                            </label>

                        </div>
                    </div>


            </div>

            <div  class="row form-group"  v-if="(inputType == 'checkbox')" :title="inputInfo">

                    <label class="col" :class="{
                    'ms-error':(msValid == 'is-invalid')
                    }"> <span class="row" >
                        <span class="col col-8">{{ forNice(inputVname) }}</span>
                        <span class="col col" ><span v-if="inputRequired" class=" text-danger fa fa-asterisk ms-spin"></span> </span>
</span></label>
                    <div class="col col-8 ">
                        <div class="form-check-inline"  v-for ="(autofiled,index) in inputAuto"  >
                            <input class="form-check-input"  v-model="msValue[index]" :name="inputName+'['+index+']'"  :type="inputType" :value="autofiled[dValue]" :id="inputName+index">
                            <label class="form-check-label" :for="inputName+index">
                                {{forNice(autofiled[dText])}}
                            </label>
                    </div>


                </div>


            </div>


            <div  class="form-group"  v-if="(inputType == 'locked') || (inputType == 'auto')" style="margin-left: 0px;cursor: help" :title="inputInfo" >
              <div class="row">

                  <label class="col" >{{ forNice(inputVname) }} </label>
                  <div class="col col-8">
                      <div class="form-control text-info text-muted disabled" >
                          {{forNice(dValue)}}

                      </div>
                  </div>


              </div>

                <input  type="hidden" v-model="dValue" :name="inputName">
            </div>


            <div  class="form-group"  v-if="(inputType == 'option') || (inputType == 'multioption')">


                <div class="input-group mb-3" >
                    <div class="input-group-prepend">
                        <label class="input-group-text" :for="inputName" :class="{
                    'ms-error':(msValid == 'is-invalid')
                    }">

                            <span class="row" >
                        <span class="col col-8">{{ forNice(inputVname) }}</span>
                        <span class="col col" ><span v-if="inputRequired" class=" text-danger fa fa-asterisk ms-spin"></span> </span>
</span>
                        </label>
                    </div>


                    <select class="custom-select margin-fix"  v-model="msValue"  :name="inputName" :id="inputName" v-if="inputType=='option'">
                        <option selected disabled>Choose one...</option>
                        <option v-for ="(autofiled,index) in inputAuto" :value="autofiled[dValue]" > {{ forNice (autofiled[dText])}}</option>
                    </select>

                    <select class="custom-select"   v-model="msValue" :name="inputName+'[]'" :id="inputName" v-if=" inputType=='multioption'" multiple >
                        <option  disabled>You can multiple option by pressing 'ctrl'...</option>
                        <option v-for ="(autofiled,index) in inputAuto" :value="autofiled[dValue]" > {{forNice(autofiled[dText])}}</option>
                    </select>

                </div>



            </div>



            <div  class="form-group"  v-if="(inputType == 'file') ||  (inputType == 'multifile')">
                <section class="row" v-for="(input,key) in finalInput" >

                    <label class="col " v-if="!input.baseValue.inputOnly" :for="inputName" :class="{
                    'ms-error':(msValid == 'is-invalid')
                    }">
                    <span class="row" >
                        <span class="col col-8">{{ forNice(input.baseValue.inputVname) }}</span>
                        <span class="col col" ><span v-if="inputRequired" class=" text-danger fa fa-asterisk ms-spin"></span> </span>
</span>

                    </label>

                    <div class="col col-8">
                    <div class="input-group" data-toggle="tooltip" data-placement="left">

                        <div v-if="input.inputPrefix" class="input-group-prepend">
                            <i :class="'fa fa-'+input.inputPrefix+ ' input-group-text' " ></i>
                        </div>

                        <input v-if="inputType == 'file'" :type="inputType"  :name="inputName"  :class="'form-control '+msValid"  @change="loadFilestoLocal" :aria-describedby="inputName" >
                        <input multiple v-if="inputType == 'multifile'"  type="file"  :name="inputName"  :class="'form-control '+msValid"  @change="loadFilestoLocal" :aria-describedby="inputName" >


                        <div v-if="inputPerfix" class="input-group-append ">
                            <i :class="'fa fa-'+inputPerfix+ ' input-group-text' " ></i>
                        </div>

                    </div>
                    </div>

                </section>
            </div>



            <small v-if="msValid == 'is-invalid'" class="form-text text-muted text-center" :id="inputName +'_error'" >

                <div v-for="item in inputError" class="alert alert-danger" role="alert" style="font-size: smaller;
    padding: 5px;">
                    {{ item }}
                </div>

            </small>

        </div>
    </div>


</template>

<script>
    import  MS  from '../MS';
    import  MDD from 'mobile-device-detect';
    //console.log(MS);
    export default {

        name: 'inputtext',
        mixins: [MS,MDD],
        props:{
            'msData':{
                type: Object,
                required: true
            },
            'msGroupIndex':{
                type: Number,
                required: true
            }
        },

        mounted() {

            // console.log(this.msData);

            if(this.msData.hasOwnProperty('groupInput'))this.groupInput=this.msData.groupInput;
            if(this.msData.hasOwnProperty('name'))
            {
                if(this.msData.hasOwnProperty('inputMultiple')){
                    this.inputName=this.msData.name+"["+this.msGroupIndex+"]";
                }else{
                    this.inputName=this.msData.name;
                }

            }

            if(this.msData.hasOwnProperty('inputInfo'))this.inputInfo=this.msData.inputInfo;
            if(this.msData.hasOwnProperty('vName'))this.inputVname=this.msData.vName;
            // if(!this.msData.hasOwnProperty('vName'))this.inputVname=this.msData.name;
            if(this.msData.hasOwnProperty('prefix'))this.inputPrefix=this.msData.prefix;
            if(this.msData.hasOwnProperty('perfix'))this.inputPerfix=this.msData.perfix;
            if(this.msData.hasOwnProperty('inputOnly'))this.inputOnly=this.msData.inputOnly;
            if(this.msData.hasOwnProperty('type'))this.inputType=this.msData.type;
            if(this.msData.hasOwnProperty('required'))this.inputRequired=this.msData.required;
            if(this.msData.hasOwnProperty('verifyBy'))
            {

                if(this.msData.verifyBy.hasOwnProperty('msdata'))this.inputAuto=this.msData.verifyBy.msdata;
                if(this.msData.verifyBy.hasOwnProperty('value'))this.dValue=this.msData.verifyBy.value;
                if(this.msData.verifyBy.hasOwnProperty('text'))this.dText=this.msData.verifyBy.text;



            }

            if(this.msData.hasOwnProperty('value'))this.dValue=this.msData.value;
            if(this.msData.hasOwnProperty('inputMultiple'))this.inputMultiple=this.msData.inputMultiple;

            if(this.msData.hasOwnProperty('validation'))
            {
                var str=this.msData.validation;
                this.inputValidation=this.msData.validation;
                if(this.msData.validation.hasOwnProperty('required'))this.inputRequired=this.msData.validation.required;
            }



            switch (this.inputType) {
                case "locked":
                    this.msValue=this.dValue;
                    break;

                case"auto":
                    this.msValue=this.dValue;
                    break;

                case "checkbox":
                    this.msValue={};
                    break;
                case "radio":
                    this.msValid="is-valid";

                    break;


            }

            //   var finalArray= this.makeArrayForInput(this);

            this.setFinalInput(this.makeArrayForInput(this));

            if(!this.$root.checkGroupExist(this.groupInput)){
                this.$root.setUpGroup(this.groupInput);
            }
            // if((this.inputType == "locked")|| (this.inputType == "auto") ){
            //     this.msValue=this.dValue;
            //     //this.$parent.setInputData(this.inputName,this.dValue);
            // }
            this.$parent.setInputData(this.inputName,this.msValue);




            // console.log( this.inputValidation);
        },
        methods:{

            setError:function () {
                this.msValid="is-invalid";

            },
            setErrorZero:function(){
                this.msValid="is-valid";
                this.inputError=new Object();
            },
            getValue:function () {
                var returnF=this.msValue;
                return returnF;
            },
            removeinput(count){

                delete this.finalInput.splice(count, 1);
                //  this.finalInput.push(this.makeArrayForInput(this));
                inputCount--;
            },
            addinput(){
                this.finalInput.push(this.makeArrayForInput(this));
                inputCount++
            },
            setFinalInput(array){
                this.finalInput=[array];
                //   console.log(this.finalInput);
            },

            isM(){
                console.log(this.isMobile());
                return this.isMobile();
            },
            loadFilestoLocal(event){
                this.$parent.setInputData(this.inputName,{});
                for (var i = 0; i < event.target.files.length; i++) {
                    this.$parent.setInputData(this.inputName,event.target.files[i],i);
                }

                //    console.log(this.$parent.msFormDataFinal);

            }


        },
        data: function () {
            return {
                msValid: 0,
                msValue:'',
                msMinCharValidation:0,
                inputValidation:[],
                inputAuto:[],
                inputError:new Object(),
                inputName:'',
                inputVname:'',
                inputPrefix:'',
                inputPerfix:'',
                inputOnly:false,
                inputType:'text',
                inputRequired:false,
                dValue:'',
                dText:'',
                finalInput:new Object({}),
                inputMultiple:false,
                inputCount:0,
                groupInput:[],
                inputInfo:"",
            }
        }
        ,
        computed: {


        },
        watch: {
            msValue: function(val, oldVal) {

                if(this.inputRequired){

                    var error=0;

                    var inputLen=1;
                    if(this.inputValidation.hasOwnProperty("minSize")){
                        inputLen=this.inputValidation.minSize;
                    }


                    switch (this.inputType) {
                        case 'password':
                            inputLen=8;
                            if (this.validatePassword(val,inputLen)){

                                if(this.inputError.hasOwnProperty('passwordNotStrong'))
                                    delete this.inputError.passwordNotStrong;
                                if(error)error=0;

                            }else{

                                error=1;
                                if(!this.inputError.hasOwnProperty('string'))
                                    this.inputError.passwordNotStrong="Password Must have a lowercase, upercase, number, symbol & "+inputLen+" char. required";
                            }

                            break;
                    }





                    if(this.validateLen(val,inputLen)){
                        delete this.inputError.MinLen;
                        if(error)error=0;
                    }else {
                        error=1;
                        this.inputError.MinLen="Min. "+inputLen+" char. required";
                    }


                    if (!error) {
                        //this.$parent.msFormDataValue[];
                        this.msValid="is-valid";
                    }else{

                        this.msValid="is-invalid";
                    }

                }else {
                    this.msValid=" ";
                }
                console.log(val);
                this.$parent.setInputData(this.inputName,val);

            }
        }
    }
</script>

<style>
    .margin-fix{



    }
    .custom-select{
        border-radius: 0px;

        min-height: 42px;
    }
    .input-group,.form-group{
        border-radius: 0px;
    }
    .input-group-prepend{
        border-radius: 0px;
    }
    .form-check-inline,.form-check-label,.form-check-input  {
        cursor: pointer;
    }
    .form-check-inline
    {
        border:1px solid rgba(23,162,184,0.5);
        padding-left:5px;

        min-height: 35px;
        box-shadow: rgba(23, 162, 184, 0.2) -3px 3px 1px;
        cursor: pointer;


    }

    .form-check-inline > div{
        padding: 5px;
    }



    .form-check-inline >  label{
        padding-left:5px ;
        padding-right:5px ;
        min-height: 35px;
        padding:5px;

    }

    input:checked + label  {
        color:white;
        background-color:  rgba(23,162,184,1);
        box-shadow: -22px 0px 0px rgba(23,162,184,1);
        transition: all 500ms ease-in-out ;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none;
        padding-top:5px ;
        padding-bottom:5px ;



    }

    .form-group{

        padding-left: 15px ;

        margin-bottom: 15px;

    }

    .form-group > label,.form-group>div > label  , .form-group>section> label{
        padding:5px 5px 5px 5px;

        border-top:1px solid rgba(35,37,38,0.2) ;
        border-bottom:1px solid rgba(35,37,38,0.2) ;
        border-left:2px outset rgba(35,37,38,0.1) ;
        border-right:2px solid rgba(35,37,38,0.1) ;
        box-shadow: 3px 3px 1px rgba(35,37,38,0.2);
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none;



    }

    .form-control{
        border-radius:0px;
    }



</style>

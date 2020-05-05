<template>
    <div >



        <div  class=" p-2" >





            <div v-if="inputType == 'locked'" class="flex flex-wrap" :class="msValid">
                <span v-if="!inputOnly" class=" select-none lg:mr-2" >{{inputVname}}</span>
                <i class="fas p2 ml-2 mt-1 fa-qrcode mr-2"></i><input :type="inputType" disabled autocomplete="off" class="text-center border focus:outline-none focus:shadow-outline lg:flex-1" :class="{'w-full':onMobile}" :name="inputName"  v-model="msValue" :id="msData.msGroupIndex">
            </div>

            <div  v-if="inputType == 'text'"  class="flex flex-wrap" :class="msValid">
            <span v-if="!inputOnly" class=" select-none lg:mr-2" >{{inputVname}}</span>
            <input @focus="msFocus = true"  :index="msInputIndex"  :placeholder="'Enter '+inputVname+' here'" :type="inputType"  autocomplete="off" class=" border focus:outline-none focus:shadow-outline lg:flex-1" :class="{'w-full':onMobile}" :name="inputName"  v-model="msValue" :id="msData.msGroupIndex">
            </div >

            <div v-else-if="inputType == 'password'" class="select-none flex flex-wrap" :class="msValid">

                <span v-if="!inputOnly" class=" select-none lg:flex-1" :class="{'w-full':!onMobile}">{{inputVname}}</span>
                <input :index="msInputIndex"  :placeholder="'Enter '+inputVname+' here'" :type="inputType" autocomplete="off"  class="msPasswordInput focus:outline-none focus:shadow-outline lg:flex-1 "  :class="{'w-9/12':onMobile}" :name="inputName"  v-model="msValue" :id="msData.msGroupIndex">

                <div class="msPasswordVisible" :class="{'w-3/12':onMobile}" v-on:click="visiblePassowrd"

              >
              <i :class="{
                'far fa-eye':inputPasswordVisible,
                'far fa-eye-slash':!inputPasswordVisible,
                'object-center':true,
                }"></i>

                  <div v-if="inputPasswordVisible" :class="{
                'inline-block':true,

                }">

                  </div>
              </div>


                <span v-if="inputPasswordVisible" class="w-full bg-info-100 mt-21 border text-bold">{{msValue}}</span>


              </div>

            <div v-else-if="inputType == 'email'" class="flex flex-wrap" :class="msValid">
                <span v-if="!inputOnly" class=" select-none lg:mr-2" >{{inputVname}}</span>
                <input :index="msInputIndex" :placeholder="'Enter '+inputVname+' here'" :type="inputType" style="min-width: 60%;" autocomplete="off" class="border focus:outline-none focus:shadow-outline lg:flex-1"  :class="{'w-full':onMobile}"  :name="inputName"  v-model="msValue" :id="msData.msGroupIndex">
            </div>

            <div v-else-if="inputType == 'number'" class="flex flex-wrap" :class="msValid">
                <span v-if="!inputOnly" class=" select-none lg:mr-2" >{{inputVname}}</span>
                <input :index="msInputIndex" :type="inputType" style="min-width: 50%;" autocomplete="off" class="border focus:outline-none focus:shadow-outline lg:flex-1"  :class="{'w-full':onMobile}"  :name="inputName"  v-model="msValue" :id="msData.msGroupIndex">
            </div>


            <div  v-if="inputType == 'file'" class="flex flex-wrap" :class="msValid"  >
                <span v-if="!inputOnly" class=" select-none  lg:mr-2">{{inputVname}}</span>
                <input :index="msInputIndex" :type="inputType"  class="text-center border focus:outline-none focus:shadow-outline lg:flex-1 " :class="{'w-full':onMobile}" :name="inputName"  v-on:change="loadFilestoLocal($event)"  :id="msData.msGroupIndex">
            </div>

            <div v-if="inputType == 'radio'" class="flex flex-wrap" :class="msValid">
                <span v-if="!inputOnly" class=" select-none" :class="{'w-4/12 mr-2':!onMobile,'w-full':onMobile}">{{inputVname}}</span>

                <div :class="{
                'select-none flex-1 border-l p-1 mr-1 border-b':true,
                'bg-blue-200 shadow':msValue==radio[msData.verifyBy.value],

                }"  v-for="(radio,key) in msData.verifyBy.msdata" v-on:click="customSetValue(radio[msData.verifyBy.value])">
                    <i class="far" :class="{
                    'fa-check-circle text-green-500':msValue==radio[msData.verifyBy.value],
                    'fa-circle text-blue-500':msValue!=radio[msData.verifyBy.value],
                     }"></i>  {{ forNice(radio[msData.verifyBy.text]) }}
                </div>



            </div>

            <div v-if="inputType == 'checkbox'" class="flex flex-wrap" :class="msValid">
                <span v-if="!inputOnly" class=" select-none" :class="{'w-4/12 mr-2':!onMobile,'w-full':onMobile}">{{inputVname}}</span>

                <div :class="{
                'select-none flex-1 border-l p-1 mr-1 border-b':true,
                'bg-blue-200 shadow':in_array( radio[msData.verifyBy.value], inputChecked),

                }"  v-for="(radio,key) in msData.verifyBy.msdata" v-on:click="customSetValue(radio[msData.verifyBy.value])">
                    <i class="far" :class="{
                    'fa-check-square text-green-500': in_array( radio[msData.verifyBy.value], inputChecked),
                    'fa-square text-blue-500':!in_array( radio[msData.verifyBy.value], inputChecked),
                     }"></i>  {{ forNice(radio[msData.verifyBy.text]) }}
                </div>



            </div>



            <div v-if="inputType == 'date'" class="flex flex-wrap" :class="msValid"  >
                <span v-if="!inputOnly" class=" select-none lg:mr-2" >{{inputVname}}</span>
                <input :index="msInputIndex" :type="inputType"  class="text-center border focus:outline-none focus:shadow-outline lg:flex-1" :class="{'w-full':onMobile}" :name="inputName"  v-model="msValue" :id="msData.msGroupIndex">
            </div>

            <div v-if="inputType == 'time'" class="flex flex-wrap" :class="msValid"  >
                <span v-if="!inputOnly" class=" select-none lg:mr-2" >{{inputVname}}</span>
                <input :index="msInputIndex" :type="inputType"  class="text-center border focus:outline-none focus:shadow-outline lg:flex-1" :class="{'w-full':onMobile}" :name="inputName"  v-model="msValue" :id="msData.msGroupIndex">
            </div>

            <div v-if="inputType == 'textarea'" class="flex flex-wrap" :class="msValid"  >
                <span v-if="!inputOnly" class=" select-none lg:mr-2" >{{inputVname}}</span>
                <textarea :index="msInputIndex" :type="inputType"  class="border focus:outline-none focus:shadow-outline lg:flex-1" :class="{'w-full':onMobile}"  :name="inputName"  v-model="msValue" :id="msData.msGroupIndex"> </textarea>
            </div>

            <div v-if="inputType == 'option'" class="flex flex-wrap" :class="msValid">

                <span v-if="!inputOnly" class=" select-none" :class="{'w-4/12 mr-2':!onMobile,'w-full':onMobile}">{{inputVname}}  <i class="" v-if="(msValue!=null ) && ((msValue.search('msicon-') != '-1') || (msValue.search('flaticon-') != '-1') )" :class='msValue'></i></span>

                <select :name="inputName" class="border focus:outline-none focus:shadow-outline lg:flex-1" :class="{'w-full':onMobile}" size="1" v-model="msValue" >
                    <option v-for="(radio,key) in msData.verifyBy.msdata" v-bind:value="radio[msData.verifyBy.value]" >

                        {{ forNice(radio[msData.verifyBy.text]) }}</option>
                </select>


            </div>




            <div  v-if="msValid == 'is-invalid'" class="flex flex-wrap"  >

                <small class="text-left bg-red-200 w-full" >

                    <div v-for="item in inputError" class="" role="alert" style="font-size: smaller;
    padding: 5px;">
                        {{ item }}
                    </div>

                </small>

            </div>



        </div>

    <div v-if="hasAutofield() " class="flex">

        <div  class="w-full block ms-text-auto">

            <div :class="{
    'bg-blue-300': autofiled[msData.verifyBy.value]==msValue,
    }"
                 v-for ="autofiled in inputAuto"  class="bg-gray-200 p-1 bprder m-1" v-on:click="setFinalInputFromAuto(autofiled[dValue])">
                {{autofiled[dText]}}
            </div>
        </div>


    </div>
















    </div>


</template>

<script>
    import MS from './MS';
    // import  MDD from 'mobile-device-detect';
    // //console.log(MS);
    export default {

        name: 'msinput',
        mixins: [MS],
        props:{
            'msData':{
                type: Object,
                required: true
            },
            'msGroupIndex':{
                type: Number,
                required: true
            },
            'msInputIndex':{
                type: Number,
                required: true
            },
            'msMultiIndex':{
                type: Number,
                required: false,
                default:1
            }




        },

        beforeMount() {

            // console.log(this.msData);
            if(this.hasOwnProperty('msMultiIndex'))this.inputMultipleIndex=this.msMultiIndex;
            if(this.msData.hasOwnProperty('groupInput'))this.groupInput=this.msData.groupInput;
            if(this.msData.hasOwnProperty('name'))
            {
                if(this.msData.hasOwnProperty('inputMultiple')){
                    this.inputName=this.msData.name;
                    //this.inputName=this.msData.name+"["+this.msGroupIndex+"]";
                }else{
                    this.inputName=this.msData.name;
                }

            }


            if(this.msData.hasOwnProperty('msMultiIndex'))this.inputMultipleIndex=this.msData.msMultiIndex;
            if(this.msData.hasOwnProperty('inputMultiple'))this.inputMultiple=this.msData.inputMultiple;
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

            //    if(this.msData.verifyBy.hasOwnProperty('value'))this.dValue=this.msData.verifyBy.value;
                if(this.msData.verifyBy.hasOwnProperty('text'))this.dText=this.msData.verifyBy.text;


                if(this.msData.verifyBy.hasOwnProperty('value'))this.dValue=this.msData.verifyBy.value;

            }

            if(this.msData.hasOwnProperty('value')){
                this.dValue=this.msData.value;
            }


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

                default:
                    if(this.hasOwnProperty('dValue') && !this.inputMultiple)this.msValue=this.dValue;
                    break;



            }

            //   var finalArray= this.makeArrayForInput(this);

            this.setFinalInput(this.makeArrayForInput (this));

            // if(!this.$ref['msFrom'].checkGroupExist(this.groupInput)){
            //     this.$ref['msFrom'].setUpGroup(this.groupInput);
            // }
            // if((this.inputType == "locked")|| (this.inputType == "auto") ){
            //     this.msValue=this.dValue;
            //     //this.$parent.setInputData(this.inputName,this.dValue);
            // }
            if(this.inputType == 'date'){
                var utc =new Date().toISOString( 'en',{ timeZone: 'Asia/Kolkata'}).slice(0, 10);

                var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
                var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, 10);

        //   console.log((new Date(Date.now() - tzoffset)).getTimezoneOffset());

               this.msValue=localISOTime;
            }
        //    if(this.msData.hasOwnProperty('inputMultiple')) return this.$parent.setInputData(this.inputName,val,this.msData.inputMultiple);
            if(!this.inputMultiple){
                this.$parent.setInputData(this.inputName,this.msValue,this.inputMultiple,this.msGroupIndex);
            }

            if ( window.innerWidth < 800  )this.onMobile=true;
          //  console.log(this.inputAuto);

            // this.inputAuto.push({
            //         dText: 'hello',
            //         dValue:10,
            //     }
            // );

            // console.log( this.inputValidation);
        },
        methods:{

            setError:function () {

                this.msValid="is-invalid";

            },
            setErrorZero:function(){
                this.msValid="is-valid";
                //this.$parent.in
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
               // console.log(this.isMobile());
                return this.isMobile();
            },
            loadFilestoLocal(event){
                this.msValue=event.target.files;
                this.$parent.setInputData(this.inputName,{});

                for (var i = 0; i < event.target.files.length; i++) {
                //    console.log(event.target.files[i]);
                    this.$parent.setInputData(this.inputName,event.target.files[i]);
                }

                //    console.log(this.$parent.msFormDataFinal);

            },
            hasAutofield(event){
                if(this.inputType == "text" )
               //    console.log(this.msData);
                if(this.inputAuto.length>0 && this.msFocus)return true;
                //this.hasAutofieldBool=true;

                return false;
            },
            setFinalInputFromAuto(value){
                this.msFocus=false;
                this.msValue=value;

                this.$parent.setInputData(this.inputName,value,this.inputMultiple,this.msGroupIndex);
            },
            inpututProcess(val, oldVal){
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

                       var  str="";

                        switch (this.inputType) {
                            case 'checkbox':
                                this.inputError.MinLen="Min. "+inputLen+" Selection required";
                                break;
                            default:
                                this.inputError.MinLen="Min. "+inputLen+" char. required";
                                break ;
                        }



                    }


                    if (!error) {
                        //this.$parent.msFormDataValue[];

                        this.$parent.removeError(this.inputName);
                        this.msValid="is-valid";
                    }else{
                        this.$parent.setError(

                        {
                            inputName:this.inputName,
                                errors:this.inputError
                        }


                        );
                        this.msValid="is-invalid";
                    }

                }else {
                    this.msValid=" ";
                }
                //  console.log(val);
              //  if(this.msData.hasOwnProperty('inputMultiple')) return this.$parent.setInputData(this.inputName,val,this.msData.inputMultiple,this.msData.msGroupIndex);

                this.$parent.setInputData(this.inputName,val,this.inputMultiple,this.inputMultipleIndex);


            }
            ,visiblePassowrd(){
                if(this.inputPasswordVisible)
                {
                    this.inputPasswordVisible=false;
                //    this.inputType='password';
                }else {
                    this.inputPasswordVisible=true;
                  //  this.inputType='text';
                }


            },
            customSetValue(val){
                if(this.inputType== 'checkbox'){

                if(!this.in_array(val,this.inputChecked)){
                    this.inputChecked.push(val);


                }else {
                    this.inputChecked=this.inputChecked.filter(function(ele){
                        return ele != val;
                    });

                }
                    this.msValue=this.inputChecked;

                }else{
                    this.msValue=val;
                }


            },
            makeInputName(key){
                return this.inputVname+"["+key+"]";
            },
            getfile(){

                return  this.$refs.file.files[0];
            }

        },
        data: function () {
            return {
                msValid: 0,
                msValue:null,
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
             //   dValue:'',
          //      dText:'',
                finalInput:new Object({}),
                inputMultiple:false,
                inputCount:0,
                groupInput:[],
                inputInfo:"",
                inputPasswordVisible:false,
                onMobile:false,
                inputChecked:[]
                ,msFile:null,
                msFocus:false,
                inputMultipleIndex:this.msMultiIndex
               // hasAutofieldBool:false,,

            }
        }
        ,
        computed: {


        },
        watch: {
            msValue: function(val, oldVal) {

               this.inpututProcess(val,oldVal);


               switch (this.inputType) {
                   case 'text':
                    if(this.inputAuto.length > 0){

                        var msData1= this.inputAuto;
                        var msThis=this;
                        // console.log(
                        //
                        //     msData1.filter(function (ele) {
                        //
                        //
                        //
                        //
                        //     })
                        //
                        //
                        //

//                        );

                    }
                       break;
               }



            },
            msFile:function (val,oldVal) {
             //   console.log(val)

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


    .msPasswordVisible{
        @apply pl-2;
        @apply pr-2;
        @apply border-r;
        @apply border-t;
        @apply border-b;
        @apply bg-blue-300;
        @apply block;

        @apply text-center;


    }
    .msPasswordInput{
        @apply block;
        @apply border;
        @apply flex-wrap;

    }
    .is-invalid{
        @apply border;
        @apply border-red-600;

    }
    .is-invalid > span{
        @apply text-red-600;
        @apply font-medium;
    }

</style>

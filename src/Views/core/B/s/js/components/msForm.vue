<template>

    <div style="padding-bottom: 75px;">

        <form class="ms-form" enctype="multipart/form-data" type="post">

            <div class="card" v-for="(section,id,key) in  msFormData"  style="border-radius: 0px">
                <div class="card-header sticky-top bg-light"   data-toggle="collapse" :id="section.id" :data-target="section.id+'_target'" aria-expanded="false" :aria-controls="section.id+'_target'">
                    <h4 class="float-left">  {{section.gruoupHeading}}  </h4>

                    <div class="float-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="..." style="border-radius:0px;cursor: pointer;">
                            <div class="btn btn-outline-success " v-if="checkMutlipleFirst(section)" v-on:click.prevent="addInputGroup(id)"><i class="fa fa-times-circle " style="transform: rotate(45deg)"></i> </div>

                            <div class="btn btn-outline-info"  v-on:click.prevent="showCollapse(section.id+'_target')"><i class="fa fa-compress-arrows-alt "  ></i> </div>
                            <div class="btn btn-outline-danger" v-if="checkMutlipleSub(section)" v-on:click.prevent="removeInputGroup(id,section.rootId)"><i class="fa fa-times-circle "></i> </div>
                        </div>
                    </div>
                </div>



                <div  class="collapse card card-body" :class="{ 'show': id === 0 }" :id="section.id+'_target'" :aria-labelledby="section.id"  style="border-radius: 0px">
                    <!--<table class="table table-bordered">-->
                    <div class="row">
                    <inputtext class="col col-6" v-for="(inputRaw,id2) in section.inputs" :key="inputRaw.name.toLowerCase()" :ref="inputRaw.name.toLowerCase()" v-bind:ms-data="inputRaw"   v-bind:ms-group-index="id" ></inputtext>
                    </div>
                        <!--</table>-->
                </div>



            </div>

            <div class="card-footer text-muted bg-light" >


                <div class="btn-group btn-group-sm btn-block " role="group" aria-label="First group">


                    <button  v-for="(msBtn,index) in msActionBtn" type="button" v-bind:class="[msBtn.btnClass]" @click="getAllData(msBtn.route)">
                        {{msBtn.btnColor}}
                        <i v-if="msBtn.hasOwnProperty('btnIcon')" :class="msBtn.btnIcon"></i> {{displauActionBtnText(msBtn)}}

                    </button>



                </div>


            </div>

        </form>


        <p  v-if="false" class="text-center text-muted" translate="no" style="opacity: 0.6;pointer-events: none;" ><br><img @click.prevent="msNoClick()" @contextmenu="msNoClick()" :src="msQ.image"  style="max-height:120px"><br>{{msQ['0']}}<br><small class="text-right" translate="no">said by {{msQ['1']}}</small><br></p>
    </div>




</template>

<script>
    import MS from '../MS';
    export default {
        name: "msform",
        mixins: [MS],
        props:{
            'msData':{
                type: Object,
                required: true
            }

        },
        mounted() {
            //   console.log(this.msData);
            var d = new Date();
            var n = d.getTime();

            this.mslastActive=n;
            //console.log(this.checkLastActive());
            if(this.msData.hasOwnProperty('multipleGroup'))this.msMultiple=this.msData.multipleGroup;
            if(this.msData.hasOwnProperty('actionButton'))this.msActionBtn=this.msData.actionButton;
            if(this.msData.hasOwnProperty('q'))this.msQ=this.msData.q;

            //console.log();

            if(this.msData.hasOwnProperty('formData'))
            {
                Object.keys(this.msData.formData).forEach(function(key,index) {
                    //console.log(index);
                    var data=this.msData.formData[key];
                    data.id=key;
                    this.msFormData.push(data);
                    //   console.log(index);

                    if(this.msCount.hasOwnProperty(index)){
                        this.msCount[index]++
                    }else{
                        this.msCount[index]=1;
                    }

                },this);
            }
            // this.msFormData= this.msData.formData;

        },
        data: function () {
            return {
                msclass:"collapse card card-body",
                msMultiple:[],
                msFormData:[],
                msFormDataValue:[],
                msCount:{},
                mslastActive:0,
                msActionBtn:null,
                msFormDataFinal:{},
                msQ:{},
                msViewIcon:"fa-eye"
            }
        },
        methods:{
            msNoClick(){

            },
            showCollapse:function(id,event){
                // this.msclass +=' show';
                if(this.checkLastActive())
                    $("#"+id).collapse('toggle');
                // event.target.tagName
                //console.log(this.section.class);
            },
            checkMutlipleFirst:function (section) {
                //  console.log(section.hasOwnProperty("rootId"));
                if(section.groupDynamic)
                {

                    if(section.hasOwnProperty("rootId"))return false;
                    //  console.log(section);
                    return true;
                }

                return false;
            },
            checkMutlipleSub:function (section) {
                if(section.groupDynamic)
                {

                    if(section.hasOwnProperty("rootId"))return true;
                    //  console.log(section);
                    return false;
                }
                return false;

            }
            ,
            addInputGroup:function (id,event) {
                if(true){

                    //console.log(this.msCount.hasOwnProperty(id))
                    if(this.msCount.hasOwnProperty(id)){
                        this.msCount[id]++
                    }else{
                        this.msCount[id]=1;
                    }
                    //  console.log(this.makeArrayForInputGroup(this,id,this.msCount[id]))
                    this.msFormData.push(this.makeArrayForInputGroup(this,id,this.msFormData.length)) ;
                }

                //console.log(this.msData.formData[id]);
            },
            removeInputGroup:function (id,rootId) {
                //console.log(this.msCount.hasOwnProperty(id))
                if(this.checkLastActive()){
                    if(this.msCount.hasOwnProperty(rootId) && this.msCount[rootId] >1){
                        //    console.log(id);
                        delete this.msFormData.splice(id, 1);
                        this.msCount[rootId]--;

                    }
                }




                //console.log(this.msData.formData[id]);
            },
            checkLastActive:function(){
                var d = new Date();
                var n = d.getTime();
                //  console.log(this.get_time_diff(this.mslastActive));
                if(this.get_time_diff(this.mslastActive) > 250){
                    this.mslastActive=n
                    return true;
                }

                this.mslastActive=n
                return false
            },
            displauActionBtnText(actionBtn){
                var str="";


                //if(actionBtn.hasOwnProperty('btnColor'));
                //if(actionBtn.hasOwnProperty('route'));
                //  if(actionBtn.hasOwnProperty('btnIcon'))str=str+"<i class='"+actionBtn.btnIcon+"'></i> ";
                if(actionBtn.hasOwnProperty('btnText'))str=str+actionBtn.btnText;


                return str;

            },
            getAllData(link){


              //  console.log(link);
                var formData=new FormData();
                var signLink="http://gst.ms/MAS/core/signRequest";

                for(var propertyName in this.msFormDataFinal) {
                    //console.log(propertyName);
                    if(this.msFormDataFinal[propertyName] instanceof Object){
                        for(var file in this.msFormDataFinal[propertyName]){
                            formData.append(propertyName+"["+file+"]",this.msFormDataFinal[propertyName][file]);
                        }
                    }else{

                        formData.append(propertyName,this.msFormDataFinal[propertyName]);
                    }


                    // propertyName is what you want
                    // you can get the value like this: myObject[propertyName]
                }





                var data =  this.postLink(link,formData,this);

                //console.log(data);
                // console.log($('form'));


            }
            ,setInputData(name,value,name2="test"){
                //console.log(name2 != "");
                // console.log(name2);
                if(name2 != "test"){
                    if(!(this.msFormDataFinal[name] instanceof Object))
                    {
                        this.msFormDataFinal[name]={};

                    }

                    //  console.log("226");
                    if( this.msFormDataFinal.hasOwnProperty(name) && this.msFormDataFinal[name].hasOwnProperty(name2) ){
                        // console.log(name);
                    }else{
                        this.msFormDataFinal[name][name2]=value ;
                    }



                }else {


                    this.msFormDataFinal[name]= value;


                }
                //

                //console.log(this.msFormDataFinal[name].mslength);
            },
            viewIconTogle(){}
            ,setAllMsError(data){

                 //    console.log(data);


                this.$parent.setMsError(data,this.$refs);

            }

        }


    }
</script>

<style scoped>
    .btn{
        text-transform: capitalize;
    }

</style>

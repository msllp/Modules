<template>

    <div  class="bg-white border">
        <div v-if="msData.hasOwnProperty('formTitle')"  clasa="w-full">
            <div class="px-5 py-2 text-xl bg-blue-200 font-medium  subpixel-antialiased  select-none  cursor-not-allowed">
            <i class="fab fa-wpforms pr-2 font-black-500 hover:font-bold"></i>
                {{ msData.formTitle }}
            </div>



        </div>

    <div class="block ">

        <div v-if="compactForm" class="w-full rounded  border-t shadow-lg bg-gray-100"  v-for="(section,id,key) in  msFormData" >

            <div v-if="section.groupDynamic">
                <span v-if="msCount[id] >=1"  class="font-bold text-md border-b p-2  flex flex-wrap bg-blue-200 ">{{section.gruoupHeading}} {{msCount[id]}}</span>
                <table  >

                    <tr v-if="id < 3 ">
                        <th class="border-l  border-r border-b" v-for="input in section.inputs">{{input.vName}}</th>
                        <th class="border-l  border-r border-b">Action</th>
                    </tr>
                    <tr  class="">

                        <msinput style="display: table-cell; " :ms-multi-index="section.msMultiIndex" class="border-l  border-r border-b" v-if="!(section.hasOwnProperty('withData') && section.withData)"  :class="section.inputs[id2].inputSize" v-for="(inputRaw,id2) in section.inputs" :key="inputRaw.name.toLowerCase()" :ref="inputRaw.name.toLowerCase()" v-bind:ms-data="makeitForCompactForm(inputRaw)"   v-bind:ms-group-index="id" :ms-input-index="id2" />

                        <td class="border-l  border-r border-b">
                            <div class="flex px-3  ml-3 " v-if="section.groupDynamic ">

                                <div class="text-green-500 bg-gray-200 border hover:border-green-500 hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleFirst(section)" v-on:click.prevent="addInputGroup(id)"><i class="fa fa-times-circle " style="transform: rotate(45deg)"></i> </div>

                                <div class="text-red-500 bg-gray-200 border hover:border-red-500  hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleSub(section)" v-on:click.prevent="removeInputGroup(id,section.rootId,section.msMultiIndex)" ><i class="fa fa-times-circle "></i> </div>

                            </div>
                        </td>

                    </tr>

                </table>


            </div>

            <div v-else>
                <div class=" w-full px-3 py-2 cursor-pointer mb-2 border-b"  :class="{ 'show': id === 0 , }" :id="section.id+'_target'" :aria-labelledby="section.id" >
                    <div class="font-bold text-md border-b p-2  flex flex-wrap" :class="{'bg-blue-200 ':!checkImHiddenOrNot(section), }" >

                        <div  class="expand-btn flex" :style="{'opacity':checkImHiddenOrNot(section) }" :class="{
                        'bg-gray-200':!checkImHiddenOrNot(section),
                    'bg-gray-500':checkImHiddenOrNot(section)}"  v-on:click.prevent="showCollapse(section.id)">
                            <i :class="{
                    'fas fa-search-minus':!checkImHiddenOrNot(section),
                    'fas fa-search-plus':checkImHiddenOrNot(section)
                    }"/> </div>
                        <span class="">{{section.gruoupHeading}}</span>





                        <div class="flex px-3  ml-3 " v-if="section.groupDynamic ">

                            <div class="text-green-500 bg-gray-200 border hover:border-green-500 hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleFirst(section)" v-on:click.prevent="addInputGroup(id)"><i class="fa fa-times-circle " style="transform: rotate(45deg)"></i> </div>

                            <div class="text-red-500 bg-gray-200 border hover:border-red-500  hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleSub(section)" v-on:click.prevent="removeInputGroup(id,section.rootId,section.id)"><i class="fa fa-times-circle "></i> </div>


                        </div>


                    </div>

                    <div>



                        <div class="text-gray-700 text-base flex flex-wrap"  v-bind:class="{
                'hidden':checkImHiddenOrNot(section),
                // 'flex':onMobile,
                // 'flex':!onMobile
                }">

                            <msinput v-if="!(section.hasOwnProperty('withData') && section.withData)" class="w-1/2"  :class="section.inputs[id2].inputSize" v-for="(inputRaw,id2) in section.inputs" :key="inputRaw.name.toLowerCase()" :ref="inputRaw.name.toLowerCase()" v-bind:ms-data="inputRaw"   v-bind:ms-group-index="id" :ms-input-index="id2" >
                            </msinput>

                            <msinput v-else class="w-1/2"  :class="section.inputs[id2].inputSize" v-for="(inputRaw,id2,key) in section.inputs" :key="inputRaw.name.toLowerCase()" :ref="inputRaw.name.toLowerCase()" v-bind:ms-data="inputRaw"   v-bind:ms-group-index="id" :ms-input-index="
                       Object.keys(section.inputs[id2].inputs).find(key =>section.inputs[id2].name == id2 )
                         " >

                            </msinput>
                        </div>



                    </div>


                </div>
            </div>

        </div>
















                <div class="w-full rounded  border-t shadow-lg mb-4 bg-gray-100"  v-for="(section,id,key) in  msFormData" v-if="!(section.hasOwnProperty('withData') && section.withData) && !compactForm">

                    <div class=" w-full px-3 py-2 cursor-pointer mb-2 border-b"  :class="{ 'show': id === 0 , }" :id="section.id+'_target'" :aria-labelledby="section.id" >
                        <div class="font-bold text-md border-b p-2  flex flex-wrap" :class="{'bg-blue-200 ':!checkImHiddenOrNot(section), }" >

                            <div  class="expand-btn flex" :style="{'opacity':checkImHiddenOrNot(section) }" :class="{
                                'bg-gray-200':!checkImHiddenOrNot(section),
                            'bg-gray-500':checkImHiddenOrNot(section)}"  v-on:click.prevent="showCollapse(section.id)">
                                <i :class="{
                            'fas fa-search-minus':!checkImHiddenOrNot(section),
                            'fas fa-search-plus':checkImHiddenOrNot(section)
                            }"/> </div>
                            <span class="">{{section.gruoupHeading}}</span>





                            <div class="flex px-3  ml-3 " v-if="section.groupDynamic && false">

                                <div class="text-green-500 bg-gray-200 border hover:border-green-500 hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleFirst(section)" v-on:click.prevent="addInputGroup(id)"><i class="fa fa-times-circle " style="transform: rotate(45deg)"></i> </div>

                                <div class="text-red-500 bg-gray-200 border hover:border-red-500  hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleSub(section)" v-on:click.prevent="removeInputGroup(id,section.rootId,section.id)"><i class="fa fa-times-circle "></i> </div>


                            </div>


                        </div>

                        <div>



                            <div class="text-gray-700 text-base flex flex-wrap"  v-bind:class="{
                        'hidden':checkImHiddenOrNot(section),
                        // 'flex':onMobile,
                        // 'flex':!onMobile
                        }">

                                <msinput v-if="!(section.hasOwnProperty('withData') && section.withData)" class="w-1/2"  :class="section.inputs[id2].inputSize" v-for="(inputRaw,id2) in section.inputs" :key="inputRaw.name.toLowerCase()" :ref="inputRaw.name.toLowerCase()" v-bind:ms-data="inputRaw"   v-bind:ms-group-index="id" :ms-input-index="id2" >
                                </msinput>

                                <msinput v-else class="w-1/2"  :class="section.inputs[id2].inputSize" v-for="(inputRaw,id2,key) in section.inputs" :key="inputRaw.name.toLowerCase()" :ref="inputRaw.name.toLowerCase()" v-bind:ms-data="inputRaw"   v-bind:ms-group-index="id" :ms-input-index="
                               Object.keys(section.inputs[id2].inputs).find(key =>section.inputs[id2].name == id2 )
                                 " >

                                </msinput>
                            </div>



                        </div>


                    </div>

                </div>

                <div class="w-full rounded  border-t shadow-lg mb-4 bg-gray-100"  v-else-if="section.hasOwnProperty('withData') && section.withData">




                    <div class=" w-full px-3 py-2 cursor-pointer mb-2 border-b"  :class="{ 'show': id === 0 , }" :id="section.id+'_target'" :aria-labelledby="section.id" >
                        <div class="font-bold text-md border-b p-2  flex flex-wrap" :class="{
                        'bg-blue-200 ':!checkImHiddenOrNot(section)

                        }" >


                            <div  class="expand-btn flex"
                                  :style="{

                                  'opacity':checkImHiddenOrNot(section)
                                  }"
                                  :class="{'bg-gray-200':!checkImHiddenOrNot(section),
                            'bg-gray-500':checkImHiddenOrNot(section)}"  v-on:click.prevent="showCollapse(section.id)"><i :class="{
                            'fas fa-search-minus ':!checkImHiddenOrNot(section),
                            'fas fa-search-plus ':checkImHiddenOrNot(section)

                            }"  ></i> </div>


                            {{section.gruoupHeading}}

                            <div class="flex px-3  ml-3 " v-if="section.groupDynamic ">

                                <div class="text-green-500 bg-gray-200 border hover:border-green-500 hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleFirst(section)" v-on:click.prevent="addInputGroup(id)"><i class="fa fa-times-circle " style="transform: rotate(45deg)"></i> </div>

                                <div class="text-red-500 bg-gray-200 border hover:border-red-500  hover:shadow px-2 mx-1 hover:bg-gray-300 " v-if="checkMutlipleSub(section)" v-on:click.prevent="removeInputGroup(id,section.rootId)"><i class="fa fa-times-circle "></i> </div>


                            </div>


                        </div>

                        <div >



                            <div class="text-gray-700 text-base flex flex-wrap"  v-bind:class="{
                        'hidden':checkImHiddenOrNot(section),
                        // 'flex':onMobile,
                        // 'flex':!onMobile
                        }">

                                <div v-for="(inputRaw,id2) in section.msDyData" >

        <table class="table-auto mt-2 w-full border border-blue-300">

            <thead class="border border-blue-500  border-b-2 ">

            <tr class="ms-datatable-header-thead bg-blue-200">
                <th class="border border-blue-300 px-2 pt-2">


                    {{ section.inputs.find(key=>key.name==id2).vName }}</th>
                <th class="border border-blue-300 px-2 pt-2"> Action </th>

            </tr>
            </thead>

            <tbody v-if="false" >

            <tr v-for="(subRow,id3) in msFormDataFinal[id2]">
                <td >
                    {{
                    section.inputs.find(key=>key.name==id2).verifyBy.msdata.find(function(data) {
                    return data[section.inputs.find(key=>key.name==id2).verifyBy.value]==subRow
                    })[section.inputs.find(key=>key.name==id2).verifyBy.text]

                    }}
                </td>
                <td v-on:click.prevent="removeDataFromDynamic(id2,section.inputs.findIndex(key=>key.name==id2))">

                    <span class="text-red-500 bg-gray-200 border hover:border-red-500  hover:shadow px-2 mx-1 hover:bg-gray-300 "  ><i class="fa fa-times-circle "></i> </span>
                </td>

            </tr>


            </tbody>

        <tbody v-if="true" v-for="(subRow,id3) in inputRaw.msdata">



                                        <tr v-if="setInputDataFromDynamic(id2,section.inputs.findIndex(key=>key.name==id2), foundRow[section.inputs.find(key=>key.name==id2).verifyBy.value])" v-for="foundRow in section.inputs.find(key=>key.name==id2).verifyBy.msdata.filter(function(data) {return (data[section.inputs.find(key=>key.name==id2).verifyBy.value] ==  subRow[inputRaw.text] );})">

                                            <td >
                                     {{ foundRow[section.inputs.find(key=>key.name==id2).verifyBy.text] }}
                                            </td>
                                            <td v-on:click.prevent="removeDataFromDynamic(id2,section.inputs.findIndex(key=>key.name==id2),id)">

                                                <span class="text-red-500 bg-gray-200 border hover:border-red-500  hover:shadow px-2 mx-1 hover:bg-gray-300 "  ><i class="fa fa-times-circle "></i> </span>
                                            </td>

                                        </tr>

        </tbody>

        </table>


                                </div>

                            </div>



                        </div>


                    </div>



                </div>

                <div class="w-full rounded overflow-hidden shadow-lg">
                <div class=" px-6 py-4 border-t">
                    <div class="inline-flex w-full cursor-pointer text-center" :class="{}" >
                     <span
                         @click.prevent="formActionFromBtn(index)"
                         class="w-1/3 bg-gray-200  hover:bg-gray-400 border-t border-b  border-r px-3 py-1 text-sm font-semibold text-gray-700"

                              v-for="(msBtn,index) in msActionBtn" type="button" :class="{[msBtn.btnColor]:msBtn.hasOwnProperty('btnColor')}"

                        >
                               <i v-if="msBtn.hasOwnProperty('btnIcon')" :class="msBtn.btnIcon"></i> {{displauActionBtnText(msBtn)}}

                            </span>
                    </div>
                </div>

            </div>


            </div>



        </div>




</template>

<script>
    import MS from './MS';
   /// console.log(MS);
    export default {
        name: "msform",
        mixins: [MS],
      //  components:[msinput],
        props:{
            'msData':{
                type: Object,
                required: true
            }

        },
        mounted() {
          //  console.log(this.msData);
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
            if ( window.innerWidth < 800  )this.onMobile=true;
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
                msViewIcon:"fa-eye",
                msCurrentTab:null,
                onMobile:false,
                allErrors:[],
                CurrentDataFromServer:null,
                compactForm:true
            }
        },
        methods:{
            formShortcut(event){
                switch (event.keyCode) {
                    case '102':

                        break;
                }
                console.log(event.keyCode);
            },
            makeitForCompactForm(data){
                data.inputOnly=true;
                return data;
            },
            msNoClick(){

            },
            showCollapse(id,event){
                // this.msclass +=' show';
                if(true)
                    this.msCurrentTab=id;
               // console.log(section.id);
                    //$("#"+id).collapse('toggle');
                // event.target.tagName
                //console.log(this.section.class);
            },
            checkMutlipleFirst(section) {
                // console.log(section);
                if(section.groupDynamic)
                {

                    if(section.hasOwnProperty("rootId"))return false;
                    //  console.log(section);
                    return true;
                }

                return false;
            },
            checkMutlipleSub(section) {
                if(section.groupDynamic)
                {

                    if(section.hasOwnProperty("rootId"))return true;
                    //  console.log(section);
                    return false;
                }
                return false;

            },
            addInputGroup(id,event) {
                if(true){

                    //console.log(this.msCount.hasOwnProperty(id))
                    if(this.msCount.hasOwnProperty(id)){
                        this.msCount[id]++
                    }else{
                        this.msCount[id]=1;
                    }
                    //  console.log(this.makeArrayForInputGroup(this,id,this.msCount[id]))
                    this.msFormData.push(this.makeArrayForInputGroup(this,id,this.msFormData.length,this.msCount[id])) ;
                }

                //console.log(this.msData.formData[id]);
            },
            removeInputGroup(id,rootId,rid) {
                //console.log(this.msCount.hasOwnProperty(id))
                console.log("id: "+id+" rootId: "+rootId +" rid: "+rid);
                if(confirm('Are you sure you want to remove Input group ?')){
                    if(this.msCount.hasOwnProperty(rootId) && this.msCount[rootId] >1){


                        for ( var row in  this.msFormData[id].inputs){
                            this.removeDataFromDynamicWithGroup(rid,this.msFormData[id].inputs[row].name);
                        }

                        delete this.msFormData.splice(id, 1);

                        this.msCount[rootId]--;

                    }
                }




                //console.log(this.msData.formData[id]);
            },


            checkLastActive(){
                var d = new Date();
                var n = d.getTime();


                console.log(this.get_time_diff(this.mslastActive));

                if(this.get_time_diff(this.mslastActive) > 150){
                    this.mslastActive=n
                    return true;
                }else {
                    alert('You clicking so fast please wait for our server to respond.')
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


                return this.forNice(str);

            },
            getAllData(link){


                //  console.log(link);
                var formData=new FormData();
                var signLink="http://gst.ms/MAS/core/signRequest";

                for(var propertyName in this.msFormDataFinal) {


                    if(this.msFormDataFinal[propertyName] instanceof Object){
                        var d=this.$refs[propertyName]

                        //console.log(d.msValue);

                       for(var file in this.msFormDataFinal[propertyName]){

                            formData.append(propertyName+"["+file+"]",this.msFormDataFinal[propertyName][file]);
                           //console.log(file)
                        }
                       // formData.append(propertyName,this.msFormDataFinal[propertyName]);
                    }else{

                        formData.append(propertyName,this.msFormDataFinal[propertyName]);
                    }


                    // propertyName is what you want
                    // you can get the value like this: myObject[propertyName]
                }





                var data =  this.postLink(link,formData,this,'getData');


          //      console.log(data);




                // console.log($('form'));


            },
            getData(data){
                //console.log(data.nextData);
                window.vueApp.updateTab(data.nextData);

            },
            setInputDataFromDynamic(name,index,value){
                if(!this.msFormDataFinal.hasOwnProperty(name))this.msFormDataFinal[name]=[]
               if(!this.in_array(value,this.msFormDataFinal[name]))  this.msFormDataFinal[name].push(value);
                return true;
            },

            removeDataFromDynamicWithGroup(id,name){
             //   if(this.msFormDataFinal.hasOwnProperty(name) && this.msFormDataFinal[name].hasOwnProperty(id))console.log(id);     console.log(this.msFormDataFinal[name][id]);
                if(this.msFormDataFinal.hasOwnProperty(name) && typeof this.msFormDataFinal[name] == 'object' && this.msFormDataFinal[name].hasOwnProperty(id)){
                    console.log("found: id: "+id+" name :"+ name);
                    delete this.msFormDataFinal[name][id];
                }else {

                    console.log("Not found: id: "+id+" name :"+ name);
                    // console.log( id);
                    // console.log( this.msFormDataFinal);
                    // console.log(name);

                }

            },

            removeDataFromDynamic(name,index,section,value){
              //  console.log(this.msFormDataFinal[name].findIndex(key=>key==value));

                delete this.msFormData[section].msDyData[name].msdata.splice(    this.msFormData[section].inputs[index].verifyBy.msdata.findIndex(data=>{return true;}), 1);
               // console.log(this.msFormDataFinal[name].findIndex(key=>key==value))
               delete this.msFormDataFinal[name].splice(index, 1);
               //  delete this.msFormDataFinal[name][index];

            }
                ,setInputData(name,value,multi=false,index=0){
                //console.log(name2 != "");
               /// console.log(multi);
                console.log('Name: '+name+' value: '+value+' multi: '+multi+' index: '+index);
                if(false){
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

                    if(multi){
                       //TODO: Make array for thing
                        if( !this.msFormDataFinal.hasOwnProperty(name))this.msFormDataFinal[name]={};
                     //   delete this.msFormDataFinal[name].splice(index, 1);
                        //this.setInputDataFromDynamic(name,index,value);
                                this.msFormDataFinal[name][index]=value;

                    }else{

                        this.msFormDataFinal[name]= value;
                    }




                }
                //

                //console.log(this.msFormDataFinal[name].mslength);
            },
            viewIconTogle(){}
            ,setAllMsError(data){

                //    console.log(data);

     //           this.$emit('setMsError',data,this.$refs);

       //         this.$refs.msFrom.setMsError(data,this.$refs);

                //this.$root.setMsError(data,this.$refs);
                this.setMsError(data);

            },
            setError(data){
                this.allErrors.push(data);



            },
            setMsError:function (Data) {

                if(Data != undefined){
                    this.mserror=Data;
                    //console.log(Data);
                    if(Data.hasOwnProperty('errorsRaw')){
                        alert(Data.errorsRaw);
                    }else{
                        for (var inputName in Data){
                            var key=inputName.toString().toLowerCase();
                            //
                            //console.log(inputName);
                            if(this.$refs.hasOwnProperty(key) && this.$refs[key].hasOwnProperty(0)){

                                this.$refs[key][0].setError();
                                this.$refs[key][0].inputError=Data[inputName];
                                this.allErrors.push(
                                    {
                                        inputName:inputName,
                                        errors:Data[inputName]
                                    }


                                );
                            }
                        }
                    }


                }else{
                        alert('Opps...System had some wrong enviroment to work please reload your page. Sorry & Thank you.');
                    }





                //    this.mserror.forEach(function(value, index) {
                //        var key=value.name.toString();
                //        this.$refs[key].setError();
                //        this.$refs[key].inputError=value.msg;
                //
                // //       console.log(this.$refs[key].getValue());
                //
                //    },this)
                this.mserrorCount=true;
                //   console.log(this.mserror);

            }
            ,
            removeError(key){

               // console.log(key);
                var fkey=this.allErrors.findIndex(o => o.inputName == key);
              //  console.log(fkey);
                if(fkey != -1)this.allErrors.splice(fkey,1);



            }


            ,checkImHiddenOrNot(section){

              //  if()this.msCurrentTab=section.id;

                if(this.msCurrentTab!=null){

                     //   console.log(this.msCurrentTab==section.id);
                        if(this.msCurrentTab==section.id)return false;
                        return true;



                }
                    //&& (this.msCurrentTab != section.id))return true;
                this.msCurrentTab=section.id;
                return false;

            }
            ,formActionFromBtn(id,row){
                if(this.allErrors.length<1){
                    var row=this.msData.actionButton[id];
                    var mKey=row.msLinkKey;
                    //console.log(mKey);
                    var route=this.msData.actionButton[id].route;


                    return this.getAllData(route);

                 //   console.log(this.msData.actionButton[id].route);
                }else{
                    var route=this.msData.actionButton[id].route;
                    return this.getAllData(route);
                }

                //console.log(this.msData.actionButton[id].route);
            }

        }


    }
</script>

<style scoped>
    .btn{
        text-transform: capitalize;
    }

    .expand-btn{
        @apply block;

        @apply text-center;
        @apply inline-flex;
        @apply rounded;
        @apply pl-2 pr-2 pt-1 pb-1;
        @apply mr-2;
        @apply float-left;
        @apply inset-y-0;
        @apply inset-y-0;

    }

    .hiiden{

        transition: all 1s ease-in-out;
    }

</style>

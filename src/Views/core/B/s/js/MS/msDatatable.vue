<template>
    <div class="flex flex-wrap">

        <div class="w-full border shadow py-1 bg-white">
            <div  class="flex flex-wrap   border-blue-400 my-1  ms-datatable-header-box" >


                <div class="w-1/3 p-2 border-blue-300  border-l border-t border-b border-r ">
                    <div class="flex flex-wrap ">
                        <div class =" pr-5 w-full">Search <i class="fi flaticon-add"></i> </div>
                    <input type="text" class="w-full border focus:outline-none focus:shadow-outline shadow" v-model="msSearch">
                    <select   v-model="msSearchBy" class="w-full mt-3  border focus:outline-none focus:shadow-outline shadow">
                        <option value="ms0" disabled selected>Please Select Column to search</option>
                        <option :value="index"  v-for="column,index,key in msAllData.fromV.tableColumns"  >{{  column.vName }}</option>
                    </select>

                    </div>
                </div>


    <div class="w-1/3 border-t border-b border-blue-300 p-2">

        <div class="flex flex-wrap " v-if="msSelectedRow.length > 0">

        <span class="w-full ms-btn border-l hover:shadow">Perform</span>
        <select   v-model="msMassActionSelected" class="w-full mt-3  border focus:outline-none focus:shadow-outline shadow">
            <option value="ms0" disabled selected>Please Select Action to perform</option>
            <option :value="index"  v-for="column,index in msMassAction"  :class="column.color" > <i :class="column.icon"></i> {{  column.text }}</option>
        </select>
        <span class="w-full">on selected   <strong>{{ msSelectedRow.length }}</strong>  </span>
        </div>
        <div  v-if="msSelectedRow.length < 1">No Selection made yet</div>
    </div>



                <div class="w-1/3 border-blue-300 border p-2 ">


                        <div class="flex flex-wrap  float-right">
                            <div class ="flex text-right pr-5">Per page rows </div>
                            <select   v-model="msPerPage" class="flex-1   border focus:outline-none focus:shadow-outline shadow">

                                <option :value="column"  v-for="column,index,key in msPerPageData"  >{{  column }}</option>
                            </select>

                            <div class ="flex ">to display </div>
                        </div>


                </div>



            </div>

            <table class="table-auto mt-2 w-full ms-datatable-table-box">

                <thead class="border border-blue-500  border-b-2 ">

                <tr class="ms-datatable-header-thead">
                    <th class="ms-datatable-check-box-th" >
                        <i class="far fa-square text-blue-500 "></i>
                    </th>

                    <th v-for="column in msAllData.fromV.tableColumns" class="ms-datatable-th"> {{  column.vName }}</th>
<!--                    <th class="border bg-blue-200 ms-action-btn-th" v-if="msActionView"> Click here to hide action button</th>-->
                </tr>

                </thead>

                <tbody class=" shadow">

<tr v-for="row,index in msAllData.fromV.tableData.data" class="border bg-white" :class="{

          'bg-white':!msSelectedRow.includes(row[msRowID]),
             'bg-blue-200':msSelectedRow.includes(row[msRowID]),

}" v-on:mouseenter="msShowAction(index)" v-on:mouseleave="msHideAction(index)">

    <td class="" v-on:click="msSelecetRow(index)"  :class="{

          'ms-datatable-check-box-td':!msSelectedRow.includes(row[msRowID]),
             'ms-datatable-check-box-td-checked':msSelectedRow.includes(row[msRowID]),

}">
     <span class="far "
           :class="{
           'fa-square text-blue-500':!msSelectedRow.includes(row[msRowID]),
           'fa-check-square text-green-500':msSelectedRow.includes(row[msRowID]),
        }"

     ></span>


    </td>


    <td    v-for="column,index,key in msAllData.fromV.tableColumns"  class="border p-1 text-center cursor-wait" :title="column.vName" >

<div>

        <span v-if="(column.type =='text') || (column.type =='number') || (column.type =='email') || (column.type =='textarea') || (column.type =='password') || (column.type =='auto')  ">


                        {{ forNice(row[index]) }}

                        </span>






        <span v-if="column.type =='date' && (true)"  >
                            {{ getOutDate(row[index]) }}

                        </span>

        <span v-if="column.type =='time' && (true)"  >
                            {{ getOutTime(row[index]) }}

                        </span>


        <span v-if="column.type =='file' && (true)"  ></span>






        <span v-if="column.type =='option' && (true)" >


                        <span v-if="msData.fromV.tableFromOther.hasOwnProperty(index)" class=" select-none" >

                            <span v-if="msData.fromV.tableFromOther[index].hasOwnProperty(column.name)">SS</span>

                            {{ getVnameFromDataForOption(row[index],msData.fromV.tableFromOther[index])}}


                        </span>
        </span>



        <span v-if="column.type =='checkbox' && (true)"  ></span>
        <span v-if="column.type =='radio' && (true)"  >
                             <span v-if="msData.fromV.tableFromOther.hasOwnProperty(index)" class=" select-none" >

                            <i class="fas "
                               :class="{
                            'fa-chevron-right':!(row[index]==1||(row[index]== 0)),
                            'text-blue-500':!(row[index]==1||(row[index]== 0)),
                            'text-green-500':(row[index]==1) ||(row[index]=='1'),
                            'text-red-500':row[index]==0,
                            'fa-power-off':row[index]==1||(row[index]== 0),


                            }"
                            ></i>
                            {{ getVnameFromDataForRadio(row[index],msData.fromV.tableFromOther[index])}}

                        </span>

                        </span>

</div>


    </td>


    <td class="border p-1 text-center bg-grey-100 cursor-pointer select-none ms-action-btn-td  hover:bg-blue-200":class="{

    }" v-if="msActionViewRow.includes(index)">



        <span v-on:click="msActionClick(ac,row)" v-for="ac,index in msAction" :class="ac.color"  class="hover:border hover:shadow-inner px-2 py-1 mx-1" :title="ac.text"> <i :class="ac.icon"> </i></span>



    </td>

</tr>
</tbody>


            </table>


            <div  class="flex flex-wrap " >
                <div class="w-8/12">Showing {{ msAllData.fromV.tableData.from }} to {{ msAllData.fromV.tableData.to }} of {{msAllData.fromV.tableData.total}} total entries</div>
                <div class="w-4/12 text-right">Page: {{msAllData.fromV.tableData.current_page }} / {{ msAllData.fromV.tableData.last_page }}</div>

            </div>
            <div  class="flex flex-wrap text-center cursor-pointer shadow" >

                <div class="ms-btn  flex-1"  v-if="(msAllData.fromV.tableData.prev_page_url != null)"  :class="{
                'cursor-not-allowed':(msAllData.fromV.tableData.prev_page_url == null)}" v-on:click="getDataFromSerevr(msAllData.fromV.tableData.first_page_url)" >
                    <i class="fas fa-angle-double-left"></i> </div>

                <div class="ms-btn border-l flex-1" v-if="(msAllData.fromV.tableData.prev_page_url != null)" :class="{
                'cursor-not-allowed':(msAllData.fromV.tableData.prev_page_url == null)}" v-on:click="getDataFromSerevr(msAllData.fromV.tableData.prev_page_url)" >
                    <i class="fas fa-angle-left"></i>
                </div>

                <div class="ms-btn flex-1" :class="{

                'ms-apginate-btn-current':(msAllData.fromV.tableData.current_page == n),
                'ms-apginate-btn':(msAllData.fromV.tableData.current_page != n),
                }" v-for="n in msAllData.fromV.tableData.last_page"
                     v-on:click="getPage(n)"
                > {{ n }} </div>

                <div class="ms-btn  flex-1"  v-if="(msAllData.fromV.tableData.next_page_url != null)" :class="{
                'cursor-not-allowed':(msAllData.fromV.tableData.next_page_url == null)}" v-on:click="getDataFromSerevr(msAllData.fromV.tableData.next_page_url)" >
                    <i class="fas fa-angle-right"></i> </div>
                <div class="ms-btn  flex-1"   v-if="(msAllData.fromV.tableData.next_page_url != null)" :class="{
                'cursor-not-allowed':(msAllData.fromV.tableData.next_page_url == null)}" v-on:click="getDataFromSerevr(msAllData.fromV.tableData.last_page_url)" >
                    <i class="fas fa-angle-double-right"></i> </div>
            </div>


        </div>

    </div>

</template>

<script>
    import MS from './C/MS';

    export default {
        name: "msDatatable",
        mixins:[MS],
        props:{
            'msData':{
                type: Object,
                required: true
            }

        },
        data:function () {
            return {


                msAllData:null,
                msPath:null,
                msSearchBy:'ms0',
                msSearch:"",
                msPerPage:10,
                msPerPageData:['5','10','20','30','50','100'],
                msAction:null,
                msActionView:false,
                msActionViewRow:[],
                msMassAction:null,
                msSelectedRow:[],
                msRowID:null,
                msMassActionSelected:null,

            }
        },
    mounted() {
      //  console.log(this.msAction);
    }
        ,
        beforeMount() {
            this.msAllData=this.msData;
            this.msPath=this.msData.fromV.tableData.path;
            this.msPerPage= this.msData.fromV.tableData.per_page;
            this.msAction=this.msData.fromV.tableAction;
            this.msMassAction=this.msData.fromV.tableMassAction;
            this.msRowID=this.msData.fromV.rowId;

        //   console.log(this.msData.fromV);
          //  msSearch=this.msAllData.fromV.tableData.columns

        },

        methods:{
            setHtml(data){
             //   console.log(data);

                this.msAllData.fromV.tableData=data.fromV.tableData;
                //this.msAllData.fromV.tableColumns=this.msData.fromV.tableColumns;
                //this.msAllData.fromV.tableTitle=this.msData.fromV.tableColumns;
            },
            getDataFromSerevr(link){
                var data = this.getGetLink(link,this);

            },

            msSelecetRow(index){
              //  console.log(this.msSelectedRow.includes(this.msAllData.fromV.tableData.data[index][this.msRowID]));
                if(!this.msSelectedRow.includes(this.msAllData.fromV.tableData.data[index][this.msRowID])){
                    this.msSelectedRow.push(this.msAllData.fromV.tableData.data[index][this.msRowID]);
                }else{
                    var mthis=this;

                    this.msSelectedRow.splice( this.msSelectedRow.findIndex(function (val) {
                        return val==mthis.msAllData.fromV.tableData.data[index][mthis.msRowID]
                    }) , 1);
                }


//console.log(this.msSelectedRow);
                }



        ,

            msActionClick(ac,row){
                var mValid=1;
             //   console.log(ac);
                if(ac.hasOwnProperty('doubleConfirm') && ac.hasOwnProperty('doubleConfirmText') && ac.doubleConfirm=='true' && ac.hasOwnProperty('msLinkText') && row.hasOwnProperty(ac.msLinkText)){
                    mValid=0;
                    if (confirm(ac.doubleConfirmText+" "+row[ac.msLinkText] + " ?") ) {
                        mValid=1;
                    }
                }

                if(mValid){
                    if(ac.hasOwnProperty('msLinkKey')){
                        var newUrl=ac.url+"/"+row[ac.msLinkKey];
                        var data={
                            tabCode:'02',
                            modCode:"MAS",
                            modDView: this.forNice(ac.text+ " "+row[ac.msLinkText]),
                            modUrl:newUrl,
                            data:""

                        };

                        if(ac.hasOwnProperty('ownTab') &&  ac.ownTab == 'true'){
                            window.vueApp.updateTab(data);
                        }else{
                            window.vueApp.addNewTab(data);
                        }

                    }else{
                        var data={
                            tabCode:'01',
                            modCode:"MAS",
                            modDView: this.forNice(ac.text),
                            modUrl:ac.url,
                            data:""

                        };
                        window.vueApp.updateTab(data);
                    }

                }


      // console.log(data);


           //     window.vueApp.updateTab(data);


            },


            getPage(page){
                var data=[
                {
                    name:'page',
                    value:page
                }, {
                        name:'perpage',
                        value:this.msPerPage
                    },
                ];


                var link=this.makeLink(data);
                this.getDataFromSerevr(link)
                //console.log(link);

            },
            getSearch(str){

                var data=[
                    {
                        name:'page',
                        value:1
                    },
                    {
                        name:'q',
                        value:str
                    },
                    {
                        name:'by',
                        value:this.msSearchBy
                    },
                    {
                        name:'perpage',
                        value:this.msPerPage
                    },
                ];


                var link=this.makeLink(data);
                this.getDataFromSerevr(link);
              //  console.log(link);

            }

            ,makeLink(parameter){
                var q=[];
               //let para ;
                for(var para in parameter){
                    q.push(parameter[para].name+'='+parameter[para].value);
                }

                return this.msPath+"?"+q.join('&');
            },
            getVnameFromDataForOption(value,data){
                 //console.log(data);
                 //console.log(value);

                var outname="";

                data.msdata.filter(function(element){
                  //  console.log(data.value);
                    if(element[data.value] == value){
                        //return element[data.text];
                        outname=element[data.text];
                    }
                    return element;
                });
//console.log(outname);
                return outname;
            }
            ,
            getVnameFromDataForRadio(value,data){
               // console.log(data);
               // console.log(value);

                var outname="";

              data.msdata.filter(function(element){
                    if(element[data.value] == value){
                        //return element[data.text];
                        outname=element[data.text];
                    }
                    return element;

                });

                    return outname;
            },
            getOutDate(data){
                var d = new Date(data)
                return [d .getDate(),d .getMonth(),d.getFullYear()].join('/');
                //console.log([d .getDate(),d .getMonth(),d.getFullYear()].join('/'));

            },
            getOutTime(data){
                var d = new Date(data);

                return data;

            },
            changePerPage(val){

                var data=[
                    {
                        name:'page',
                        value:1
                    },

                    {
                        name:'perpage',
                        value:val
                    },
                ];


                var link=this.makeLink(data);
                this.getDataFromSerevr(link);
            },

            msShowAction(index){

                if ((this.msActionView !=true) ){this.msActionView=true;this.msActionViewRow.push(index); //console.log("hover in trigred");
                     }

            }
,
            msHideAction(index){
                var msIndex=index;
                if (this.msActionView !=false){
                    this.msActionView=false;
                    this.msActionViewRow.splice( this.msActionViewRow.findIndex(function (val) {
                        return val==msIndex;
                    }) , 1);
                 //   console.log("hover out trigred");
                }

            }



        },
        watch:{
            msSearch(newVal,oldVal){

                if((newVal.length > 2) && (this.msSearchBy !="ms0")){
                    this.getSearch(newVal);

                }
                if(newVal.length < 2 )this.getPage(1);
            },msPerPage(newVal,oldVal){

                this.changePerPage(newVal);

            }
        }
    }
</script>

<style scoped>

</style>

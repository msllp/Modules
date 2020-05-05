<template>
    <div  class=" ms-live-tab  "   contextmenu.prevent="rightClick($event)">
        <ul class="ms-view-tab-block">

            <li

                :class="{
                '':checkActive(index),
               'ms-tab-btn':true,
                }"

                 v-for="(tab,index) in allTab" v-on:click="tabClicked(index)">

                <a

                :class="{
                'flex-1':true,
                'ms-tab-btn-inner-active':checkActive(index),
                'ms-tab-btn-inner':!checkActive(index)
                }"
>

                    <span > {{tab.modDView}}</span>


                    <span class="fa fa-window-close p-1 block" v-on:click="deleteTab(index)"></span></a >

            </li>
            <li
                :class="{

                'ml-1 mr-1 ':true,
                'hidden':!(this.maxTabLimit > this.allTab.length)
                }"
                v-on:click="addNewTab({ tabCode:'01',
                    modCode:'New Tab',
            modDView:'New Tab',
            modUrl:'/newtab',
            data:''})"
            > <span class="fa fa-plus p-3 bg-white border-l border-r border-t mt-2"></span></li>

        </ul>

        <div >
            <div v-for="(tab,index) in allTab" >


                <div
                    :class="{
                'hidden':!checkActive(index),
                'visible ':checkActive(index),
                'ms-live-data-block':true
                }"
                   >
                    <mswindow class="ms-live-data-block" :ms-data="tab"  :index="index"  :ref= "'tab_'+index" > </mswindow>


            </div>

        </div>

    </div>
    </div>
</template>

<script>
    import  MS  from './C/MS';
    import  MDD from 'mobile-device-detect';
    export default {
        name: "msviewpanel",
        props:{
            'msData':{
                type: Object,
                required: true
            },
        },
        mixins:[MS],
        mounted(){
           if ( window.innerWidth < 800  )this.maxTabLimit=3;

            let sampleData=[
                {
                    tabCode:'01',
                    modCode:"MAS",
                    modDView:"Make image for Container",
                    modUrl:"/DCM/action/make/image",
                    data:""
                },

                ];
            this.currentTab=0;
            this.$nextTick(() => {
                this.allTab=(typeof this.msData.tab == 'undefined' || !this.msData.hasOwnProperty('tab'))?sampleData:this.msData.tab;

                for (var i in this.allTab){
                    this.addActionToTab(this.allTab[i]);
                }


            });




        },
        data:function () {
            return {
                allTab:[],
                currentTab:0,
                maxTabLimit:5


            };
        },
        methods:{


            tabClicked(index){
              //  console.log(index);
                this.currentTab=index;
            },
            checkActive(index){
                if(index==this.currentTab)return true;
                return false;
            },
            getModCoode(){
                var mObj=this.allTab[this.currentTab];

                if (mObj === undefined) {       //if t=undefined, call tt
                //    console.log(this.allTab)      //call t
                }else {
                    return mObj.modDView.toString();

                }

            },
            rightClick(event){

                // screenX/Y gives the coordinates relative to the screen in device pixels.
              //  console.log(event.screenX);
                //console.log(event.screenY);

            },
            deleteTab(index){
             //   console.log("deltetTab")
                delete this.allTab.splice(index, 1);
            },
            addNewTab(data){
                if(this.maxTabLimit > this.allTab.length){
                    data.tabCode=this.ms_rand(5,1);
                    this.allTab.push(data);
                }else{
                    alert("Opps... Max tab limit reached. Contact Million Solution to Increase it.");
                    console.log("Limit: "+this.maxTabLimit+" current lenth: "+this.allTab.length);
                }

            },
            addNewTabnUpdate(data){

                this.addNewTab(data);
                var newtab=this.allTab.length-1;
                this.currentTab=newtab-1;

                this.$nextTick(() => {
                var nextTab=this.allTab.length-1;
                var Handler=this.$refs['tab_'+ nextTab ] [0];
                Handler.updateTab(data);
                //    console.log(data);
                //normalizeArray(this.$refs.form).classList.remove("was-validated");
            },data);
            this.currentTab=newtab;
            },
            addActionToTab(data){
                this.$nextTick(() => {
                    var Handler=this.$refs['tab_'+this.currentTab][0];
                    if(this.allTab.length < 1){
                        data.tabCode=this.ms_rand(5,1);
                        data.modCode="MAS";
                        this.addNewTab(data);
                    }else{
                        this.allTab[this.currentTab].modDView=data.modDView;
                    }

                    Handler.updateTab(data);

            });

                //this.$children[this.currentTab].updateTab(data);
                //
            //    var msHandle=this.$refs[this.currentTab];
              //  var msHandle2=msHandle[0];
               // console.log(msHandle2);

             //   this.$refs[this.currentTab][0].updateTab(data);
            },
            updateTabFromOthe(data){
                this.allTab[this.currentTab].modDView=data.modDView;
            }

        },
        watch:{},

    }
</script>

<style scoped>

</style>

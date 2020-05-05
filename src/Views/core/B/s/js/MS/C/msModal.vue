<template>

    <div :class="{

    'ms-dashboard-modal':msModalOpen,
    'ms-dashboard-modal-hidden':!msModalOpen
    }"  >

        <div class="ms-dashboard-modal-overlay"></div>
        <div class="ms-dashboard-modal-container ">



            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="ms-dashboard-modal-content">
                <!--Title-->
                <div class="ms-dashboard-modal-title ">

                    <div class="ms-dashboard-modal-title-head">
                        <svg v-if="(typeof msModalIcon == 'object'  && msModalIcon.hasOwnProperty('type') && msModalIcon.type=='svg')" class="ms-dashboard-modal-title-icon">
                            <use :xlink:href="'#'+msModalIcon.icon" />
                        </svg>
                        <div class="ms-dashboard-modal-title-text">
                            {{msModalTitle}}
                        </div>
                        </div>



                    <div v-on:click="closeModal" class="ms-dashboard-modal-title-modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>
                <!--body-->

                <div class="ms-dashboard-modal-body "  >
                    <div id="msmodal"></div>
                </div>

                <!--Footer-->
                <div class="ms-dashboard-modal-footer ">
                 <button v-for="(btn,key) in msModalButton" v-on:click="performBtnAction(btn,key)" class="px-4 bg-indigo-500 cursor-pointer p-3 rounded-lg text-white hover:bg-indigo-400">
                     {{btn.text}}</button>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "msmodal",
        data(){
            return{
                msModalTitle:'modelTitle',
                msModalOpen:false,
                msModalBody:null,
                msModalButton:[
                    {
                        text:'Close',
                        actionType:'inbuilt',
                        actionMethod:'closeModal',

                    }
                ],
                msModalIcon:{}
            }
        },
        mounted() {
            var modalData={
                'url':'https://app.o3erp.ms/o3/User/profile'
            };
         //   this.getModalData(modalData);

        },
        methods:{
            getModalData(data){
            var client=msInstance;
            var th=this;
            th.msModalTitle=data.title;
            th.msModalIcon=data.titleIcon;
            client.get(data.url,[]).then(
                function (data) {

                    th.setModalBody(data.data);
                }
            ).catch(e=>console.log(e))


            },
            performBtnAction(data,key){
                switch (data.actionType) {

                    case "inbuilt":
                        console.log('inbuilt');
                        var method=data.actionMethod;
                        this[data.actionMethod](data,key);

                        break;

                }
            },
            closeModal(){
                console.log('cloase click');
                this.resetModalBody();
                this.$parent.setModalStatus(false);
                this.msModalOpen=false;
            },

            openModalFromParent(data={}){
              //  this.$parent.setModalStatus(true);
                this.msModalOpen=true;
            },
            resetModalBody(){
                this.msModalBody = new Vue({
                    name:'mslivemodal',
                    data: {
                        message: '{}'
                    },
                    el: '#msmodal',
                    template:"<div id='msmodal'></div>",
                    //     sharedState: store.state,
                    mounted() {
                        //      console.log(this.$root.$data);
                    }
                });
            },
            setModalBody(data){

                this.msModalBody = new Vue({
                    name:'mslivemodal',
                    data: {
                        message: '{}'
                    },
                    el: '#msmodal',
                    template:"<div id='msmodal'>"+ data +"</div>",
                    //     sharedState: store.state,
                    mounted() {
                        //      console.log(this.$root.$data);
                    }
                });

                Vue.compile;

            }
        }
    }
</script>

<style scoped>

</style>

<template>

    <div  class="ms-dashboard-container" :class="{
        'ms-dark-mode':this.msDarkMode
    }">



        <div class="fixed w-full ms-nav-container shadow " :class="{'ms-dashboard-modal-active':this.msModalOpen}" >
            <nav class="flex items-center justify-between flex-wrap lg:p-1  object-cover " style="min-height: 70px;">

                <div class="flex items-center flex-shrink-0 lg:hidden" >

                <div @click.prvent="hideNavOnlyForMobile($event)" class="ms-nav-btn" :class="{'ms-nav-btn-active':!msNavBar,'border':msNavBar}"  >
                                      <i class="fas fa-level-down-alt p-1" :class="{
                'ms-animation fa-rotate-90':!msNavBar,
                'ms-animation':msNavBar,

                }"></i>


                </div>

                    <div v-if="false" class="ms-nav-btn" :class="{
                        'ms-nav-btn-active':!msNavBar,'border':msNavBar
                    }"  @click.prevent="onCalac($event,67)" >

                        <i class="fi flaticon-technological p-1" :class="{
                'ms-animation fa-rotate-90':!msNavBar,

                }"></i>


                    </div>

            </div>




                <div v-on:click="hideNavBar($event)" class="flex items-center flex-shrink-0 mr-6">

                    <img src="/images/logo.png" class="fill-current h-12 mr-2 ms-company-logo " >



                </div>
                <div v-if="false" class="block lg:hidden">
                    <button v-on:click="clickToggaleButton" class="flex items-center px-3 py-2 border rounded text-black-200 text-black-200 hover:text-white hover:border-white">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                    </button>
                </div>

                <div class='ms-dashboard-right-nav-box'>
                    <div class="ms-dashboard-right-nav-btn" v-on:click="oprateNotificationBox">
                        <div class="ms-dashboard-right-nav-btn-notification">
                        <svg class="">
                        <use xlink:href="#msicon-svg-notification-read" />
                        </svg>
                        </div>
                    </div>

                    <div class="ms-dashboard-right-nav-btn " v-on:click="oprateProfileBox" >
                        <div class="ms-dashboard-right-nav-btn-profile" >

                            <span >{{msUserData.Username.charAt(0)}}</span>

                        </div>
                    </div>
                </div>

            </nav>

            <div :class="{
        'ms-dashboard-profile-box':msProfileDiv,
        'ms-dashboard-profile-box-hidden':!msProfileDiv,


        }">
                <div class="ms-dashboard-profile-body">

                    <div class="ms-dashboard-profile-user-box ">
                        <svg  class="ms-dashboard-profile-user-icon">
                            <use v-bind:xlink:href="'#msicon-svg-user-'+msUserData.sex+'-1'" />
                        </svg>

                    </div>

                    <hr class="ms-dashboard-profile-hr">
                    <div class="text-center">{{msUserData.Username}}
                    <br>{{msUserData.email}}
                    </div>
                    <hr class="ms-dashboard-profile-hr">
                    <div class="ms-dashboard-profile-footer">

                        <div class="ms-dashboard-profile-edit-btn" v-on:click="openProfile">

                        <svg  class="ms-dashboard-profile-edit-icon">
                            <use xlink:href="#msicon-svg-user-edit" />
                        </svg>
                            <span>Edit Profile</span>
                        </div>
                       <a href="/o3/User/logout">
                        <div class="ms-dashboard-profile-signout-btn">
                    <span>Log out</span>
                            <svg  class="ms-dashboard-profile-signout-icon">
                                <use xlink:href="#msicon-svg-user-signout" />
                            </svg>
                        </div>
                       </a>

                    </div>
                    <hr class="ms-dashboard-profile-hr">
                    <div class="ms-dashboard-profile-footer">
                        <span class="flex">Switch mode : </span>
                        <div class="ms-dashboard-profile-darkmode-btn " v-on:click="darkModeToggel">

                            <span>
<i class="ms-dashboard-profile-darkmode-icon fi2 flaticon-replace" :class="{
                              'flaticon-replace':msDarkMode
                          }"></i>
                                {{(msDarkMode)?'Light':'Dark'}} </span>

                        </div>
                    </div>

                </div>


            </div>




        <div :class="{
        'ms-dashboard-notification-box':msNotificationDiv,
        'ms-dashboard-notification-box-hidden':!msNotificationDiv,}">
                <div class="ms-dashboard-notification-body">

                    <div class="ms-dashboard-notification-user-box ">
                        <svg  class="ms-dashboard-notification-user-icon">
                            <use xlink:href="#msicon-svg-notification-read" />
                        </svg>

                    </div>

                    <hr class="ms-dashboard-profile-hr">

                    <table class="ms-dashboard-notification-table">
                        <tbody>
                            <tr v-for="row in msAllNotification"
                                :class="{
                                'ms-dashboard-notification-tr-read':row.NotifyRead=='1',
                                'ms-dashboard-notification-tr-unread':row.NotifyRead=='0'
                                }" v-on:click="openNotificationView(row)">

                                <td>

                                    <svg v-if="(typeof row.NotifyData == 'object' && row.NotifyData.hasOwnProperty('iconType') && row.NotifyData.iconType=='svg' )"  class="ms-dashboard-contact-list-call-btn-icon">
                                    <use xlink:href="#msicon-svg-call" />
                                    </svg>

                                    <div class="ms-dashboard-notification-tr-title">{{row.NotifyTitle}}</div>
                                    <div class="ms-dashboard-notification-tr-body">{{row.NotifyData.body}}</div>

                                </td>
                                <td>{{row.NotifyType}}</td>

                            </tr>
                        </tbody>
                    </table>



                    <table v-if="false" class="ms-dashboard-contact-list-table">
                        <tbody>
                        <tr v-for="row in allUser" class="ms-dashboard-contact-list">
                            <td>{{row.name}}</td>
                            <td>{{row.CompanyId}}</td>
                            <td class="ms-dashboard-contact-list-call-btn" v-on:click="SendCall(row)">
                                <svg  class="ms-dashboard-contact-list-call-btn-icon">
                                    <use xlink:href="#msicon-svg-call" />
                                </svg>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr class="ms-dashboard-profile-hr">
                    <table class="ms-dashboard-call-list-table">
                        <tbody>
                        <tr v-for="row in currentCall" class="ms-dashboard-call-list">
                        <td>{{row.type}}</td>
                        <td>{{row.user.name}}</td>
                        <td v-if="row.state=='live'" class="ms-dashboard-call-list-onCall-btn" >On Call </td>
                        <td v-if="row.state=='incoming'"  v-on:click="acceptCall(row)" class="ms-dashboard-call-list-accept-btn">Accept</td>
                        <td class="ms-dashboard-call-list-reject-btn" >Reject</td>
                        </tr>
                        </tbody>
                    </table>



                    <div class="text-center">{{msUserData.Username}}
                    <br>{{msUserData.email}}
                    </div>
                    <hr class="ms-dashboard-profile-hr">
                    <div class="ms-dashboard-notification-footer">

                        <div class="ms-dashboard-notification-edit-btn"  v-on:click="openvMeet">

                        <svg  class="ms-dashboard-notification-edit-icon">
                            <use xlink:href="#msicon-svg-video-calling" />
                        </svg>
                            <span>Schedule vMeet</span>
                        </div>

                        <div class="ms-dashboard-notification-signout-btn">
                    <span>Log out</span>
                            <svg  class="ms-dashboard-notification-signout-icon">
                                <use xlink:href="#msicon-svg-user-signout" />
                            </svg>
                        </div>

                    </div>

                </div>


            </div>

        </div>

        <mssidenav :class="{'ms-nav-mian-div-hidden':!msNavBar,'ms-nav-mian-div':msNavBar,'ms-dashboard-modal-active':this.msModalOpen}"  ref="msMenuSide" :ms-nav ="msNavOn"  ></mssidenav>

        <div style=""
        :class="{
        'ms-livebox ':true,
        'ms-livebox-full':!msNavOn,
        'ms-livebox-without-nav':!msNavBar,
        'ms-dashboard-modal-active':this.msModalOpen
        }"
        >
            <msviewpanel ref="ms-live-tab" :ms-data="dataFormsViewpanel" ></msviewpanel>

        </div>

        <msmodal :key="0" ref="msCurrentModal" ></msmodal>
    </div>
</template>

<script>
    import  MS  from './C/MS';
   // import msMenubar from './msMenubar';
    export default {
        name: "msdashboard", mixins: [MS],
        data() {
            return {
              //  msRoot:app,

                //msModelOpen:true,
                msNotification:false,
                msNavOn:true,
                msMenuOn:false,
                msNavBar:true,
                windowWidth:window.innerWidth,
                msMenuData:null,
                msProfileDiv:false,
                msNotificationDiv:false,
                msVideoUrl:'',
                msUserData:{
                    Username:'maxirooney',
                    sex:'male',
                    email:'user@company.com',

                },
                msId:'',
                msOtherId:'',
                msInstialer:true,
                msBackEnd:window.msBackEnd,
                liveStream:{},
                currentCall:[],
                currentStream:null,
                allUser:[],
                msModalOpen:false,
                msAllNotification:{},
                dataFormsViewpanel:{}

            }
        },
        props:{
            'msData':{
                type: Object,
                required: true
            },


        }
        ,
        methods:{

            openInTab(data){
                this.$refs['ms-live-tab'].addActionToTab(data);
            },

            openNotificationView(notify){

                var data ={
                    modCode:"Notification",
                    modIcon:{
                        type:'svg',
                        icon:'msicon-svg-video-calling'
                    },
                    modDView:notify.NotifyTitle,
                    modUrl:notify.NotifyAction.view.url
                };
                this.openInTab(data);

             //   this.openModal(data);

            },

            getNotification(){
                var th=this;
                var client=msInstance;
                var apiToken=this.msData.accessToken;
                var url=msBackEnd+'/o3/User/notification/get/'+apiToken;

                client.get(url).then(data=>th.msAllNotification=data.data.msData);



            },
            openvMeet(){
                var data ={
                 //   modCode:"Schedule vMeet",
                    modIcon:{
                        type:'svg',
                        icon:'msicon-svg-video-calling'
                    },
                    modDView:"Schedule vMeet",
                    modUrl:"/o3/User/vMeet/add/newMeet"
                };


                this.openModal(data);

            }
            ,
            setModalStatus(v){
                this.msModalOpen=v;
            },
            openModal(data={}){
                this.msModalOpen=true;
                this.$nextTick(() => {
                    this.$refs.msCurrentModal.getModalData({'titleIcon':data.modIcon,'url':data.modUrl,'title':data.modDView})
                    this.$refs.msCurrentModal.openModalFromParent() ;
                });
            },
            getModalStatus(){
                this.$nextTick(() => {
                    this.msModalOpen= this.$refs.msCurrentModal.msModalOpen ;
                });
            },
            openProfile(){
                if(this.msProfileDiv)this.msProfileDiv=false;
                var data ={
                    modCode:"USERS4O3",
                    modDView:"View Profile",
                    modUrl:"/o3/User/profile"};


                this.openModal(data);
          //      this.$refs['ms-live-tab'].addActionToTab(data);
            },
            oprateProfileBox(){

                this.msProfileDiv=(this.msProfileDiv)?false:true;
                if(this.msNotificationDiv)this.msNotificationDiv=false;
            },
            oprateNotificationBox(){
                if(this.msProfileDiv)this.msProfileDiv=false;
                this.msNotificationDiv=(this.msNotificationDiv)?false:true;
            },
            onCalac(event,kCode){
                window.vueApp.msShortCut(event,kCode);
            },
            setNavOn(show=false,event){

                //this.$children['msMenu'].hideNav();

                if(!show){
                    this.msNavOn=false;

                }else {
                    this.msNavOn=true
                }

               // console.log(event.offsetY);

            },
            clickToggaleButton(){

                if (this.msMenuOn){
                    this.msMenuOn=false;
                }else {
                    this.msMenuOn=true;
                   // this.$refs['msMenull'].fromOtherCom('hideNav',this.msMenuOn)
                   // console.log();
                }


            },
            hideNavBar($event){
                if (this.msNavBar){
                    this.msNavBar=false;
                }else {
                    this.msNavBar=true;
                }

            },
            driveRequestFromNavToLiveTab(data){

                    this.$refs['ms-live-tab'].addActionToTab(data);
            },
            getDataForSideBar(){
                var data = [
                    {
                        name:'accessToken',
                        value:this.msData.accessToken
                    },

                    {
                        name:'type',
                        value:'json'
                    },
                    {
                        name:'find',
                        value:'sidebar'
                    }

                ];
                var link = this.makeGetUrl(this.msData.path.sidebar,data);
              //  console.log(link);
               this.getGetRaw(link,this,'setMenuData');
                  // var Han=this.$refs['msMenuSide'];
              //  this.sendNavDatatoBar();
              //  console.log(this.msMenuData);
                  //  console.log(   this.sendNavDatatoBar());
                  // var root= this.$root;
             //   this.$refs['msMenull'].updateMSmenuData(this.msMenuData);

            },
            sendNavDatatoBar(){
                //return "ok"

            //    this.getDataForSideBar() ;
                return this.msMenuData;

            },
            getNavData(){

                return this.sendNavDatatoBar();
            },
            setMenuData(data){

                this.msMenuData=data;

                var Han=this.$refs['msMenuSide'];
                Han.setData(this.sendNavDatatoBar().items);
                //  console.log(this.msMenuData);
          //      console.log(   this.sendNavDatatoBar());
                //console.log( this.msMenuData);
            },
            hideNavOnlyForMobile(event){
                this.hideNavBar(event);
            },
            darkModeToggel(){
                this.$root.$data.msDarkMode=(this.$root.$data.msDarkMode)?false:true;
            },

            sendCallReqToServer(to,data){

                var th=this;
                var callFrom=this.msData.accessToken;
                var callTo=(to!=null)?to:'5kpN6wgAVlhqQkp4anBNRG5HUVBOTWRGblBRQ0dMTlhCZmxYQnVPVXVpSUp6Zk95aVRVS29PSmZwQkpGaGVibEFvdmFMVnNPeUhGbHVtQWRjbVRTYUdzdGVJVnd2YVBERkNiZXNqV0dsTUpCT2JBclV5WHV2Vk12eXlPRmluYWdCSUxVUWxIRm9IS1JVYmZ3dlZpck5ZaUZvY0ROZGlPRGpmRmJ3T2pZYm5sZ25DQXFzbk9kd3JucnBFUWZTcGZuS3A=vhV235';
                var callFromTourl=msBackEnd+'/o3/User/video/call/send/'+callFrom+'/'+callTo;
                var client=msInstance;

                var streamId=data.vCallData;
                streamId.sdp += '\n';

                client.post(callFromTourl, streamId,{crossDomain: true,})
                    .then(function (response) {
             //           console.log('trigger From Post')
                        th.callIsGoing(response.data.msData);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });


            },
            SendCallRcvToServer(to,data){

                var th=this;
                var callFrom=this.msData.accessToken;
                var callTo=(to!=null)?to:'4eH2EoNcGVZeHlOQk9uYWtVTFFUd2JtelNjUXBGRGZpb1FDYUxKQUdScWhrem5zRldmQU12d0xFR0dRTkRmbnVSZFZxandjcEhubmd3a0pDRFB5TG91dnN0SVdaRGltbWZ3c2NxUkFUSmR2ZGFyTmJMQ2FMRWRLSEtVU2RZUVNObXFtdEhzSGlCelhTVFJIdm1qYXBieG1IaXRkclJuUUFGTGhyU0lxc290VUpad29RekVnS0V1TEFBSndEUWFlSGs=u1gh4';
                var callFromTourl=msBackEnd+'/o3/User/video/call/receive/'+callFrom+'/'+callTo;
                var client=msInstance;

                client.post(callFromTourl, data,{crossDomain: true,})
                    .then(function (response) {
                        th.callIsComing(response.data.msData,true);
                      //  console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },


            SendCall(user){

                var th = this;
                var to =user.apiToken;
                navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                }).then(
                    function (stream) {
                     //   console.log('Stream start 1');
                        th.liveStream = new window.MSStream({
                            initiator: true,
                            trickle: false,
                            stream:stream,
                            config: { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }, { urls: 'turn:coturn.o3erp.in:3478' ,username: "o3erp", credential: "MSadmin!123"}] },
                           // wrtc:window.MSwrtc
                        });
                        th.liveStream.on('error', err => console.log('error', err))
                        th.liveStream.on('signal', data => {
                            data.sdp=data.sdp+"\n"
                            var data= {
                                vCallData: data
                            };
                            th.sendCallReqToServer(to,data);
                        })
                        th.liveStream.on('connect', () => {
                            console.log('CONNECT')
                        })
                        th.liveStream.on('data', data => {
                            console.log('data: ' + data)
                        })
                        th.liveStream.on('stream', stream => {
                            var video = th.$refs['other'];
                            var video2=th.$refs['own'];
                            if ('srcObject' in video && 'srcObject' in video2 ) {
                                video.srcObject = stream;
                                video2.srcObject= stream;
                            } else {
                                video.src = window.URL.createObjectURL(stream) // for older browsers
                                video2.src = window.URL.createObjectURL(stream) // for older browsers
                            }
                            video2.play();
                            video.play();
                        })

                    }
                ).catch(() => {})
            },

            acceptCall(idata){
                var th = this;
                navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                }).then(
                    function (stream) {
                 //       console.log('Stream start 2');
                 //       console.log(idata);
                        th.liveStream = new window.MSStream({
                            initiator: false,
                            trickle: false,
                            stream:stream,
                            config: { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }, { urls: 'turn:coturn.o3erp.in:3478' ,username: "o3erp", credential: "MSadmin!123"}] },
                           // wrtc:window.MSwrtc
                        });
                        th.liveStream.on('error', err => console.log('error', err))
                        th.liveStream.on('signal', data => {
                            data.sdp=data.sdp+"\n";
                            var outdata= {
                                callId:idata.callId,
                                vCallData: data
                            };
                            th.SendCallRcvToServer(idata.user.token,outdata);
                        })
                        th.liveStream.on('connect', () => {
                            console.log('CONNECT')
                        })
                        th.liveStream.on('data', data => {
                            console.log('data: ' + data)
                        })
                        th.liveStream.on('stream', stream => {
                            var video = th.$refs['other'];
                            var video2=th.$refs['own'];
                            if ('srcObject' in video && 'srcObject' in video2 ) {
                                video.srcObject = stream;
                                video2.srcObject= stream;
                            } else {
                                video.src = window.URL.createObjectURL(stream) // for older browsers
                                video2.src = window.URL.createObjectURL(stream) // for older browsers
                            }
                            video2.play();
                            video.play();
                        })
                        idata.vCallData.sdp=idata.vCallData.sdp+"\n";
                       // console.log(idata);
                        th.liveStream .signal(idata.vCallData);
                    }
                ).catch(() => {})

            },

            callIsComing(data,accepted=false){
       //
                if (accepted){
                    console.log(data);
                   for(var i in this.currentCall ){
                       if(data.state=='outgoing'){
                          if(data.callId == this.currentCall[i]['callId']){
                              this.currentCall[i]['state']='live';
                          }

                       }
                   }

                }else {
                    this.currentCall.push({callId:data.callId,type:'video',state:data.state,user:data.from,vCallData:data.vCallData});
                }

            },
            callIsGoing(data,accepted=false){

                if (accepted){

                    for(var i in this.currentCall ){
                        if(data.state=='outgoing'){
                            if(data.callId == this.currentCall[i]['callId']){
                                this.currentCall[i]['state']='live';
                                data.vCallData.sdp=data.vCallData.sdp+"\n";
                                this.liveStream.signal(data.vCallData);

                            }

                        }
                    }

                }else {
                    this.currentCall.push({callId:data.callId,type: 'video', state: data.state, user: data.to,vCallData:data.vCallData});
                }
            },

            getAllAvailableUser(){
                var apiToken=this.msData.accessToken;

                var callFromTourl=msBackEnd+'/o3/User/video/call/allowed/list/'+apiToken;
                var client=msInstance;
                var th =this;

                client.post(callFromTourl,{crossDomain: true,})
                    .then(function (response) {
                        th.allUser=response.data.msData;
                      //  console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        },


        beforeCreate(){

        },
        mounted() {
//this.openModal();
            var defaultViewPanelData={};
            this.dataFormsViewpanel=(typeof this.msData.msViewPanel =='undefined' || !this.msData.hasOwnProperty('msViewPanel'))?defaultViewPanelData:this.msData.msViewPanel;
            var channel =window.Echo.channel('o3erp');
            var th=this;
            var client=msInstance;
            this.getAllAvailableUser();
            this.getModalStatus();
            this.getNotification();
            var myNotifyChannel='.private_'+ this.msData.msUser.id;

            console.log(" Channel Name: "+myNotifyChannel)
            channel.listen(myNotifyChannel, function(data) {
            //    console.log(data);
                switch (data.type) {
                        case 'live':

                            break;
                        case 'call':
                           switch (data.state) {
                            case 'incoming':
                                if(data.hasOwnProperty('dataLink')){
                                client.post(data.dataLink).then(
                                    function (data2) {

                                        data.from= data2.data.msData.from;
                                        data.callId= data2.data.msData.callId;
                                        data.vCallData= data2.data.msData.vCallData;
                                        th.callIsComing(data);
                                    }
                                );

                                }else{
                                    th.callIsComing(data);

                                }
                                break;

                            case 'outgoing':

                                if(data.hasOwnProperty('dataLink')){
                                    client.post(data.dataLink).then(
                                        function (data2) {

                                            data.from= data2.data.msData.from;
                                            data.callId= data2.data.msData.callId;
                                            data.vCallData= data2.data.msData.vCallData;
                                            th.callIsGoing(data,true);
                                        }
                                    );

                                }else{
                                    th.callIsGoing(data,true);

                                }

                                break;
                           }

                    //    console.log("Call Request Done");
                            break;
                }
                th.msNotification=true;
                th.msNotificationDiv=true;

            });

            channel.listen('.my-live-feed', function(data) {

                data.sdp += '\n';
                th.msId=data;
                th.acceptStreamReq(data);
            });

            if(this.msData.hasOwnProperty('msUser'))this.msUserData=this.msData.msUser;

           this.getDataForSideBar();



            if(this.msNavOn && ( window.innerWidth < 800  ))this.msNavOn=false;
        },
        beforeMount(){
           // this.getDataForSideBar();
        }

        ,
        computed : {
            msDarkMode(){
                console.log(this.$root.$data.msDarkMode);
                return this.$root.$data.msDarkMode;
            }

        }
    }
</script>

<style scoped>


</style>

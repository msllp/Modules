<template>

    <div class="ms-videconf-main-div-container" >


        <div  class="ms-videconf-main-div-own">
            <div  controls v-for="(msvideo,key) in msVideoStreams1"  class="ms-videconf-main-video-box">



            <video controls :key="key" ref="msVideoStreams1" class="ms-videconf-main-video-stream"  >
                Your browser does not support the video tag.
            </video>

            <div  class="ms-videconf-main-video-tag">

                <table class="">
                    <tr class>
                        <td class="ms-videconf-main-video-name" >{{msvideo.name}}</td>
                        <td>Mute</td>

                    </tr>
                    <tr>
                        <td class="ms-videconf-main-video-watermarke" >O<sub>3</sub>ERP vMeet:</td>
                        <td  > {{vMeetingId}} </td>

                    </tr>
                </table>

            </div>

        </div>
        </div>

        <div  class="ms-videconf-main-div">
            <div  controls v-for="(msvideo,key) in msVideoStreams2"  class="ms-videconf-main-video-box">



            <video controls :key="key" ref="msVideoStreams2" class="ms-videconf-main-video-stream"  >
                Your browser does not support the video tag.
            </video>

            <div  class="ms-videconf-main-video-tag">
                <table class="">
                    <tr class>
                        <td class="ms-videconf-main-video-name" >{{msvideo.name}}</td>
                        <td>Mute</td>

                    </tr>
                    <tr>
                        <td class="ms-videconf-main-video-watermarke" >O<sub>3</sub>ERP vMeet:</td>
                        <td  > {{vMeetingId}} </td>

                    </tr>
                </table>
            </div>

        </div>
        </div>

        <div  class="ms-videconf-main-div">
            <div  controls v-for="(msvideo,key) in msVideoStreams3"  class="ms-videconf-main-video-box">



            <video controls :key="key" ref="msVideoStreams3"  class="ms-videconf-main-video-stream"  >
                Your browser does not support the video tag.
            </video>

            <div  class="ms-videconf-main-video-tag">     <table class="">
                <tr class>
                    <td class="ms-videconf-main-video-name" >{{msvideo.name}}</td>
                    <td>Mute</td>

                </tr>
                <tr>
                    <td class="ms-videconf-main-video-watermarke" >O<sub>3</sub>ERP vMeet:</td>
                    <td  > {{vMeetingId}} </td>

                </tr>
            </table></div>

        </div>
        </div>

        <div  class="ms-videconf-main-div">
            <div  controls v-for="(msvideo,key) in msVideoStreams4"  class="ms-videconf-main-video-box">



            <video controls :key="key" ref="msVideoStreams4"  class="ms-videconf-main-video-stream"  >
                Your browser does not support the video tag.
            </video>

            <div  class="ms-videconf-main-video-tag">     <table class="">
                <tr class>
                    <td class="ms-videconf-main-video-name" >{{msvideo.name}}</td>
                    <td>Mute</td>

                </tr>
                <tr>
                    <td class="ms-videconf-main-video-watermarke" >O<sub>3</sub>ERP vMeet:</td>
                    <td  > {{vMeetingId}} </td>

                </tr>
            </table></div>

        </div>
        </div>






    </div>


</template>

<script>
    export default {
        name: "msvideoconf",
        props:{
            'msUser':{
                type: Object,
                required: false,
                default(){
                       return{
                           name:'Mitul Patel',
                           id:'129031920319293',
                           apiToken:"djsjagjdghashgdhagsjdgjagshdjgashtchtahdastghdjkdyhdashdgxhagtshdjxashdkahdnhansk"
                       }

                }
            },
        },
        data(){
            return{
                vMeetingId:"isjdoiajs",
                msVideoStreams1:[],
                msVideoStreams2:[],
                msVideoStreams3:[],
                msVideoStreams4:[],

                msVideoStreamConfig:{
                    video: true,
                    audio: true
                },
                msVideoHeight:'100px',
                msVideoWidth:'100px',
                msOwnStream:null
            }
        },
        mounted() {

            var th=this;
            navigator.mediaDevices.getUserMedia(th.msVideoStreamConfig).then(stream=>{th.processStream(stream)}).catch(e=>{th.errorFound(th,e)});

        },

        methods:{
            processStream(stream){

                this.setupOwnUser(stream);
                this.$nextTick(() => {
                    this.addStreamToVideoTag(stream);
                       });

            },
            errorFound(th,error){
                console.log(error);
            },

            setupOwnUser(stream){
                var currentUser= this.msUser;
                currentUser.stream=stream;
                this.msVideoStreams1=[
                    currentUser
                ];
            },

            addStreamToVideoTag(stream,key='0',row='1'){

                //console.log(this.$refs['msVideoStreams'+row][key]);
                var videOwn=this.$refs['msVideoStreams'+row][key];

               console.log('Stream Started');

               if ('srcObject' in videOwn ) {
                    videOwn.srcObject= stream;
                } else {
                    videOwn.src = window.URL.createObjectURL(stream) // for older browsers
                }


               if(videOwn.controls)videOwn.controls= false;
               videOwn.play();
            },

            addCall(user){

            }

        }

    }
</script>

<style scoped>

</style>

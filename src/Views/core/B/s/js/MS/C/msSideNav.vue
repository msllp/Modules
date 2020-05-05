<template>

    <div class="" style=""  :class="{ 'ms-nav-div-hidden':!msNavigationOn }">


        <div class="flex flex-wrap ms-nav-div" v-if="currentMainTab">

            <div class="ms-main-title cursor-pointer" @click.prvent="hideNav($event)">

                <i class="fas fa-ellipsis-v p-1" :class="{
                'ms-animation fa-rotate-90':!msNavigationOn,

                }"></i>
                <span v-if="msNavigationOn" :class="{'ms-animation':msNavigationOn}">Navigation</span>

            </div>



            <div v-for="mainNav,index in msData" class="ms-master-title" v-on:click="setMainTab(index)">
                <div class="">

                    <i v-if="mainNav.hasOwnProperty('icon')" :class="mainNav.icon" class="p-1"></i>

                    <span v-if="msNavigationOn" :class="{'ms-animation':msNavigationOn}">{{mainNav.text}}</span>

                </div>

            </div>

        </div>

        <div class="flex-wrap ms-nav-div" v-if="!currentMainTab">
            <div class="ms-main-title cursor-pointer" v-on:click="backToMain">
                <i class="fas fa-backward p-1" ></i>
                <span v-if="msNavigationOn">back to Main Navigation</span>
            </div>

            <div v-for="mainNav,index in msData" class="" v-if="currentSubTab == index">
                <div class="flex flex-wrap ms-side-sun-div">

                    <span class="w-full ms-master-title-in-sub">
                    <i v-if="mainNav.hasOwnProperty('icon')" :class="mainNav.icon" class="p-1"></i>

                    <span v-if="msNavigationOn" >{{mainNav.text}}</span>

                    </span>
                    <div v-if="mainNav.hasOwnProperty('sub')" class="flex flex-wrap">

                   <div class="w-full"  v-for="subMainNav in mainNav.sub"   @click.prevent="openTab(subMainNav,(subMainNav.type=='link'))">

                      <div :class="{'ms-main-title-link':(subMainNav.type=='link'),'ms-main-title-sub':!(subMainNav.type=='link')}">
                          <i v-if="subMainNav.hasOwnProperty('icon')" :class="subMainNav.icon" class="p-1"></i>
                          <span v-if="msNavigationOn">{{subMainNav.text}}</span>
                      </div>

                   </div>


                    </div>

                </div>

            </div>
        </div>




    </div>



</template>

<script>
    import  MS  from './MS';
    export default {
        name: "mssidenav",
        mixins:[MS],
        props:{
//TODO: Remove this
            'msNav':{
                type: Boolean,
                required: true,
                default:true
            },
      },
        data(){
            return {
                msData:null,
                currentMainTab:true,
                currentSubTab:0,
                msNavigationOn:false,
            }
        },
        methods:{
            getData(){

             //   alert(this.msPath);
               // this.getGetRaw(this.msPath,this,'setData');
            //    console.log( this.msPath) ;
            },
            setData(data){
                this.msData=data;
              //  console.log(data);
            },
            setMainTab(index){
                this.currentMainTab=false;
                this.currentSubTab=index;
            },
            backToMain(){
                this.currentMainTab=true;
                this.currentSubTab=0;
            },
            openTab(item,proccess) {
          //      this.activeSubMenu = item.txt;
                // this.$router.push(this.getUrl(item));
                if(proccess)this.getUrlFromSideNav(item);
                //  window.bus.$emit('menu/closeMobileMenu');
            },
            getUrlFromSideNav(item) {



                var data={
                    modUrl:item.link,
                    modDView:item.text
                };
              //  data.modUrl=item.link;
               //data.modCode="MAS";
            //    data.modDView=item.text;
                this.$parent.hideNavOnlyForMobile(true);
                this.$parent.driveRequestFromNavToLiveTab(data);

                // let sectionSlug = kebabCase(item.txt);
                // return `${item.link}/${sectionSlug}`;
            },
            hideNav(event) {

                if (this.msNavigationOn) {
                    this.msNavigationOn = false;
                    //this.msContextClass = "context-menu-container-full";
                    //this.msNavClass = " ms-nav";
                } else {
                    this.msNavigationOn = true
                   // this.msNavClass = " ms-nav  ms-animation";
                    //this.msContextClass = "";
                }
                this.$parent.setNavOn(this.msNavigationOn, event);

            }

            },
        created(){
            //this.msNavigationOn =this.msNav;
        },
        mounted() {
           // msNav
            if(this.msNav && ( window.innerWidth < 800  )){this.msNavigationOn=false;}else{this.msNavigationOn=true;}

            this.getData();
        }
    }
</script>

<style scoped>



</style>

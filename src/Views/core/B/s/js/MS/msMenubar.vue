<template>



<div class="select-none">
    <ul class="fixed" :class="msNavClass">

        <li class="menu__top" @click.prvent="hideNav($event)"  :class="{
'menu__top_small':!msNavigationOn
}" >

            <a
                href="#"

                class="menu__title"
            >
                <i class="fas fa-location-arrow menu__icon" :class="{
'ms-animation fa-rotate-180':msNavigationOn,


}" aria-hidden="true"></i>
                <span v-if="msNavigationOn" :class="{'ms-animation':msNavigationOn}" >Navigation</span>
            </a>
        </li>

        <li>
            <a
                href="#"
                @click.prevent="updateMenu($event,'home')"
                :class="highlightSection('home')"
            >
                <i class="fa fa-home menu__icon" aria-hidden="true"></i>
                <span  v-if="msNavigationOn"> Home</span>
            </a>
        </li>
<li v-for="(menu,index) in menuData">

    <a
        href="#"
        @click.prevent="updateMenu($event,index)"
        :class="highlightSection(index)"
    >
        <i :class="menu[0].icon" class="menu__icon" aria-hidden="true"></i>
        <span  v-if="msNavigationOn"> {{forNice(index)}}</span>
        <i class="fa fa-chevron-right menu__arrow-icon float-right" aria-hidden="true"></i>
    </a>
</li>

    </ul>


    <ul>
        <li>
            <transition name="slide-fade">

                <div class="context-menu-container" v-show="showContextMenu" :class="{
'context-menu-container_small':!msNavigationOn

}">

                    <ul class="context-menu">

                        <li v-for="(item, index) in menuItens" :key="index" class="context-li"
                        :class="{
                           'context-li-title':item.type === 'title',
                        }"
                        >

                            <h5 v-if="item.type === 'title'" class="context-menu__title">

                                <i  v-if="item.hasOwnProperty('icon')" :class="item.icon" aria-hidden="true"></i>

                                {{forNice(item.txt)}}

                                <a
                                    v-if="index === 0"
                                    @click.prevent="closeContextMenu"
                                    class="context-menu__btn-close"
                                    href="#"
                                >
                                    <i class=" menu__arrow-icon fa fa-window-close" aria-hidden="true"></i>
                                </a>

                            </h5>

                            <h5 v-else >
                            <i style="min-width: 36px;"  v-if="item.hasOwnProperty('icon')" :class="item.icon" class="text-center menu__icon" aria-hidden="true"></i>
                            <a

                                href="#"
                                @click.prevent="openSection(item)"
                                :class="subMenuClass(item.txt)"
                            >
                                {{item.txt}}
                            </a>
                            </h5>
                        </li>

                    </ul>

                </div>

            </transition>

        </li>
    </ul>


    </div>
</template>

<script>
   // import menuData from '../components/support/menu-data';
    import kebabCase from 'lodash/kebabCase';
   import  MS  from './C/MS';


    export default {
        name: "msmenubar",
     //   name: 'msMenu',
        mixins:[MS],
        props:{
            'msNav':{
                type: Boolean,
                required: true,
                default:true
            },
            'msPath':{
                type:String,
                required: true,
                default:''
            }
        },
        data(){
            return {
                contextSection: '',
                menuItens: [],
                menuData: [],
                activeSubMenu: '',
                msNavigationOn:true,
                msNavClass:'ms-nav',
                msContextClass:'',
                msMenuData:{},
                msDPath:null
            }
        },
        methods: {
            openProjectLink() {
                //this. hideNav()
                //  alert('You could open the project frontend in another tab here, so the logged admin could see changes made to the project ;)');
            },
            updateMenu(event,context) {
                this.contextSection = context;
                this.menuItens = this.menuData[context];
              //  console.log(event.offsetY);

            },
            highlightSection(section) {
                // console.log(this.contextSection);
                return {
                    'menu__link': true,
                    'menu__link--active': section === this.contextSection,
                    'menu__top_small':!this.msNavigationOn

                };
            },
            subMenuClass(subMenuName) {
                return {
                    'context-menu__link': true,
                    'context-menu__link--active': this.activeSubMenu === subMenuName,

                };
            },
            closeContextMenu() {
                this.contextSection = '';
                this.menuItens = [];
            },
            openSection(item) {
                this.activeSubMenu = item.txt;
               // this.$router.push(this.getUrl(item));
                this.getUrl(item);
              //  window.bus.$emit('menu/closeMobileMenu');
            },
            getUrl(item) {
                let data={};
                data.modUrl=item.link;
                this.closeContextMenu();
                //data.modCode="MAS";
                data.modDView=item.txt;
                this.$parent.driveRequestFromNavToLiveTab(data);

                // let sectionSlug = kebabCase(item.txt);
                // return `${item.link}/${sectionSlug}`;
            },
            fromOtherCom(type=0,data=null){
                //console.log(type)
                switch (type) {
                    case 'hideNsv':
                        this.msNavigationOn=false;
                        this.msContextClass="";
                        this.msNavClass=" ms-nav menu__top_hidden";
                        break;
                }
            },
            hideNav(event){

                if(this.msNavigationOn){
                    this.msNavigationOn=false;
                    this.msContextClass="";
                    this.msNavClass=" ms-nav menu__top_hidden";
                }else{
                    this.msNavigationOn=true
                    this.msNavClass=" ms-nav  ms-animation";
                    this.msContextClass="context-menu-container_small";
                }
                this.$parent.setNavOn(this.msNavigationOn,event);


            }
            ,
            updateMSmenuData(data){
                console.log(data);
            },

            getDataForSideBar(){
                let vm = this;
                vm.msDPath=vm.msPath;

                //  var link = this.makeGetUrl(this.msData.path,data);
              //  console.log( this.msData);
             //   this.getGetRaw(this.msPath,this,'setMenuData');
                //console.log(   this.msMenuData );
                // var root= this.$root;
                //   this.$refs['msMenull'].updateMSmenuData(this.msMenuData);

            },
            setMenuData(classFor,data){
                //console.log(data);
                classFor.msMenuData=data;
            }


        },
        computed: {
            showContextMenu() {
                return this.menuItens.length;
            },
        },
        mounted() {
            let demo=this;
            var link='http://gst.ms/MAS/test/getSidebar?accessToken=4ckMtOqVXNlck1pdHVsGsJT4&type=json&find=sidebar';


            setTimeout(function() {



                fetch(link)   .then(function(response) { return response.json()
                    .then( function(data) {

                        console.log(data)

                        demo.menuData=data.items;
                    } );
                })
                    .catch(function(error) {
                        console.log(error);
                    });



            }, 500);




            console.log(this.msData);
            //this.getDataForSideBar();
          //  console.log(this.msPath);
            //this.getGetRaw(this.msPath,this,'setMenuData');
             //this.menuData=this;
             //var test =this.msData;
            // console.log(test);
            //this.msData2= test;
        //    this.menuItens=this.msData;
            this.msNavigationOn=Boolean(Number(this.msNav));
            if(this.msNavigationOn && ( window.innerWidth < 800  ))this.msNavigationOn=0;
        }
    }
</script>

<style scoped>
.menu__top{
    @apply bg-teal-300;
    @apply p-3;

}
   li> .menu__link{
       @apply block;
       @apply p-2;
       width: 250px;
       @apply bg-teal-300;
       @apply border-t;

   }
    .context-menu-container{
        margin-left:252px ;
        top:80px;
        min-width: 200px;
        @apply bg-teal-400;
        @apply border-t;
        @apply fixed;
    }
    .context-menu-container_small{
        margin-left:82px ;
    }
    .context-menu__title{
    @apply border-t;
        @apply mt-2;
    }
    .menu__icon{
        @apply pr-2;
        @apply pl-2;
    }
    .menu__top_small{
        transition: all 800ms ease-in-out;
        max-width: 80px;
    }
    .menu__arrow-icon{
        @apply float-right;
        @apply p-1;
    }

.context-menu{

    @apply p-1;
}
   .context-menu__title{
        @apply pr-3;
        @apply pt-1;
        @apply pb-1;
        @apply pl-3;
        @apply min-w-full;

    }
    .context-li{
@apply flex;
    }
.context-li-title{
    @apply border-b;

}
    .ms-nav{
        top: 80px;
        cursor:ponter;
    }

</style>

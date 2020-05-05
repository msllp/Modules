<template>
<div class="">

    <!-- root level itens -->



    <ul class="menu" :class="msNavClass">

        <li class="menu__top" @click.prvent="hideNav($event)"  >

            <a
                href="#"

                class="menu__title"
            >
                <i class="fas fa-location-arrow menu__icon" :class="{
'ms-main-btn-fix':!msNavigationOn,
'ms-animation':msNavigationOn,
'fa-rotate-180':msNavigationOn,

}" aria-hidden="true"></i>
               <span v-if="msNavigationOn" :class="{'ms-animation':msNavigationOn}">Navigation</span>
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

        <li>
            <a
                href="#"
                @click.prevent="updateMenu($event,'products')"
                :class="highlightSection('products')"
            >
                <i class="fa fa-tag menu__icon" aria-hidden="true"></i>

                   <span  v-if="msNavigationOn">  Products</span>
                <i class="fa fa-chevron-right menu__arrow-icon" aria-hidden="true"></i>
            </a>
        </li>

        <li>
            <a
                href="#"
                @click.prevent="updateMenu($event,'customers')"
                :class="highlightSection('customers')"
            >
                <i class="fa fa-users menu__icon" aria-hidden="true"></i>
                <span  v-if="msNavigationOn"> Customers </span>
                <i class="fa fa-chevron-right menu__arrow-icon" aria-hidden="true"></i>
            </a>
        </li>

        <li>
            <a
                href="#"
                @click.prevent="updateMenu($event,'account')"
                :class="highlightSection('account')"
            >
                <i class="fa fa-user menu__icon" aria-hidden="true"></i>
                <span  v-if="msNavigationOn">  Account</span>
                <i class="fa fa-chevron-right menu__arrow-icon" aria-hidden="true"></i>
            </a>
        </li>

    </ul>


    <ul>
        <li>
            <transition name="slide-fade">

                <div class="context-menu-container" v-show="showContextMenu" :class="msContextClass">

                    <ul class="context-menu">

                        <li v-for="(item, index) in menuItens" :key="index">

                            <h5 v-if="item.type === 'title'" class="context-menu__title">

                                <i :class="item.icon" aria-hidden="true"></i>

                                {{item.txt}}

                                <a
                                    v-if="index === 0"
                                    @click.prevent="closeContextMenu"
                                    class="context-menu__btn-close"
                                    href="#"
                                >
                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                </a>

                            </h5>

                            <a
                                v-else
                                href="#"
                                @click.prevent="openSection(item)"
                                :class="subMenuClass(item.txt)"
                            >
                                {{item.txt}}
                            </a>

                        </li>

                    </ul>

                </div>

            </transition>

        </li>
    </ul>


</div>

</template>

<script>
    import menuData from './support/menu-data';
    import kebabCase from 'lodash/kebabCase';


    export default {
        name: 'msMenu',
        props:{
            'msNav':{
                     type: Boolean,
                    required: true,
                    default:true
            }
        },
        data(){
            return {
                contextSection: '',
                menuItens: [],
                menuData: menuData,
                activeSubMenu: '',
                msNavigationOn:true,
                msNavClass:'ms-nav',
                msContextClass:''
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
                console.log(event.offsetY);

            },
            highlightSection(section) {
               // console.log(this.contextSection);
                return {
                    'menu__link': true,
                    'menu__link--active': section === this.contextSection,
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
                this.$router.push(this.getUrl(item));

                window.bus.$emit('menu/closeMobileMenu');
            },
            getUrl(item) {
                let sectionSlug = kebabCase(item.txt);
                return `${item.link}/${sectionSlug}`;
            },
            hideNav(event){

                if(this.msNavigationOn){
                    this.msNavigationOn=false;
                    this.msContextClass="context-menu-container-full";
                    this.msNavClass=" ms-nav menu__top_hidden";
                }else{
                    this.msNavigationOn=true
                    this.msNavClass=" ms-nav  ms-animation";
                    this.msContextClass="";
                }
                this.$parent.setNavOn(this.msNavigationOn,event);


            }
        },
        computed: {
            showContextMenu() {
                return this.menuItens.length;
            },
        },
        mounted() {
            this.msNavigationOn=this.msNav;
        }
    }
</script>
<style>
.ms-main-btn-fix{
    margin-left: 15px;

    transition: all 350ms ease-in-out;
}
    .ms-animation,.menu__top_hidden{
        transition: all 350ms ease-in-out;
    }
</style>

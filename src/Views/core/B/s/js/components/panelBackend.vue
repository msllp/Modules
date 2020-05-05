<template>
    <div>
        <div class=" sticky-top" style="background: linear-gradient(to right, rgba(255, 81, 47, 1), rgba(221, 36, 118, 1));">
    <nav class="navbar navbar-expand-lg navbar-dark" style="">
        <a class="navbar-brand" href="#">
            
            <img src="/images/logo_final.png" style="max-height:40px;">
            
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse flex" id="navbarSupportedContent">
            <!--<ul class="navbar-nav mr-auto flex">-->
                <!--<li class="nav-item active">-->
                    <!--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" href="#">Link</a>-->
                <!--</li>-->
                <!--<li class="nav-item dropdown">-->
                    <!--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--Dropdown-->
                    <!--</a>-->
                    <!--<div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
                        <!--<a class="dropdown-item" href="#">Action</a>-->
                        <!--<a class="dropdown-item" href="#">Another action</a>-->
                        <!--<div class="dropdown-divider"></div>-->
                        <!--<a class="dropdown-item" href="#">Something else here</a>-->
                    <!--</div>-->
                <!--</li>-->
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>-->
                <!--</li>-->
            <!--</ul>-->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
        </div>

        <div class="block">

            <div class="flex ">

<transition name="ms">
                <div class="ms-side fixed " v-if="msNavOn">

                    <ms-menu :ms-nav ="msNavOn" ></ms-menu>

                </div>


                <div class="ms-side float-right col-xs-12 col-sm-12 col-md-2 col-lg-2" v-else >

                    <ms-menu :ms-nav ="msNavOn"></ms-menu>

                </div>

</transition>

                <div class="ms-live-box float-right col-xs-12 col-sm-12 col-md-10 col-lg-10 bg-light"


                     v-if="msNavOn">
                    <msviewpanel></msviewpanel>
                </div>
                <div class="ms-live-box float-right col-xs-12 col-sm-12 col-md-12 col-lg-12 bg-light ms-live-box-full"  v-else>
                        Live Box

                </div>

            </div>
        </div>


    </div>
</template>

<script>

    import msMenu from './msMenu';
    export default {
        name: "panelBackend",

        data() {
            return {
                msNavOn:true

            }
        }
        ,
        methods:{
            setNavOn(show=false,event){
                if(!show){
                    this.msNavOn=false;
                }else {
                    this.msNavOn=true
                }

                console.log(event.offsetY);

            },


        }

        ,

        components : {
            msMenu
        }
    }
</script>

<style scoped>



</style>

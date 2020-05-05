<template>
    <div >


        <div class="cssload-tetrominos" :class="msLoading" >
            <div class="cssload-tetromino cssload-box1"></div>
            <div class="cssload-tetromino cssload-box2"></div>
            <div class="cssload-tetromino cssload-box3"></div>
            <div class="cssload-tetromino cssload-box4"></div>
        </div>
<div class="card">


    <div class="card-header " style="position: sticky;
    top: 0;background-color: white;z-index: 1025;">

        <div style="z-index: 2"  class="">

                <p style="margin-bottom:10px;float: left" > Search HSN/SAC Code</p>


            <div class="input-group" >
                <input style="border-top-left-radius: 0;
                        border-bottom-left-radius: 0;" type="text" class="form-control"  v-model="msSearch" placeholder="Enter Your Product Or Service Name" aria-label="Product Or Service Name" >
                <div class="input-group-append">
                    <button class="btn btn-success"  v-on:click="getSearch()" type="button" style="border-top-right-radius: 0;
                        border-bottom-right-radius: 0;" >Search</button>

                </div>
            </div>


            <small class="text-muted float-right" style="margin-top:10px;">Powered by <a href="https://www.millionsllp.com">
                <img src="http://gst.msllp.in/images/logo_final.png" style="max-height: 30px;margin-top:-7px"></a></small>
        </div>


                <div class="btn-group btn-group-toggle" data-toggle="buttons" style="z-index: 3;">

                    <label class="btn btn-info active disabled" style="border-radius: 0px;cursor: pointer;" for="option1" >
                        <input type="radio" id="option1" autocomplete="off" checked > Select Type Code :
                    </label>
                    <label class="btn btn-info active" style="border-radius: 0px;cursor: pointer;" for="option1" v-on:click="setHsn()">
                        <input type="radio" id="option1" autocomplete="off" checked > HSN Code
                    </label>
                    <label class="btn btn-warning" style="border-radius: 0px;cursor: pointer;" for="option2" v-on:click="setSac()">
                        <input type="radio" id="option2" autocomplete="off" > SAC Code
                    </label>

                </div>

    </div>

    <div class="card-body">
        <table class="table  table-bordered table-hover " :class="msVisibleClass" style="z-index: 2;">
        <thead  class="thead-info" style="position: sticky;
    top: 0;">


    <tr v-if="msDataFor.hsn_results.length > 0 || msDataFor.sac_results.length > 0">
        <td  >{{ msCodeType.toUpperCase() }} Code</td>
        <td  > Code Description  </td>
    </tr>

    </thead>

            <tbody v-if="msCodeType=='hsn' &&  msDataFor.hsn_results.length > 0 ">
    <tr v-for="row in msDataFor.hsn_results">

        <td >{{row.hsn_code}} </td>
        <td >{{row.description}}</td>

    </tr>

        </tbody>

            <tr v-else-if="msCodeType=='hsn' && msDataFor.hsn_results.length < 1">

                <td colspan="2" >
                    <img src="http://gst.msllp.in/images/notfound.svg" style="max-height:50px">
                    Sorry we couldn't find any {{ msCodeType.toUpperCase() }} Code for {{msSearch.toUpperCase()}} </td>


            </tr>


            <tbody v-if="msCodeType=='sac' && msDataFor.sac_results.length > 0">
            <tr v-for="row in msDataFor.sac_results">

                <td >{{row.sac_code}} </td>
                <td >{{row.description}}</td>

            </tr>
            </tbody>
            <tr v-else-if="msCodeType=='sac' && msDataFor.sac_results.length < 1">

                <td colspan="2" >
                    <img src="http://gst.msllp.in/images/notfound.svg" style="max-height:50px">
                    Sorry we couldn't find any {{ msCodeType.toUpperCase() }} Code for {{msSearch.toUpperCase()}}  </td>


            </tr>

</table>


    </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "msgst",
        props:{
            'msData':{
                type: String,
                required: true
            }
        },
        data:function () {
            return {
                msDataFor:{},
                msSearch:"",
                msVisibleClass:"display",
                msLoading:"hidden",
                msCodeType:"hsn",
            }
            },
        methods:{
            getHSNCode(searchKeyWord){
                this.msVisibleClass="hidden";
                this.msLoading="display";
                var url='http://gst.msllp.in/MAS/getHsnCode?key='+searchKeyWord+"&type="+this.msCodeType
               // var url='http://gst.msllp.in/MAS/getHsnCode?key='+searchKeyWord

                var self=this

                let re= axios.get(url)

                    .then(
                        function(response){

                           var  returnX=response.data;
                           // console.log(response.data);
                           // self.setmsDataFor(returnX);
                            self.msDataFor=response.data.result;

                        }
                    )
                    .catch(function (error) {
                        // handle error
                       // self.setMsError(error.response.data);
                        //  console.log(error.response.data);
                   //     console.log(error);
                      //  this.setmsDataFor(this,error);
                    })
                    .finally( response => {
                        self.msVisibleClass="display";
                        self.msLoading="hidden";
                    });
            },
            setmsDataFor(data){
                this.msDataFor=data;
            },
            getSearch(){
                this.getHSNCode( encodeURI( this.msSearch));
            },
            setHsn(){
                if(this.msCodeType != "hsn")
                this.msCodeType="hsn";
            },setSac(){
                if(this.msCodeType != "sac")
                    this.msCodeType="sac";
            }

        },
        mounted() {
            //this.msDataFor= JSON.parse(this.msData);
           this.getHSNCode("Demo");
        },
        watch:{

        }
    }
</script>

<style scoped>
    .hidden{
        display: none;
        transition: display 1s;
    }
    .display{
        display: block;
        transition: display 1s;
    }
    .cssload-tetrominos {
        z-index: 2025;
        position: absolute;
        left: 50%;
        top:50%;
        transform: translate(-109px, -94px);
        -o-transform: translate(-109px, -94px);
        -ms-transform: translate(-109px, -94px);
        -webkit-transform: translate(-109px, -94px);
        -moz-transform: translate(-109px, -94px);
    }

    .cssload-tetromino {
        width: 94px;
        height: 109px;
        position: absolute;
        transition: all ease 0.35s;
        -o-transition: all ease 0.35s;
        -ms-transition: all ease 0.35s;
        -webkit-transition: all ease 0.35s;
        -moz-transition: all ease 0.35s;
        background: url('data:image/svg+xml;utf-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 612 684"%3E%3Cpath fill="%23010101" d="M305.7 0L0 170.9v342.3L305.7 684 612 513.2V170.9L305.7 0z"/%3E%3Cpath fill="%23fff" d="M305.7 80.1l-233.6 131 233.6 131 234.2-131-234.2-131"/%3E%3C/svg%3E') no-repeat top center;
    }

    .cssload-box1 {
        animation: cssload-tetromino1 1.73s ease-out infinite;
        -o-animation: cssload-tetromino1 1.73s ease-out infinite;
        -ms-animation: cssload-tetromino1 1.73s ease-out infinite;
        -webkit-animation: cssload-tetromino1 1.73s ease-out infinite;
        -moz-animation: cssload-tetromino1 1.73s ease-out infinite;
    }

    .cssload-box2 {
        animation: cssload-tetromino2 1.73s ease-out infinite;
        -o-animation: cssload-tetromino2 1.73s ease-out infinite;
        -ms-animation: cssload-tetromino2 1.73s ease-out infinite;
        -webkit-animation: cssload-tetromino2 1.73s ease-out infinite;
        -moz-animation: cssload-tetromino2 1.73s ease-out infinite;
    }

    .cssload-box3 {
        animation: cssload-tetromino3 1.73s ease-out infinite;
        -o-animation: cssload-tetromino3 1.73s ease-out infinite;
        -ms-animation: cssload-tetromino3 1.73s ease-out infinite;
        -webkit-animation: cssload-tetromino3 1.73s ease-out infinite;
        -moz-animation: cssload-tetromino3 1.73s ease-out infinite;
        z-index: 2;
    }

    .cssload-box4 {
        animation: cssload-tetromino4 1.73s ease-out infinite;
        -o-animation: cssload-tetromino4 1.73s ease-out infinite;
        -ms-animation: cssload-tetromino4 1.73s ease-out infinite;
        -webkit-animation: cssload-tetromino4 1.73s ease-out infinite;
        -moz-animation: cssload-tetromino4 1.73s ease-out infinite;
    }









    @keyframes cssload-tetromino1 {
        0%, 40% {
            transform: translate(0, 0);
        }
        50% {
            transform: translate(47px, -26px);
        }
        60%, 100% {
            transform: translate(94px, 0);
        }
    }

    @-o-keyframes cssload-tetromino1 {
        0%, 40% {
            -o-transform: translate(0, 0);
        }
        50% {
            -o-transform: translate(47px, -26px);
        }
        60%, 100% {
            -o-transform: translate(94px, 0);
        }
    }

    @-ms-keyframes cssload-tetromino1 {
        0%, 40% {
            -ms-transform: translate(0, 0);
        }
        50% {
            -ms-transform: translate(47px, -26px);
        }
        60%, 100% {
            -ms-transform: translate(94px, 0);
        }
    }

    @-webkit-keyframes cssload-tetromino1 {
        0%, 40% {
            -webkit-transform: translate(0, 0);
        }
        50% {
            -webkit-transform: translate(47px, -26px);
        }
        60%, 100% {
            -webkit-transform: translate(94px, 0);
        }
    }

    @-moz-keyframes cssload-tetromino1 {
        0%, 40% {
            -moz-transform: translate(0, 0);
        }
        50% {
            -moz-transform: translate(47px, -26px);
        }
        60%, 100% {
            -moz-transform: translate(94px, 0);
        }
    }

    @keyframes cssload-tetromino2 {
        0%, 20% {
            transform: translate(94px, 0px);
        }
        40%, 100% {
            transform: translate(140px, 26px);
        }
    }

    @-o-keyframes cssload-tetromino2 {
        0%, 20% {
            -o-transform: translate(94px, 0px);
        }
        40%, 100% {
            -o-transform: translate(140px, 26px);
        }
    }

    @-ms-keyframes cssload-tetromino2 {
        0%, 20% {
            -ms-transform: translate(94px, 0px);
        }
        40%, 100% {
            -ms-transform: translate(140px, 26px);
        }
    }

    @-webkit-keyframes cssload-tetromino2 {
        0%, 20% {
            -webkit-transform: translate(94px, 0px);
        }
        40%, 100% {
            -webkit-transform: translate(140px, 26px);
        }
    }

    @-moz-keyframes cssload-tetromino2 {
        0%, 20% {
            -moz-transform: translate(94px, 0px);
        }
        40%, 100% {
            -moz-transform: translate(140px, 26px);
        }
    }

    @keyframes cssload-tetromino3 {
        0% {
            transform: translate(140px, 26px);
        }
        20%, 60% {
            transform: translate(94px, 53px);
        }
        90%, 100% {
            transform: translate(47px, 26px);
        }
    }

    @-o-keyframes cssload-tetromino3 {
        0% {
            -o-transform: translate(140px, 26px);
        }
        20%, 60% {
            -o-transform: translate(94px, 53px);
        }
        90%, 100% {
            -o-transform: translate(47px, 26px);
        }
    }

    @-ms-keyframes cssload-tetromino3 {
        0% {
            -ms-transform: translate(140px, 26px);
        }
        20%, 60% {
            -ms-transform: translate(94px, 53px);
        }
        90%, 100% {
            -ms-transform: translate(47px, 26px);
        }
    }

    @-webkit-keyframes cssload-tetromino3 {
        0% {
            -webkit-transform: translate(140px, 26px);
        }
        20%, 60% {
            -webkit-transform: translate(94px, 53px);
        }
        90%, 100% {
            -webkit-transform: translate(47px, 26px);
        }
    }

    @-moz-keyframes cssload-tetromino3 {
        0% {
            -moz-transform: translate(140px, 26px);
        }
        20%, 60% {
            -moz-transform: translate(94px, 53px);
        }
        90%, 100% {
            -moz-transform: translate(47px, 26px);
        }
    }

    @keyframes cssload-tetromino4 {
        0%, 60% {
            transform: translate(47px, 26px);
        }
        90%, 100% {
            transform: translate(0, 0);
        }
    }

    @-o-keyframes cssload-tetromino4 {
        0%, 60% {
            -o-transform: translate(47px, 26px);
        }
        90%, 100% {
            -o-transform: translate(0, 0);
        }
    }

    @-ms-keyframes cssload-tetromino4 {
        0%, 60% {
            -ms-transform: translate(47px, 26px);
        }
        90%, 100% {
            -ms-transform: translate(0, 0);
        }
    }

    @-webkit-keyframes cssload-tetromino4 {
        0%, 60% {
            -webkit-transform: translate(47px, 26px);
        }
        90%, 100% {
            -webkit-transform: translate(0, 0);
        }
    }

    @-moz-keyframes cssload-tetromino4 {
        0%, 60% {
            -moz-transform: translate(47px, 26px);
        }
        90%, 100% {
            -moz-transform: translate(0, 0);
        }
    }


    [type="radio"]{
        border-radius: 0px;
    }
</style>

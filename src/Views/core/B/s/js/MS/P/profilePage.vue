<template>

    <div class ="flex flex-wrap">

        <div class="container">


            <div class="profileBox">

                <div class="profileBox-container">

                    <div class="profileBox-left-box">
                        <div class="profileBox-left-icon">
                            <svg  class="profileBox-left-icon-user">
                                <use v-bind:xlink:href="'#msicon-svg-user-'+msUserData.sex+'-1'" />
                            </svg>

                        </div>

                        <div class="profileBox-left-username">{{msUserData.Username}}</div>
                    </div>
                    <div class="profileBox-right-box">

                        <table class="profileBox-right-box-table">

                            <tr>
                                <th>Name</th>
                                <td>{{msUserData.fname}} {{msUserData.lname}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{msUserData.email}}</td>
                            </tr>
                            <tr>
                                <th>Contact no.</th>
                                <td>{{msUserData.phone}}</td>
                            </tr>
                            <tr>
                                <th>Active Plan</th>
                                <td>{{msUserData.plan.name}}</td>
                            </tr>
                        </table>


                    </div>


                </div>





            </div>

            <div class="w-full flex flex-fill flex-wrap">

                <div class="usageBox">
                    <table class="usageBox-box-table">
                        <tr class="usageBox-box-table-h"><th colspan="3">Active Plan Details</th> </tr>
                        <tr v-for="row in msUserData.plan.limits">
                            <th class="text-left">{{row.vName}}</th>
                            <td>{{row.usage}}/{{row.limit}}

                            </td>
                            <td> <progress :value="row.usage" :max="row.limit"></progress></td>


                        </tr>
                    </table>

                </div>

                <div class="planUpgradeBox">

                    <table class="planUpgradeBox-table">
                        <tr class="planUpgradeBox-table-h"><th colspan="3">Upgrade Your Plan</th> </tr>
                        <tr v-for="row in msUserData.plan.limits">
                            <th class="text-left">{{row.vName}}</th>
                            <td>{{row.limit}}
                            </td>
                            <td >  + 10  </td>


                        </tr>



                    </table>
                    <div colspan="planUpgradeBox-table-f">
                        <span>Upgrade Now</span>
                    </div>
                </div>


            </div>



        </div>



    </div>

</template>

<script>
    export default {
        name: "profile",
        props:{
            'msData':{
                type: Object,
                required: true
            } ,
            'msExtra':{
                type: Object,
                required: true
            }


        },
        data:function () {
        return{
            msUserData:this.msData,
            // msUserData:{
            //     Username:'maxirooney',
            //     sex:'female',
            //     email:'user@company.com',
            //     fname:'Mitul',
            //     lname:'Patel',
            //     phone:'9662611234',
            //     plan:{
            //
            //         name:'Test',
            //         limits:[
            //             {
            //                 vName:'Products',
            //                 limit:5,
            //                 usage:1,
            //
            //
            //             },
            //             {
            //                 vName:'Invoice / Month',
            //                 limit:5,
            //                 usage:1,
            //             },
            //             {
            //                 vName:'Purchase / Month',
            //                 limit:5,
            //                 usage:1,
            //             }
            //         ]
            //     }
            //
            // }

        }
        }
    }
</script>

<style scoped>

</style>

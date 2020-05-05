<template>
<div class="flex flex-wrap">
    <div class="flex-1 p-2 m-3 shadow border bg-green-300">

        <canvas id="myChart" class="container"></canvas>

    </div>



    <div class="ms-card-box md:flex-1">
        <div class="ms-card bg-green-100">
            <div class="ms-card-body container">
<!--                <div class="ms-card-icon-box">-->
<!--                    <div class="ms-card-icon-div"><i class="ms-card-icon fi2 flaticon-down-left-arrow text-green-600"></i> <i class="ms-card-icon fi2 flaticon-rupee text-green-600"></i> </div>-->
<!--                </div>-->
                <div class="flex-1 text-left select-none">

                    <div class="flex items-center mt-2">


                        <svg class="select-none w-10 h-10 mr-4" >
                            <use xlink:href="#msicon-svg-leads" />
                        </svg>
                        <div class="text-xl">
                            <p class="text-gray-900 leading-none">Manage Leads</p>

                        </div>


                    </div>
                    <hr />
                    <div class="flex items-center mt-2">

                    <div class="ms-dashboard-action-box  " >

                            <svg class=" w-10 h-10 mr-4" >
                                <use xlink:href="#msicon-for-addlead" />
                            </svg>


                        <div class="text-sm">
                            <p class="text-gray-900 leading-none">Get Leads</p>

                        </div>
                    </div>

                    <div class="ms-dashboard-action-box">
                        <svg class=" w-10 h-10 mr-4" >
                            <use xlink:href="#msicon-for-viewlead" />
                        </svg>
                        <div class="text-sm">
                            <p class="text-gray-900 leading-none">View All Leads</p>

                        </div>
                    </div>




                    </div>
                    <hr />


                    <div class="flex items-center mt-2">


                        <svg class="select-none w-10 h-10  mr-4" >
                            <use xlink:href="#msicon-svg-followup" />
                        </svg>
                        <div class="text-xl">
                            <p class="text-gray-900 leading-none">Manage Quotation</p>

                        </div>
                    </div>
                    <hr />
                    <div class="flex items-center mt-2">

                        <div class="ms-dashboard-action-box">

                            <svg class=" w-10 h-10 mr-4" >
                                <use xlink:href="#msicon-for-addquotation" />
                            </svg>


                            <div class="text-sm">
                                <p class="text-gray-900 leading-none">Generate  Quotation</p>

                            </div>
                        </div>

                        <div class="ms-dashboard-action-box">
                            <svg class=" w-10 h-10 mr-4" >
                                <use xlink:href="#msicon-for-viewquotation" />
                            </svg>
                            <div class="text-sm">
                                <p class="text-gray-900 leading-none">View All Quotations</p>

                            </div>
                        </div>




                    </div>
                    <hr />

                    <div class="flex items-center mt-2">


                        <svg class="select-none w-10 h-10  mr-4" >
                            <use xlink:href="#msicon-svg-invoice" />
                        </svg>
                        <div class="text-xl">
                            <p class="text-gray-900 leading-none">Manage Invoices</p>

                        </div>
                    </div>
                    <hr />
                    <div class="flex items-center mt-2">

                        <div class="ms-dashboard-action-box">

                            <svg class=" w-10 h-10 mr-4" >
                                <use xlink:href="#msicon-for-addinvoice" />
                            </svg>


                            <div class="text-sm">
                                <p class="text-gray-900 leading-none">Generate  Invoice</p>

                            </div>
                        </div>

                        <div class="ms-dashboard-action-box">
                            <svg class=" w-10 h-10 mr-4" >
                                <use xlink:href="#msicon-for-viewinvoice" />
                            </svg>
                            <div class="text-sm">
                                <p class="text-gray-900 leading-none">View All Invoices</p>

                            </div>
                        </div>



                    </div>
                    <div class="flex items-center mt-2">
                    <div class="ms-dashboard-action-box">
                        <svg class=" w-10 h-10 mr-4" >
                            <use xlink:href="#msicon-for-addpayment" />
                        </svg>
                        <div class="text-sm">
                            <p class="text-gray-900 leading-none">Receive Payment againts Invoices</p>

                        </div>
                    </div>

                    </div>

                    <hr />
                    <div class="flex items-center mt-2">


                        <svg class="select-none w-10 h-10  mr-4" >
                            <use xlink:href="#msicon-svg-customer" />
                        </svg>
                        <div class="text-sm">
                            <p class="text-gray-900 leading-none">Manage Customers</p>

                        </div>
                    </div>
                    <hr />


                </div>
            </div>
        </div>

    </div>

</div>
</template>

<script>


    export default {
        components: {

        },
        name: "salesdashboard",
        data:function (){
            return {


            };
        },
        mounted(){
            var myChart = new Chart('myChart', {
                type: 'bar',
                responsive:true,
                data: {
                    labels: ['Product 1', 'Product 2','Product 3','Product 4','Product 5'],
                    datasets: [{
                        label: 'Last Month',

                        data: [12, 19, 3, 0, 2],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'

                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    },{
                        label: 'Current Month',
                        data: [10, 16, 1, 2, 4],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)'

                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },

                    legend:{
                        fullWidth:true,
                        labels: {
                            fontColor:  'rgba(0, 0, 0, 0.8)',
                         }
                    }
                },
                animation: {
                    duration:5000,
                    easing:'easeInBounce'
                }
            });
        },
        methods:{
            doNothing(event){event.preventDefault();}


        }
    }
</script>

<style scoped>
#myChart{

}
</style>

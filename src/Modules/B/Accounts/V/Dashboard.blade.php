<div class="flex flex-wrap">
    <div class="ms-card-box md:w-1/2 xl:w-1/2">

<!--Metric Card-->
<div class="ms-card bg-green-100">
    <div class="ms-card-body ">
        <div class="ms-card-icon-box">
            <div class="ms-card-icon-div"><i class="ms-card-icon fi2 flaticon-down-left-arrow text-green-600"></i> <i class="ms-card-icon fi2 flaticon-rupee text-green-600"></i> </div>
        </div>
        <div class="flex-1 text-right md:text-center">
            <h5 class="uppercase text-grey">Total Revenue</h5>
            <h3 class="text-3xl">₹ {{ \MS\Mod\B\Accounts\L\Ledger::getTotalRevenue() }} <span class="text-green"><i class="fas fa-caret-up"></i></span></h3>
        </div>
    </div>
</div>
<!--/Metric Card-->

    </div>


    <div class="ms-card-box md:w-1/2 xl:w-1/2">
        <div class="ms-card bg-red-100">
            <div class="ms-card-body">
                <div class="ms-card-icon-box">
                    <div class="ms-card-icon-div"><i class="ms-card-icon fi2 flaticon-rupee text-red-600">  <i class="ms-card-icon ml-1 fi2 flaticon-down-left-arrow msicon-h-180 text-red-600"></i> </i> </div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="uppercase text-grey">Total Expense</h5>
                    <h3 class="text-3xl">₹ {{ \MS\Mod\B\Accounts\L\Ledger::getTotalExpense() }} <span class="text-green"><i class="fas fa-caret-up"></i></span></h3>
                </div>
            </div>
        </div>
    </div>
</div>



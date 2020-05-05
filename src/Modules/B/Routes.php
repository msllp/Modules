<?php
//dd(\MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'MAS.R'],'b'));

Route::prefix('o3')->group(function (){

    Route::prefix('User')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'User4O3.R'],'b',true);
    });
Route::prefix('Panel')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Panel4O3.R'],'b',true);
    });

    Route::prefix('Company')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Company4O3.R'],'b',true);
    });

});





Route::prefix('Core')->group(function () {

    Route::prefix('User')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Users.R'],'b',true);
    });
    Route::prefix('Sales')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Sales.R'],'b',true);
    });

    Route::prefix('Accounts')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Accounts.R'],'b',true);
    });


    Route::prefix('Mod')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Mod.R'],'b',true);
    });

    Route::prefix('Company')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Company.R'],'b',true);
    });

    Route::prefix('Operation')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Operation.R'],'b',true);
    });



});
Route::get('mpanel/{ln?}','\MS\Mod\B\Users\C@MaintainaceDashboard')->name('mPanel')->middleware('web');
Route::get('getMpanelData','\MS\Mod\B\Users\C@SideNavForMaintainaceDashboard')->name('mPanel.SideNav')->middleware('web');


Route::prefix('env')->group(function (){
    Route::prefix('Users')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Users4EN.R'],'b',true);
    });
    Route::prefix('Purchase')->group(function () {
            \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Purchase4EN.R'],'b',true);
        });
    Route::prefix('panel')->group(function () {
            \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Panel4EN.R'],'b',true);
        });
});



//
//Route::prefix('HM')->group(function () {
//    \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'HM.R'],'b');
//});
//
//Route::prefix('DCM')->group(function () {
//
//    \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'DCM.R'],'b');
//});
//


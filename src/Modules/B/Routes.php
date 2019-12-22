<?php
//dd(\MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'MAS.R'],'b'));



Route::prefix('Core')->group(function () {

    Route::prefix('User')->group(function () {
        \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Users.R'],'b',true);
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



});
Route::get('mpanel/{ln?}','\MS\Mod\B\Users\C@MaintainaceDashboard')->name('mPanel')->middleware('web');
Route::get('getMpanelData','\MS\Mod\B\Users\C@SideNavForMaintainaceDashboard')->name('mPanel.SideNav')->middleware('web');



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


<?php
//dd(\MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'MAS.R'],'b'));



Route::prefix('Core')->group(function () {

Route::prefix('User')->group(function () {
    \MS\Core\Helper\Comman::loadCustom(['locationOfFile'=>'Users.R'],'b',true);
});




});
Route::get('mpanel','\MS\Mod\B\Users\C@MaintainaceDashboard')->name('mPanel');
Route::get('getMpanelData','\MS\Mod\B\Users\C@SideNavForMaintainaceDashboard')->name('mPanel.SideNav');



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


<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 12-03-2019
 * Time: 03:03 AM
 */

namespace MS\Provider;
use Illuminate\Http\Request;

define("MSCORE_UI_STATUS_1","B\MAS:CORE_UI_Status_1:StatusBoolean->StatusName");
define("MSCORE_UI_BOOL_1","MS\Mod\B\MSSetup:Master_Bool_1:BoolValue->BoolName");
define("MSCORE_UI_ICON_1","MS\Mod\B\MSSetup:Master_Icon_1:IconValue->IconName");

define("MSCORE_MOD_MASTER","MS\Mod\B\Mod:Master_Mod:UniqId->ModuleName");

define('MSCORE_ROUTE_TYPE_MASTER',"MS\Mod\B\MSSetup:MS_Route_Type:RouteTypeCode->RouteTypeName");
define('MSCORE_ROUTES_MASTER',"MS\Mod\B\Mod:Master_Route:RouteName->RouteUrl");

define("MSCORE_MOD_EVENT_MASTER","MS\Mod\B\Mod:Master_Events:UniqId->EventName");
define('MSCORE_USER_TYPE_MASTER',"MS\Mod\B\Users:User_User_Type:UniqId->UserTypeName");

define('MSCORE_ROLE_PERMISSION',"MS\Mod\B\Users:User_User_Type_sub:UniqId->EventCode");

define('DS',DIRECTORY_SEPARATOR);

class MSCoreServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //\MS\Core\Helper\Comman::loadBack();


        $this->loadTranslationsFrom(  dirname(__DIR__) .DS.'Lang', 'MS');

        $this->loadViewsFrom(  dirname(__DIR__) .DS.'Views', 'MS');

        $this->loadViewsFrom(  base_path(implode(DS,['vendor','msllp','modules','src','Modules'])), 'MOD');

        $this->publishes([
            dirname(__DIR__) .DS.'Config'.DS.'MS.php' => base_path('config/MS.php'),
        ], 'MS_config');



        $this->publishes([
            dirname(__DIR__).DS.'MSDB' => base_path('MS/DB/Master')
        ], 'MS_db');
        $this->publishes([
            dirname(__DIR__) .DS.'Public'.DS.'B'.DS.'asset' => public_path(),
        ], 'public_backend');

        $this->publishes([
            dirname(__DIR__).DS.'Routes'.DS.'MasterRoutes.php' => base_path('routes/web.php')
        ], 'MS_Master_Routes');

        $this->publishes([
            dirname(__DIR__).DS.'Routes'.DS.'ModuleRoutes.php' => base_path('MS/B/M/Routes.php')
        ], 'MS_Backend_Routes');

        $this->publishes([
            dirname(__DIR__).DS.'Routes'.DS.'ModuleRoutes.php' => base_path('MS/F/M/Routes.php')
        ], 'MS_Frontend_Routes');


        $this->publishes([
            dirname(__DIR__).DS.'Middlelwares'.DS.'settingOn.php' => base_path('app/Http/Middleware/settingOn.php')
        ], 'MS_SettingOn_Config');


        $this->publishes([
            dirname(__DIR__) .DS.'Core'.DS.'Template'.DS.'webpack.mix.js' => base_path('webpack.mix.js'),
        ], 'webpack');

        $this->publishes([
            dirname(__DIR__) .DS.'Core'.DS.'Template'.DS.'bower.json' => base_path('bower.js'),
        ], 'bower');

        $this->publishes([
            dirname(__DIR__) .DS.'Core'.DS.'Template'.DS.'gulpfile.js' => base_path('gulpfile.js'),
        ], 'gulp');






        if(config('MS.default_route_load')){



        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                \MS\Core\Console\Master::class,
                \MS\Core\Console\GenMod::class,
                \MS\Core\Console\Git::class,
            ]);
        }



    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

//
//        $this->mergeConfigFrom(
//            dirname(__DIR__).DS.'Config/Auth.php', base_path('config/auth.php')
//        );

        $this->mergeConfigFrom(
            dirname(__DIR__).DS.'Config/MS.php', 'MS'
        );

      //  \Config::set('app.url','http://hdtuto.com/');
      //  dd(dirname(__DIR__));
        $this->mergeConfigFrom(
            dirname(__DIR__).DS.'Config/Filesystem.php', 'filesystems.disks'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).DS.'Config/Database.php', 'database.connections'
        );


        \MS\Core\Helper\Comman::loadBack();
        \MS\Core\Helper\Comman::coreBack();
        //\MS\Core\Helper\Comman::loadBack();
       // dd(config('MS'));
        \Route::prefix(config('MS.ms_prefix'))->group(function () {

//    Route::get('/', function () {
//        return redirect()->action('\B\Panel\Controller@index');
//    });

            \Route::get('test',function (Request $r){

                return \MS\Core\Test\Master::Test($r);

            })->name('MS.Test');


        });
    }
}

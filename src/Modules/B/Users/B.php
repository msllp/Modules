<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:13 AM
 */

namespace MS\Mod\B\Users;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Users\C";
    public static $model="MS\Mod\B\Users\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[

        [
            'name'=>'MAS.Index',
            'route'=>'/',
            'method'=>'index',
            'type'=>'get',
        ],

        [
            'name'=>'Test.FormLink',
            'route'=>'test/form',
            'method'=>'testFormLink',
            'type'=>'get'
        ],

        [
            'name'=>'Test.StoreDataLink',
            'route'=>'test/store',
            'method'=>'storeDataLink',
            'type'=>'post'
        ],
        [
            'name'=>'Test.SideBarData',
            'route'=>'test/getSidebar',
            'method'=>'testGetSideBarData',
            'type'=>'get'
        ],

        [
            'name'=>'Test.NewRab',
            'route'=>'test/NewTab',
            'method'=>'testNewTab',
            'type'=>'get'

        ],




[
    'name'=>'paginationLink.Test',
    'route'=>'/pagination',
    'method'=>'paginationTest',
    'type'=>'get',

],

        [
            'name'=>'MAS.core.encryptRequest',
            'route'=>'::',
            'method'=>'MS:Helper.MSSign@check',

        ],

//        [
//            'name'=>'MAS.Index.data',
//            'route'=>'/data',
//            'method'=>'indexData',
//            'type'=>'get',
//        ],



        [
            'name'=>'PM.Add.Product',
            'route'=>'/addProduct',
            'method'=>'productAddForm',
            'type'=>'get',
        ],

        [
            'name'=>'BM.Generate.Invoice.PDF.Post',
            'route'=>'/fromAppGenaratePdf',
            'method'=>'genarateInvoicePDFPost',
            'type'=>'post',
        ],

        [
            'name'=>'Test.Post.With.Data',
            'route'=>'/test/post',
            'method'=>'postLinkTest',
            'type'=>'post',
        ],



//
//        [
//            'name'=>'BM.Generate.Invoice.PDF',
//            'route'=>'/fromAppGenaratePdf',
//            'method'=>'genarateInvoicePDF',
//            'type'=>'get',
//        ],


//        [
//            'name'=>'BM.Generate.Invoice.PDF',
//            'route'=>'/getHsnCode',
//            'method'=>'findGst',
//            'type'=>'get',
//        ],

//
//        [
//            'name'=>'BM.Generate.Invoice.for.App',
//            'route'=>'/gen/invoice/app',
//            'method'=>'genInvFroApp',
//            'type'=>'get',
//        ],
//
//        [
//            'name'=>'BM.Generate.Invoice.for.App',
//            'route'=>'/get/gstrate/from/code',
//            'method'=>'findGstRate',
//            'type'=>'get',
//        ],








    ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}

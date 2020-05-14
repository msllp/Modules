<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:13 AM
 */

namespace MS\Mod\B\Company4O3;



use MS\Core\Module\Master;

class B extends Master
{

    public static $controller="MS\Mod\B\Company4O3\C";
    public static $model="MS\Mod\B\Company4O3\M";
  //  public static $dir="MS.B.MAS";

    public static $route=[


        [
            'name'=>'O3.Company.test',
            'route'=>'/test',
            'method'=>'test',
            'type'=>'get' ,
        ],

        [
            'name'=>'O3.CompanyDetails.For.Website',
            'route'=>'/company/forWebsite/{companyId}',
            'method'=>'getCompanyForWebsite',
            'type'=>'get' ,
        ],

        [
            'name'=>'O3.CompanyDetails.For.Website.ById',
            'route'=>'/company/forWebsite/byCompanyId/{companyId}',
            'method'=>'getCompanyForWebsiteByCompanyId',
            'type'=>'get' ,
        ],

        [
            'name'=>'O3.Company.Setup.intial',
            'route'=>'/setup/company',
            'method'=>'setupCompany',
            'type'=>'get' ,
        ],
        [
            'name'=>'O3.Company.Setup.intial.Post',
            'route'=>'/setup/company',
            'method'=>'setupCompanyPost',
            'type'=>'post' ,
        ],

        [
            'name'=>'O3.Company.Setup.get.States',
            'route'=>'/setup/company/get/states',
            'method'=>'getStatesForCompany',
            'type'=>'get' ,
        ],


        [
            'name'=>'O3.Company.All.For.User',
            'route'=>'/get/all/company/{userId}',
            'method'=>'getAllCompany',
            'type'=>'get' ,
        ],

        ];


    public static $allOnSameconnection=false;


    public static $tables=[




    ];

}

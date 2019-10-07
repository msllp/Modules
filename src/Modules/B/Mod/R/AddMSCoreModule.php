<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 14-07-2019
 * Time: 03:48 PM
 */

namespace B\MAS\R;
use MS\Core\Request\Master;

class AddMSCoreModule  extends Master
{

    protected $msRules=[];
    protected $msMsg=[];
    protected $msAttr=[];

    public static $tableId = "Master_Mod";
    public function rules(){




        return [

        ];
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 02-06-2019
 * Time: 01:14 PM
 */

namespace MS\Core\Helper\Request;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class Master extends FormRequest implements BaseMaster
{


    protected function formatErrors(Validator $validator)
    {


        return $validator->errors() ;


    }
}

<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 18-03-2019
 * Time: 03:06 AM
 */

namespace MS\Mod\B\Company4O3;

use MS\Core\Model\Master;


class M extends Master
{




    public function routeNotificationForMail($notification)
    {
        return $this->Email;
    }



}

<?php


namespace MS\Mod\B\User4O3;

use MS\Core\Model\Master;


class M extends Master
{

    public function routeNotificationForMail($notification)
    {
        return $this->Email;
    }


}

<?php


namespace MS\Mod\B\Accounts;


use MS\Core\Model\Master;

class M  extends Master
{
    public function routeNotificationForMail($notification)
    {
        return $this->Email;
    }
}

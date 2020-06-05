<?php


namespace MS\Mod\B\Users\L;


class User
{
    public $userId,$userData;

    public function __construct($userId=null)
    {
        if($userId!=null)$this->userId=$userId;
        $m=\MS\Mod\B\Users\F::getAppUserModel();
        //dd($this->userId);

        $md=$m->rowGet(['UniqId'=>$userId]);

        $this->setUserData(reset($md));
        //dd($this);

    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserData()
    {



        return $this->userData;
    }

    /**
     * @param mixed $userData
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;
    }

}

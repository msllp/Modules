<?php


namespace MS\Mod\B\Mod\L;


class Mod
{


    public static function delete($id){
        $m=\MS\Mod\B\Mod\F::getEventModel();
        $m2=\MS\Mod\B\Mod\F::getEventSubModel($id);
       // $m->delete();
        return ($m->delete())?$m->rowDelete(['UniqId'=>$id]):false;
    }


}

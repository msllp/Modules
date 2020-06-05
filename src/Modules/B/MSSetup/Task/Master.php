<?php
namespace MS\Mod\B\MSSetup\Task;

trait Master
{

public function runMSTask ($s){

    $tasks=[
        [
            'class'=>'MS\Mod\B\Users\F',
            'duration'=>'everyMinute'
        ]
    ];


    foreach ($tasks as $task){

        $c=new $task['class'];
        $d=$task['duration'];
        $s->call($c)->$d();

      //  $s->call(new $task['class'])->$task['duration']();
    }


    //$s->call(new MS\Mod\B\Users\F)->everyMinute();

    return true;

}

}

<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 03-07-2019
 * Time: 04:34 AM
 */

namespace MS\Core\Console;


use  Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Git extends Command
{

    protected $signature = 'ms:git {--type=} {--repo=}';

    protected $description = 'MS Git Module & it Components';
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $cmd='dir';
        //shell_exec( $cmd );
        //$cmd="ECHO %CurrentDir%";
        //dd(shell_exec( $cmd ));

        $data['type']=$this->option('type');
        $data['path']=base_path('Test');
        $data['url']="https://github.com/".$this->option('repo').".git "."vendor/msllp/core2";

        switch ($data['type']){
            case 'clone':
                $cmd="git fetch ".$data['url'];

                dd(shell_exec( $cmd ));

                $cmd="git fetch ".$data['url'];//." ".$data['path'];
            //dd($cmd);
               dd( shell_exec( $cmd ));


                break;
        }

    }

}

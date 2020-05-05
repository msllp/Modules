<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 27-06-2019
 * Time: 04:13 PM
 */

namespace MS\Core\Console;

use  Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenMod  extends  Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    private $corepageLocation= "vendor.msllp.core.src.Core" ;

    private $MS="MS";

    public $masterFile=[

     'mod' =>  [
         'folder'=>['R','T','V','F','J'],
         'file'=>[
             'Template.Module.Routes'=>"R",
             'Template.Module.Base'=>"B",
             'Template.Module.Controller'=>"C",
             'Template.Module.Model'=>"M",
             'Template.Module.Function'=>"F",
         ],
                ]


    ];
    public $action=[];
    protected $signature = 'ms:gen {--type=} {--name=} {--mod=} {--end=b}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genrate MS Module & it Components';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $masterType=[
'module','controller','table','function','view',
    ];

    private $masterEnd=[
        'b','f',
    ];

    private $masterFileMap=[



        [   'to'=>'Base.php',
            'from'=>'Base.php'],

        [   'to'=>'Controller.php',
            'from'=>'Controller.php'
        ],



    ];
    /**
     * Execute the console command.
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {

        $data['type']=$this->option('type');
        $data['newName']=$this->option('name');
        $data['moduleName']=$this->option('mod');
        $data['end']=$this->option('end');

        //$this->table(['Gen. Driver','File name','Module Name','END'], [  $data  ]);
        if(!in_array($data['type'],$this->masterType))$data['type']=$this->choice("What Type of file you Want to Generate ?",$this->masterType);
     //   $this->line($data['type']);
        if(!in_array($data['end'],$this->masterEnd))$data['end']=$this->choice("From Which End you Want to Generate File?",$this->masterEnd);

     //   $this->table(['Gen. Driver','File name','Module Name','END'], [  $data  ]);

        Beging:
        switch ($data['type']){
            case "module":
                $this->makeModule($data);
                break;
            case "controller":
                $this->makeControllerForModule($data);
                break;
            case "table":
                $this->makeTableForModule($data);
                break;
            case "function":
                $this->makeFunctionForModule($data);
                break;
            case "view":
                $this->makeViewForModule($data);
                break;
            default:
                $data['type']=$this->choice("What you Want to Generate ?",$this->masterType);
                goto Beging;
                break;

        }




    }

    private function makeModule($data){
        //$this->info(base_path());
        foreach ($this->masterFile['mod']['folder'] as $key=>$value){
            if($data['moduleName'] != null)
            {
                MS_makeModule_1:
                $filePath=implode('/',[strtoupper($data['end']),"M" ,$data['moduleName'],$value ]);
                Storage::disk('MS-CORE')->makeDirectory($filePath);
            }else{

                $data['moduleName']=  $this->ask("Please Enter Module Name");
                goto MS_makeModule_1;
            }

        }

      //  $this->table(['Gen. Driver','File name','Module Name','END'], [  $data  ]);
    }
    private function makeControllerForModule($data){


    }
    private function makeTableForModule($data){


    }
    private function makeFunctionForModule($data){


    }
    private function makeViewForModule($data){


    }

    private function makeFilePath($shortUrl){
        $exoPath=explode('.',$shortUrl);
        $basePath=explode('.',$this->corepageLocation);
        $returPath="";
        //  dd($exoPath );
        if(count($basePath)>1){
            $basePath=implode("/",$basePath);
        }
        //$returPath=$basePath;

        //dd($basePath);

        if($exoPath > 1){
            $returPath =implode('/',[ $basePath, implode("/",explode(".",$shortUrl)) ]) ;
        }else{
            $returPath =implode('/',[ $basePath, $shortUrl ]) ;
        }
        return $returPath;

    }
    private function makeFile($dv,$file)
    {
        //dd($file);
        $file=file_get_contents(base_path($file));

        foreach ($dv as $key => $value) {
            $file=str_replace($key, $value,$file);
        }

        return $file;
        //str_replace("%body%", "black", "<body text='%body%'>");
        //dd($file);

    }

}

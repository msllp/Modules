<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 27-06-2019
 * Time: 03:25 PM
 */
namespace MS\Core\Console;

//use App\User;
//use App\DripEmailer;
use Illuminate\Console\Command;


class Master extends Command
{




    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ms:v';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get MS Version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {

        $heading=['Desc', 'Data'];
        $table =[


            [
                'Desc'=>"Vesion",
                'Data'=>"MS Frame 6 Community Licence"
            ],
            [
                'Desc'=>"Platform",
                'Data'=>"PHP 7"
            ]
            ,
            [
                'Desc'=>"Server",
                'Data'=>"Apache"
            ]

        ];

        $this->table($heading, $table);

//        $bar = $this->output->createProgressBar("100");
//        $bar->start();
//        //$bar->advance(1);
//        for ($x=0;$x < 100;$x++){
//           // $this->info($x);
//           //dd(explode('',$x));
//           //var_dump(($x+1) % 10);
//           //if(($x+1) % 10 == 0)
//            $bar->advance();
//        }
//       $bar->finish();
       // $name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);
        return "5.8";
        //$drip->send(User::find($this->argument('user')));
    }



}

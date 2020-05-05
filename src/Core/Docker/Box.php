<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 19-08-2019
 * Time: 02:49 AM
 */

namespace MS\Core\Docker;
define('DEFAULT_CONTAINER_DIR',["MS","Deploy",'Docker']);
use Symfony\Component\Yaml\Yaml;
//nuse function GuzzleHttp\Psr7\str;

class Box
{
public $services=[];
public $userId,$image,$expose;

public $v="3.7";
public function __construct($user=001)
{
    $this->userId=$user;
}
public function makeFromImage(Image $image){
    $ports=($image->expose[array_key_first($image->expose)]);
    $data=[
        'name'=>$this->userId."_services",
        'containerName'=>"container_".$this->userId,
        'image'=>$image->getImageForCompose(),
        'ports'=>$this->makeExpose($ports),
    ];

    //$this->setImage($image->getImageForCompose());
    //$this->setExpose();

    $this->addService($data);
    $data['name'].="_20";
    $data['containerName'].="_20";

    $data['image']=$image->getImageForCompose();
    $data['ports']=$this->makeExpose($ports);
    $this->addService($data);
    $this->makeDockerCompose();
    dd($this->up());


}

public function up(){
    //dd($this);
    chdir("../");
    chdir(implode('/',DEFAULT_CONTAINER_DIR));

    $excuteComman="docker-compose rm -f";
    $excuteComman="docker-compose up";
    system($excuteComman);
  //  dd($excuteComman);
    dd(system($excuteComman));
}

    public function makeDockerCompose(){
        //dd($this);
        $text=[];
        $text[]=implode(':',['version',' "'.$this->v.'"']);
        $text[]=" ";
        $text[]=" ";
        $text[]=" ";
        $text[]="services:";
        $data['version']=$this->v;
        $data['services']=[];

        foreach ($this->services as $name=>$vd){

            $data['services'][$vd['name']]['image']="msllp/".$vd['image'];
            $data['services'][$vd['name']]['container_name']=$vd['containerName'];
            $data['services'][$vd['name']]['ports']=$vd['ports'];

            $text[]='   "'.$vd['name'].'":';
            $text[]=implode(':',['      image'," msllp/".$vd['image']]);
            $text[]=implode(':',['      container_name'," ".$vd['containerName']]);
            $text[]=implode(':',['      ports',
            "
            -".implode('
            -',  $vd['ports']) ]);
            $text[]=" ";

        }
       // dd(Yaml::dump($data));
        $rText=implode('
',$text);
    //    dd($this);


        $basePath=[base_path(implode(DS,DEFAULT_CONTAINER_DIR))];
        $dockerfileName="docker-compose.yml";
        $basePath[]=$dockerfileName;

        $file=fopen(implode(DS,$basePath), "w");
        fwrite($file, $rText);
       // dd($rText);
}





    public function setImage($image){
        $this->image=$image;
        return $this;
    }

    public function setExpose($array){

       $this->expose=$this->makeExpose($array);

    }

    public function makeExpose($array){
        $data=[];

        foreach ($array as $port){
            $p=$this->findSafePort();
            $data[$p]=' "'.implode(':',[$p,$port]).'"' ;
        }
        return $data;
    }

    public function findSafePort(){

    $port=\MS\Core\Helper\Comman::random(5);
//dd($this->checkSafePort($port));
    //    dd($this->checkSafePort($port));

        while (!$this->checkSafePort($port)){
        $port=(string)\MS\Core\Helper\Comman::random(5);
    }

    return $port;
//dd($port);
    //dd();
    }

    public function checkSafePort($port){

    if($port > 49152){
        if($port < 65535){
        return true;
        }
    }

    if($port < 65535){
        if($port > 49152){
            return true;
        }
    }
     return false;

    return true;
    }


public function addService($data){
$this->services[$data['name']]=$data;
}

    public function deleteContainerCommand($name){

        $comman="docker container rm ".$name;
    }

    public function stopContainerCommand($name){
        $comman="docker stop web ".$name;
    }
}

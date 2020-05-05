<?php

namespace MS\Core\Helper;


class MSPlease
{

    public static function ModuleInMod($namespace='',$varData=[]){

        $dir=[
            'D'=>'For Default Table Data feed',
            'T'=>'For Module Tables & Config',
            'L'=>'For Module Logic Class',
            'V'=>'For Module View Elements'
        ];
        $files=[
            'r','m','c','b','f'
        ];
        $dataFinal=[];
        $exNamespace=explode('\\',$namespace);
       // dd($exNamespace);
        $dataStatic=[
            'ModCode'=>end($exNamespace),
            'NameSpace'=>$namespace,
            'Path'=>implode('/',['vendor','msllp','modules','src','Modules',reset($exNamespace)]),
            'Disk'=>'MS-ROOT',
            'BasePath'=>implode('/',['vendor','msllp','core','src','Core','Template'])
        ];
      //  dd($dataStatic);
        if(count($varData)<1){$dataFinal=$dataStatic;}else{$dataFinal= array_merge($dataStatic,$varData) ;}

        try {
            //dd($dir);
            foreach ($dir as $type=>$typeData) {
             //   dd($dataFinal['Path']);
               // dd( \Storage::disk($dataFinal['Disk'])->makeDirectory(implode('/',[$dataFinal['Path'],$dataFinal['ModCode']])));
              \Storage::disk($dataFinal['Disk'])->makeDirectory(implode('/',[$dataFinal['Path'],$dataFinal['ModCode']]));
                \Storage::disk($dataFinal['Disk'])->makeDirectory(implode('/',[$dataFinal['Path'],$dataFinal['ModCode'],$type]));

            }

            foreach ($files as $file){
                $fileData=self::getMasterFile($file,$dataFinal);
        //        if(!array_key_exists('name',$fileData))dd('ok');
                $basPath=implode("/", [$dataFinal['BasePath'],$fileData['name']]);
                $targetPath=implode("/",[$dataFinal['Path'],$dataFinal['ModCode'],self::makeFileName($fileData['name']) ]);
                //$directory=implode(DS,[$dataFinal['Path'],$type]);
             // dd($targetPath);
                \Storage::disk($dataFinal['Disk'])->copy($basPath, $targetPath);
                $fileRaw=\Storage::disk($dataFinal['Disk'])->get($targetPath);
               // dd($fileData);
                foreach ($dataFinal as $varKey=>$varValue)if(array_key_exists($varKey,$fileData['var']))$fileRaw=str_replace('{'.$varKey.'}', $varValue,$fileRaw);

                \Storage::disk($dataFinal['Disk'])->put($targetPath,$fileRaw);
            }
        }catch (\Exception $exception){
            return false;
            dd($exception);
        }

      //  dd($dataFinal);

        return true;
    }

    public static function makeFileName($filename){
        $filenameExp=explode('.',$filename);
        if(count($filenameExp)>1)unset($filenameExp[array_key_last($filenameExp)]);
        $finalFile=implode('.',[reset($filenameExp),'php']);
        return $finalFile;

    }

    public static function getMasterFile($key,$data=[]):array {
        $a=[];
        $masterFiles=[
            'r'=>[
                'name'=>'R.ms',
                'var'=>[
                    'NameSpace'=>''
                ],
            ],
            'b'=>[
                'name'=>'B.ms',
                'var'=>[
                    'NameSpace'=>''
                ],
            ],
            'c'=>[
                'name'=>'C.ms',
                'var'=>[
                    'NameSpace'=>''
                ],
            ],
            'm'=>[
                'name'=>'M.ms',
                'var'=>[
                    'NameSpace'=>''
                ],
            ],
            'f'=>[
                'name'=>'F.ms',
                'var'=>[
                    'NameSpace'=>''
                ],
            ],
        ];

        if(array_key_exists($key,$masterFiles)){

            switch ($key){

//                case 'r':
//
//                    $a=$masterFiles[$key];
//                    if(count($data)>1 && array_key_exists('NameSpace',$data))$a['var']['NameSpace']=$data['NameSpace'];
//                    break;

               default:

                    $a=$masterFiles[$key];
                    if(count($data)>1 && array_key_exists('NameSpace',$data))$a['var']['NameSpace']=$data['NameSpace'];
                    break;

            }
        }

            return $a;
    }

}

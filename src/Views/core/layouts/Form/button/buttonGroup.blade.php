<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 05-06-2019
 * Time: 05:09 PM
 */
//dd($data);


?>

<div class="btn-group btn-block" role="group" aria-label="Basic example">

@foreach($data as $type =>$btnData)
<?php // dd($btnData);

//$btnClass=[btn];
        $btn['Class']=['btn'];
        switch ($type){
    case 'back';
    $btn['Class'][]='btn-primary';
    break;

    case 'add';
                $btn['Class'][]='btn-success';
    break;

            case 'edit';
                $btn['Class'][]='btn-warning';
                break;


            case 'delete';
                $btn['Class'][]='btn-danger';
                break;
        }

//dd( route($btnData['route']));
?>

    <button type="button" v-on:click="getModBtn('{{route($btnData['route'])}}')"   class="{{implode(' ',$btn['Class'])}}">{{$btnData['btnText']}}</button>


    @endforeach

</div>



<script type="javascript">



</script>

<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 02-06-2019
 * Time: 02:22 PM
 */
//dd($data);
$uniqID="aa_".\MS\Core\Helper\Comman::random();
$uniqID2="bb_".\MS\Core\Helper\Comman::random();

?>





<div class="card">
    <div class="card-header collapse show " data-toggle="collapse" id="{{$uniqID2}}" data-target="#{{$uniqID}}" aria-expanded="false" aria-controls="{{$uniqID}}">
        <h4>{{$data['title']}} <span  v-on:click="addGroupofInput()">add</span></h4>
    </div>
        <div class="collapse card card-body" id="{{$uniqID}}" aria-labelledby="{{$uniqID2}}" data-parent="#msapp" >


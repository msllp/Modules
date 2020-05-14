@extends('MS::core.layouts.root')
@section('body')

    <?php

$jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();

?>

    <msupgradeuser :ms-data="{{$jsonData}}"></msupgradeuser>



@endsection

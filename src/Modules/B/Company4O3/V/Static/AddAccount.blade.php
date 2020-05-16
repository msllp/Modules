@extends('MS::core.layouts.root')
@section('body')

    <?php

    $jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();

    ?>

    <addbankaccount :ms-data="{{$jsonData}}"></addbankaccount>
@endsection

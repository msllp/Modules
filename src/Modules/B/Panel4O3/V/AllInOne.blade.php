@extends('MS::core.layouts.rootRaw')
@section('body')

    <?php

    $jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();

    ?>

    <allinone :ms-data="{{$jsonData}}"></allinone>
@endsection

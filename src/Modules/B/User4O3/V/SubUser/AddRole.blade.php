@extends('MS::core.layouts.rootRaw')
@section('body')

    <?php $jsonData=(isset($data))?collect($data)->toJson():collect([])->toJson();  ?>

    <addrole :ms-data="{{$jsonData}}"></addrole>

@endsection

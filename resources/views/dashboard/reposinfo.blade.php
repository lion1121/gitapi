@extends('layouts.app')

@section('content')
<div class="container">

            <h2>Repos information</h2>
            {{--<reposinfo-component></reposinfo-component>--}}
    <div class="row justify-content-start">

                <div class="col-4">id</div> <div class="col-8">{{$id}}</div>
                <div class="col-4">name</div> <div class="col-8">{{$name}}</div>
                <div class="col-4">owner</div> <div class="col-8">{{$owner}}</div>
                <div class="col-4">stars</div> <div class="col-8">{{$stars}}</div>
        </div>
</div>
@endsection

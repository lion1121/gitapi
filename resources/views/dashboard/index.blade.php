@extends('layouts.app')

@section('content')
    <section class="container" >
        <reposlist-component url="{{url('/user/dashboard/')}}"></reposlist-component>
    </section>
@endsection

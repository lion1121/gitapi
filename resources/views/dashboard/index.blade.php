@extends('layouts.app')

@section('content')
    <section class="container" >
        <div class="row">
            <div class="col-12">
                <h2 class="repos_title">Git repos list</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12" id="app1">
                <reposlist-component></reposlist-component>
            </div>
        </div>
    </section>
@endsection

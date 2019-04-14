@extends('layouts.app')

@section('content')
    <section class="container" id="app1">
        <div class="row">
            <div class="col-12">
                <h2 class="repos_title">Search git repo</h2>
                <reposlist-search></reposlist-search>
            </div>
        </div>
        <div class="row">
            <div class="col-12" >
                <h2 class="repos_title">Git repos list</h2>
                <reposlist-component></reposlist-component>
            </div>
        </div>
    </section>
@endsection

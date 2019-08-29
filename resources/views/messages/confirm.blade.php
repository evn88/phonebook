@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $m['title'] }}</div>

                <div class="card-body">
                   <h3>{{ $m['message'] }}</h3>
                </div>
            </div>
        </div>          
    </div>
</div>

@endsection

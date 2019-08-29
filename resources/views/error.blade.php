@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ошибка!</div>

                <div class="card-body">
                    <p class="alert alert-danger">Данный товар уже кто-то забронировал раньше. Что бы такое не повторилось чаще обновляйте страницу</p>
                    {{-- <a href="{{ route('home') }}" class="btn btn-primary btn-block">На главную</a> --}}
                </div>
            </div>
        </div>          
    </div>
</div>

@endsection

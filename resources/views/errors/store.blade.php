@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ошибка!</div>

                <div class="card-body">
                    <div class="alert alert-danger">
                    <h4>Вы неверно заполнили форму:</h4>
                        <ul>
                            @foreach ($errors->all() as $message)
                            <li> {{ $message }} </li>
                            @endforeach
                        </ul>
                    </div>
                    <br><br>
                    <!-- <p>Исправьте ошибки и повторите снова</p> -->

                    <!-- <a href="{{ route('home') }}" class="btn btn-info">На главную</a> -->
                </div>
            </div>
        </div>          
    </div>
</div>

@endsection

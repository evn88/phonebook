@extends('layouts.app')

@section('content')

<computers-component>
    <div class="container">
        <div class="col-md-12">     
            загрузка...
        </div>
    </div>
</computers-component>

    @include('modal.info', [
        'title_booking'=>'Бронирование компьютера', 
        'title_rebooking'=>'Перекупить компьютер', 
        'route'=>'computer.store', 
        'id'=>'pc_id'
    ])
@endsection
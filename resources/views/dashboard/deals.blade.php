@extends('layouts.dashboard')

@section('content')
    <div class="p-3">
        <deals-index-component :deals="{{$deals ? json_encode($deals) : null}}"></deals-index-component><br>
        <deal-create-modal-component :accounts="{{$accounts ? json_encode($accounts) : null}}"></deal-create-modal-component>
        <deal-edit-modal-component :accounts="{{$accounts ? json_encode($accounts) : null}}"></deal-edit-modal-component>
    </div>
@endsection

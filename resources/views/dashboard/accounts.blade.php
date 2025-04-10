@extends('layouts.dashboard')

@section('content')
    <div class="p-3">
        <accounts-index-component :accounts="{{$accounts ? json_encode($accounts) : null}}"></accounts-index-component>
        <account-create-modal-component></account-create-modal-component>
        <accounts-deals-index-modal-component></accounts-deals-index-modal-component>
    </div>
@endsection

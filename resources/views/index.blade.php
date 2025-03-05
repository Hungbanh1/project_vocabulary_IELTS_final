@extends('layouts.index')

@section('content')
    @include('modal.modal_edit')
    @include('modal.modal_parapharse')
    @include('modal.modal_list_parapharse')
    <div class="container mt-5">
        <div class="row" id="main_content">
            @include('loadmore')
        </div>

    </div>
@endsection

@extends('layouts.index')

@section('content')
    @include('modal.modal_edit')
    @include('modal.modal_parapharse')
    @include('modal.modal_list_parapharse')
    @if (session('message'))
        <script>
            Swal.fire({
                title: "Thành công!",
                text: "{{ session('message') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    @endif
    <div class="container mt-5">
        <div class="row" id="main_content">
            @include('loadmore')
        </div>

    </div>
@endsection

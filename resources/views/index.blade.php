@extends('layouts.index')

@section('content')
    @include('modal.modal_edit')
    @include('modal.modal_list_parapharse')
    @include('modal.modal_parapharse')
    {{-- @if ($errors->any())
        <script>
            $(document).ready(function() {
                $("#myModalEdit").modal('show');
            });
        </script>
    @endif --}}
    {{-- @if (session('message'))
        <script>
            Swal.fire({
                title: "Thành công!",
                text: "{{ session('message') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    @endif --}}




    <div class="container mt-5">
        <div class="row" id="main_content">
            @include('loadmore')
        </div>

    </div>
    <script>
        var page = 1;
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                page++; // Tăng page lên
                infinteLoadMore(page);

                function infinteLoadMore(page) {
                    $('.content').addClass("loading");
                    $.ajax({
                        url: "?page=" + page,
                        // dataType: 'html',
                        type: "GET",
                        success: function(data) {
                            // console.log(data.html);
                            setTimeout(function() {
                                $(".content").removeClass("loading");
                                $("#main_content").append(data.html);

                            }, 500);
                        },


                    });
                }
            }
        });
    </script>
@endsection

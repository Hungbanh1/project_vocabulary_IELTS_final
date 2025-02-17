@extends('layouts.index')
@section('content')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- @if (session('success'))
        <div class="alert alert-success" role="alert" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show">
            {{ session('success') }}
        </div>
    @endif --}}
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Thành công!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    @endif

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        @php
            $defaultUrl = url('/');
            $type_of_voca = request()->segment(1); // adj , adv ,...
            $fullUrl = request()->fullUrl();
        @endphp
        {{-- <div class="container content loading"> --}}
        <div class="container ">
            <a class="navbar-brand" href="{{ url('/') }}">Vocabulary</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav no-marker">
                    <li class="nav-item">
                        <a class="nav-link {{ $type_of_voca == 'adv' ? 'active' : '' }}" href="{{ route('adv') }}">Trạng
                            từ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type_of_voca == 'adj' ? 'active' : '' }}" href="{{ route('adj') }}">Tính
                            từ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type_of_voca == 'N' ? 'active' : '' }}" href="{{ route('N') }}">Danh
                            từ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type_of_voca == 'V' ? 'active' : '' }}" href="{{ route('V') }}">Động
                            từ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type_of_voca == 'Phrase' ? 'active' : '' }}"
                            href="{{ route('Phrase') }}">Cụm từ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type_of_voca == 'edit' ? 'active' : '' }}" href="{{ route('edit') }}">Edit
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5  ">
        <div class="head mb-5">
            <div class="row justify-content-end">
                <div class="col-lg-3 col-12">
                    <div class="search">
                        <form action="{{ route('search') }}" method="GET">
                            <div class="d-flex">
                                <input type="text" class="form-control keyword" name="keyword" id="keyword"
                                    placeholder="Từ vựng">
                                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                            </div>

                        </form>
                    </div>
                    <div class="mt-5">
                        <p>Hiện tại có : <span class="text-danger">{{ count($vocabulary) }}</span> từ vựng</p>

                    </div>
                </div>
                @if ($fullUrl == $defaultUrl)
                    <div class="col-xl-9 col-12">
                        <div class="search">
                            {{-- <form action="{{ route('add') }}" method="POST">
                                @csrf --}}
                            <div class="row justify-content-center">
                                <div class="group-input mx-3 col-lg-3 col-12">
                                    <input type="text" name="english"
                                        class="form-control w-100 mb-2  @error('english') is-invalid @enderror"
                                        id="english" placeholder="Tiếng anh" value="{{ old('english') }}">
                                    {{-- @error('english')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror --}}
                                    <span class="invalid-feedback" id="english-error"></span>
                                </div>
                                <div class="group-input  mx-3 col-lg-3 col-12">
                                    <input type="text" name="vietnam"
                                        class="form-control w-100 mb-2  @error('vietnam') is-invalid @enderror"
                                        id="vietnam" placeholder="Tiếng việt" value="{{ old('vietnam') }}">
                                    {{-- @error('vietnam')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror --}}
                                    <span class="invalid-feedback" id="vietnam-error"></span>

                                </div>
                                <div class="group-input mx-3 col-lg-3 col-12">
                                    <select id="type" name="type"
                                        class="form-control  @error('type') is-invalid @enderror">
                                        <option value="">Chọn loại từ</option>
                                        @foreach ($type as $item)
                                            @if ($item->name == 'N')
                                                <option value="{{ $item->id }}" class="mr-2" style="color: #28a745;">
                                                    {{ $item->name }}
                                                    ({{ $item->description }})
                                                </option>
                                            @elseif ($item->name == 'V')
                                                <option value="{{ $item->id }}" class="mr-2" style="color: #007bff;">
                                                    {{ $item->name }}
                                                    ({{ $item->description }})
                                                </option>
                                            @elseif ($item->name == 'Adj')
                                                <option value="{{ $item->id }}" class="mr-2" style="color: #dc3545;">
                                                    {{ $item->name }}
                                                    ({{ $item->description }})
                                                </option>
                                            @elseif ($item->name == 'Adv')
                                                <option value="{{ $item->id }}" class="mr-2" style="color: #fd7e14;">
                                                    {{ $item->name }}
                                                    ({{ $item->description }})
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}" class="mr-2" style="">
                                                    {{ $item->name }}
                                                    ({{ $item->description }})
                                                </option>
                                            @endif
                                            {{-- <option value="{{ $item->id }}">
                                            {{ $item->name }} ({{ $item->description }})
                                        </option> --}}
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <span class="invalid-feedback" id="type-error"></span>

                                </div>
                                <button type="submit" class="btn btn-primary btn-add-vocabulary col-lg-3 col-11 mt-3 w-100"
                                    style="margin-left:0px!important;padding:5px!important">Thêm
                                    từ
                                    vựng</button>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row" id="main_content">
            @php
                $t = 0;
            @endphp
            @foreach ($vocabulary as $item)
                @php
                    $t++;
                @endphp
                <div class="col-xl-6 col-sm-6 vocabulary-item">
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center mb-2">
                            <p class="mr-2">{{ $t }}/</p>
                            @if ($item->type->name == 'N')
                                <p class="vocabulary-vn mr-2" style="color: #28a745;"> {{ $item->english }}</p>
                                <p style="color: #28a745;">({{ $item->type->name }})</p>
                            @elseif ($item->type->name == 'V')
                                <p class="vocabulary-vn mr-2" style="color: #007bff;">{{ $item->english }}</p>
                                <p style="color: #007bff;">({{ $item->type->name }})</p>
                            @elseif ($item->type->name == 'Adj')
                                <p class="vocabulary-vn mr-2" style="color: #dc3545;">{{ $item->english }}</p>
                                <p style="color: #dc3545;">({{ $item->type->name }})</p>
                            @elseif ($item->type->name == 'Adv')
                                <p class="vocabulary-vn mr-2" style="color: #fd7e14;">{{ $item->english }}</p>
                                <p style="color: #fd7e14;">({{ $item->type->name }})</p>
                            @else
                                <p class="vocabulary-vn mr-2" style="">{{ $item->english }}</p>
                                <p style="">({{ $item->type->name }})</p>
                            @endif
                            {{-- <p>({{ $item->type->name }})</p> --}}
                            <p class="mx-3">:</p>
                            <p class="vocabulary-vn" style="color: #6c757d;">{{ $item->vietnam }}</p>
                        </li>
                        <li>
                            <div class="d-flex list_action">
                                <button style="border:none" data-toggle="modal" data-target="#myModalEdit"
                                    data-eng="{{ $item->english }}" data-vn="{{ $item->vietnam }}"
                                    data-type="{{ $item->type->id }}" data-id="{{ $item->id }}">
                                    <img src="{{ asset('public/img/edit.png') }}" alt="edit vocabulary"
                                        class="action-icon">
                                </button>

                                <button class="delete-link btn-delete-vocabulary " data-id="{{ $item->id }}">
                                    <img src="{{ asset('public/img/delete.png') }}" alt="" class="action-icon">
                                </button>

                            </div>
                        </li>
                    </ul>

                </div>
            @endforeach

        </div>
        @include('modal.modal_edit')

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.btn-add-vocabulary').click(function(e) {
            e.preventDefault(); // Ngăn form submit
            $('.content').addClass("loading");
            $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
            $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
            // const year = $("#select_year").val();
            const english = $("#english").val();
            const vietnam = $("#vietnam").val();
            const type = $("#type").val();
            data = {
                english: english,
                vietnam: vietnam,
                type: type,
            }
            console.log("Dữ liệu gửi:", data); // Kiểm tra dữ liệu trước khi gửi
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('add') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    $('.content').html(response);
                    setTimeout(function() {
                        $(".content").removeClass("loading");
                        Swal.fire({
                            title: "Thành công!",
                            text: "Thêm từ vựng thành công!",
                            icon: "success",
                            confirmButtonText: "OK"
                        });
                    }, 1500);

                },

                error: function(xhr) {
                    // $(".content").removeClass("loading");
                    setTimeout(function() {
                        $(".content").removeClass("loading");
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            // Duyệt qua từng lỗi và hiển thị dưới input
                            Object.keys(errors).forEach(function(key) {
                                $("#" + key).addClass(
                                    "is-invalid"); // Thêm class đỏ vào input
                                $("#" + key + "-error").text(errors[key][
                                    0
                                ]); // Hiển thị lỗi
                            });
                        } else {
                            Swal.fire("Lỗi!", "Có lỗi xảy ra. Vui lòng thử lại!", "error");
                        }
                    }, 800);

                },
                complete: function() {
                    // $(".content").removeClass("loading");
                },

            })

        })
    </script>
    <script>
        $(document).on('click', '.btn-delete-vocabulary', function() {
            let vocabularyId = $(this).data('id');
            let row = $(this).closest('.vocabulary-item');
            var url = '{{ $defaultUrl }}' + "/delete/" + vocabularyId;
            Swal.fire({
                title: "Xác nhận xóa?",
                text: "Bạn có chắc chắn muốn xóa từ vựng này không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        url: url,
                        data: {
                            id: vocabularyId
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Đã xóa!",
                                text: response.message,
                                icon: "success",
                                timer: 1000, // Hiển thị 1s trước khi reload
                                showConfirmButton: false
                            }).then(() => {
                                setTimeout(() => {
                                    window.location.href = "/";
                                    // Reload sau 1 giây
                                }, 200);
                            });
                        },
                        error: function(xhr) {
                            Swal.fire("Lỗi!", "Không thể xóa từ vựng.", xhr.vocabulary);
                        }
                    });
                }
            });
        });
        $(document).ready(function() {
            var timeout = null;
            var url = '{{ $defaultUrl }}' + "/search/searchajax/";
            var assetUrl = '{{ $defaultUrl }}';

            var getColor = function(type_id) {
                var colors = {
                    '1': '#fd7e14', // adv - màu cam
                    '2': '#dc3545', // adj - màu đỏ
                    '3': '#007bff', // v - màu xanh dương
                    '4': '#28a745', // n - màu xanh lá
                    '5': '#6c757d' // cụm từ - màu xám
                };
                return colors[type_id] || '#6c757d';
            };

            var getTypeName = function(type_id) {
                var types = {
                    '1': 'Adv',
                    '2': 'Adj',
                    '3': 'V',
                    '4': 'N',
                    '5': 'Cụm từ'
                };
                return types[type_id] || 'Cụm từ';
            };

            var createVocabularyItem = function(index, value) {
                var color = getColor(value.type_id);
                var typeName = getTypeName(value.type_id);
                return `
            <div class="col-xl-6 col-sm-6">
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-2">
                        <p class="mr-2">${index + 1}/</p>
                        <p class="mr-2" style="color: ${color};">${value.english}</p>
                        <p style="color: ${color};">(${typeName})</p>
                        <p class="mx-3">:</p>
                        <p style="color: #6c757d;">${value.vietnam}</p>
                         <div class="d-flex list_action">
                <button style="border:none" data-toggle="modal" data-target="#myModalEdit"
                    data-eng="${value.english}" data-vn="${value.vietnam}"
                    data-type="${value.type_id}" data-id="${value.id}">
                    <img src="${assetUrl}/public/img/edit.png" alt="edit vocabulary"
                        class="action-icon">
                </button>
                   <button class="delete-link btn-delete-vocabulary " data-id="${value.id}">
                                    <img src="{{ asset('public/img/delete.png') }}" alt=""
                                        class="action-icon">
                                </button>
            </div>
                    </li>
                </ul>
            </div>
        `;
            };
            $('.keyword').keyup(function() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    var data = {
                        keyword: $('.keyword').val(),
                    };
                    // console.log(data);

                    $.ajax({
                        type: 'get',
                        dataType: 'json',
                        data: data,
                        url: url,
                        success: function(data) {
                            $('#main_content').empty();
                            // console.log(data.vocabulary);

                            if (data.vocabulary.length > 0) {
                                var content = data.vocabulary.map(function(value,
                                    index) {
                                    return createVocabularyItem(index, value);
                                }).join('');
                                $('#main_content').html(content);
                            } else {
                                $('#main_content').html(`
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                Không có từ vựng
                            </div>
                        </div>
                    `);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.error('Lỗi AJAX:', xhr.status, thrownError);
                        },
                    });
                }, 200);
            });
        });
    </script>
@endsection

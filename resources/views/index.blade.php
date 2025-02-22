@extends('layouts.index')
@section('content')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    @php
        $defaultUrl = url('/');
        $type_of_voca = request()->segment(1); // adj , adv ,...
        $fullUrl = request()->fullUrl();
    @endphp
    <div class="container mt-5">
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
                        @if (isset($vocabulary) && !empty($vocabulary))
                            <p>Hiện tại có : <span class="text-danger">{{ count($vocabulary) }}</span>
                                từ vựng</p>
                        @else
                        @endif


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

                                    <span class="invalid-feedback" id="vietnam-error"></span>

                                </div>
                                <div class="group-input mx-3 col-lg-3 col-12">
                                    <select id="type_vocabulary" name="type_vocabulary"
                                        class="form-control type_vocabulary @error('type_vocabulary') is-invalid @enderror">
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
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    <span class="invalid-feedback" id="type_vocabulary-error"></span>

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
    </div>

    <div class="container mt-5">
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
                            <p class="vocabulary-en" style="color: #6c757d;">{{ $item->vietnam }}</p>
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
                                <button style="border:none; margin-left:5px" data-toggle="modal"
                                    data-target="#ModalParapharse" data-eng="{{ $item->english }}"
                                    data-vn="{{ $item->vietnam }}" data-type="{{ $item->type->id }}"
                                    data-id="{{ $item->id }}">
                                    <i class="fa-solid fa-plus" style="color:#44ca44"></i>
                                </button>


                            </div>
                        </li>
                    </ul>

                </div>
            @endforeach

        </div>
        <div id="config" class="d-none" data-default-url="{{ $defaultUrl }}"
            data-route-add="{{ route('add') }}">
        </div>
    </div>


@endsection

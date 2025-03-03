<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kufam:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/index.css') }}">
    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body>
    @php
        $fullUrl = request()->fullUrl();
        $defaultUrl = url('/');
        $custom_url = Str::afterLast($fullUrl, '/');
        $is_parapharse = $custom_url;
        $type_of_voca = request()->segment(1); // adj , adv ,...
        // $defaultUrl = url('/');
        // $type_of_voca = request()->segment(1); // adj , adv ,...
        // $fullUrl = request()->fullUrl();
    @endphp

    <div id="wp-content" class="bg-white content ">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container ">
                <a class="navbar-brand" href="{{ url('/') }}">Vocabulary</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav no-marker">
                        <li class="nav-item">
                            <a class="nav-link {{ $type_of_voca == 'adv' ? 'active' : '' }}"
                                href="{{ route('adv') }}">Trạng
                                từ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type_of_voca == 'adj' ? 'active' : '' }}"
                                href="{{ route('adj') }}">Tính
                                từ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type_of_voca == 'N' ? 'active' : '' }}"
                                href="{{ route('N') }}">Danh
                                từ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type_of_voca == 'V' ? 'active' : '' }}"
                                href="{{ route('V') }}">Động
                                từ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type_of_voca == 'Parapharse' ? 'active' : '' }}"
                                href="{{ route('parapharse') }}">Parapharse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type_of_voca == 'Phrase' ? 'active' : '' }}"
                                href="{{ route('Phrase') }}">Cụm từ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $type_of_voca == 'edit' ? 'active' : '' }}"
                                href="{{ route('edit') }}">Edit
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="head mb-5">
                <div class="row justify-content-end">
                    <div class="col-lg-3 col-12">
                        <div class="search ">
                            {{-- <form action="{{ route('search') }}" method="GET"> --}}
                            <div class="d-flex route_search" data-route-search="{{ route('search') }}">
                                <input type="text" class="form-control keyword" name="keyword" id="keyword"
                                    placeholder="Từ vựng">
                                <button type="submit" class="btn btn-primary w-100 btn-search">Tìm kiếm</button>
                            </div>

                            {{-- </form> --}}
                        </div>
                        <div class="mt-5">
                            @if (isset($vocabulary) && !empty($vocabulary))
                                <p>Hiện tại có : <span class="text-danger">{{ $vocabulary->total() }}</span>
                                    từ vựng</p>
                            @else
                            @endif
                        </div>
                    </div>
                    @if ($fullUrl === $defaultUrl || $is_parapharse == 'parapharse')
                        @php
                            // dd($is_parapharse);
                        @endphp
                        <div class="col-xl-9 col-12">
                            <div class="search">
                                <div class="row justify-content-center ">
                                    <div
                                        class="group-input  {{ $is_parapharse == 'parapharse' ? 'col-lg-4 flex-wrap-nowrap' : 'col-lg-3 mx-3 ' }} col-12">
                                        <input type="text" name="english"
                                            class="form-control w-100 mb-2  @error('english') is-invalid @enderror"
                                            id="english" placeholder="Tiếng anh" value="{{ old('english') }}">
                                        <span class="invalid-feedback" id="english-error"></span>
                                    </div>
                                    <div
                                        class="group-input {{ $is_parapharse == 'parapharse' ? 'col-lg-4 flex-wrap-nowrap' : 'col-lg-3 mx-3 ' }} col-12">
                                        <input type="text" name="vietnam"
                                            class="form-control w-100 mb-2  @error('vietnam') is-invalid @enderror"
                                            id="vietnam" placeholder="Tiếng việt" value="{{ old('vietnam') }}">

                                        <span class="invalid-feedback" id="vietnam-error"></span>
                                    </div>
                                    {{-- <div
                                        class="group-input mx-3 {{ $is_parapharse == 'parapharse' ? 'd-none' : 'col-lg-3 ' }} col-12"> --}}
                                    <div class="group-input mx-3 col-lg-3 col-12">
                                        {{-- @if ($fullUrl === $defaultUrl) --}}
                                        <select id="type_vocabulary" name="type_vocabulary"
                                            class="form-control type_vocabulary @error('type_vocabulary') is-invalid @enderror">
                                            <option value="">Chọn loại từ</option>
                                            @foreach ($type as $item)
                                                @if ($item->name == 'N')
                                                    <option value="{{ $item->id }}" class="mr-2"
                                                        style="color: #28a745;">
                                                        {{ $item->name }}
                                                        ({{ $item->description }})
                                                    </option>
                                                @elseif ($item->name == 'V')
                                                    <option value="{{ $item->id }}" class="mr-2"
                                                        style="color: #007bff;">
                                                        {{ $item->name }}
                                                        ({{ $item->description }})
                                                    </option>
                                                @elseif ($item->name == 'Adj')
                                                    <option value="{{ $item->id }}" class="mr-2"
                                                        style="color: #dc3545;">
                                                        {{ $item->name }}
                                                        ({{ $item->description }})
                                                    </option>
                                                @elseif ($item->name == 'Adv')
                                                    <option value="{{ $item->id }}" class="mr-2"
                                                        style="color: #fd7e14;">
                                                        {{ $item->name }}
                                                        ({{ $item->description }})
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}" class="mr-2"
                                                        style="">
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
                                    {{-- <button type="submit"
                                        class="btn btn-primary {{ $is_parapharse == 'parapharse' ? 'btn-add-parapharse' : 'btn-add-vocabulary mt-3' }} col-lg-3 col-11 w-100"
                                        style="margin-left:0px!important;padding:5px!important;margin-bottom: 8px;">Thêm
                                        từ
                                        vựng</button> --}}
                                    <button type="submit"
                                        class="btn btn-primary btn-add-vocabulary mt-3 col-lg-3 col-11 w-100"
                                        style="margin-left:0px!important;padding:5px!important;margin-bottom: 8px;">Thêm
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
        @yield('content')
        <div id="config" class="d-none" data-default-url="{{ $defaultUrl }}"
            data-route-add="{{ route('add') }}" data-route-add-parapharse="{{ route('add_parapharse') }}"
            data-is-parapharse={{ $is_parapharse }}>
        </div>
    </div>
</body>

<script src="{{ asset('public/js/main.js') }}"></script>

</html>

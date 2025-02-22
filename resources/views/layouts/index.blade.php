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

    @include('modal.modal_edit')
    @include('modal.modal_parapharse')
    <title>Document</title>
</head>

<body>
    @php
        $defaultUrl = url('/');
        $type_of_voca = request()->segment(1); // adj , adv ,...
        $fullUrl = request()->fullUrl();
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

        @yield('content')
    </div>
</body>

<script src="{{ asset('public/js/main.js') }}"></script>

</html>

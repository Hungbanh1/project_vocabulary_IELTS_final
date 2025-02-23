@extends('layouts.index')

@section('content')
    @include('modal.modal_edit')
    @include('modal.modal_parapharse')
    @include('modal.modal_list_parapharse')

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
                                <button style="border:none; margin-left:5px" data-toggle="modal"
                                    data-target="#ModalListParapharse" data-eng="{{ $item->english }}"
                                    data-vn="{{ $item->vietnam }}" data-type="{{ $item->type->id }}"
                                    data-id="{{ $item->id }}">
                                    <i class="fa-solid fa-expand"></i>
                                </button>


                            </div>
                        </li>
                    </ul>

                </div>
            @endforeach

        </div>

    </div>
@endsection

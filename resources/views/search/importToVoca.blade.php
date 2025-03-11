<h1>dadas</h1>
<div class="col-xl-6 col-sm-6 vocabulary-item">
    <ul class="list-unstyled">
        <li class="d-flex align-items-center mb-2">
            <p class="mr-2">{{ $index + 1 }}/</p>
            <p class="vocabulary-vn mr-2" style="color: {{ $color }};">{{ $value['english'] }}</p>
            <p style="color: {{ $color }};">({{ $typeName }})</p>
            <p class="mx-3">:</p>
            <p class="vocabulary-en" style="color: #6c757d;">{{ $value['vietnam'] }}</p>
        </li>
        <li>
            <div class="d-flex list_action">
                <button style="border:none" data-toggle="modal" data-target="#myModalEdit"
                    data-eng="{{ $value['english'] }}" data-vn="{{ $value['vietnam'] }}"
                    data-type="{{ $value['type_id'] }}" data-id="{{ $value['id'] }}">
                    <img src="{{ asset('public/img/edit.png') }}" alt="edit vocabulary" class="action-icon">
                </button>
                <button class="delete-link btn-delete-vocabulary" data-id="{{ $value['id'] }}">
                    <img src="{{ asset('public/img/delete.png') }}" alt="" class="action-icon">
                </button>
                <button style="border:none; margin-left:5px" data-toggle="modal" data-target="#ModalParapharse"
                    data-eng="{{ $value['english'] }}" data-vn="{{ $value['vietnam'] }}"
                    data-type="{{ $value['type_id'] }}" data-id="{{ $value['id'] }}">
                    <i class="fa-solid fa-plus" style="color:#44ca44"></i>
                </button>
            </div>
        </li>
    </ul>
</div>



<div class="col-xl-6 col-sm-6 vocabulary-item ">
    <ul class="list-unstyled">
        <li class="d-flex align-items-center mb-2" style="flex-wrap: wrap">
            <p class="mr-2">{{ $t }}/</p>
            <p class="vocabulary-vn mr-2" style="color: #28a745;"> {{ $item->english }}</p>
            {{-- <p class="mx-3">:</p> --}}
            @foreach ($item->parapharse as $index => $parapharses)
                <p class="vocabulary-vn mr-2" style="color: #28a745;">= {{ $parapharses->english }}</p>
            @endforeach
            <p class="vocabulary-en" style="color: #6c757d;">= {{ $item->vietnam }}</p>
        </li>
        <li>
            <input class="d-none" type="text" name="is_parapharse" id="is_parapharse">

            <div class="d-flex list_action pd-5">
                <button class="btn-show-list-parapharse" style="border:none; margin-left:5px" data-toggle="modal"
                    data-target="#ModalParapharseList" data-eng="{{ $item->english }}" data-vn="{{ $item->vietnam }}"
                    data-type="{{ $item->id }}" data-id="{{ $item->id }}">
                    <i class="fa-solid fa-list"></i>
                </button>
                <button style="border:none" data-toggle="modal" data-target="#myModalEdit"
                    data-eng="{{ $item->english }}" data-vn="{{ $item->vietnam }}" data-type="{{ $item->type_id }}"
                    data-id="{{ $item->id }}" data-is-parapharse="{{ $item->is_parapharse }}">
                    <img src="{{ asset('public/img/edit.png') }}" alt="edit vocabulary" class="action-icon">
                </button>
                <button style="border:none; margin-left:5px" data-toggle="modal" data-target="#ModalParapharse"
                    data-eng="{{ $item->english }}" data-vn="{{ $item->vietnam }}" data-type="{{ $item->id }}"
                    data-id="{{ $item->id }}">
                    <i class="fa-solid fa-plus" style="color:#44ca44"></i>
                </button>

                <button class="delete-link btn-delete-parapharse" data-id="{{ $item->id }}">
                    <img src="{{ asset('public/img/delete.png') }}" alt="" class="action-icon">
                </button>
            </div>
        </li>
    </ul>

</div>

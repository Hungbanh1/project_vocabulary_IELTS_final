<script>
    $(document).ready(function() {
        $('#myModalEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button trigger modal
            var eng_edit = button.data('eng');
            var vn_edit = button.data('vn');
            var type = button.data('type');
            var id = button.data('id');
            var is_parapharse = button.data('is-parapharse');
            var ModalParapharse = this.id;
            $('#eng_edit').val(eng_edit);
            $('#vn_edit').val(vn_edit);
            $('#type').val(type);
            $('#id').val(id);
            $('#is_parapharse').val(is_parapharse);
            console.log(ModalParapharse);


        });
    });
</script>


<div class="modal" id="myModalEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa từ vựng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('edit_vocabulary') }}">
                    @csrf
                    <input type="hidden" id="id" value="" name="id">
                    <input type="text" id="is_parapharse" class="form-control d-none" name="is_parapharse"
                        value="">
                    <input type="hidden" name="modal" value="myModalEdit">

                    <div class="form-group">
                        <label for="eng_edit">Tiếng anh <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control @error('eng_edit') is-invalid @enderror"
                            name="eng_edit" value="{{ old('eng_edit') }}" id="eng_edit"
                            placeholder="Nhập từ tiếng anh">
                        <span class="invalid-feedback">{{ $errors->first('eng_edit') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="vn_edit">Tiếng việt <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control @error('vietnam')is-invalid @enderror" name="vn_edit"
                            value="{{ old('vn_edit') }}" id="vn_edit" placeholder="Nhập từ tiếng việt">
                        @error('vietnam')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Loại từ <strong class="text-danger">*</strong></label>
                        <select id="type" name="type" class="form-control  @error('type') is-invalid @enderror">
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

                    <div class="modal-footer">
                        <div class="form-group text-center w-100">
                            <button type="submit" class="btn btn-add w-25"></i>Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        $.ajax({
            type: 'POST',
            url: '/edit_vocabulary', // Route của edit
            data: $(this).serialize(),
            success: function(response) {
                location.reload(); // Reload sau khi edit thành công
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(field) {
                        $('#' + field).addClass('is-invalid'); // Thêm class lỗi
                        $('#' + field + '-error').text(errors[field][0]); // Hiển thị lỗi
                    });
                }
            }
        });
    });
</script> --}}

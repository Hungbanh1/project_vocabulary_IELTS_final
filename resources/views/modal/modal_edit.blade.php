<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myModalEdit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button trigger modal
            var english = button.data('eng');
            var vn = button.data('vn');
            var type = button.data('type');
            var id = button.data('id');
            var is_parapharse = button.data('is-parapharse');
            $('#eng').val(english);
            $('#vn').val(vn);
            $('#type').val(type);
            $('#id').val(id);
            $('#is_parapharse').val(is_parapharse);
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
                    <div class="form-group">
                        <label for="eng">Tiếng anh <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control @error('eng') is-invalid @enderror" name="eng"
                            value="{{ old('eng') }}" id="eng" placeholder="Nhập từ tiếng anh">
                        <span class="invalid-feedback">{{ $errors->first('eng') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="vn">Tiếng việt <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control @error('vietnam')is-invalid @enderror" name="vn"
                            value="{{ old('vn') }}" id="vn" placeholder="Nhập từ tiếng việt">
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

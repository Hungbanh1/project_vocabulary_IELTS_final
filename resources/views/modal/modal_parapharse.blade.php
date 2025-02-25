<script>
    $(document).ready(function() {
        $('#ModalParapharse').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button trigger modal
            var eng = button.data('eng');
            var vn = button.data('vn');
            var type = button.data('type');
            var id = button.data('id');
            // $('#eng').val(eng);
            // $('#vn').val(vn);
            // $('#type').val(type);
            $('#vocabulary_id').val(id);
        });
    });
</script>


<div class="modal" id="ModalParapharse">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Parapharse</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('add_parapharse') }}">
                    @csrf
                    <div class="form-group">
                        <label for="eng">Tiếng anh <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" name="english" value="" id="english"
                            placeholder="Nhập từ tiếng anh">
                    </div>
                    <div class="form-group">
                        <label for="vietnam">Tiếng việt <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" name="vietnam" value="" id="vietnam"
                            placeholder="Nhập từ tiếng việt">
                    </div>
                    <input type="text" id="vocabulary_id" class="form-control d-none" name="vocabulary_id"
                        value="">

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

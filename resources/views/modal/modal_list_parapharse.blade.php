<script>
    $(document).ready(function() {
        $('#ModalParapharseList').on('show.bs.modal', function(event) {
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
            $('#id_parapharse').val(id);
            $('#is_parapharse').val(is_parapharse);


        });
    });
</script>


<div class="modal" id="ModalParapharseList">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Danh sách parapharse</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('edit_list_parapharse') }}">
                    @csrf --}}
                <input type="hidden" id="id_parapharse" value="" name="id_parapharse">
                <input type="text" id="is_parapharse" class="form-control d-none" name="is_parapharse"
                    value="">
                <input type="hidden" name="modal" value="ModalParapharseList">
                <div class="row" id="parapharseList"></div>
                <div class="modal-footer">
                    <div class="form-group text-center w-100">
                        <button type="submit" class="btn btn-add w-25 btn-edit-list-parapharse"></i>Lưu</button>
                    </div>
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>

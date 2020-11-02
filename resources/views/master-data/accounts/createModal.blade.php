<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Akun</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div class="form-group">
                                <label for="nomor_akun" class="col-sm-12 control-label">Nomor Akun</label>
                                <div class="col-sm-12"><input type="number" class="form-control" id="nomor_akun" name="nomor_akun" placeholder="Contoh: 100" required></div>
                            </div>
                            <div class="form-group">
                                <label for="nama_akun" class="col-sm-12 control-label">Nama Akun</label>
                                <div class="col-sm-12"><input type="text" class="form-control" id="nama_akun" name="nama_akun" placeholder="Contoh: Aktiva Lancar" required></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="saveButton" value="Add" form="addEditForm">Submit</button>
            </div>
        </div>
    </div>
</div>

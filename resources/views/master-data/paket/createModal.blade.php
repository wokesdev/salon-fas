<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Paket</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div class="form-group">
                                <label for="name" class="col-sm-12 control-label">Nama Paket</label>
                                <div class="col-sm-12"><input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Potong Rambut" required></div>
                            </div>
                            <div class="form-group">
                                <label for="kategori" class="col-sm-12 control-label">Kategori</label>
                                <div class="col-sm-12 selectgroup w-100">
                                    <label class="selectgroup-item"><input type="radio" name="kategori" value="Laki-laki" id="men" class="selectgroup-input" checked required><span class="selectgroup-button">Laki-laki</span></label>
                                    <label class="selectgroup-item"><input type="radio" name="kategori" value="Perempuan" id="women" class="selectgroup-input"><span class="selectgroup-button">Perempuan</span></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga" class="col-sm-12 control-label">Harga</label>
                                <div class="col-sm-12 input-group w-100">
                                    <div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="text" class="form-control harga" id="harga" name="harga" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div>
                                </div>
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

<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Barang</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div class="form-group">
                                <label for="nama" class="col-sm-12 control-label">Nama Barang</label>
                                <div class="col-sm-12"><input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Minyak Rambut" required></div>
                            </div>
                            <div class="form-group">
                                <label for="harga_beli" class="col-sm-12 control-label">Harga Beli</label>
                                <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="text" class="form-control harga" id="harga_beli" name="harga_beli" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                            </div>
                            <div class="form-group">
                                <label for="harga_jual" class="col-sm-12 control-label">Harga Jual</label>
                                <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="text" class="form-control harga" id="harga_jual" name="harga_jual" placeholder="Contoh: 100.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                            </div>
                            <div class="form-group">
                                <label for="stok" class="col-sm-12 control-label">Stok</label>
                                <div class="col-sm-12 input-group w-100"><input type="number" class="form-control" id="stok" name="stok" placeholder="Contoh: 100" required><div class="input-group-append"><span class="input-group-text">pcs</span></div></div>
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

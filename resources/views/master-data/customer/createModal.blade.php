<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Pelanggan</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div class="form-group">
                                <label for="nama" class="col-sm-12 control-label">Nama Pelanggan</label>
                                <div class="col-sm-12"><input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Budi Rahman" required></div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-12 control-label">Email Address</label>
                                <div class="col-sm-12"><input type="email" class="form-control" id="email" name="email" placeholder="Contoh: budi@gmail.com" required></div>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin" class="col-sm-12 control-label">Jenis Kelamin</label>
                                <div class="col-sm-12 selectgroup w-100">
                                    <label class="selectgroup-item"><input type="radio" name="jenis_kelamin" value="Laki-laki" id="men" class="selectgroup-input" checked required><span class="selectgroup-button">Laki-laki</span></label>
                                    <label class="selectgroup-item"><input type="radio" name="jenis_kelamin" value="Perempuan" id="women" class="selectgroup-input"><span class="selectgroup-button">Perempuan</span></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="col-sm-12 control-label">Alamat</label>
                                <div class="col-sm-12"><textarea name="alamat" id="alamat" class="form-control" placeholder="Contoh: Baloi One Residence Blok B No. 11" rows="4" required></textarea></div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp" class="col-sm-12 control-label">Nomor HP</label>
                                <div class="col-sm-12"><input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required></div>
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

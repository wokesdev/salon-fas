<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Supplier</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div class="form-group">
                                <label for="kode" class="col-sm-12 control-label">Kode Supplier</label>
                                <div class="col-sm-12"><input type="text" class="form-control" id="kode" name="kode" required placeholder="Contoh: "></div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-12 control-label">Nama Supplier</label>
                                <div class="col-sm-12"><input type="text" class="form-control" id="name" name="name" required autocomplete="name" placeholder="Nama Lengkap"></div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-12 control-label">Email Address</label>
                                <div class="col-sm-12"><input type="email" class="form-control" id="email" name="email" value="" required autocomplete="email" placeholder="Email Address"></div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="col-sm-12 control-label">Jenis Kelamin</label>
                                <div class="col-sm-12 selectgroup w-100">
                                    <label class="selectgroup-item"><input type="radio" name="gender" value="Laki-laki" id="men" class="selectgroup-input" checked required><span class="selectgroup-button">Laki-laki</span></label>
                                    <label class="selectgroup-item"><input type="radio" name="gender" value="Perempuan" id="women" class="selectgroup-input"><span class="selectgroup-button">Perempuan</span></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address" class="col-sm-12 control-label">Alamat</label>
                                <div class="col-sm-12"><textarea name="address" id="address" class="form-control" required autocomplete="name" placeholder="Alamat" rows="4"></textarea></div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-12 control-label">Nomor HP</label>
                                <div class="col-sm-12"><input type="number" class="form-control" id="phone" name="phone" required autocomplete="phone" placeholder="08123456xxxx"></div>
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

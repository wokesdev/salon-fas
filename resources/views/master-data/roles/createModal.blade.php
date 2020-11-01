<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Tambah Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div id="dataFields">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12 control-label">Jabatan</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name" required autocomplete="name" placeholder="Nama Jabatan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-sm-12 control-label">Level</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="level" name="level" required autocomplete="level" required>
                                            <option value="" disabled selected>Pilih Level</option>
                                            <option value="1">1 - Mendapat akses penuh</option>
                                            <option value="2">2 - Hanya bisa mengakses menu transaksi</option>
                                            <option value="3">3 - Hanya bisa mengakses menu laporan</option>
                                        </select>
                                    </div>
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

<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Penerimaan Kas</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div class="form-group">
                                <label for="rincian_akun" class="col-sm-12 control-label">Akun</label>
                                <div class="col-sm-12">
                                    <select name="rincian_akun" id="rincian_akun" class="form-control" required>
                                        <option value="" disabled selected>Pilih Akun</option>
                                        @foreach ($accountDetails as $accountDetail)
                                            <option value="{{ $accountDetail->id }}">{{ $accountDetail->nomor_rincian_akun }} - {{ $accountDetail->nama_rincian_akun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jumlah" class="col-sm-12 control-label">Jumlah</label>
                                <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="text" class="form-control jumlah" id="jumlah" name="jumlah" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan" class="col-sm-12 control-label">Keterangan</label>
                                <div class="col-sm-12"><textarea name="keterangan" id="keterangan" class="form-control" placeholder="Contoh: investasi si budi" rows="4" required></textarea></div>
                            </div>
                            <div class="form-group">
                                <label for="tanggal" class="col-sm-12 control-label">Tanggal Penerimaan Kas</label>
                                <div class="col-sm-12"><input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Contoh: 11/03/2020" required></div>
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

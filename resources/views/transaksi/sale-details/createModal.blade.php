<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Rincian Penjualan</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div class="form-group">
                                <label for="purchase_id" class="col-sm-12 control-label">Penjualan</label>
                                <div class="col-sm-12">
                                    <select name="purchase_id" id="purchase_id" class="form-control" required>
                                        <option value="" disabled selected>Pilih Penjualan</option>
                                        @foreach ($sales as $sale)
                                            <option value="{{ $sale->id }}">{{ $sale->nomor_penjualan }} - {{ $sale->account_detail->nama_rincian_akun }} - {{ $sale->keterangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kuantitas" class="col-sm-12 control-label">Kuantitas</label>
                                <div class="col-sm-12"><input type="number" class="form-control" id="kuantitas" name="kuantitas" placeholder="Contoh: 5" required></div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-12 control-label">Harga Satuan</label>
                                <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="text" class="form-control price" id="price" name="price" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan" class="col-sm-12 control-label">Detail Keterangan</label>
                                <div class="col-sm-12"><textarea name="keterangan" id="keterangan" class="form-control" placeholder="Contoh: Kursi" rows="4" required></textarea></div>
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

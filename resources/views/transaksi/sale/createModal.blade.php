<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel" style="z-index: 2000;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Penjualan</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div id="mainFields" class="col-sm-6">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div id="saleFields">
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
                                    <label for="customer" class="col-sm-12 control-label">Pelanggan</label>
                                    <div class="col-sm-12">
                                        <select name="customer" id="customer" class="form-control" required>
                                            <option value="" disabled selected>Pilih Pelanggan</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->kode_pelanggan }} - {{ $customer->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-12 control-label">Tanggal Pembelian</label>
                                    <div class="col-sm-12"><input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Contoh: 11/03/2020" required></div>
                                </div>
                                <div class="form-group" id="totalFieldServis">
                                    <label for="totalServis" class="col-sm-12 control-label">Total Servis</label>
                                    <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control inputTotal" id="totalServis" name="total_servis" placeholder="0" readonly required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                                </div>
                                <div class="form-group" id="totalFieldBarang">
                                    <label for="totalBarang" class="col-sm-12 control-label">Total Barang</label>
                                    <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control inputTotal" id="totalBarang" name="total_barang" placeholder="0" readonly required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                                </div>
                                <div class="form-group" id="totalField">
                                    <label for="total" class="col-sm-12 control-label">Total</label>
                                    <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control total" id="total" name="total" placeholder="0" readonly required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                                </div>
                            </div>
                        </div>
                        <div id="detailFields" class="col-sm-6"></div>
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

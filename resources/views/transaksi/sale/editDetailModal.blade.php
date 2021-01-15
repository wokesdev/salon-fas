<div class="modal fade" id="editDetailModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="editDetailModalLabel" style="z-index: 1999;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Edit Rincian Pembelian</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="editDetailForm" name="editDetailForm" class="form-horizontal" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="detailId" id="detailId">
                            <input type="hidden" name="saleId" id="saleId">
                            <input type="hidden" name="currentSubtotalServis" id="currentSubtotalServis">
                            <input type="hidden" name="currentSubtotalBarang" id="currentSubtotalBarang">
                            <input type="hidden" name="currentStok" id="currentStok">
                            <input type="hidden" name="detailAction" id="detailAction" value="Add">
                            <div id="servisField">
                                <div class="form-group">
                                    <label for="detailServis" class="col-sm-12 control-label">Servis</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="detailServis" name="detailServis" required>
                                            <option value="" disabled selected>Pilih Servis</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="detailKuantitasServis" class="col-sm-12 control-label">Kuantitas</label>
                                    <div class="col-sm-12"><input type="number" class="form-control input" id="detailKuantitasServis" name="detailKuantitasServis" placeholder="Contoh: 5" required></div>
                                </div>
                                <div class="form-group">
                                    <label for="detailHargaSatuanServis" class="col-sm-12 control-label">Harga Satuan</label>
                                    <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control input" id="detailHargaSatuanServis" name="detailHargaSatuanServis" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                                </div>
                                <div class="form-group">
                                    <label for="detailSubtotalServis" class="col-sm-12 control-label">Subtotal</label>
                                    <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control" id="detailSubtotalServis" name="detailSubtotalServis" placeholder="0" required readonly><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                                </div>
                            </div>
                            <div id="barangField">
                                <div class="form-group">
                                    <label for="detailBarang" class="col-sm-12 control-label">Barang</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="detailBarang" name="detailBarang" required>
                                            <option value="" disabled selected>Pilih Barang</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="detailKuantitasBarang" class="col-sm-12 control-label">Kuantitas</label>
                                    <div class="col-sm-12"><input type="number" class="form-control input" id="detailKuantitasBarang" name="detailKuantitasBarang" placeholder="Contoh: 5" required></div>
                                </div>
                                <div class="form-group">
                                    <label for="detailHargaSatuanBarang" class="col-sm-12 control-label">Harga Satuan</label>
                                    <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control input" id="detailHargaSatuanBarang" name="detailHargaSatuanBarang" placeholder="Contoh: 50.000" required><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                                </div>
                                <div class="form-group">
                                    <label for="detailSubtotalBarang" class="col-sm-12 control-label">Subtotal</label>
                                    <div class="col-sm-12 input-group w-100"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" class="form-control" id="detailSubtotalBarang" name="detailSubtotalBarang" placeholder="0" required readonly><div class="input-group-append"><span class="input-group-text">,00</span></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="editDetailButton" value="Add" form="editDetailForm">Edit</button>
            </div>
        </div>
    </div>
</div>

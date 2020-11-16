<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel" style="z-index: 2000;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Tambah Pembelian</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="addEditForm" name="addEditForm" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div id="mainFields" class="col-sm-6">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="action" id="action" value="Add">
                            <div id="purchaseFields">
                                <div class="form-group">
                                    <label for="account_detail_id" class="col-sm-12 control-label">Akun</label>
                                    <div class="col-sm-12">
                                        <select name="account_detail_id" id="account_detail_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Akun</option>
                                            @foreach ($accountDetails as $accountDetail)
                                                <option value="{{ $accountDetail->id }}">{{ $accountDetail->nomor_rincian_akun }} - {{ $accountDetail->nama_rincian_akun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="supplier_id" class="col-sm-12 control-label">Supplier</label>
                                    <div class="col-sm-12">
                                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->code }} - {{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal" class="col-sm-12 control-label">Tanggal Pembelian</label>
                                    <div class="col-sm-12"><input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Contoh: 11/03/2020" required></div>
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

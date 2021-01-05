<div class="modal fade" id="chooseModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="chooseModalLabel" style="z-index: 2000;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Pilih Rincian Akun</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="chooseButton" value="Choose" form="chooseForm">Pilih</button>
            </div>
        </div>
    </div>
</div>

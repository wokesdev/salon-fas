<div class="modal fade" id="importModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="titleModal">Import Excel</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <form id="importForm" name="importForm" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="import" class="col-sm-12 control-label">File Excel</label>
                                <div class="col-sm-12"><input type="file" class="form-control" id="import" name="import" required></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="importSubmitButton" value="Add" form="importForm">Import</button>
            </div>
        </div>
    </div>
</div>

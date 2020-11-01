<div class="modal fade" id="addEditModal" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="addEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Tambah Admin</h5>
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
                                    <label for="name" class="col-sm-12 control-label">Nama</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name" required autocomplete="name" placeholder="Nama Lengkap">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="col-sm-12 control-label">Username</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="username" name="username" value="" required autocomplete="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-12 control-label">Email Address</label>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" id="email" name="email" value="" required autocomplete="email" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="col-sm-12 control-label">Jabatan</label>
                                    <div class="col-sm-12">
                                        <select name="role" id="role" class="form-control" required autocomplete="role">
                                            <option value="" disabled selected>Pilih Jabatan</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="passwordFields">
                                <div class="form-group">
                                    <label for="password" class="col-sm-12 control-label" id="label-password">Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" id="password" name="password"  required autocomplete="new-password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm" class="col-sm-12 control-label" id="label-confirm-password">Confirm Password</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter Password">
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

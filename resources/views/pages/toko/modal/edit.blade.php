<div class="modal fade text-left modal-borderless" id="toko_edit" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Toko</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <section>
                <form id="Addform">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Kode Toko</label>
                                        <input type="text" id="kd_toko_edit" name="kd_toko_edit" class="form-control" placeholder="Enter Kode Toko">
                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            This is valid state.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Toko</label>
                                        <input type="text" id="nm_toko_edit" name="nm_toko_edit" class="form-control" placeholder="Enter Nama Toko">
                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            This is valid state.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat_edit" name="alamat_edit" rows="3"></textarea>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" id="username_edit" name="username_edit" class="form-control" placeholder="Enter Username">
                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            This is valid state.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" id="password_edit" name="password_edit" class="form-control" placeholder="Enter Password">
                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            This is valid state.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" id="swal-update-button" class="btn btn-primary me-1 mb-1">
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

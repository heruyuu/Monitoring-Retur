<div class="modal fade text-left modal-borderless" id="produk_create" data-backdrop="static" data-keyword="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Add Produk</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <section>
                <form id="Addform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Plu</label>
                                        <input type="text" id="plu" name="plu" class="form-control" placeholder="Enter Plu">
                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            This is valid state.
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <input type="text" id="nm_produk" name="nm_produk" class="form-control" placeholder="Enter Nama Produk">
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
                        <button type="submit" class="btn btn-primary me-1 mb-1">
                            <span class="d-none d-sm-block">Save</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>


@extends('module.layout')
@section('title', 'Data Retur')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Retur</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Retur</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <form id="Addform">
        @csrf
        <section id="horizontal-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Buat Retur
                            <button type="submit" class="btn btn-primary float-end">
                                <i class="fa fa-file"></i> Save
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-2 col-3">
                                            <label class="col-form-label">No. Faktur</label>
                                        </div>
                                        <div class="col-lg-10 col-9">
                                            <input type="text" id="no_faktur" class="form-control" name="no_faktur" placeholder="Enter No Faktur">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-2 col-3">
                                            <label class="col-form-label">Tgl Faktur</label>
                                        </div>
                                        <div class="col-lg-10 col-9">
                                            <input type="date" id="tgl_faktur" class="form-control" name="tgl_faktur" placeholder="Enter Tanggal Faktur">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-2 col-3">
                                            <label class="col-form-label">Tgl Tiba</label>
                                        </div>
                                        <div class="col-lg-10 col-9">
                                            <input type="date" id="tgl_tiba" class="form-control" name="tgl_tiba" placeholder="Enter Tanggal Tiba">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-2 col-3">
                                            <label class="col-form-label">Pejabat</label>
                                        </div>
                                        <div class="col-lg-10 col-9">
                                            <input type="text" id="pejabat" class="form-control" name="pejabat" placeholder="Enter Pejabat">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-2 col-3">
                                            <label class="col-form-label">No Plat / Mu</label>
                                        </div>
                                        <div class="col-lg-10 col-9">
                                            <input type="text" id="no_plat_mu" class="form-control" name="no_plat_mu" placeholder="Enter No Plat">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="btn_add_temp" class="btn btn-success" onclick="add_temp(0)">
                                <i class="fa fa-plus"></i> Add Item
                            </button>
                            <hr>
                            <div class="table-responsive">
                                <table id="Dtable" class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>-</th>
                                            <th>Plu / Produk</th>
                                            <th>Qty Dalam Cont</th>
                                            <th>BTA</th>
                                            <th>SB</th>
                                            <th>Bl</th>
                                            <th>Bk</th>
                                            <th>BNF</th>
                                            <th>BRP</th>
                                            <th>Ket / Plu SB</th>
                                        </tr>
                                    </thead>
                                    <tbody id="temp_item_retur">
                                        <tr>
                                            <td colspan="10" class="text-center">Data Belum Ada</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
@push('js_internal')
    @include('pages.retur.script')
@endpush

@extends('module.layout')
@section('title','Data User')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data User</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <br>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Detail User
                    <button type="button" class="btn btn-light-primary float-end" data-bs-toggle="modal" data-bs-backdrop="false" data-bs-target="#user_create">
                        <i class="fa fa-plus"></i> Add
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="Dtable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js_internal')
    @include('pages.user.modal.create')
    @include('pages.user.modal.edit')
    @include('pages.user.script')
@endpush

@extends('module.layout')
@section('title','Dashboard')
@section('content')
    @php
        $label = ['Belum Dilihat', 'Sudah Selesai', 'Diterima', 'Ditolak'];
        $icon = ['fa fa-eye', 'fa fa-check', 'fa fa-bookmark', 'fa fa-eject'];
        $color = ['stats-icon purple', 'stats-icon blue', 'stats-icon green', 'stats-icon red'];
    @endphp
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="alert alert-info alert-styled-left alert-arrow-left alert-component">
                <h6 class="alert-heading text-semibold" id="greeting"></h6>
                {{ auth()->user()->name }}
            </div>
        </div>
        <div class="row">
            @foreach ($label as $key => $item)
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-white text-semibold {{ $color[$key] }}">
                                        <i class="{{ $icon[$key] }}"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">{{ $item }}</h6>
                                    <h6 class="font-extrabold mb-0">{{ $data[$item] }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="Dtable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal / Jam</th>
                                <th>Nama Toko</th>
                                <th>No Faktur</th>
                                <th>Tanggal Faktur</th>
                                <th>Tanggal Tiba</th>
                                <th>Pejabat</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js_internal')
    @include('pages.dashboard.modal.show')
    @include('pages.dashboard.script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#greeting').html(greeting());
        });
    </script>
@endpush

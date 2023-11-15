<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Tooken -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '') {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dataTable-bootstrap4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dataTable-bootstrap4/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/load.css') }}">
    {{-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon"> --}}
</head>

<body>
    <!-- Loader Start -->
    <div id="preloader">
        <div id="status">
            <div class="logo">
                <img src="{{ asset('assets/vendors/svg-loaders/audio.svg') }}" alt="audio">
            </div>

        </div>
    </div>
    <!-- Loader End -->
    <div id="app">
        @include('module.sidebar')
        <div id="main" class='layout-navbar'>
            @include('module.header')
            <div id="main-content">
                @yield('content')
                @include('module.footer')
            </div>
        </div>
    </div>

    <div class="modal fade text-left w-100" id="gantipas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" id="modal-size">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white" id="modal-title"></h4>
                    <button type="button" id="btn-close-modal" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i> X
                    </button>
                </div>
                <div class="modal-body" id="modal-body"></div>
                <div class="modal-footer" id="modal-footer"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dataTable-bootstrap4/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dataTable-bootstrap4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dataTable-bootstrap4/js/dataTables.responsive.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dataTable-bootstrap4/js/responsive.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dataTable-bootstrap4/js/moment.min.js') }}"></script>
    @stack('js_internal')
    @stack('js_eksternal')
    <script type="text/javascript">
        var tokenCSRF = jQuery('meta[name="csrf-token"]').attr('content');
        var url_link = "{{ asset('/') }}";
        $(document).ready(function() {
            $('#preloader').show();
        });

        function out_load() {
            $('#preloader').hide();
        }

        function in_load() {
            $('#preloader').show();
        }

        function error_detail(error) {
            console.log(error);
            if(error.responseJSON.status == 'warning') {
                Swal.fire('warning',''+error.responseJSON.messages+'', 'warning');
                return false;
            } else if(error.responseJSON.status == 'error') {
                Swal.fire('Error',''+error.responseJSON.messages+'', 'error');
                return false;
            } else {
                Swal.fire(''+error.status+'', ''+error.responseJSON.messages+'', 'error');
                return false;
            }
        }
    </script>
    <script type="text/javascript">
        $(function() {
            $('#preloader').hide();
            get_status();
            setInterval('get_status()', 5000);
        });

        function get_status() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ asset('/realtime_update_status') }}",
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    out_load();
                }
            });
        }

        // Update Password
        function ganti_pass() {
            $('#modal-title').html('Ganti Password');
            $('#modal-size').attr('class', 'modal-dialog');
            $('#modal-body').html('<form id="Gpas">'
                +'<div class="form-group">'
                    +'<label class="col-form-label">Password</label>'
                    +'<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">'
                +'</div>'
            +'</form>');
            $('#modal-footer').html('<button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">'
                                +'<i class="bx bx-x d-block d-sm-none"></i>'
                                +'<span class="d-none d-sm-block">Close</span>'
                            +'</button>'
                            +"<button type='button' onclick=\"$('#Gpas').submit()\" class='btn btn-primary me-1 mb-1'>"
                                +'<span class="d-none d-sm-block">Save</span>'
                            +'</button>');
            $('#gantipas').modal('show');

            $('#Gpas').on('submit', function(e) {
                e.preventDefault();
                idata = new FormData($('#Gpas')[0]);
                idata.append('_token',tokenCSRF);
                idata.append('_method','PUT');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ asset('/setSetting') }}",
                    data: idata,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        in_load();
                    },
                    success: function(data) {
                        Swal.fire(''+data.status+'',''+data.messages+'','success').then((value) => {
                            window.location.reload();
                        });
                        $('#gantipas').modal('hide');
                        out_load();
                    },
                    error: function(error) {
                        error_detail(error);
                        out_load();
                    }
                });
            });
        }
      </script>
    @yield('custom_js','')
</body>
</html>

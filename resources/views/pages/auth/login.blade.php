<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/load.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
</head>

<body>
    <!-- Loader Start -->
    <div id="preloader">
        <div id="status">
            <div class="logo">
                <img src="{{ asset('assets/vendors/svg-loaders/audio.svg') }}" class="center" alt="audio">
            </div>
        </div>
    </div>
    <!-- Loader End -->
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                    <form id="data_form" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" id="username" class="form-control form-control-xl" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" id="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>

                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript">
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
                Swal.fire('Warning',''+error.responseJSON.messages+'', 'warning');
                return false;
            } else if(error.responseJSON.status == 'error') {
                Swal.fire('Error',''+error.responseJSON.messages+'', 'error');
                return false;
            } else {
                Swal.fire(''+error.status+'', ''+error.responseJSON.messages+'', 'error');
                return false;
            }
        }

        setInterval(function() {
            $('#preloader').hide();
        }, 500);

        $('#data_form').on('submit', function(e) {
            e.preventDefault();
            idata = new FormData($('#data_form')[0]);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ asset('login') }}",
                data: idata,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    in_load();
                },
                success: function(data) {
                    Swal.fire(''+data.status+'', ''+data.messages+'', "success").then((value) => {
                        window.location.href="{{ asset('/') }}";
                    });
                    out_load();
                },
                error: function(error) {
                    error_detail(error);
                    out_load();
                }
            });
        });
    </script>
</body>

</html>

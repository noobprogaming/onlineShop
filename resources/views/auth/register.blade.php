@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card pb-5" style="background-color: #F0F0F0">
                <div class="card-body py-5">

                    <div class="text-center mb-5">
                        <h4>Register</h4>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" placeholder="Nama" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata Sandi"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-login w-100">
                                    Register
                                </button>
                            </div>
                        </div>
                        
                        <script>
                            $.ajax({
                                type: "GET",
                                url: "{{  route('getprovince') }}",
                                beforeSend: function () {
                                    //console.log("loading");
                                    //$("#tes").val("loading");
                                },
                                success: function (data) {
                                    //console.log(data);
                                    $("#province").html(data);
                                },
                            });

                            $('#province').change(function () {

                                //Mengambil value dari option select province kemudian parameternya dikirim menggunakan ajax 
                                var province_id = $('#province').val();

                                $.ajax({
                                    type: "GET",
                                    url: "{{ route('getcity') }}",
                                    data: "province_id=" + province_id,
                                    beforeSend: function () {
                                        //console.log("loading");
                                        //$("#tes").val("loading");
                                    },
                                    success: function (data) {
                                        //console.log(data);
                                        $("#city").html(data);
                                    },
                                });
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

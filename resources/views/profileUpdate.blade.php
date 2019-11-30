@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">

                        <div class="col-md-3 my-3">
                            <div class="card">
                                <img class="card-img-top w-100"
                                    src="{{ asset('data_file/'.$usr[0]['id'].'_profile') }}">
                                <div class="card-body">
                                    <p class="card-text">{{ $usr[0]['name'] }}</p>
                                    <p class="card-text">{{ $usr[0]['email'] }}</p>
                                    <p class="card-text">{{ $usr[0]['phone_number'] }}</p>
                                    <p class="card-text">
                                        {{ $usr[0]['address'] }}
                                        {{ $usr[0]['district'] }}
                                        {{ $usr[0]['city_name'] }}
                                        {{ $usr[0]['province_name'] }}
                                        {{ $usr[0]['postal_code'] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('setProfileUpdate', [$usr[0]['id']]) }}" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="photo_profile"
                                    class="col-md-4 col-form-label text-md-right">{{ __('photo_profile') }}</label>

                                <div class="col-md-6">

                                    <input id="photo_profile" @error('photo_profile') is-invalid @enderror type="file"
                                        name="photo_profile">

                                    @error('photo_profile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $usr[0]['name'] }}" required autocomplete="name" >

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('name') is-invalid @enderror" name="email"
                                        value="{{ $usr[0]['email'] }}" required autocomplete="email" >

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone_number"
                                    class="col-md-4 col-form-label text-md-right">{{ __('phone_number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone_number" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="phone_number"
                                        value="{{ $usr[0]['phone_number'] }}" required autocomplete="phone_number"
                                        >

                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password" >

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="btnUpdateProfile" type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>

                        </form>


                        <form>
                            <div>
                                <div class="form-group row">
                                    <label for="province_id"
                                        class="col-md-4 col-form-label text-md-right">{{ __('province_id') }}</label>

                                    <div class="col-md-8">

                                        <select id="province"
                                            class="form-control @error('province_id') is-invalid @enderror"
                                            name="province_id">
                                        </select>

                                        @error('province_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="city_id"
                                        class="col-md-4 col-form-label text-md-right">{{ __('city_id') }}</label>

                                    <div class="col-md-8">
                                        <select id="city" name="city_id"
                                            class="form-control @error('city_id') is-invalid @enderror">
                                        </select>

                                        @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="postal_code"
                                        class="col-md-4 col-form-label text-md-right">{{ __('postal_code') }}</label>

                                    <div class="col-md-8">
                                        <select id="postal" name="postal_code"
                                            class="form-control @error('postal_code') is-invalid @enderror">
                                        </select>

                                        @error('postal_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="urban"
                                        class="col-md-4 col-form-label text-md-right">{{ __('urban') }}</label>

                                    <div class="col-md-8">
                                        <select id="urban" name="urban"
                                            class="form-control @error('urban') is-invalid @enderror">
                                        </select>

                                        @error('urban')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address"
                                        class="col-md-4 col-form-label text-md-right">{{ __('address') }}</label>

                                    <div class="col-md-8">
                                        <input id="address" type="text"
                                            class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Rumah putih, No. 10, RT01/RW01"
                                            value="{{ $usr[0]['address'] }}" autocomplete="address" >

                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#password-confirm').on('keyup', function () {
            var password = $('#password').val();
            var passwordConfirm = $('#password-confirm').val();

            if (password != passwordConfirm) {
                document.getElementById("btnUpdateProfile").disabled = true;
            } else {
                document.getElementById("btnUpdateProfile").disabled = false;
            }
        })

        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: "{{  route('getprovinceLocal') }}",
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#province").html(data);
                    document.getElementsById("alamat").setAttribute("selectBoxOptions",
                        "democlass");
                },
            });
        });

        $('#province').change(function () {
            //Mengambil value dari option select province kemudian parameternya dikirim menggunakan ajax 
            var province_id = $('#province').val();

            $.ajax({
                type: "GET",
                url: "{{ route('getcityLocal') }}",
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

        $('#city').change(function () {
            //Mengambil value dari option select province kemudian parameternya dikirim menggunakan ajax 
            var city_name = document.getElementById("city").options[this.selectedIndex].innerHTML;

            $.ajax({
                type: "GET",
                url: "{{ route('getPostalLocal') }}",
                data: "city_name=" + city_name,
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#postal").html(data);
                },
            });
        });

        $('#postal').change(function () {
            //Mengambil value dari option select province kemudian parameternya dikirim menggunakan ajax 
            var postal_code = $('#postal').val();

            $.ajax({
                type: "GET",
                url: "{{ route('getUrbanLocal') }}",
                data: "postal_code=" + postal_code,
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#urban").html(data);
                },
            });
        });

    </script>
    @endsection

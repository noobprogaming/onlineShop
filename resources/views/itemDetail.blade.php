@extends('layouts.app')

@section('content')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">Detail</div>
                        <div class="col text-right">
                            @if ($usr_seller[0]['id'] == Auth::user()->id || empty(Auth::user()->id))
                            <div class="tap" onclick="getUpdateItem()">
                                <kbd>Update</kbd>
                                <i class="fa fa-edit"></i>
                            </div>
                            <script>
                                function getUpdateItem() {
                                    window.location.assign("{{ route('updateItem', [$usr_seller[0]['item_id']]) }}");
                                }

                            </script>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">

                        <div>
                            <img class="card-img-top w-25"
                                src="{{ asset('data_file/'.$usr_seller[0]['item_id'].'_a') }}">
                            <img class="card-img-top w-25"
                                src="{{ asset('data_file/'.$usr_seller[0]['item_id'].'_b') }}">
                            <div class="card-body">
                                <h4 class="card-title">{{ $usr_seller[0]['name'] }}</h4>
                                <p class="card-text">Stok:
                                    @if ($usr_seller[0]['stock'] >= 100)
                                    >100
                                    @elseif ($usr_seller[0]['stock'] >= 50)
                                    >50
                                    @elseif ($usr_seller[0]['stock'] >= 10)
                                    >10
                                    @else
                                    {{ $usr_seller[0]['stock'] }}
                                    @endif
                                </p>
                                <p class="card-text">Berat: {{ $usr_seller[0]['weight'] }} gram</p>
                                <p class="card-text">
                                    @if (!empty($usr_seller[0]['description']))
                                    {{ $usr_seller[0]['description'] }}
                                    @else
                                    {{ "No description" }}
                                    @endif
                                </p>
                                <p class="card-text">Harga:
                                    Rp{{ number_format($usr_seller[0]['selling_price']),2,',','.' }}
                                </p>

                                @if ($usr_seller[0]['id'] == Auth::user()->id || empty(Auth::user()->id))

                                <div class="value-button" id="decrease">-</div>
                                <input id="number" value="1">
                                <div class="value-button" id="increase">+</div>
                                <button class="btn btn-primary" disabled>Tambahkan ke cart</button>

                                @else
                                <div class="value-button" id="decrease" onclick="decreaseValue()"
                                    value="Decrease Value">-</div>
                                <input id="number" type="number" class=" @error('amount') is-invalid @enderror"
                                    name="amount" value="1" required>
                                <div class="value-button" id="increase" onclick="increaseValue()"
                                    value="Increase Value">+</div>

                                <button type="submit" class="btn btn-primary" onclick="addItem(
                                    {{ $usr_seller[0]['seller_id'].', '. $usr_seller[0]['item_id'] }}
                                )">Tambahkan ke
                                    keranjang</button>

                                @endif

                                <div id="ongkir"></div>

                            </div>
                        </div>

                        <div>
                            <div class="card-body">
                                <h4 class="card-title">Penilaian Produk</h4>
                                @foreach ($rating as $n)

                                @if (!empty($n['rating']))
                                <p class="card-text">Review:<br>
                                    @for ($i = 0; $i < $n['rating']; $i++) <i class="fa fa-star yellow"></i>
                                        @endfor
                                        @for ($i = 0; $i < (5-$n['rating']); $i++) <i class="fa fa-star lightGrey"></i>
                                            @endfor
                                            <br>
                                            {{ $n['review'] }}
                                </p>
                                <p class="card-text">{{ date('D, d-m-Y', strtotime($n['time'])) }}</p>
                                @else
                                Belum ada penilaian
                                @endif

                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Profil Pelapak</div>

                <div class="card-body tap" onclick="getProfilePelapak({{ $usr_seller[0]['id'] }})">
                    <img class="card-img-top img-thumbnail rounded-circle w-25"
                        src="{{ asset('data_file/'.$usr_seller[0]['id'].'_profile') }}">
                    <h4 class="card-title">{{ $usr_seller[0]['seller'] }}</h4>
                    <p class="card-text">
                        <div id="city">
                            {{ $usr_seller[0]['city_name'] }}
                        </div>

                        <div id="province">
                            {{ $usr_seller[0]['province_name'] }}
                        </div>
                    </p>
                    <hr>
                    <p class="card-text">
                        Rating Lapak <br>

                        @if (!empty($ratingLapak[0]['ratingLapak']))
                        @for ($i = 0; $i < ($ratingLapak[0]['ratingLapak']-1); $i++) <i class="fa fa-star yellow"></i>
                            @endfor
                            @if(substr(($ratingLapak[0]['ratingLapak']-0.001), 2) >= 0.5)
                            <i class="fa fa-star yellow"></i>
                            @else
                            <i class="fa fa-star-half yellow"></i>
                            @endif

                            {{ $ratingLapak[0]['ratingLapak'] }}
                            @else
                            Belum ada penilaian
                            @endif


                    </p>
                </div>

            </div>


    <script>
        /* Amount */
        function increaseValue() {
            if (document.getElementById('number').value >= {
                    {
                        $usr_seller[0]['stock']
                    }
                }) {
                alert('Stok tidak mencukupi');
            } else {
                var value = parseInt(document.getElementById('number').value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                document.getElementById('number').value = value;
            }
        }

        function decreaseValue() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            value < 1 ? value = 1 : '';
            value--;
            document.getElementById('number').value = value;
        }

        $('#number').on('input', function (e) {
            if (document.getElementById('number').value > {
                    {
                        $usr_seller[0]['stock']
                    }
                }) {
                alert('Stok tidak mencukupi');
                document.getElementById('number').value = {
                    {
                        $usr_seller[0]['stock']
                    }
                };
            }
        });
        /**/

        getOngkir();

        function getOngkir() {
            var origin = "{{ $usr_seller[0]['city_id'] }}";
            var dst = "{{ $usr_buyer[0]['city_id'] }}";
            //var courier = $('#kurir').val();
            var weight = "{{ $usr_seller[0]['weight'] }}";

            $.ajax({
                type: "GET",
                url: "{{  route('checkshipping') }}",
                data: {
                    'dst': dst,
                    'courier': 'pos',
                    'origin': origin,
                    'weight': weight,
                },
                beforeSend: function () {
                    $('#ongkir').html("loading...");
                },
                success: function (data) {
                    $('#ongkir').html(data);
                },
            });
        }
    </script>

    @endsection

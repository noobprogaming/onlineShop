@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">Detail</div>
                        <div class="col text-right">
                            @if ($usr_seller[0]['id'] == Auth::user()->id || empty(Auth::user()->id))
                            <div class="tap" onclick="gotoUpdateItem()">
                                <kbd>Update</kbd>
                                <i class="fa fa-edit"></i>
                            </div>
                            <script>
                                function gotoUpdateItem() {
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
                                <p class="card-text">Stok: {{ $usr_seller[0]['stock'] }}</p>
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

                                <form id="formTambahkan">

                                    {{ csrf_field() }}

                                    <input type="hidden" class="@error('seller_id') is-invalid @enderror"
                                        name="seller_id" value="{{ $usr_seller[0]['seller_id'] }}" required>
                                    <input type="hidden" class="@error('item_id') is-invalid @enderror" name="item_id"
                                        value="{{ $usr_seller[0]['item_id'] }}" required>
                                    <div class="value-button" id="decrease" onclick="decreaseValue()"
                                        value="Decrease Value">-</div>
                                    <input id="number" type="number" class=" @error('amount') is-invalid @enderror"
                                        name="amount" value="1" required>
                                    <div class="value-button" id="increase" onclick="increaseValue()"
                                        value="Increase Value">+</div>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </form>

                                <button type="submit" class="btn btn-primary" onclick="addItem()">Tambahkan ke
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
                                    @for ($i = 0; $i < $n['rating']; $i++) <i class="fa fa-star"></i>
                                        @endfor
                                        <br>
                                        {{ $n['review'] }}
                                </p>
                                <p class="card-text">{{ $n['time'] }}</p>
                                @else
                                Belum ada penilaian
                                @endif

                                @endforeach

                            </div>
                        </div>


                        <i class="fa fa-shopping-cart" data-toggle="modal" data-target="#cartModal"
                            id="btnCartList"></i>
                        <div id="cartCount"></div>

                        <div class="modal fade" id="cartModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Keranjang</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="cartList"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href={{ route('pay') }} class="btn btn-primary">Bayar</a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Profil Pelapak</div>

                <div class="card-body">

                </div>

                <div class="card-body">
                    <div>
                        <div class="card-body tap" onclick="gotoProfilePelapak()">
                            <h4 class="card-title">{{ $usr_seller[0]['seller'] }}</h4>
                            <p class="card-text">
                                <div id="city">
                                    {{ $usr_seller[0]['city_name'] }}
                                </div>

                                <div id="province">
                                    {{ $usr_seller[0]['province_name'] }}
                                </div>
                            </p>
                            <p class="card-text">rating pelapak</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        //getCartCount
        $("#cartCount").load("{{ route('cartCount') }}");

        //getCartList
        $("#btnCartList").click(function () {
            $("#cartList").load("{{ route('cartList') }}");
        });

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
                    'courier': 'jne',
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

        function getCartList() {
            $("#cartList").load("{{ route('cartList') }}");
        }

        function addItem() {
            $.ajax({
                type: "POST",
                url: "{{ route('storeCart') }}",
                data: $('#formTambahkan').serialize(),
            }).done(function () {
                alert("Barang telah ditambahkan!")
                $("#cartCount").load("{{ route('cartCount') }}");
            });
        }

        function deleteItem(itemId) {
            $.ajax({
                type: "GET",
                url: "/deleteCart/" + itemId,
            }).done(function () {
                alert("Barang telah dihapus!")
                $("#cartCount").load("{{ route('cartCount') }}");
                getCartList();
            });
        }

        function gotoProfilePelapak() {
            window.location.assign("{{ route('profile', [$usr_seller[0]['id']]) }}");
        }
    </script>

    @endsection

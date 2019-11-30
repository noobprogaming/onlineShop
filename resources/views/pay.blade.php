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

                        <div>
                            <div class="card-body">Penerima
                                <h4 class="card-title">{{ $usr_buyer[0]['name'] }}</h4>
                                <p class="card-text">{{ $usr_buyer[0]['phone_number'] }}</p>
                                <p class="card-text">
                                    {{ $usr_buyer[0]['address'] }}
                                    {{ $usr_buyer[0]['district'] }}
                                    <div id="city2">{{ $usr_buyer[0]['city_name'] }}</div>
                                    <div id="province2">{{ $usr_buyer[0]['province_name'] }}</div>
                                    {{ $usr_buyer[0]['postal_code'] }}
                                </p>
                            </div>
                        </div>

                    </div>

                        <button class="btn btn-primary" data-toggle="modal" data-target="#payModal"
                            id="btnCartList">Bayar</button>

                        <div class="modal fade" id="payModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Pembayaran</h4>
                                    </div>
                                    <div class="modal-body">
                                        Transfer ke<br>
                                        538 - Bank Muamalat Indonesia<br><br>

                                        No. Rekening: 5380004149<br>
                                        Nama: Alvin Bintang Rebrastya<br><br>

                                        Nominal (pengurangan kode unik = 3)<br>
                                            Rp99.997
                                    </div>
                                    <div class="modal-footer">
                                        <a href="" class="btn btn-primary">Upload bukti pembayaran</a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="row">
                        <div id="payCartList"></div>
                        {{-- <div id="ongkir"></div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        //getCartList
        $("#payCartList").load("{{ route('payCartList') }}");

        function getPayCartList() {
            $("#payCartList").load("{{ route('payCartList') }}");
        }

        function deleteItem(itemId) {
            $.ajax({
                type: "GET",
                url: "/deleteCart/" + itemId,
            }).done(function () {
                alert("Barang telah dihapus!")
                $("#cartCount").load("{{ route('cartCount') }}");
                getPayCartList();
            });
        }

    </script>

    @endsection

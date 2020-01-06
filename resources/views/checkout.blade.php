@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<section class="cart_area col-md-12">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                @if ($status['confirm_id'] == 1)
                {{-- Status: <h5>Belum bayar</h5> --}}
                @elseif ($status['confirm_id'] == 2)
                Status: <h5>Pembayaran sedang diproses</h5>
                @elseif ($status['confirm_id'] == 3)
                Status: <h5>Sedang diproses pelapak</h5>
                @elseif ($status['confirm_id'] == 4)
                Status: <h5>Pesanan sedang dalam pengiriman</h5><br>
                Resi: {{ $status['resi'] }}
                @elseif ($status['confirm_id'] == 5)
                Status: <h5>Pelapak melakukan komplain</h5>
                @elseif ($status['confirm_id'] == 6)
                Status: <h5>Pesanan selesai</h5>
                @elseif ($status['confirm_id'] == 7)
                Status: <h5>Dibatalkan oleh pembeli</h5>
                @elseif ($status['confirm_id'] == 8)
                Status: <h5>Dibatalkan oleh penjual</h5>
                @endif
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Qty</th>
                            <th scope="col" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total_price = 0;
                        $total_weight = 0;
                        @endphp
                        @foreach($cartList as $j)
                        @if($cartSeller[0]['seller'] == $j['seller'])

                        <tr>
                            <td>
                                <div class="media">
                                    <div class="d-flex">
                                        <img class="img-checkout" src="{{ asset('data_file/'.$j['item_id'].'_a') }}"
                                            alt="" />
                                    </div>
                                    <div class="media-body">
                                        <p class="tap" onclick="getItemDetail({{ $j['item_id'] }})">{{ $j['name'] }}</p>
                                        @if ($status['confirm_id'] == 1)
                                        <i class="fa fa-trash lightGrey" onclick="deleteItem({{ $j['item_id'] }})"></i>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>Rp{{ number_format($j['selling_price']) }}</h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    {{ $j['amount'] }}
                                </div>
                            </td>
                            <td class="text-right">
                                <h5>Rp{{ number_format($j['selling_price']*$j['amount']) }}</h5>
                            </td>
                        </tr>


                        @php
                        $total_price+=$j['selling_price']*$j['amount'];
                        $total_weight+=$j['weight']*$j['amount'];
                        @endphp
                        @endif
                        @endforeach

                        <tr>
                            <td>
                                @if ($status['confirm_id'] == 1)
                                <input id="note" type='text' class="form-control" placeholder="Catatan" name='note'>
                                @else
                                Catatan: {{ $status['note'] }}
                                @endif
                            </td>
                            <td></td>
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5 class="text-right">Rp{{ number_format(($total_price)) }}</h5>
                            </td>
                        </tr>
                        <tr class="shipping_area">
                            <td style="vertical-align: top">
                                <div class="card-body">Pengirim
                                    <h4 class="card-title">{{ $cartSeller[0]['seller'] }}</h4>
                                    <p class="card-text">{{ $cartSeller[0]['city_name'] }}</p>
                                    <p class="card-text">{{ $cartSeller[0]['province_name'] }}</p>
                                </div>
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <h5 style="margin-top: 12px">Ekspedisi</h5>
                            </td>
                            <td style="vertical-align: top">
                                <div class="shipping_box">
                                    <ul class="list">
                                        @if ($status['confirm_id'] == 1)
                                        <div id="ongkir"></div>
                                        @else
                                        <p class="mt-2">Rp{{ number_format($status['shipping_price']) }}</p>
                                        @endif
                                    </ul>
                                    <h6>
                                    </h6>
                                </div>
                            </td>
                        </tr>
                        <tr class="out_button_area text-right">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="checkout_btn_inner">
                                    @if ($status['confirm_id'] == 1)
                                    <a class="gray_btn" href="{{ route('home') }}">Belanja lagi</a>
                                    <button class="main_btn"
                                        onclick="storePayment({{ $cartSeller[0]['seller_id'] }}, {{ $total_price }})">Checkout</button>

                                    <div class="modal fade" id="detailTransactionModal">
                                        <div class="modal-dialog">
                                            <form action="{{ route('storeTransaction') }}" method="post"
                                            enctype="multipart/form-data">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Pembayaran</h4>
                                                </div>
                                                <div class="modal-body text-left">
                                                    <div id="detailTransaction"></div>
                                                    <div>
                                                        {{-- <img class="card-img-top w-100"
                                                            src="{{ asset('data_file/'.Request::Segment(2).'_trx') }}"> --}}
                                                        
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="purchase_id"
                                                                value="{{ Request::Segment(2) }}">

                                                            <input type="file" name="file_transaction">

                                                            {{-- <button type="submit" class="btn btn-primary">
                                                                Upload
                                                            </button> --}}

                                                        
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>
                                                        Upload bukti pembayaran</button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <button class="btn btn-sm btn-secondary" disabled>Proceed to checkout</button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    $("#detailTransaction").load("{{ route('detailTransaction', Request::segment(2)) }}");
    // $("#detailTransactionModal").modal("show");

    var origin = "{{ $cartSeller[0]['city_id'] }}";
    var dst = "{{ $usr_buyer[0]['city_id'] }}";
    //var courier = $('#kurir').val();
    var weight = "{{ $total_weight }}";

    $.ajax({
        type: "GET",
        url: "{{ route('checkshipping') }}",
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

    function storePayment(seller_id, total_price) {
        var note = document.getElementById('note').value;
        var shipping_price = document.getElementById('shipping').value;

        $.ajax({
            type: "POST",
            url: "{{ route('storePayment') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "seller_id": seller_id,
                "total_price": total_price,
                "shipping_price": shipping_price,
                "note": note,
            }
        }).done(function () {
            $("#detailTransaction").load("{{ route('detailTransaction', Request::segment(2)) }}");
            $('#detailTransactionModal').modal('show');
        });
    }

</script>

@endsection

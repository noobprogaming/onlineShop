@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-5">

                    <div class="text-center mb-5">
                        <h4>Transaksi</h4>
                    </div>

                    <div class="col-lg-12">
                        <div class="mx-3">
                            <h5>Pembelian</h5>
                            @foreach($usr_buyer as $n)
                            <div class="order_box mb-2">
                                <div class="row">
                                    <div class="col text-left">
                                        <h2 class="tap"
                                            onclick="getCheckout({{ $n['purchase_id'] }},{{ $n['seller_id'] }},{{ $n['buyer_id'] }})">
                                            {{ $n['seller'] }}</h2>
                                    </div>
                                    <div class="col text-right">
                                        #ID Transaksi : {{ $n['purchase_id'] }}
                                    </div>
                                </div>
                                @if ($n['confirm_id'] == 1)
                                Status: <h5>Belum bayar</h5>
                                @elseif ($n['confirm_id'] == 2)
                                Status: <h5>Pembayaran sedang diproses</h5>
                                @elseif ($n['confirm_id'] == 3)
                                Status: <h5>Sedang diproses pelapak</h5>
                                @elseif ($n['confirm_id'] == 4)
                                Status: <h5>Pesanan sedang dalam pengiriman</h5><br>
                                Resi: {{ $n['resi'] }}
                                <button class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#confirmTransactionModal">Konfirmasi Terima</button>
                                <div class="modal fade" id="confirmTransactionModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Konfirmasi Barang Sampai</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Produk</th>
                                                            <th scope="col">Harga</th>
                                                            <th scope="col ">Qty</th>
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
                                                                        <i class="fa fa-trash red" onclick="deleteItem({{ $j['item_id'] }})"></i>
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
                                                                Catatan:
                                                                @if(!empty($status['note'])) 
                                                                    {{ $status['note'] }}
                                                                @else 
                                                                    -
                                                                @endif
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
                                                    </tbody>
                                                </table>
                                                <form action="{{ route('confirmTransaction') }}" method="post">

                                                    <div id="detailTransaction"></div>
                                                    <div>
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="purchase_id"
                                                            value="{{ $n['purchase_id'] }}">

                                                        <h5 class="mx-2 my-2">Anda akan melakukan konfirmasi bahwa
                                                            barang pembelian telah sampai. Uang akan diteruskan
                                                            kepada pelapak.</h5>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fa fa-upload"></i>
                                                    Submit</button>
                                                <button type="button" class="btn btn-xs btn-danger"
                                                    data-dismiss="modal">Keluar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @elseif ($n['confirm_id'] == 5)
                                Status: <h5>Pembeli melakukan komplain</h5>
                                @elseif ($n['confirm_id'] == 6)
                                Status: <h5>Pesanan selesai</h5>
                                @elseif ($n['confirm_id'] == 7)
                                Status: <h5>Dibatalkan oleh pembeli</h5>
                                @elseif ($n['confirm_id'] == 8)
                                Status: <h5>Dibatalkan oleh penjual</h5>
                                @endif
                                <ul class="list list_2">
                                    <li>
                                        <a href="#">Total
                                            <span>Rp{{ number_format($n['total_price']+$n['shipping_price']) }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-5">

                        <div class="col-lg-12">
                            <div>
                                <h5>Penjualan</h5>
                                @foreach($usr_seller as $n)
                                <div class="order_box mb-2">
                                    <div class="row">
                                        <div class="col text-left">
                                            <h2 class="tap"
                                                onclick="getCheckout({{ $n['purchase_id'] }},{{ $n['seller_id'] }},{{ $n['buyer_id'] }})">
                                                {{ $n['buyer'] }}</h2>
                                        </div>
                                        <div class="col text-right">
                                            #ID Transaksi : {{ $n['purchase_id'] }}
                                        </div>
                                    </div>
                                    @if ($n['confirm_id'] == 1)
                                    Status: <h5>Belum bayar</h5>
                                    @elseif ($n['confirm_id'] == 2)
                                    Status: <h5>Pembayaran sedang diproses</h5>
                                    @elseif ($n['confirm_id'] == 3)
                                    Status: <h5>Sedang diproses pelapak</h5>
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#updateTransactionModal">Kirim sekarang</button>
                                    <div class="modal fade" id="updateTransactionModal">
                                        <div class="modal-dialog">
                                            <form action="{{ route('updateTransaction') }}" method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Konfirmasi penjualan</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="detailTransaction"></div>
                                                        <div>
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="purchase_id"
                                                                value="{{ $n['purchase_id'] }}">
                                                            <input type="text" class="form-control" name="resi"
                                                                placeholder="Nomor Resi">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fa fa-upload"></i>
                                                            Submit</button>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                            data-dismiss="modal">Keluar</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @elseif ($n['confirm_id'] == 4)
                                Status: <h5>Pesanan sedang dalam pengiriman</h5>
                                Resi: {{ $n['resi'] }}
                                @elseif ($n['confirm_id'] == 5)
                                Status: <h5>Pembeli melakukan komplain</h5>
                                @elseif ($n['confirm_id'] == 6)
                                Status: <h5>Pesanan selesai</h5>
                                @elseif ($n['confirm_id'] == 7)
                                Status: <h5>Dibatalkan oleh pembeli</h5>
                                @elseif ($n['confirm_id'] == 8)
                                Status: <h5>Dibatalkan oleh penjual</h5>
                                @endif
                                {{-- <ul class="list">
                                <li>
                                    <a href="#">Product
                                        <span>Total</span>
                                    </a>
                                </li>
                            </ul> --}}
                                <ul class="list list_2">
                                    <li>
                                        <a href="#">Total
                                            <span>Rp{{ number_format($n['total_price']+$n['shipping_price']) }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @endforeach
                        </div>


                    </div>
                </div>

            </div>
        </div>

        </section>

        <script>
            function getCheckout(purchase_id, seller_id, buyer_id) {
                window.location.assign(
                    "{{ route('checkout', ['purchase_id' => '', 'seller_id' => '', 'buyer_id' => '']) }}" + '/' +
                    purchase_id + '/' + seller_id + '/' + buyer_id);
            }

        </script>

        @endsection

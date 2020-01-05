@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif


<section class="cat_product_area section_gap">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-6">
                <div>
                    Penjualan
                        @foreach($usr_buyer as $n)
                        <div class="order_box mb-2">
                            <h2 class="tap" onclick="getCheckout({{ $n['purchase_id'] }})">#IDTransaksi {{ $n['purchase_id'] }}</h2>
                            @if ($n['confirm_id'] == 1)
                            Status: <h5>Belum bayar</h5>
                            @elseif ($n['confirm_id'] == 2)
                            Status: <h5>Pembayaran sedang diproses</h5>
                            @elseif ($n['confirm_id'] == 3)
                            Status: <h5>Sedang diproses pelapak</h5>
                            @elseif ($n['confirm_id'] == 4)
                            Status: <h5>Pesanan sedang dalam pengiriman</h5><br>
                            Resi: {{ $n['resi'] }}
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#confirmTransactionModal" >Konfirmasi barang</button>
                            <div class="modal fade" id="confirmTransactionModal">
                                <div class="modal-dialog">
                                    <form action="{{ route('confirmTransaction') }}" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Konfirmasi barang sampai</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="detailTransaction"></div>
                                            <div>           
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="purchase_id"
                                                        value="{{ $n['purchase_id'] }}">
    
                                                    <h5 class="mx-2 my-2">Anda akan melakukan konfirmasi bahwa barang pembelian telah sampai. Uang akan diteruskan kepada pelapak.</h5>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>
                                                Submit</button>
                                            <button type="button" class="btn btn-xs btn-danger"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            @elseif ($n['confirm_id'] == 5)
                            Status: <h5>Pelapak melakukan komplain</h5>
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
            <div class="col-lg-6">
                <div>
                    Pembelian
                        @foreach($usr_seller as $n)
                        <div class="order_box mb-2">
                            <h2>#IDTransaksi {{ $n['purchase_id'] }}</h2>
                            @if ($n['confirm_id'] == 1)
                            Status: <h5>Belum bayar</h5>
                            @elseif ($n['confirm_id'] == 2)
                            Status: <h5>Pembayaran sedang diproses</h5>
                            @elseif ($n['confirm_id'] == 3)
                            Status: <h5>Sedang diproses pelapak</h5>
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#updateTransactionModal" >Kirim sekarang</button>
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
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>
                                                Submit</button>
                                            <button type="button" class="btn btn-xs btn-danger"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            @elseif ($n['confirm_id'] == 4)
                            Status: <h5>Pesanan sedang dalam pengiriman</h5>
                            Resi: {{ $n['resi'] }}
                            @elseif ($n['confirm_id'] == 5)
                            Status: <h5>Pelapak melakukan komplain</h5>
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
    
</section>

<script>
function getCheckout(purchase_id) {
    window.location.assign("{{ route('checkout', '') }}" + '/' + purchase_id);
}
</script>

@endsection

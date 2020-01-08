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
                        <h4>Admin Panel</h4>
                    </div>

                    @foreach($usr as $n)
                    <div class="order_box mb-2">
                        <div class="row">
                            <div class="col text-left">
                                <h2 class="tap" onclick="getCheckout({{ $n['purchase_id'] }},{{ $n['seller_id'] }},{{ $n['buyer_id'] }})">#IDTransaksi
                                    {{ $n['purchase_id'] }}</h2>
                            </div>
                            <div class="col text-right">
                                <form action="{{ route('updateAdminTransaction') }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col text-left">
                                            <input type="hidden" name="purchase_id" value="{{ $n['purchase_id'] }}">
                                            <select name="confirm_id" class="form-control">
                                                <option selected>-- opsi --</option>
                                                @foreach($confirm as $j)
                                                <option value="{{ $j['confirm_id']}}">{{ $j['confirm_id']}} -
                                                    {{ $j['confirm']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>
                                                Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if ($n['confirm_id'] == 1)
                        Status: <h5>Belum bayar</h5>
                        @elseif ($n['confirm_id'] == 2)
                        Status: <h5>Pembayaran sedang diproses</h5>
                        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#trxModal">Lihat bukti
                            transfer</button>

                        <div class="modal fade" id="trxModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Bukti Transfer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="detailTransaction"></div>
                                        <div>
                                            <h5 class="mx-2 my-2">
                                                <img src="{{ asset('data_file/'.$n['purchase_id'].'_trx') }}" class="w-100" />
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>
                                            Submit</button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                            data-dismiss="modal">Keluar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @elseif ($n['confirm_id'] == 3)
                        Status: <h5>Sedang diproses pelapak</h5>
                        @elseif ($n['confirm_id'] == 4)
                        Status: <h5>Pesanan sedang dalam pengiriman</h5><br>
                        Resi: {{ $n['resi'] }}
                        <button class="btn btn-sm btn-success" data-toggle="modal"
                            data-target="#confirmTransactionModal">Konfirmasi barang</button>
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
                                                <input type="hidden" name="purchase_id" value="{{ $n['purchase_id'] }}">

                                                <h5 class="mx-2 my-2">Anda akan melakukan konfirmasi bahwa
                                                    barang pembelian telah sampai. Uang akan diteruskan
                                                    kepada pelapak.</h5>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i>
                                                Submit</button>
                                            <button type="button" class="btn btn-xs btn-danger"
                                                data-dismiss="modal">Keluar</button>
                                        </div>
                                </form>
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

@endsection

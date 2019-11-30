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

                    @foreach($invoice as $n)
                        Invoice no: {{ $n['purchase_id'] }}<br>
                        Price: Rp{{ $n['total_price'] }}<br>
                        Shipping: Rp{{ $n['shipping_price'] }}<br>
                        Note: {{ $n['note'] }}<br><br>

                        Total Price: Rp{{ $n['total_price']+$n['shipping_price'] }}<br>
                        Trf to: Alvin Bintang R.<br> 
                            538 0004149 BANK MUAMALAT INDONESIA<br>
                        Trf : Rp{{ $n['total_price']+$n['shipping_price']-$n['purchase_id'] }}
                    @endforeach

                    </div>

                </div>
            </div>
        </div>
    </div>

    @endsection

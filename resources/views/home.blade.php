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
                        <div class="col">
                            <form action="{{ route('find') }}" method="get" class="form-inline">
                                <input type="search" name="q" class="form-control form-control-sm">
                                <input type="submit" value="Find" class="btn btn-sm btn-primary">
                            </form>
                        </div>

                        @foreach ($category as $n)
                            <div class="card">
                                <a href="{{ route('find') ."?q=". $n['category_id'] }}">{{ $n['explanation'] }}</a>
                            </div>
                            
                        @endforeach

                        <div class="col">
                            <select onchange="sortBy()" id="sort">
                                <option>{{ app('request')->input('sort') }}</option>
                                <option value="priceLowHigh">Harga Terendah - Tertinggi</option>
                                <option value="priceHighLow">Harga Tertinggi - Terendah</option>
                            </select>
                        </div>

                        <div class="col">
                            <a href="{{ route('createItem') }}">Jual Barang</a>
                        </div>
                    </div>
                    

                    <div class="row">

                        @foreach($usr as $n)

                        <div class="col-md-3 my-3" onclick="getItem({{$n['item_id']}})">
                            <div class="card">
                                <img class="card-img-top w-100" src="{{ asset('data_file/'.$n['item_id'].'_a') }}">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $n['name'] }}</h4>
                                    <p class="card-text">Rp{{ number_format($n['selling_price']), 2 }}</p>
                                    <a href="" class="btn btn-block btn-primary">Beli</a>
                                </div>
                            </div>
                        </div>

                        @endforeach

                        <div class="pagination">
                            {{ $usr->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    
    function getItem(item_id) {
        window.location.assign("{{ route('itemDetail', '') }}" + '/' + item_id);
    }

    </script>
    @endsection

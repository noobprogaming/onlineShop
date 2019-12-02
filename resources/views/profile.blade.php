@extends('layouts.app')

@section('content')
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
                            {{-- <form action="{{ route('find') }}" method="get" class="form-inline">
                                <input type="search" name="q" class="form-control form-control-sm">
                                <input type="submit" value="Find" class="btn btn-sm btn-primary">
                            </form> --}}
                        </div>

                        <div class="col">
                            <a href="{{ route('createItem') }}">Jual Barang</a>
                        </div>
                    </div>
                    

                    <div class="row">

                        <div class="col-md-3 my-3">
                            <div class="card">
                                <img class="card-img-top w-100" src="{{ asset('data_file/'.$usr[0]['id'].'_profile') }}">
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

                    </div>

                    <a href="{{ route('profileUpdate', ['id'=>$usr[0]['id']]) }}">Update Profil</a>

                    <div class="row">

                            @foreach($item as $n)
    
                            <div class="col-md-3 my-3">
                                <div class="card">
                                    <img class="card-img-top w-100" src="{{ asset('data_file/'.$n['item_id'].'_a') }}">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $n['name'] }}</h4>
                                        <p class="card-text">Rp{{ number_format($n['selling_price']), 2 }}</p>
                                        <a href="{{ route('itemDetail', [$n['item_id']]) }}" class="btn btn-primary">Lihat</a>
                                    </div>
                                </div>
                            </div>
    
                            @endforeach
    
                            <div class="pagination">
                                {{ $item->links() }}
                            </div>
    
                        </div>
                </div>
            </div>

    @endsection

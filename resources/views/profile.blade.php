@extends('layouts.app')

@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Profile</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col text-left">
                             <form action="{{-- route('find') --}}" method="get" class="form-inline">
                                <input type="search" name="q" class="form-control form-control-sm">
                                <input type="submit" value="Find" class="btn btn-sm btn-primary">
                            </form> 
                        </div>
                        <div class="col jarak text-right">
                            <a class="btn btn-success" href="{{ route('createItem') }}"><i class="fa fa-shopping-bag"></i> Sell Item</a>
                            <a class="btn btn-primary" href="{{ route('profileUpdate', ['id'=>$usr[0]['id']]) }}"><i class="fa fa-pencil"></i> Update Profil</a>
                        </div>
                    </div>
                    
                    <div class="card mb-3 p-2" >
                      <div class="row no-gutters">
                        <div class="col-md-4">
                          <img class="card-img-top rounded-lg" style="max-width: 540px;" src="{{ asset('data_file/'.$usr[0]['id'].'_profile') }}">
                        </div>
                        <div class="col-md-8">
                          <div class="card-body">
                            <h3 class="card-title">{{ $usr[0]['name'] }}</h3>
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

                    <br>
                    <h3 class="my-3">My Shop</h3>
                    <div class="row">
                            @foreach($item as $n)

                            <div class="col-md-3">
                                <div class="card ">
                                    <div class="h-250">
                                        <img class="card-img-top h-100" src="{{ asset('data_file/'.$n['item_id'].'_a') }}">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $n['name'] }}</h4>
                                        <p class="card-text">Rp{{ number_format($n['selling_price']), 2 }}</p>
                                        <a href="{{ route('itemDetail', [$n['item_id']]) }}" class="btn btn-primary">Detail</a>
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

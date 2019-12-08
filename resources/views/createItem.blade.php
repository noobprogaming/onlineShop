@extends('layouts.app')

@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sell Item</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="{{ route('setCreateItem') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    value="{{ old('description') }}" required autocomplete="description">

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">{{ __('Stock') }}</label>

                            <div class="col-md-6">
                                <input id="stock" type="number" min=0
                                    class="form-control @error('stock') is-invalid @enderror" name="stock"
                                    value="{{ old('stock') }}" required autocomplete="stock">

                                @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="purchasing_price"
                                class="col-md-4 col-form-label text-md-right">{{ __('Purchasing Price') }}</label>

                            <div class="col-md-6">
                                <input id="purchasing_price" type="number" min=0
                                    class="form-control @error('purchasing_price') is-invalid @enderror"
                                    name="purchasing_price" value="{{ old('purchasing_price') }}" required
                                    autocomplete="purchasing_price">

                                @error('purchasing_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selling_price"
                                class="col-md-4 col-form-label text-md-right">{{ __('Selling Price') }}</label>

                            <div class="col-md-6">
                                <input id="selling_price" type="number" min=0
                                    class="form-control @error('selling_price') is-invalid @enderror"
                                    name="selling_price" value="{{ old('selling_price') }}" required
                                    autocomplete="selling_price">

                                @error('selling_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="weight"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Weight') }}</label>
    
                                <div class="col-md-6">
                                    <input id="weight" type="number" min=0
                                        class="form-control @error('weight') is-invalid @enderror"
                                        name="weight" value="{{ old('weight') }}" required
                                        autocomplete="weight">
    
                                    @error('weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="category_id"
                                class="col-md-4 col-form-label text-md-right">{{ __('Category ID') }}</label>

                            <div class="col-md-6">
                                <select id="category_id" name="category_id" class="form-control">
                                    @foreach ($category as $n)
                                    <option value="{{ $n['category_id'] }}">{{ $n['explanation'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <input type="file"  name="file_a">
                        <input type="file"  name="file_b">
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-shopping-bag"></i>
                                     Insert to MyShop
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

    
            @endsection

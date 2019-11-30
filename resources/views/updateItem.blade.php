@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-left">Update</div>
                        <div class="col text-right">
                            <div class="tap" data-toggle="modal"
                            data-target="#deleteItemModal">
                                <kbd>Delete</kbd>
                                <i class="fa fa-trash"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteItemModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirm Delete Item</h4>
                            </div>
                            <div class="modal-body">
                                <h6>Anda akan menghapus data. Ketik "DELETE" untuk konfirmasi.</h6>
                                <input type="text" id="funDelete" placeholder="DELETE">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm mr-auto" onclick="funDelete()">Confirm Delete</button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function funDelete() {
                        if (document.getElementById("funDelete").value == "DELETE") {
                            window.location.assign(
                                "{{ route('deleteItem', ['id'=>$usr[0]['id'], 'item_id'=>$usr[0]['item_id']]) }}")
                        }
                    }

                </script>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <img class="card-img-top w-25" src="{{ asset('data_file/'.$usr[0]['item_id'].'_a') }}">
                    <img class="card-img-top w-25" src="{{ asset('data_file/'.$usr[0]['item_id'].'_b') }}">

                    <form action="{{ route('setUpdateItem') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="item_id" value="{{ $usr[0]['item_id'] }}">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $usr[0]['name'] }}" required autocomplete="name">

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
                                    value="{{ $usr[0]['description'] }}" required autocomplete="description">

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
                                    value="{{ $usr[0]['stock'] }}" required autocomplete="stock">

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
                                    name="purchasing_price" value="{{ $usr[0]['purchasing_price'] }}" required
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
                                    name="selling_price" value="{{ $usr[0]['selling_price'] }}" required
                                    autocomplete="selling_price">

                                @error('selling_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="weight" class="col-md-4 col-form-label text-md-right">{{ __('Weight') }}</label>

                            <div class="col-md-6">
                                <input id="weight" type="number" min=0
                                    class="form-control @error('weight') is-invalid @enderror" name="weight"
                                    value="{{ $usr[0]['weight'] }}" required autocomplete="weight">

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
                                <select id="category_id" name="category_id">
                                    <option selected value='{{ $usr[0]['category_id'] }}'>{{ $usr[0]['explanation'] }}
                                    </option>
                                    @foreach ($category as $n)
                                    <option value="{{ $n['category_id'] }}">{{ $n['explanation'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <input type="file" name="file_a">
                        <input type="file" name="file_b">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    @endsection

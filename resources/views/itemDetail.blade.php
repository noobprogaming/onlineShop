@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<div class="product_image_area">
    <div class="container" style="background-color: #FFFFFF">
        <div class="row s_product_inner">
            <div class="col-lg-6">
                <div class="s_product_img">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                                <img src="{{ asset('data_file/'.$usr_seller[0]['item_id'].'_a') }}" class="img-thumb" />
                            </li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1">
                                <img src="{{ asset('data_file/'.$usr_seller[0]['item_id'].'_b') }}" class="img-thumb" />
                            </li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100"
                                    src="{{ asset('data_file/'.$usr_seller[0]['item_id'].'_a') }}" alt="First slide" />
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100"
                                    src="{{ asset('data_file/'.$usr_seller[0]['item_id'].'_b') }}" alt="Second slide" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="s_product_text">
                    <h3>{{ $usr_seller[0]['name'] }}</h3>
                    <h2>Rp{{ number_format($usr_seller[0]['selling_price']),2,',','.' }}</h2>
                    {{-- <del>Rp{{ number_format($usr_seller[0]['selling_price']*123/100) }}</del> --}}
                    <ul class="list">
                        <li>
                            <a class="active" href="#">
                                <span>Kategori</span> : {{ $usr_seller[0]['explanation'] }}</a>
                        </li>
                        <li>
                            <a href="#"> <span>Stok</span> :
                                @if ($usr_seller[0]['stock'] >= 100)
                                >100 item
                                @elseif ($usr_seller[0]['stock'] >= 50)
                                >50 item
                                @elseif ($usr_seller[0]['stock'] >= 10)
                                >10 item
                                @elseif ($usr_seller[0]['stock'] >= 1)
                                {{ $usr_seller[0]['stock'] }} item
                                @else
                                Out of stock
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="#"> <span>Berat</span> :
                                {{ $usr_seller[0]['weight'] }} gram
                            </a>
                        </li>



                    </ul>
                    <p>
                        @if (!empty($usr_seller[0]['description']))
                        {{ $usr_seller[0]['description'] }}
                        @else
                        {{ "No description" }}
                        @endif



                    </p>

                    <div class="card_area">
                        <div>
                            @if ($usr_seller[0]['id'] == Auth::user()->id || empty(Auth::user()->id))

                            <a class="btn btn-login" href="{{ route('updateItem', ['item_id'=>$usr_seller[0]['item_id']]) }}"><i
                                class="fa fa-pencil"></i>Ubah Barang</a>
        
                            @endif

                            @if ($usr_seller[0]['id'] == Auth::user()->id || empty(Auth::user()->id))

                            <div class="value-button" id="decrease">-</div>
                            <input id="number" value="1" disabled>
                            <div class="value-button" id="increase">+</div>
                            
                            <button class="btn btn-secondary" disabled>Tambahkan ke keranjang</button>

                            @else
                            <div class="value-button" id="decrease" style="border-radius: 5px 0 0 5px"
                                onclick="decreaseValue()" value="Decrease Value">-</div>
                            <input id="number" type="number" class=" @error('amount') is-invalid @enderror"
                                name="amount" style="border: 1px solid #F0F0F0;" value="1" required>
                            <div class="value-button" id="increase" style="border-radius: 0 5px 5px 0"
                                onclick="increaseValue()" value="Increase Value">+</div>

                            <button class="main_btn" onclick="addItem(
                                {{ $usr_seller[0]['seller_id'].', '. $usr_seller[0]['item_id'] }}
                            )">Tambahkan ke keranjang</button>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="product_description_area" style="background-color: #FFFFFF">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Profil Pelapak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                    aria-controls="review" aria-selected="false">Penilaian Produk</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Pelapak</h4>
                        <ul class="list cat-list">
                            <li>
                                <div class="">
                                    <img class="d-inline img-thumbnail rounded-circle w-25 h-25" src="{{ asset('data_file/'.$usr_seller[0]['id'].'_profile') }}">
                                    <h4 class="d-inline ml-3">{{ $usr_seller[0]['seller'] }}</h4>
                                </div>
                                
                                <p>
                                    <div id="city">
                                        {{ $usr_seller[0]['city_name'] }}
                                    </div>

                                    <div id="province">
                                        {{ $usr_seller[0]['province_name'] }}
                                    </div>
                                </p>
                                <hr>
                                <p>
                                    Penilaian Pembeli<br>

                                    @if (!empty($ratingLapak[0]['ratingLapak']))
                                    @for ($i = 0; $i < ($ratingLapak[0]['ratingLapak']-1); $i++) <i
                                        class="fa fa-star yellow"></i>
                                        @endfor
                                        @if(substr(($ratingLapak[0]['ratingLapak']-0.001), 2) >= 0.5)
                                        <i class="fa fa-star yellow"></i>
                                        @else
                                        <i class="fa fa-star-half yellow"></i>
                                        @endif
                                        {{ $ratingLapak[0]['ratingLapak'] }}
                                    @else
                                    
                                    {{ $ratingLapak[0]['ratingLapak'] }}
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <br>
                                    Belum ada penilaian
                                    @endif


                                </p>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row total_rate">
                            <div class="col-md-6">
                                <div class="box_total">
                                    <h5>Penilaian</h5>
                                    <h4>{{ $rating_avg[0]["AVG(rating.rating)"] }}</h4>
                                    <h6>({{ $rating_count }} Penilai)</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="rating_list">
                                    <h3>Kriteria Review</h3>
                                    <ul class="list">
                                        <li>
                                            <a href="#">5 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                        </li>
                                        <li>
                                            <a href="#">4 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                        </li>
                                        <li>
                                            <a href="#">3 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                        </li>
                                        <li>
                                            <a href="#">2 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                        </li>
                                        <li>
                                            <a href="#">1 Star
                                                <i class="fa fa-star"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="review_list">
                            @foreach ($rating as $n)
                            @if (!empty($n['rating']))

                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img class="img-rating rounded-circle" src="{{ asset('data_file/'.$n['id'].'_profile') }}" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <h4>{{ $n['name'] }}</h4>
                                        @for ($i = 0; $i < ($n['rating']); $i++) 
                                        <i class="fa fa-star yellow"></i>
                                        @endfor
                                        @for ($i = 0; $i < (5-$n['rating']); $i++) 
                                        <i class="fa fa-star lightGrey" style="color: #CBCBCB"></i>
                                        @endfor
                                        {{-- <i class="fa fa-star-half yellow"></i> --}}      
                                    </div>
                                </div>
                                <p>
                                    {{ $n['review'] }}
                                    {{ $n['review'] }}
                                    {{ $n['review'] }}
                                    {{ $n['review'] }}
                                    {{ $n['review'] }}
                                </p>
                            </div>
                            <p class="card-text">{{ date('D, d-m-Y', strtotime($n['time'])) }}</p>
                            @else
                                Belum ada penilaian
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    getOngkir();

    function getOngkir() {
        var origin = "{{ $usr_seller[0]['city_id'] }}";
        var dst = "{{ $usr_buyer[0]['city_id'] }}";
        //var courier = $('#kurir').val();
        var weight = "{{ $usr_seller[0]['weight'] }}";

        $.ajax({
            type: "GET",
            url: "{{  route('checkshipping') }}",
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
    }

    /* Amount */
    function increaseValue() {
        if (document.getElementById('number').value >= "{{ $usr_seller[0]['stock'] }}") {
            alert('Stok tidak mencukupi');
        } else {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('number').value = value;
        }
    }

    function decreaseValue() {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        document.getElementById('number').value = value;
    }

    $('#number').on('input', function (e) {
        if (document.getElementById('number').value > "{{ $usr_seller[0]['stock'] }}") {
            alert('Stok tidak mencukupi');
            document.getElementById('number').value = "{{ $usr_seller[0]['stock'] }}";
        }
    });
    /**/

</script>

@endsection

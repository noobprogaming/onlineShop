@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<div class="product_image_area">
    <div class="container">
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
                        {{ $usr_seller[0]['description'] }}
                        {{ $usr_seller[0]['description'] }}
                        @else
                        {{ "No description" }}
                        @endif



                    </p>

                    <div class="card_area">
                        <div>
                            @if ($usr_seller[0]['id'] == Auth::user()->id || empty(Auth::user()->id))

                            <div class="value-button" id="decrease">-</div>
                            <input id="number" value="1">
                            <div class="value-button" id="increase">+</div>
                            {{-- <button class="btn btn-primary" disabled>Tambahkan ke cart</button> --}}

                            @else
                            <div class="value-button" id="decrease" style="border-radius: 5px 0 0 5px"
                                onclick="decreaseValue()" value="Decrease Value">-</div>
                            <input id="number" type="number" class=" @error('amount') is-invalid @enderror"
                                name="amount" style="border: 1px solid #F0F0F0;" value="1" required>
                            <div class="value-button" id="increase" style="border-radius: 0 5px 5px 0"
                                onclick="increaseValue()" value="Increase Value">+</div>

                            @endif
                        </div>

                        <button class="main_btn" onclick="addItem(
                            {{ $usr_seller[0]['seller_id'].', '. $usr_seller[0]['item_id'] }}
                        )">Tambahkan ke keranjang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="product_description_area">
    <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Specification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                    aria-controls="contact" aria-selected="false">Comments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                    aria-controls="review" aria-selected="false">Reviews</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                <p>
                    Beryl Cook is one of Britain’s most talented and amusing artists
                    .Beryl’s pictures feature women of all shapes and sizes enjoying
                    themselves .Born between the two world wars, Beryl Cook eventually
                    left Kendrick School in Reading at the age of 15, where she went
                    to secretarial school and then into an insurance office. After
                    moving to London and then Hampton, she eventually married her next
                    door neighbour from Reading, John Cook. He was an officer in the
                    Merchant Navy and after he left the sea in 1956, they bought a pub
                    for a year before John took a job in Southern Rhodesia with a
                    motor company. Beryl bought their young son a box of watercolours,
                    and when showing him how to use it, she decided that she herself
                    quite enjoyed painting. John subsequently bought her a child’s
                    painting set for her birthday and it was with this that she
                    produced her first significant work, a half-length portrait of a
                    dark-skinned lady with a vacant expression and large drooping
                    breasts. It was aptly named ‘Hangover’ by Beryl’s husband and
                </p>
                <p>
                    It is often frustrating to attempt to plan meals that are designed
                    for one. Despite this fact, we are seeing more and more recipe
                    books and Internet websites that are dedicated to the act of
                    cooking for one. Divorce and the death of spouses or grown
                    children leaving for college are all reasons that someone
                    accustomed to cooking for more than one would suddenly need to
                    learn how to adjust all the cooking practices utilized before into
                    a streamlined plan of cooking that is more efficient for one
                    person creating less
                </p>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <h5>Width</h5>
                                </td>
                                <td>
                                    <h5>128mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Height</h5>
                                </td>
                                <td>
                                    <h5>508mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Depth</h5>
                                </td>
                                <td>
                                    <h5>85mm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Weight</h5>
                                </td>
                                <td>
                                    <h5>52gm</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Quality checking</h5>
                                </td>
                                <td>
                                    <h5>yes</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Freshness Duration</h5>
                                </td>
                                <td>
                                    <h5>03days</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>When packeting</h5>
                                </td>
                                <td>
                                    <h5>Without touch of hand</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Each Box contains</h5>
                                </td>
                                <td>
                                    <h5>60pcs</h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="comment_list">
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="{{ asset('img/product/single-product/review-1.png') }}" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <h5>12th Feb, 2017 at 05:56 pm</h5>
                                        <a class="reply_btn" href="#">Reply</a>
                                    </div>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna
                                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip ex ea commodo
                                </p>
                            </div>
                            <div class="review_item reply">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="{{ asset('img/product/single-product/review-2.png') }}" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <h5>12th Feb, 2017 at 05:56 pm</h5>
                                        <a class="reply_btn" href="#">Reply</a>
                                    </div>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna
                                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip ex ea commodo
                                </p>
                            </div>
                            <div class="review_item">
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="{{ asset('img/product/single-product/review-3.png') }}" alt="" />
                                    </div>
                                    <div class="media-body">
                                        <h4>Blake Ruiz</h4>
                                        <h5>12th Feb, 2017 at 05:56 pm</h5>
                                        <a class="reply_btn" href="#">Reply</a>
                                    </div>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna
                                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco laboris nisi ut aliquip ex ea commodo
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Post a comment</h4>
                            <form class="row contact_form" action="contact_process.php" method="post" id="contactForm"
                                novalidate="novalidate">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Your Full name" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Address" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="number" name="number"
                                            placeholder="Phone Number" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="message" rows="1"
                                            placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" value="submit" class="btn submit_btn">
                                        Submit Now
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row total_rate">
                            <div class="col-6">
                                <div class="box_total">
                                    <h5>Overall</h5>
                                    <h4>4.0</h4>
                                    <h6>(03 Reviews)</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rating_list">
                                    <h3>Based on 3 Reviews</h3>
                                    <ul class="list">
                                        <li>
                                            <a href="#">5 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> 01</a>
                                        </li>
                                        <li>
                                            <a href="#">4 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> 01</a>
                                        </li>
                                        <li>
                                            <a href="#">3 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> 01</a>
                                        </li>
                                        <li>
                                            <a href="#">2 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> 01</a>
                                        </li>
                                        <li>
                                            <a href="#">1 Star
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> 01</a>
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
                        <div class="col-lg-6">
                            <div class="review_box">
                                <h4>Add a Review</h4>
                                <p>Your Rating:</p>
                                <ul class="list">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star"></i>
                                        </a>
                                    </li>
                                </ul>
                                <p>Outstanding</p>
                                <form class="row contact_form" action="contact_process.php" method="post"
                                    id="contactForm" novalidate="novalidate">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Your Full name" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="number" name="number"
                                                placeholder="Phone Number" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" id="message" rows="1"
                                                placeholder="Review"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" value="submit" class="btn submit_btn">
                                            Submit Now
                                        </button>
                                    </div>
                                </form>
                            </div>
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

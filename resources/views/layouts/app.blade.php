<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/icon.png') }}">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/linericon/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/lightbox/simpleLightbox.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/nice-select/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/jquery-ui/jquery-ui.css') }}" />
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/stellar.js') }}"></script>
    <script src="{{ asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>
    <script src="{{ asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendors/isotope/isotope-min.js') }}"></script>
    <script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('js/mail-script.js') }}"></script>
    <script src="{{ asset('vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('vendors/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendors/counter-up/jquery.counterup.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>

</head>

<body style="background-color: #F8F9F9">
    <div id="app">
        <header class="header_area">
            {{-- <div class="top_menu">
                <div class="container">
                </div>
            </div> --}}
            <div class="main_menu">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light w-100">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <a class="navbar-brand logo_h" href="{{ url('/') }}">
                            <img src="{{ asset('img/logo.png')}}" alt="" />
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
                            <div class="row w-100 mr-0">
                                @guest
                                <div class="col-lg-7 pr-0">
                                    <ul class="nav navbar-nav center_nav pull-right">
                                        <li class="nav-item">
                                            <a class="nav-link"></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"></a>
                                        </li>
                                    </ul>
                                </div>
                                @else
                                <div class="col-lg-7 pr-0">
                                    <ul class="nav navbar-nav center_nav pull-right">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('transaction') }}">Transaksi</a>
                                        </li>
                                        @if(Auth::user()->email == "admin@admin")
                                        <li class="nav-item">
                                            <a class="nav-link blue" href="{{ route('admin') }}">Admin Panel</a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @endguest
                                

                                <div class="col-lg-5 pr-0">
                                    <ul class="nav navbar-nav navbar-right right_nav pull-right">
                                        @guest
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">Akun</a>
                                        </li>
                                        @else

                                        <li class="nav-item">
                                            <a class="icons" data-toggle="modal" data-target="#cartModal"
                                                id="btnCartList">
                                                <i class="ti-shopping-cart"></i>
                                                <sup>
                                                    <div id="cartCount" class="mt-2 d-inline"></div>
                                                </sup>
                                            </a>
                                        </li>

                                        <li class="nav-item submenu dropdown">
                                            <a class="icons">
                                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-user mr-2" aria-hidden="true"></i>
                                                        {{ Auth::user()->name }} <span class="caret"></span>
                                                    </a>
                                                <ul class="dropdown-menu">
                                                    <li class="nav-item">
                                                        <a class="nav-link"
                                                            href="{{ route('profile', Auth::user()->id) }}">{{ __('Profile')}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="{{ route('logout') }}"
                                                            onclick="event.preventDefault();
                                                                                            document.getElementById('logout-form').submit();">
                                                            {{ __('Logout') }}
                                                        </a>

                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </a>
                                        </li>

                                        @endguest
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        @if (Auth::user())
        <div class="modal fade" id="cartModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Keranjang</h4>
                    </div>
                    <div class="modal-body my-3">
                        <div id="cartList">
                            <img src="{{ asset('data_file/load.gif') }}" class="load" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Keluar</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <main>
            <div class="container">
                <div class="row justify-content-center">
                    @yield('content')
                </div>
            </div>
        </main>

</body>

<footer class="footer-area section_gap">
    <div class="container">
        <div class="footer-bottom row align-items-center">
            <p class="footer-text m-0 col-lg-8 col-md-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>
                    document.write(new Date().getFullYear());

                </script> All rights reserved | This template is made with <i class="fa fa-heart-o"
                    aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
            <div class="col-lg-4 col-md-12 footer-social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-dribbble"></i></a>
                <a href="#"><i class="fa fa-behance"></i></a>
            </div>
        </div>
    </div>
</footer>

<script>
    /* Cart */

    //getCartCount
    $("#cartCount").load("{{ route('cartCount') }}");

    //getCartList
    $("#btnCartList").click(function () {
        $("#cartList").load("{{ route('cartList') }}");
    });

    function getCartList() {
        $("#cartList").load("{{ route('cartList') }}");
    }


    function addItem(seller_id, item_id) {
        var amount = document.getElementById('number').value;

        $.ajax({
            type: "POST",
            url: "{{ route('storeCart') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "seller_id": seller_id,
                "item_id": item_id,
                "amount": amount,
            }
        }).done(function () {
            $("#cartCount").load("{{ route('cartCount') }}");
            $("#cartList").load("{{ route('cartList') }}");
            $('#cartModal').modal('show');
            // alert("Barang telah ditambahkan!")
        });
    }

    function deleteItem(itemId) {
        $.ajax({
            type: "GET",
            url: "/deleteCart/" + itemId,
        }).done(function () {
            alert("Barang berhasil dihapus!")
            $("#cartCount").load("{{ route('cartCount') }}");
            getCartList();
        });
    }
    /* -- */

    function getItemDetail(item_id) {
        window.location.assign("{{ route('itemDetail', '') }}" + '/' + item_id);
    }


    function getProfilePelapak(seller_id) {
        window.location.assign("{{ route('profile', '') }}" + '/' + seller_id);
    }

    function getCheckout(purchase_id, seller_id, buyer_id) {
        window.location.assign("{{ route('checkout', ['purchase_id' => '', 'seller_id' => '', 'buyer_id' => '']) }}" + '/' + purchase_id + '/' + seller_id + '/' + buyer_id);
    }

</script>

</html>

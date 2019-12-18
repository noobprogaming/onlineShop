<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="vendors/linericon/style.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/lightbox/simpleLightbox.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <link rel="stylesheet" href="vendors/animate-css/animate.css" />
    <link rel="stylesheet" href="vendors/jquery-ui/jquery-ui.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/responsive.css" />

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    @if (Auth::user())
                        <i class="fa fa-shopping-cart" data-toggle="modal" data-target="#cartModal"
                            id="btnCartList"></i>
                        <sup>
                            <div id="cartCount" class="mt-2"></div>
                        </sup>
                        @endif

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
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('profile', Auth::user()->id) }}">{{ __('Profile')}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>

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
            alert("Barang telah ditambahkan!")
        });
    }

    function deleteItem(itemId) {
        $.ajax({
            type: "GET",
            url: "/deleteCart/" + itemId,
        }).done(function () {
            alert("Barang telah dihapus!")
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

    function getCheckout(purchase_id) {
        window.location.assign("{{ route('checkout', '') }}" + '/' + purchase_id);
    }

    /* Amount */
    function increaseValue() {
        if (document.getElementById('number').value >= "") {
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
        if (document.getElementById('number').value > "") {
            alert('Stok tidak mencukupi');
            document.getElementById('number').value = "";
        }
    });
    /**/

</script>

</html>

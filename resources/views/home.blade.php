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
                            <input type="text" oninput="onInput()" id="nameItem" class="form-control form-control-sm" list="itemList">
                            <datalist id="itemList">
                            </datalist>
                            <button onclick="getFindItem()" class="btn btn-sm btn-primary">Cari</button>
                        </div>

                        @foreach ($category as $n)
                        <div>
                            <button onclick="getItemCategory('{{ $n['explanation'] }}')">
                                {{ $n['explanation'] }}
                            </button>
                        </div>
                        @endforeach

                        <div class="col">
                            <select onchange="sortBy()" id="sort">
                                <option>Urutkan berdasarkan</option>
                                <option value="priceLowHigh">Harga Terendah - Tertinggi</option>
                                <option value="priceHighLow">Harga Tertinggi - Terendah</option>
                            </select>
                        </div>

                        <div class="col">
                            <a href="{{ route('createItem') }}">Jual Barang</a>
                        </div>
                    </div>


                    <div class="row" id="item">
                    </div>

                </div>
            </div>


    <script>

        //setup before functions
        var typingTimer; //timer identifier
        var doneTypingInterval = 500; //time in ms, 5 second for example
        var $nameItem = $('#nameItem');

        //on keyup, start the countdown
        $nameItem.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $nameItem.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        //user is "finished typing," do something
        function doneTyping() {
            var nameItem = $('#nameItem').val();

            $.ajax({
                type: "GET",
                url: "{{ route('getListItem') }}",
                data: {
                    "nameItem": nameItem,
                },
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#itemList").html(data);
                },
            });
        }

        getItem();

        function sortBy() {
            var nameItem = $('#nameItem').val();

            if (document.getElementById('sort').value == "priceLowHigh") {
                var sort = "priceLowHigh";
            } else if (document.getElementById('sort').value == "priceHighLow") {
                var sort = "priceHighLow";
            }

            $.ajax({
                type: "GET",
                url: "{{ route('getItem') }}",
                data: {
                    "nameItem": nameItem,
                    "sort": sort,
                },
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#item").html(data);
                },
            });
        }

        function getItem() {
            $.ajax({
                type: "GET",
                url: "{{ route('getItem') }}",
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#item").html(data);
                },
            });
        }

        function getFindItem() {
            var nameItem = $('#nameItem').val();

            if (document.getElementById('sort').value == "priceLowHigh") {
                var sort = "priceLowHigh";
            } else if (document.getElementById('sort').value == "priceHighLow") {
                var sort = "priceHighLow";
            }

            $.ajax({
                type: "GET",
                url: "{{ route('getItem') }}",
                data: {
                    "nameItem": nameItem,
                    "sort": sort,
                },
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#item").html(data);
                },
            });
        }

        function getItemCategory(explanation) {
            
            if (document.getElementById('sort').value == "priceLowHigh") {
                var sort = "priceLowHigh";
            } else if (document.getElementById('sort').value == "priceHighLow") {
                var sort = "priceHighLow";
            }

            $.ajax({
                type: "GET",
                url: "{{ route('getItemCategory') }}",
                data: {
                    "explanation": explanation,
                    "sort": sort,
                },
                beforeSend: function () {
                    //console.log("loading");
                    //$("#tes").val("loading");
                },
                success: function (data) {
                    //console.log(data);
                    $("#item").html(data);
                },
            });
        }

        function onInput() {
            var val = document.getElementById("nameItem").value;
            var opts = document.getElementById('itemList').childNodes;
            for (var i = 0; i < opts.length; i++) {
                if (opts[i].value === val) {
                    // An item was selected from the list!
                    // yourCallbackHere()
                    getFindItem();
                    // alert(opts[i].value);
                    break;
                }
            }
        }

    </script>
    @endsection

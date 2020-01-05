@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<section class="cat_product_area section_gap">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="product_top_bar">
                    <div class="left_dorp col col-md-12">
                        <select onchange="sortBy()" id="sort" class="sorting">
                            <option selected>Urutkan</option>
                            <option value="priceLowHigh">Termurah - termahal</option>
                            <option value="priceHighLow">Termahal - termurah</option>
                        </select>
                    </div>
                </div>

                <div class="latest_product_inner">
                    <div class="row" id="item">
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="left_sidebar_area">
                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Cari produk</h3>
                        </div>
                        <div class="widgets_inner">
                            <div class="input-group">
                                <input type="text" oninput="onInput()" id="nameItem" class="form-control" list="itemList"
                                    placeholder="Cari...">
                                <datalist id="itemList">
                                </datalist>
                                <div class="input-group-prepend">
                                    <button onclick="getFindItem()" class="input-group-text btn btn-sm btn-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Kategori</h3>
                        </div>
                        <div class="widgets_inner">
                            <ul class="list">
                                @foreach ($category as $n)
                                <li onclick="getItemCategory('{{ $n['explanation'] }}')">
                                    <a>{{ ucfirst($n['explanation']) }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>

                </div>
            </div>
        </div>
    </div>
</section>

<div class="row" id="item">
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

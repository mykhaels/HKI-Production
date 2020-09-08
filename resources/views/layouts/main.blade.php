<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <title>@yield('title')</title>
    <script>
        function makeActive(el){
            let elem = $(el);
            elem.addClass("active");
            elem.parent().parent().toggle()
        }
    </script>
  </head>
  <body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('/') }}"><img src="{{ asset('images/Logo.jpeg') }}" width="30%"></a>

            <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">Sign out</a>
            </li>
            </ul>
        </nav>

        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Master</span>
                        <a class="d-flex align-items-center text-muted" href="#" aria-label="Master" data-id="master-child">
                        <span data-feather="plus-circle"></span>
                        <span data-feather="minus-circle" style="display:none"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column ml-3" id="master-child">
                        <li class="nav-item">
                        <a class="nav-link" href="{{ url('product-category') }}" id="master-kategori-produk">
                                <span data-feather="file-text"></span>
                                Master Kategori Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('product') }}" id="master-produk">
                                <span data-feather="file-text"></span>
                                Master Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="master-resep">
                                <span data-feather="file-text"></span>
                                Master Resep
                            </a>
                        </li>

                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Persediaan</span>
                        <a class="d-flex align-items-center text-muted" href="#" aria-label="Persediaan" data-id="storage-child">
                        <span data-feather="plus-circle"></span>
                        <span data-feather="minus-circle" style="display:none"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column ml-3" id="storage-child">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('delivery-note') }}">
                                <span data-feather="file-text"></span>
                                Pengeluaran Bahan Baku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Stock
                            </a>
                        </li>
                    </ul>
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Production</span>
                        <a class="d-flex align-items-center text-muted" href="#" aria-label="Production" data-id="production-child" data-toggle="yes">
                        <span data-feather="plus-circle"></span>
                        <span data-feather="minus-circle" style="display:none"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column ml-3" id="production-child">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('production-order') }}">
                                <span data-feather="box"></span>
                                Perintah Produksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('delivery-request') }}">
                                <span data-feather="aperture"></span>
                                Permintaan Bahan Baku
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="aperture"></span>
                                Hasil Produksi
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script>
        // For feather icon
        feather.replace()

        //for toggling breadcrumb
        var parents = $('h6 a');
        parents.each(function(index, element){
            let ele = $(element);
             ele.click(function(){
               $("#"+ele.data("id")).toggle();
               $(ele).children().toggle();
             });

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

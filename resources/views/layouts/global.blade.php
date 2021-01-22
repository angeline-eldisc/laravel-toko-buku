<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Toko Buku - @yield("title") | Angeline Eldisc XII-RPL</title>
        <link rel="stylesheet" href="{{asset('polished/polished.min.css')}}">
        <link rel="stylesheet" href="{{asset('polished/iconic/css/open-iconic-bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/animate.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
        <style>
            .grid-highlight {
                padding-top:
                    1rem;
                padding-bottom:
                    1rem;
                background-color:
                    #5c6ac4;
                border:
                    1px solid #202e78;
                color:
                    #fff;
            }

            hr {
                margin: 6rem 0;
            }

            hr+.display-3,
            hr+.display-2+.display-3 {
                margin-bottom:
                    2rem;
            }

            .pagination {
                margin-bottom: 0px;
            }

            .is-invalid {
                border-color: red;
                padding-right: calc(1.5em + .75rem);
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(.375em + .1875rem) center;
                background-size: calc(.75em + .375rem) calc(.75em + .375rem);
            }

            .navbar-fixed-top {
                top: 0;
                border-width: 0 0 1px;
            }

            .select2 {
                width: 100%!important;
            }
        </style>

    <script type="text/javascript">
        document.documentElement.className = document.documentElement.className.replace('no-js', 'js') + (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure ", "1.1") ? 'svg ' : 'no - svg ');
    </script>
    </head>
    <body>
        <nav class="navbar navbar-expand p-0 fixed-top">
            <a class="navbar-brand text-center col-xs-12 col-md-3 col-lg-2 mr-0" href="{{ route('home') }}"> Laravel Toko Buku </a>
            <button class="btn btn-link d-block d-md-none" datatoggle="collapse" data-target="#sidebar-nav" role="button">
                <span class="oi oi-menu"></span>
            </button>
            <input class="border-dark bg-primary-darkest form-control d-none d-md-block w-50 ml-3 mr-2" type="text" placeholder="Search" arialabel="Search">
            <div class="dropdown d-none d-md-block">
                @if(\Auth::user())
                <button class="btn btn-link btn-link-primary dropdown-toggle" id="navbar-dropdown" data-toggle="dropdown">
                    {{Auth::user()->name}}
                </button>
                @endif
                <div class="dropdown-menu dropdown-menu-right" id="navbardropdown">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Setting</a>
                    <div class="dropdown-divider"></div>
                    <li>
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button class="dropdown-item" style="cursor:pointer">Sign Out</button>
                        </form>
                    </li>
                </div>
            </div>
        </nav>

        <div class="container-fluid h-100 p-0">
            <div style="min-height: 100%" class="flex-row d-flex align-itemsstretch m-0">
                <div class="polished-sidebar bg-light col-12 col-md-3 col-lg-2 p-0 collapse d-md-inline" id="sidebar-nav">
                    <ul class="polished-sidebar-menu ml-0 pt-4 p-0 d-md-block">
                        <input class="border-dark form-control d-block d-md-none mb-4" type="text" placeholder="Search" aria-label="Search" />
                        <li><a href="/home"><span class="oi oi-home"></span> Home</a></li>
                        <li><a href="/users"><span class="oi oi-people"></span> Manage Users</a></li>
                        <li><a href="{{ route('categories.index') }}"><span class="oi oi-tag"></span> Manage Categories</a></li>
                        <li><a href="{{ route('books.index') }}"><span class="oi oi-book"></span> Manage Books</a></li>
                        <li><a href="{{ route('orders.index') }}"><span  class="oi oi-inbox"></span> Manage Orders</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false"><span class="oi oi-power-standby"></span> Logout</a></li>
    
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="d-block d-md-none">
                            <div class="dropdown-divider"></div>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Setting</a></li>
                            <li>
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" style="cursor:pointer">Sign Out</button>
                                </form>
                            </li>
                        </div>
                    </ul>
                    <div class="pl-3 d-none d-md-block position-fixed" style="bottom: 0px">
                        <span class="oi oi-cog"></span> Setting
                    </div>
                </div>
                <div class="col-lg-10 col-md-9 p-4">
                    <div class="row ">
                        <div class="col-md-12 pl-3 pt-2">
                            <div class="pl-3">
                                <h3>@yield("pageTitle")</h3>
                                <br />
                            </div>
                        </div>
                    </div>
                    @yield("content")
                    <div class="row ">
                        <div class="col-md-12 pl-3 pt-2">
                            <div class="pl-3">
                                <h3>@yield("pageTitle")</h3>
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
        @yield('footer-scripts')
    </body>
</html>
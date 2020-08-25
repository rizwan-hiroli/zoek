  
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="https://zoek.co.in/favicon-32x32.png">
    <title> {{env('APP_NAME','Zoek Applications')}} </title>
    <link href="{{asset('admin/vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    @stack('styles')
    <link href="{{asset('admin/vendor/custom.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/main.css?v=1.1')}}" rel="stylesheet">
    <style type="text/css">
        .nav.side-menu>li.active, .nav.side-menu>li.current-page {
            border-right: 5px solid #F7F7F7;
        }
        .left_col {
            background: #E75297;
        }
        .btn-primary {
            color: #fff;
            background-color: #E75297;
            border-color: #e75198;
        }
        .btn-success {
            color: #fff;
            background-color: #337ab7 !important;
            border-color: #337ab7 !important;
        }
        .invert-footer {
            color: white;
            background: #E75297;
        }
    </style> 
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col fixed_footer">
          <div class="left_col scroll-view" style="background-color:#E75297">
            <div class="navbar nav_title clearfix" style="border: 0;padding-top: 12px;background-color: #E75297">
                  <a class="site_title">
                    <img src="https://zoek.co.in/assets/images/zoek-logo.svg" width="200px" height="50px">
                  </a>
            </div>

            <div class="clearfix"></div><br/>
            <!-- sidebar menu -->
            @include('layouts.sidebar')
          </div>
        </div>

        <!-- top navigation -->
        @include('layouts.header')
    
        {{-- master for listview --}}
        @include('layouts.list_master')

        

        {{-- for only form master --}}
        @include('layouts.form_container') 


        <!-- footer content -->
        @include('layouts.footer')

      </div>
    </div>

    <script src="{{asset('admin/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('admin/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    @stack('scripts')
    <script src="{{asset('admin/vendor/custom.min.js')}}"></script>
    <script src="{{asset('admin/js/main.js?v=1.1')}}"></script>
  </body>
</html>

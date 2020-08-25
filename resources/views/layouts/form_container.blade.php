@hasSection('form_container')
    <link href="{{asset('admin/vendor/pnotify/dist/pnotify.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendor/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet">
    @yield('form_styles')
    
    <div class="right_col" role="main">
      <section class="section">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                  <div class="x_title">
                    <h2>{{$formHeaders['page_title'] ?? ''}}<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox" style="min-width: 30px;">
                      <li style="float: right;">
                          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"><br />
                    @yield('form_container')
                  </div>
              </div>
          </div>
        </div>
      </section>
    </div>
    @push('scripts')
      <script src="{{asset('admin/vendor/plupload/plupload.full.min.js')}}"></script>
      <script src="{{asset('admin/vendor/jquery/dist/jquery.validate.min.js')}}"></script>
      <script src="{{asset('admin/js/PlUpload/plupload.js?v=3.0')}}"></script>
      <script src="{{asset('admin/js/notification.js')}}"></script>
      @stack('form_scripts')
    @endpush
@endif
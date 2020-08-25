@extends('layouts.app')
@push('styles')
    <link href="/admin/vendor/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="/admin/vendor/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media="print">
    <style type="text/css">
        .btn-circle.btn-xl {
          width: 200px;
          height: 200px;
          padding: 10px 16px;
          font-size: 50px;
          line-height: 1.33;
          border-radius: 100px;
        }
    </style>
@endpush

@section('content')
		<!-- page content -->
    <div class="" role="main">
      <div class="row" >
        <div class="text-center top_tiles" style="margin: 10px 0;">
          <div class="col-md-3 col-sm-3 tile">
            <span>Total Students</span>
            <h2>{{$payload['student_count'] ?? '0'}}</h2>
          </div>
          <div class="col-md-3 col-sm-3 tile">
            <span>Total Teachers</span>
            <h2>{{$payload['teacher_count'] ?? '0'}}</h2>
          </div>
          <div class="col-md-3 col-sm-3 tile">
            <span>{{auth()->user()->role == 'ADMIN' ? 'Total Teacher Presents' : 'Monthly Presents'}}</span>
            <h2>{{$payload['total_present'] ?? '0'}}</h2>
          </div>
          <div class="col-md-3 col-sm-3 tile">
            <span>{{auth()->user()->role == 'ADMIN' ? 'Total Student Presents' : 'Monthly Absents'}}</span>
            <h2>{{$payload['total_absent'] ?? '0'}}</h2>
          </div>
        </div>
      </div>
      <br/>
      <!-- <div class="row">
        <div class="col-md-12 col-sm-12 ">
          <div class="dashboard_graph x_panel">
            <div class="x_title">
              <div class="col-md-6">
                <h3>Network Activities <small>Graph title sub-title</small></h3>
              </div><br><br>
              <div class="col-md-6">
              </div>
            </div>
            <div class="x_content">
              <div class="demo-container" style="height:250px">
                <div id="chart_plot_03" class="demo-placeholder"></div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <div class="row">
        <div class="col-md-8 col-sm-6 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Events </h2>
              <ul class="nav navbar-right panel_toolbox">
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div id='calendar'></div>
            </div>
          </div>
        </div>
        <!-- </div> -->
        <!-- <div class="row"> -->
        <div class="col-md-4 col-sm-6">
          <div class="x_panel ">
            <div class="x_title">
              <h2>Today's Attendance </h2>
              <ul class="nav navbar-right panel_toolbox">
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="text-center">
                  @if(isset($payload['attendance']))
                      @if($payload['attendance'])
                          <button type="button" class="btn btn-success btn-circle btn-xl">P</button>
                      @else
                          <button type="button" class="btn btn-danger btn-circle btn-xl">A</i></button>
                      @endif
                  @else
                      <button type="button" class="btn btn-warning btn-circle btn-xl">NA</button>
                  @endif
              </div>
            </div>
          </div>
        </div>
        <!-- </div> -->
        <div class="col-md-4 col-sm-6">
          <div class="x_panel">
            <div class="x_title">
              <h2>Notices</h2>
              <ul class="nav navbar-right panel_toolbox">
                <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> -->
              <!-- </li> -->
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="dashboard-widget-content">
            <ul class="list-unstyled timeline widget">
              @foreach($payload['notices'] as $notice)
                  <li>
                    <div class="block">
                      <div class="block_content">
                        <h2 class="title">
                        <a>{{$notice->title}}</a>
                        </h2>
                        <div class="byline">
                          <span>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$notice->created_at)->diffForHumans()}}
                          </div>
                        </p>
                      </div>
                    </div>
                  </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
    </div>
    <!-- /page content -->
    	
@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script src="/admin/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
    <script type="text/javascript">
        var e,
        f,
        a=new Date,
        b=a.getDate(),
        c=a.getMonth(),
        d=a.getFullYear(),
        g=$("#calendar").fullCalendar( {
            themeSystem: 'bootstrap4',
            header: {
                left: "prev,next ", center: "title", right: ""
            }
            ,
            selectable:!0,
            selectHelper:0,
            select:function(a, b, c) {
                $("#fc_create").click(),
                e=a,
                ended=b,
                $(".antosubmit").on("click", function() {
                  var a=$("#title").val();  
                  return b&&(ended=b), f=$("#event_type").val(), a&&g.fullCalendar("renderEvent", {
                        title: a, start: e, end: b, allDay: c
                    }
                    , !0), $("#title").val(""), g.fullCalendar("unselect"), $(".antoclose").click(), !1
                }
                )
            },
            eventClick:function(a, b, c) {    
            }
            ,
            editable:0,
            events:[
                @foreach($payload['events'] as $event)
                {
                    id:'{{ $event->id }}',
                    title : '{{ $event->event_info }}',
                    start : '{{ $event->start_time }}'+'T00:00:00',
                    end : '{{ $event->end_time }}'+'T01:00:00',
                    allDay:true
                },
                @endforeach
            ]
        }
        ) 

        //Adding colors to caleder button.
        // $('.fc-prev-button').css('color','white');
        // $('.fc-prev-button').css('background-color','#169F85');
        // $('.fc-next-button').css('color','white');
        // $('.fc-next-button').css('background-color','#169F85');
         
    </script>
@endpush
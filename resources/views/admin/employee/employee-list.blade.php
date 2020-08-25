@extends('layouts.app')
@push('styles')
@endpush

@section('content')
      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
          <h2>{{$listViewheaders['page_title']}}<small></small></h2>
          <input type="hidden" name="url" value="{{$listViewheaders['url']}}" id="url">
          <input type="hidden" name="model_name" value="{{$listViewheaders['model_name']}}" id="model_name">
          <ul class="nav navbar-right panel_toolbox" style="min-width: 30px;">
            <li style="float: right;">
                <a class="collapse-link" ><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          
          @if(Route::has($listViewheaders['url'].'.create'))
              <a href="{{$listViewheaders['url'].'/create'}}" class="btn btn-primary  pull-right add_toolbar">
              <i class="fa fa-plus icon"></i>
                Add 
              </a>
          @endif
          
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <table class="table table-bordered" style="margin-bottom: 0px">
              <thead class="thead-light">
                <tr class="table-primary">
                  @foreach($listViewheaders['column_title'] as $column_title)
                      <th>{{$column_title}}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach($data as $dataValue)
                  <tr>
                    @foreach($listViewheaders['database_column'] as $database_cloumn)
                        @if($database_cloumn == 'company')
                            <th>{{$dataValue->company['name'] ?? ''}}</th>
                        @else
                            <th>{{$dataValue->$database_cloumn}}</th>
                        @endif
                    @endforeach
                        <th>
                            <div class="status-column text-center" data-id="{{$dataValue->id}}" data-value="@if(is_null($dataValue->deleted_at)) {{1}} @else {{0}}  @endif ">
                                <label>
                                  @if(is_null($dataValue->deleted_at))
                                    <span class="status-span" data-id="{{$dataValue->id}}" style="color:green">Active</span>
                                  @else
                                    <span class="status-span" data-id="{{$dataValue->id}}" style="color:red">Inactive</span>
                                  @endif
                                </label>
                            </div>
                        </th>
                        <th>
                          <div class="text-center">
                              <a class="btn btn-dark btn-circle btn-sm" href="{{'employee/'.$dataValue->id.'/edit'}}">
                                  <i class="fa fa-edit"></i>
                              </a>
                          </div>
                        </th>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="pull-right">
                {{$data->links()}}
            </div>
        </div>
      </div>
    </div>

@endsection

@push('scripts')
@endpush


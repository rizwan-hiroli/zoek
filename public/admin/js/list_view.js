
//Displaying list view.
var modelName = $('#model_name').val();
var columnsList = $('#columns').val();
var url = $('#url').val();
columnsList = JSON.parse($('#columns').val());


var table = $('.master-datatable').DataTable({
  paging: true,
  // processing: true,
  serverSide: true,
  "dom": 'l<"#master-dataTable_dropdown.dataTable_dropdown col-md-4">frtip',
  "scrollX": true,
  language: {
    loadingRecords: '&nbsp;',
    processing: "<img style='width:160px; height:20px;' src='/admin/images/loader_1.gif' class='spinner'>",
  },
  ajax: {
    url: url,
    data: {
      model_name: modelName
    }
  },
  columns: columnsList,
  "aaSorting": [],
});
// table.ajax.reload(null, false);

if($('#url').val() == 'student' || $('#url').val() == 'attendance'){
    standardList = JSON.parse(standards);
    divisionList = JSON.parse(divisions);
    intidropdown();
}

function intidropdown(){
  $("div.dataTable_dropdown").empty();
  $("div.dataTable_dropdown").html('<div class="row"><div class="col-md-6 form-group"><select name="category" class="form-control category" ><option value="" disabled selected>Select Standard </option></select></div><div class="col-md-6 form-group"><select name="sub_category" class="form-control sub_category" required><option value="" disabled selected>Select Division </option></select></div></div>');

  $.each(standardList, function(key, value) {
       $('.category')
            .append($('<option>', { value : value['id'] })
            .text(value['name']));
  });

  $.each(divisionList, function(key, value) {
       $('.sub_category')
            .append($('<option>', { value : value['id'] })
            .text(value['name']));
  });
 
}

$(document).on('change', '.category', function (e) {
    // modalData();
    var category = $('.category').val();
    var sub_category = $('.sub_category').val();
    var url = $('#url').val();
    $('.master-datatable').DataTable().destroy();
    $('#loader').show();
    var table = $('.master-datatable').DataTable({
        paging: true,
        // processing: true,
        serverSide: true,
        "dom": 'l<"#master-dataTable_dropdown.dataTable_dropdown col-md-4">frtip',
        "scrollX": true,
        language: {
          loadingRecords: '&nbsp;',
          processing: "<img style='width:160px; height:20px;' src='/admin/images/loader_1.gif' class='spinner'>",
        },
        ajax: {
          url: '/admin/'+url,
          data: {
            model_name: modelName,
            category:category,
            sub_category:sub_category
          }
          
        },
        columns: columnsList,
        "aaSorting": [],
        "initComplete": function(settings, json) {
          intidropdown();
          $('.category').val(category);
          $('.sub_category').val(sub_category);
          $('#loader').hide();
        }
    });
  });

$(document).on('change', '.sub_category', function (e) {
    var category = $('.category').val();
    var sub_category = $('.sub_category').val();
    var url = $('#url').val();
    $('.master-datatable').DataTable().destroy();
    $('#loader').show();
    var table = $('.master-datatable').DataTable({
        paging: true,
        // processing: true,
        serverSide: true,
        "dom": 'l<"#master-dataTable_dropdown.dataTable_dropdown col-md-4">frtip',
        "scrollX": true,
        language: {
          loadingRecords: '&nbsp;',
          processing: "<img style='width:160px; height:20px;' src='/admin/images/loader_1.gif' class='spinner'>",
        },
        ajax: {
          url: '/admin/'+url,
          data: {
            model_name: modelName,
            category:category,
            sub_category:sub_category
          }
        },
        columns: columnsList,
        "aaSorting": [],
        "initComplete": function(settings, json) {
          intidropdown();
          $('.category').val(category);
          $('.sub_category').val(sub_category);
          $('#loader').hide();
        }
    });
  });


//script to view notice.
$(document).on('click', '.view-column', function () {
    var id = $(this).attr("data-id");
    $('#noticeTitle').html($('#title'+id).val());
    $('#noticeSectionTitle').html($('#title'+id).val());
    $('#noticeContent').html($('#content'+id).val());
    $('#noticeDate').html($('#date'+id).val());
    $("#noticeModal").modal();
});

//script to view timtable.
$(document).on('click', '.preview-column', function () { 
    var id = $(this).attr("data-id");
    $('#filePath').attr('src',$('#image'+id).val());
    $("#timetableModal").modal();
});


//script to change status.
$(document).on('click', '.status-column', function () {
  var id = $(this).attr("data-id");
  var current_status = $(this).attr("data-value");
  var model_name = $('input[name=model_name]').val();
  var _token = $('input#_token').val();
  // $('#loader').show();
  $.ajax({
    dataType: 'json',
    data: { id: id, model_name: model_name, _token: _token, current_status: current_status },
    type: 'get',
    url: 'status',
    success: function (dt) {
      if (dt.result == 'success') {
        if (dt.status) {
          $("span.status-span[data-id=" + id + "]").html(dt.status_text).css('color', 'green');
          $(".status-column[data-id=" + id + "]").attr('data-value', 1);
        } else {
          $("span.status-span[data-id=" + id + "]").html(dt.status_text).css('color', 'red');
          $(".status-column[data-id=" + id + "]").attr('data-value', 0);
        }
        $('#loader').hide();
      }
      else {

      }
      $('#loader').hide();
    },
    error: function (data) {
    },
    complete: function () {
    }
  });

});


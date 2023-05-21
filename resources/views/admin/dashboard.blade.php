@extends('admin.admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

<div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
      </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
      <ul class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <i class="mdi mdi-timetable"></i>
          <span><?php
            $today = date("d/m/Y");
            echo $today;
          ?></span>
        </li>
      </ul>
    </nav>
  </div>
  <div class="row">
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-danger card-img-holder text-white">
        <div class="card-body">
            
          <img src="{{ asset('public/backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Weekly Sales <i class="mdi mdi-chart-line mdi-24px float-right"></i>
          </h4>
          <h2 class="mb-5">$ 15,0000</h2>
          <h6 class="card-text">Increased by 60%</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-info card-img-holder text-white">
        <div class="card-body">
          <img src="{{ asset('public/backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Weekly Orders <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
          </h4>
          <h2 class="mb-5">45,6334</h2>
          <h6 class="card-text">Decreased by 10%</h6>
        </div>
      </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
      <div class="card bg-gradient-success card-img-holder text-white">
        <div class="card-body">
          <img src="{{ asset('public/backend/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-right"></i>
          </h4>
          <h2 class="mb-5">95,5741</h2>
          <h6 class="card-text">Increased by 5%</h6>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="clearfix">
            <h4 class="card-title float-left">Doanh Thu</h4>
            {{-- <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div> --}}
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Từ Ngày</label>
              <input type="text" placeholder="Ngày bắt đầu" class="ms-2" id="date_start" style="width: 140px" autocomplete="off">
            </div>
            <div class="col-md-4" style="text-align: center">
              <label>Đến Ngày</label>
              <input type="text" name="" placeholder="Ngày kết thúc" id="date_end" style="width: 140px" autocomplete="off">
            </div>
          <div class="col-md-4">
              <button type="button" class="btn btn-success" id="btn_filter">Lọc</button>
          </div>
          </div>
          {{-- <canvas id="visit-sale-chart" class="mt-4"></canvas> --}}
          <div id="chart" style="height: 250px;"></div>
        </div>
      </div>
    </div>
    {{-- <div class="col-md-5 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Traffic Sources</h4>
          <canvas id="traffic-chart"></canvas>
          <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
        </div>
      </div>
    </div> --}}
  </div>
  {{-- <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Recent Tickets</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th> Assignee </th>
                  <th> Subject </th>
                  <th> Status </th>
                  <th> Last Update </th>
                  <th> Tracking ID </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                   
                    <img src="{{ asset('public/backend/assets/images/faces/face1.jpg') }}" class="me-2" alt="image"> David Grey
                  </td>
                  <td> Fund is not recieved </td>
                  <td>
                    <label class="badge badge-gradient-success">DONE</label>
                  </td>
                  <td> Dec 5, 2017 </td>
                  <td> WD-12345 </td>
                </tr>
                <tr>
                  <td>
                    <img src=" {{ asset('public/backend/assets/images/faces/face2.jpg') }}" class="me-2" alt="image"> Stella Johnson
                  </td>
                  <td> High loading time </td>
                  <td>
                    <label class="badge badge-gradient-warning">PROGRESS</label>
                  </td>
                  <td> Dec 12, 2017 </td>
                  <td> WD-12346 </td>
                </tr>
                <tr>
                  <td>
                    <img src=" {{ asset('public/backend/assets/images/faces/face3.jpg') }}" class="me-2" alt="image"> Marina Michel
                  </td>
                  <td> Website down for one week </td>
                  <td>
                    <label class="badge badge-gradient-info">ON HOLD</label>
                  </td>
                  <td> Dec 16, 2017 </td>
                  <td> WD-12347 </td>
                </tr>
                <tr>
                  <td>
                    <img src=" {{ asset('public/backend/assets/images/faces/face4.jpg') }}" class="me-2" alt="image"> John Doe
                  </td>
                  <td> Loosing control on server </td>
                  <td>
                    <label class="badge badge-gradient-danger">REJECTED</label>
                  </td>
                  <td> Dec 3, 2017 </td>
                  <td> WD-12348 </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div> --}}

  {{-- <div class="row">
    <div class="col-md-7 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Project Status</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th> # </th>
                  <th> Name </th>
                  <th> Due Date </th>
                  <th> Progress </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td> 1 </td>
                  <td> Herman Beck </td>
                  <td> May 15, 2015 </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td> 2 </td>
                  <td> Messsy Adam </td>
                  <td> Jul 01, 2015 </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td> 3 </td>
                  <td> John Richards </td>
                  <td> Apr 12, 2015 </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td> 4 </td>
                  <td> Peter Meggik </td>
                  <td> May 15, 2015 </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td> 5 </td>
                  <td> Edward </td>
                  <td> May 03, 2015 </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td> 5 </td>
                  <td> Ronald </td>
                  <td> Jun 05, 2015 </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title text-white">Todo</h4>
          <div class="add-items d-flex">
            <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
            <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
          </div>
          <div class="list-wrapper">
            <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
              <li>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox"> Meeting with Alisa </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li>
              <li class="completed">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox" checked> Call John </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li>
              <li>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox"> Create invoice </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li>
              <li>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox"> Print Statements </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li>
              <li class="completed">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li>
              <li>
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
  $.datepicker.formatDate( "yy-mm-dd");
  $('#date_start').datepicker({
    dateFormat: "yy-mm-dd",
    prevText: 'Tháng trước',
    nextText: 'Tháng sau',
    dayNamesMin: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
    duration: 'slow',
  });
  $('#date_end').datepicker({
    dateFormat: "yy-mm-dd",
    prevText: 'Tháng trước',
    nextText: 'Tháng sau',
    dayNamesMin: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ Nhật'],
    duration: 'slow',
  });
</script>
<script>
  var chart = new Morris.Bar({

    element: 'chart',
    lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4ADD3', '#766B56'],
    parseTime: false, 
    hideHover: 'auto',
    data: [
      { year: '2008', value: 20 },
    { year: '2009', value: 10 },
    { year: '2010', value: 5 },
    { year: '2011', value: 5 },
    { year: '2012', value: 20 }
    ],
    // The name of the data record attribute that contains x-values.
    xkey: 'period',
    // A list of names of data record attributes that contain y-values.
    ykeys: ['order', 'sales', 'profit', 'quantity'],
  
    behaveLikeLine: true,
    labels: ['đơn hàng', 'doanh số', 'lợi nhuận', 'số lượng'],
});

  chart5day();
  function chart5day(){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: '{{ url('/admin/dashboard/doanh-thu-five-day') }}',
      method: 'GET',
      dateType: 'JSON',
      data:{
        
        _token: _token,
      },
      success: function(data){
        // console.log(data);
        chart.setData(JSON.parse(data));
      },
      error:  function() {
          alert("Bug Huhu filter :<<");
      }
    })
  }

  $('#btn_filter').click(function(){
    var _token = $('meta[name="csrf-token"]').attr('content');
    var date_from = $('#date_start').val();
    var date_to = $('#date_end').val();
    // alert(date_from + " " + date_to);
    $.ajax({
      url: '{{ url('/admin/dashboard/filter-doanh-thu') }}',
      method: 'GET',
      dateType: 'JSON',
      data:{
        date_from: date_from,
        date_to: date_to,
        _token: _token,
      },
      success: function(data){
        chart.setData(JSON.parse(data));
      },
      error:  function() {
          alert("Bug Huhu filter :<<");
      }
    })
  });
  
</script>


@endsection
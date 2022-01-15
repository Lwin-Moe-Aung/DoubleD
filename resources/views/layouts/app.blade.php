<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

   {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/> --}}
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="https://cdn.datatables.net/rowgroup/1.1.1/css/rowGroup.bootstrap4.min.css" /> --}}
    
    <!-- DataTables -->
    <link href="{{ asset('css/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('css/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('css/datatables-buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" >
    <!-- Theme style -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('third_party_stylesheets')
    @yield('css')
    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
          </li>
       
        </ul>
        
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Navbar Search -->
          <li class="nav-item">
           
            <div class="navbar-search-block">
              <form class="form-inline">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                      <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li>
    
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false" onclick="getNotification()">
              <i class="far fa-comments"></i>
                @if (auth()->user()->noti_count == 0)
                  <span class="badge badge-danger navbar-badge" id="noti_count" ></span>
                @else
                  <span class="badge badge-danger navbar-badge" id="noti_count" >{{ auth()->user()->noti_count }}</span>
                @endif
              
              <input type="text" class="form-control" id="user_id" value="{{ auth()->user()->id }}" hidden>

            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;" id="noti_panel">
             
            
              
            </div>
          </li>
        
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
        
          <li class="user-footer">
            
            <a href="#" class="btn btn-default btn-flat float-right"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Sign out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        </ul>
      </nav>
    

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
          @include('admin/flash/flash-message')
          @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1
        </div>
        <strong>Copyright &copy; 2022 <a href="#">Myanmar2D</a> </strong> All rights
        reserved.
    </footer>
</div>

{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

{{-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script> --}}
{{-- <script src="{{ asset('js/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery-validation/additional-methods.min.js') }}"></script> --}}
<script src="{{ asset('js/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery-validation/additional-methods.min.js') }}"></script>

 <!-- datatable -->
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script src="{{ asset('js/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script>
    // let ip_address = '127.0.0.1';
    let ip_address = '18.183.209.242';
 
    let socket_port = '8005';
    let user_id = $('#user_id').val();
    let socket = io(ip_address + ':' + socket_port);
    socket.on("notification-channel-"+user_id, function (message)
    {
      console.log(message);
      $('#noti_count').html(message);
    });

    function getNotification() {
      
      $.ajax({
          url: "/get-notification",
          type: "GET",
          dataType: 'json',
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (data) {
            if(!$.isEmptyObject(data)){
              $('#noti_panel').html("");
              var html = "";
              var link = '';
              data.forEach(element => {
                link = element.link
                html += '<a href="'+link+'" class="dropdown-item"><div class="media">'+
                              '<img src="'+element.image+'" alt="User Avatar" class="img-size-50 mr-3 img-circle">'+
                                '<div class="media-body">'+
                                  '<h3 class="dropdown-item-title">'+element.subject+
                                    '<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>'+
                                  '</h3>'+
                                  '<p class="text-sm">'+element.description+'</p>'+
                                  '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '+element.created_at+'</p>'+
                                '</div>'+
                              '</div>'+
                            '</a>'+
                            '<div class="dropdown-divider"></div>'
              });
              html += '<a href="'+link+'" class="dropdown-item dropdown-footer">See All Messages</a>'
              $('#noti_panel').append(html);
              $('#noti_count').html('');
            }else{
                alert("fail to delete Mails");
            }
            
          }
    });
  }
</script>

@yield('scripts')

@stack('page_scripts')
</body>
</html>

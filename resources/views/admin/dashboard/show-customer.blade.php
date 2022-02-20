@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-success" id="alert-success" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>Customer ဖျက်ချင်းအောင်မြင်ပါတယ်ရှင့်။</strong>
                </div>
               
                <div class="row">
                    
                    <div class="col-12">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                              <h1 class="m-0">Customer Lists</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Back</a></li>
                              </ol>
                            </div><!-- /.col -->
                          </div>
                        <!-- /.card-header -->
                        <section class="content overflow-auto">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                          
                                           
                                            <!-- /.card-header -->
                                            <div class="card-body" >
                                                <table id="subAdminDataTable" class="table table-bordered table-striped" width="100%" >
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.card-body -->
                    <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>
    </div>

    @include('admin.dashboard.delete-customer-modal')
     
@endsection
@section('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script> --}}

<script>
    $(function () {
        
        // let ip_address = '127.0.0.1';
        // // let ip_address = '18.183.164.200';
        // let socket_port = '8005';
        // let socket = io(ip_address + ':' + socket_port);
        // socket.on("private", function (message)
        //     {
        //         console.log(message);
        //     });
       
        var table = $('#subAdminDataTable').DataTable({
            responsive: true, "lengthChange": false, "autoWidth": false,
            // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            columnDefs: [
                { "width": "20%", "targets": 0 }
            ],
           
            ajax: "{{ route('home.customer') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'image', name: 'image',"render": function (data, type, full, meta) {
        return "<img src=\"" + data + "\" height=\"50\"/>";
    },},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
        });
        //delete
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteCustomer').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "customer-delete/"+id,
                method: 'POST',
                success: function(result) {
                    $('.alert-success').hide();
                    $('.alert-danger').hide();
                    $('#alert-success').show();
                    $('#alert-info').hide();
                    $('#subAdminDataTable').DataTable().ajax.reload();
                    $('#DeleteSubAdminModal').modal('toggle');
                },
                error: function(result) {
                    $('.alert-success').hide();
                    $('.alert-danger').hide();
                    $('#alert-success').hide();
                    $('#alert-info').show();
                    $('#DeleteSubAdminModal').modal('toggle');
                }
            });
        });
        //end delete
       
       
        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

    }); 
</script>
@endsection
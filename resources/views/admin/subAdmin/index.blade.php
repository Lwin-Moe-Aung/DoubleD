@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-success" id="alert-success" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>sub admin ဖျက်ချင်းအောင်မြင်ပါတယ်ရှင့်။</strong>
                </div>
               
                <div class="row">
                    <div class="col-12">
                       
                        <!-- /.card-header -->
                        <section class="content overflow-auto">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div style="float:right;">
                                                    <a  class="btn btn-block bg-gradient-success" href="{{ route('sub-admins.create') }}">&plus;Add</a>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body" >
                                                <table id="subAdminDataTable" class="table table-bordered table-striped" width="100%" >
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Role</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Role</th>
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


    <!-- Edit Modal-->
    @include('admin.subAdmin.edit-modal')
    
     <!-- Delete Article Modal -->
     @include('admin.subAdmin.delete-modal')
     
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
           
            ajax: "{{ route('sub-admins.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
        });
        //delete
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteSubAdminForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "sub-admins-delete/"+id,
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
        // edit user
        $('body').on('click', '.editUser', function () {
            $(".print-error-msg").css('display','none');
           
            var user_id = $(this).data('id');
            $.get("{{ route('sub-admins.index') }}" +'/' + user_id +'/edit', function (data) {
                $('#modelHeading').html("Edit User");
                $('#editBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#user_id').val(data.id);
                $('#inputName').val(data.name);
                $('#inputEmail').val(data.email);
                $('#inputPassword').val("");
            })
        });
        $('#editBtn').click(function (e) {
                e.preventDefault();
                // $(this).html('Sending..');
                var usr_id = $('#user_id').val();
                //alert(usr_id);
                $.ajax({
                    data: $('#userForm').serialize(),
                    url: "/sub-admins/" + usr_id,
                    type: "PUT",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if($.isEmptyObject(data.error)){
                            $('#userForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        }else{
                            printErrorMsg(data.error);
                            // $('#editBtn').html('Save Changes');
                        }
                       
                    
                    }
            });
        });
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
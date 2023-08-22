@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-success" id="alert-success" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>stock ဖျက်ချင်းအောင်မြင်ပါတယ်ရှင့်။</strong>
                </div>
                <div class="alert alert-info" id="alert-info" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>ဒီ stock နံပါတ်သည် ထွက်ပီးသားနံပါတ်ဖြစ်နေသောကြောင့် ဖျက်၍မရနိုင်ပါရှင့်။</strong>
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
                                                    <a  class="btn btn-block bg-gradient-success" href="{{ route('stocks.create') }}">&plus;Add</a>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body" >
                                                <table id="stockDataTable" class="table table-bordered table-striped" width="100%" >
                                                    <thead>
                                                        <tr>
                                                            <th>selected_item</th>
                                                            <th>item</th>
                                                            <th>created_at</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            
                                                            <th>selected_item</th>
                                                            <th>item</th>
                                                            <th>created_at</th>
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

     <!-- Delete Article Modal -->
     <div class="modal" id="DeleteStockModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Stock ဖျက်မည်။</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4>Stock ကိုဖျက်မှာ သေချာပါသလားရှင့်..?</h4>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="SubmitDeleteStockForm">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>

<script>
    $(function () {
        //testing socket data
        // let ip_address = '127.0.0.1';
        let ip_address = '18.136.197.205';
  
        let socket_port = '8005';
        let socket = io(ip_address + ':' + socket_port);
        socket.on("private", function (message)
        {
            console.log('stock upload channel');
            console.log(message);
        });
        socket.on("livechat-channel", function (message)
        {
            console.log('livechat channel');
            console.log(message);
        });
        socket.on("tip-upload-channel", function (message)
        {
            console.log('tip-upload-channel');
            console.log(message);
        });
        socket.on("notification-channel", function (message)
        {
            console.log('notification-channel');
            console.log(message);
        });

        //testing socket data
        
        var table = $('#stockDataTable').DataTable({
            responsive: true, "lengthChange": false, "autoWidth": false,
            // buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            processing: true,
            serverSide: true,
            columnDefs: [
                { "width": "20%", "targets": 0 }
            ],
           
            ajax: "{{ route('stocks.index') }}",
            columns: [
                {data: 'selected_stock', name: 'selected_stock'},
                {data: 'stock', name: 'stock'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
        });
        //delete
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteStockForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "stock-delete/"+id,
                method: 'POST',
                success: function(result) {
                    $('.alert-success').hide();
                    $('.alert-danger').hide();
                    $('#alert-success').show();
                    $('#alert-info').hide();
                    $('#stockDataTable').DataTable().ajax.reload();
                    $('#DeleteStockModal').modal('toggle');
                },
                error: function(result) {
                    $('.alert-success').hide();
                    $('.alert-danger').hide();
                    $('#alert-success').hide();
                    $('#alert-info').show();
                    $('#DeleteStockModal').modal('toggle');
                }
            });
        });
        //end delete
    }); 
</script>
@endsection
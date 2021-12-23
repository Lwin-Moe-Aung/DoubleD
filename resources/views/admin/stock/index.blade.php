@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 " style="overflow-x: scroll;">
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
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>

<script>
    $(function () {
        
        let ip_address = '127.0.0.1';
        let socket_port = '8005';
        let socket = io(ip_address + ':' + socket_port);
        socket.on("private", function (message)
            {
                console.log(message);
            });
        // $("#stockDataTable").DataTable({
        //         "responsive": true, "lengthChange": false, "autoWidth": false,
        //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        //     $('#example2').DataTable({
        //         "paging": true,
        //         "lengthChange": false,
        //         "searching": false,
        //         "ordering": true,
        //         "info": true,
        //         "autoWidth": false,
        //         "responsive": true,
        //     });
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
        
    }); 
</script>
@endsection
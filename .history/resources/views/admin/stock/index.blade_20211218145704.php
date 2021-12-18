@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                    
                        <div class="card">
                            <!-- SidebarSearch Form -->
                            <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-sidebar">
                                            <i class="fas fa-search fa-fw"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <h3 class="card-title">Admin List</h3>
                                <div style="float:right;">
                                    <a  class="btn btn-block bg-gradient-success" href="{{ route('stocks.create') }}">&plus;Add</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>Date</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td>Aung Aung1</td>
                                <td>aungaung@gmail.com
                                </td>
                                <td>0983736347</td>
                                <td>4/5/2021</td>
                                <td><code>view</code>&nbsp;/&nbsp;<code>edit</code>&nbsp;/&nbsp;<code>delete</code></td>
                                </tr>
                                <tr>
                                <td>Mg Mg</td>
                                <td>mgmg@gmail.com
                                </td>
                                <td>0983736347</td>
                                <td>4/5/2021</td>
                                <td><code>view</code>&nbsp;/&nbsp;<code>edit</code>&nbsp;/&nbsp;<code>delete</code></td>
                                </tr>
                                <tr>
                                <td>Mya Mya</td>
                                <td>myamya@gmail.com
                                </td>
                                <td>0983736347</td>
                                <td>4/5/2021</td>
                                <td><code>view</code>&nbsp;/&nbsp;<code>edit</code>&nbsp;/&nbsp;<code>delete</code></td>
                                </tr>
                                <tr>
                                <td>Hla Hla</td>
                                <td>hlahla@gmail.com
                                </td>
                                <td>0983736347</td>
                                <td>4/5/2021</td>
                                <td><code>view</code>&nbsp;/&nbsp;<code>edit</code>&nbsp;/&nbsp;<code>delete</code></td>
                                </tr>
                                <tr>
                                <td>U Ba</td>
                                <td>uba@gmail.com
                                </td>
                                <td>0983736347</td>
                                <td>4/5/2021</td>
                                <td><code>view</code>&nbsp;/&nbsp;<code>edit</code>&nbsp;/&nbsp;<code>delete</code></td>
                                </tr>
                                <tr>
                                <td>Daw Hla</td>
                                <td>dawhla@gmail.com
                                </td>
                                <td>0983736347</td>
                                <td>4/5/2021</td>
                                <td><code>view</code>&nbsp;/&nbsp;<code>edit</code>&nbsp;/&nbsp;<code>delete</code></td>
                                </tr>
                                <tr>
                                <td>Kyaw Kya</td>
                                <td>kyawkyaw@gmail.com
                                </td>
                                <td>0983736347</td>
                                <td>4/5/2021</td>
                                <td><code>view</code>&nbsp;/&nbsp;<code>edit</code>&nbsp;/&nbsp;<code>delete</code></td>
                                </tr>
                                
                                </tbody>
                                <tfoot>
                                <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>Date</th>
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
    </div>
@endsection
@section('scripts')

<script>
    $(function () {
        let ip_address = '127.0.0.1';
        let socket_port = '8005';
        let socket = io(ip_address + ':' + socket_port);

        socket.on("private-channel:App\Events\StockEvent", function (message)
            {
               alert(message);
            });
    }); 
</script>
@endsection
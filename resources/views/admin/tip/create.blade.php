@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="content">
            <div class="container-fluid">
                <section class="content">
                    <section class="container-fluid">
                    <div class="row">
                       
                        <div class="col-md-6">
                            <section class="content-header">
                                <div class="container-fluid">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1>Stock</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="#">Stock</a></li>
                                                <li class="breadcrumb-item active">Add</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div><!-- /.container-fluid -->
                            </section>
                            <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <!-- jquery validation -->
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Add new Tips</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form action="{{ route('tips.store') }}" method="POST" id="stockForm">
                                                    @csrf
                                                   
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Tip</label>
                                                            <input type="text" name="tip" class="form-control"
                                                                id="inputTip" placeholder="Enter Tip Numbers" required>
                                                           
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="radio" value="is_morning" checked>
                                                            <label class="form-check-label">Is Morning</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="radio" value="is_evening">
                                                            <label class="form-check-label">Is Evening</label>
                                                        </div>
                
                                                    </div>
                                                    <!-- /.card-body -->
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary float-right ml-2">Save</button>
                                                        {{-- <button  class="btn btn-default float-right">Cancle</button> --}}
                                                        <a href="{{ url()->previous() }}" class="btn btn-default float-right">Back</a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!--/.col (left) -->
                                        <!-- right column -->
                                        <div class="col-md-6">
                
                                        </div>
                                        <!--/.col (right) -->
                                    </div>
                                    <!-- /.row -->
                                </div><!-- /.container-fluid -->
                            </section>
                            <!-- /.content -->
                        </div>
                        <!-- /.col -->
                    </div>
                    </section>
                </section>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
@endsection
@section('scripts')

<script>
    $(function () {
        
      /*   $.validator.setDefaults({
            submitHandler: function () {
                alert("Form successful submitted!");
            }
        }); */
       /*  $('#stockForm').validate({
            rules: {
                stock: {
                    required: true,
                    number: true,
                }
            },
            messages: {
                stock: {
                    required: "Please enter a Stock number",
                    number: "Please enter a vaild Number"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });  */
    }); 
</script>
@endsection

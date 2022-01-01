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
                                            <h1>Sub Admin</h1>
                                        </div>
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="#">Sub Admin</a></li>
                                                <li class="breadcrumb-item active">Edit</li>
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
                                                    <h3 class="card-title">Add new Sub Admin</h3>
                                                </div>
                                                @if($errors->any())
                                                    <div class="alert alert-danger">
                                                        <p><strong>Opps Something went wrong</strong></p>
                                                        <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form action="{{ route('sub-admins.store') }}" method="POST" id="subAdminForm">
                                                    @csrf
                                                   
                                                    <div class="card-body">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="inputName">Name</label>
                                                                <input type="text" name="name" class="form-control" 
                                                                    id="inputName" placeholder="Enter name" value="{{Request::old('name')}}">
                                                              </div>
                                                              <div class="form-group">
                                                                <label for="inputEmail">Email address</label>
                                                                <input type="email" name="email" class="form-control" 
                                                                    id="inputEmail" placeholder="Enter email" value="{{Request::old('email')}}">
                                                              </div>
                                                            <div class="form-group">
                                                                <label for="inputPassword">Password</label>
                                                                <input type="password" name="password" class="form-control"
                                                                    id="inputPassword" placeholder="Enter Password" value="{{Request::old('password')}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputConfirmPassword">Conirm Password</label>
                                                                <input type="password" name="confirm_password" class="form-control"
                                                                    id="inputConfirmPassword" placeholder="Enter Confirm Password" value="{{Request::old('confirm_password')}}">
                                                            </div>
                    
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
        
    
        $('#stockForm').validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6
                }

            },
            messages: {
                name: {
                    required: "နာမည်ထည့် ရန်လိုအပ့်ပါသည်။",
                },
                email: {
                    required: "email ထည့် ရန်လိုအပ့်သည်။",
                },
                password: {
                    required: "password ထည့် ရန်လိုအပ့်သည်။",
                },
                confirm_password: {
                    required: "confirm password ထည့် ရန်လိုအပ့်သည်။",
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
        });
    }); 
</script>
@endsection

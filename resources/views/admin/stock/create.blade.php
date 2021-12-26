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
                                                    <h3 class="card-title">Add new Stock</h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form action="{{ route('stocks.store') }}" method="POST" id="stockForm">
                                                    @csrf
                                                   
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Stock</label>
                                                            <input type="number" name="stock" class="form-control"
                                                                id="inputStock" placeholder="Enter Stock Number">
                                                           
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="radio" value="none" checked>
                                                              <label class="form-check-label">None</label>
                                                            </div>
                                                            @if ($selected_log != null)
                                                                @switch($selected_log)
                                                                    @case($selected_log->morning_second_select == null)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="radio" value="morning_second_select">
                                                                            <label class="form-check-label">Morning Second Number</label>
                                                                        </div>
                                                                        <input type="text" name="type" class="form-control"
                                                                            value= "morning_second_select" hidden id="type">
                                                                        @break
                                                                    @case($selected_log->evening_first_select == null)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="radio" value="evening_first_select">
                                                                            <label class="form-check-label">Evening First Number</label>
                                                                        </div>
                                                                        <input type="text" name="type" class="form-control"
                                                                            value= "evening_first_select" hidden id="type">
                                                                        {{-- <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="radio" value="evening_second_select">
                                                                            <label class="form-check-label">6:00 Number</label>
                                                                        </div> --}}
                                                                        @break
                                                                    @case($selected_log->evening_second_select == null)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="radio" value="evening_second_select">
                                                                            <label class="form-check-label">Evening Second Number</label>
                                                                        </div>
                                                                        <input type="text" name="type" class="form-control"
                                                                            value= "evening_second_select" hidden id="type">
                                                                        @break
                                                                    @default
                                                                        <div class="alert alert-success">
                                                                            <strong>Good Job!</strong> Upload complete for Today.Thanks! 
                                                                        </div>
                                                                        <input type="text" name="type" class="form-control"
                                                                            value= "today-complete" hidden id="type">
                                                                @endswitch
                                                            @else
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="radio" value="morning_first_select">
                                                                    <label class="form-check-label">Morning First Number</label>
                                                                </div>
                                                                <input type="text" name="type" class="form-control"
                                                                value= "morning_first_select" hidden id="type">
                                                                {{-- <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="radio" value="morning_second_select">
                                                                <label class="form-check-label">2:00 Number</label>
                                                                </div> --}}
                                                            @endif
                                                        </div>
                                                        <input type="text" name="user_id" class="form-control"
                                                            value= 1 hidden>
                                                        <input type="text" name="first_p" class="form-control"
                                                            value="{{ $position->first_p }}" hidden>
                                                        <input type="text" name="second_p" class="form-control"
                                                            value="{{ $position->second_p }}" hidden>
                
                                                    </div>
                                                    <!-- /.card-body -->
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary float-right ml-2" id="uploadButton">Upload</button>
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
        var type = document.getElementById("type").value;
        if(type == "today-complete"){
            document.getElementById("inputStock").disabled = true; 
            document.getElementById("uploadButton").disabled = true; 
        }
       
        // $.validator.setDefaults({
        //     submitHandler: function () {
        //         alert("Form successful submitted!");
        //     }
        // });
        $('#stockForm').validate({
            rules: {
                stock: {
                    required: true,
                    number: true,
                    minlength: 8,
                    maxlength: 8
                }
            },
            messages: {
                stock: {
                    required: "နံပါတ်များကို ရိုက်ထည့် ရန်လိုအပ့်သည်။",
                    number: "နံပါတ် ဂဏန်းများကိုသာ ရိုက်ထည့်ပေးပါ",
                    minlength: "နံပါတ် ၈ လုံးထက်နည်းနေ ပါသည်။",
                    maxlength: "နံပါတ် ၈ လုံးထက် များနေ ပါသညါ။"

                    
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

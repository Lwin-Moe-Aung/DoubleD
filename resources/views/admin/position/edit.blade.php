@extends('layouts.app')

@section('content')
    <div class="container-fluid">
       
        <div class="content">
            <div class="container-fluid">
                <section class="content">
                    <section class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                               
                                <div class="card-body pad table-responsive">
                                    <p><code style="font-size: 15px;">Your selected number position will use to show customer</code></p>
                                    <form action="{{ route('positions.update',$position->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>Select First Position:</label>
                                            <select class="form-control" name="first_p">
                                                <option value="1" @if ($position->first_p == 1) selected @endif>Position 1</option>
                                                <option value="2" @if ($position->first_p == 2) selected @endif>Position 2</option>
                                                <option value="3" @if ($position->first_p == 3) selected @endif>Position 3</option>
                                                <option value="4" @if ($position->first_p == 4) selected @endif>Position 4</option>
                                                <option value="5" @if ($position->first_p == 5) selected @endif>Position 5</option>
                                                <option value="6" @if ($position->first_p == 6) selected @endif>Position 6</option>
                                                <option value="7" @if ($position->first_p == 7) selected @endif>Position 7</option>
                                                <option value="8" @if ($position->first_p == 8) selected @endif>Position 8</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Second Position:</label>
                                            <select class="form-control" name="second_p">
                                                <option value="1" @if ($position->second_p == 1) selected @endif>Position 1</option>
                                                <option value="2" @if ($position->second_p == 2) selected @endif>Position 2</option>
                                                <option value="3" @if ($position->second_p == 3) selected @endif>Position 3</option>
                                                <option value="4" @if ($position->second_p == 4) selected @endif>Position 4</option>
                                                <option value="5" @if ($position->second_p == 5) selected @endif>Position 5</option>
                                                <option value="6" @if ($position->second_p == 6) selected @endif>Position 6</option>
                                                <option value="7" @if ($position->second_p == 7) selected @endif>Position 7</option>
                                                <option value="8" @if ($position->second_p == 8) selected @endif>Position 8</option>
                                            </select>
                                        </div>
                                        <button type="submit"  class="btn btn-primary btn-lg float-right">Save</button>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
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

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="content">
            <div class="container-fluid">
                <section class="content">
                    <section class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <div style="float:right;">
                                        <a  class="btn btn-block bg-gradient-success" href="{{ route('positions.edit',$position->id) }}">+Edit</a>
                                        
                                    </div>
                                </div>
                                <div class="card-body pad table-responsive">
                                    <table class="table table-bordered text-center">
                                        <tr>
                                            <th>Position <code>{{ $position->first_p }}</code></th>
                                            <th>Position <code>{{ $position->second_p }}</code></th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="button"  class="btn btn-block btn-outline-primary btn-lg">Position <code>{{ $position['first_p'] }}</code></button>
                                            </td>
                                            <td>
                                                <button type="button"  class="btn btn-block btn-outline-primary btn-lg">Position <code>{{ $position['second_p'] }}</code></button>
                                            </td>
                                        </tr>
                                    </table>
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

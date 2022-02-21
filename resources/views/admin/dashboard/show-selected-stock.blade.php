@extends('layouts.app')

@section('content')
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
   
    <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Home/History</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Back</a></li>
          </ol>
        </div><!-- /.col -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
       
        <div class="row">
            @foreach ($return_data as $data)
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="info-box bg-gradient-{{ $data['className'] }}">
                        <div class="info-box-content text-center">
                            <span class="info-box-text">{{ $data["date"] }}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="info-box-text">Morning</span>
                            <span class="info-box-number">
                                {{ $data['stock']['morning']['selected_stock1'] }}{{ $data['stock']['morning']['selected_stock2'] }}
                            </span>
                            <span class="info-box-number">
                                {{ $data['stock']['morning']['stock'] }}
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="info-box-text">Evening</span>
                            <span class="info-box-number">
                                {{ $data['stock']['evening']['selected_stock1'] }}{{ $data['stock']['evening']['selected_stock2'] }}
                            </span>
                            <span class="info-box-number">
                                {{ $data['stock']['evening']['stock'] }}
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                <span class="info-box-text">Tips</span>
                                {{ $data['tips']['morning']== "" ? '_' : $data['tips']['morning'] }} , {{ $data['tips']['evening']== "" ? '_' : $data['tips']['evening']}}

                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            @endforeach
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@endsection

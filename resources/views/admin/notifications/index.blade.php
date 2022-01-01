@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        
                            <div class="card card-primary card-outline">
                              <div class="card-header">
                                @if (auth()->user()->role == "Admin")
                                  <div class="float-right">
                                    <a class="btn bg-gradient-success btn-sm" href="javascript:void(0)" id="createNewProduct">&plus;New Mail</a>
                                    <!-- /.btn-group -->
                                  </div>
                                @endif
                                <!-- /.card-tools -->
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body p-0">
                                <div class="mailbox-controls">
                                  <!-- Check all button -->
                                  <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                  </button>
                                  @if (auth()->user()->role == "Admin")
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-default btn-sm" onclick="deleteMail()">
                                        <i class="far fa-trash-alt"></i>
                                      </button>
                                    </div>
                                  @endif
                                  <!-- /.btn-group -->
                                  <button type="button" class="btn btn-default btn-sm" onclick = "locationreload()">
                                    <i class="fas fa-sync-alt"></i>
                                  </button>
                                  <div class="float-right">
                                    <div class="card-tools">
                                      <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" id="user_id" value="{{ auth()->user()->id }}" hidden>
                                        {{-- <input type="text" class="form-control" placeholder="Search Mail" id="search" name="search"> --}}
                                        {{-- <div class="input-group-append">
                                            <div class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </div>
                                        </div> --}}
                                      </div>
                                    </div>
                                    <!-- /.btn-group -->
                                  </div>
                                  <!-- /.float-right -->
                                </div>
                                <div class="table-responsive mailbox-messages">
                                  <table class="table table-hover table-striped">
                                    <tbody>
                                      @if(!empty($data) && $data->count())
                                        @foreach($data as $key => $value)
                                          <tr>
                                            <td>
                                              <div class="icheck-primary">
                                                <input type="checkbox" value="{{$value->id }}" id="check{{$value->id}}">
                                                <label for="check1"></label>
                                              </div>
                                            </td>
                                            <td class="mailbox-star" onclick="readMail({{$value->id }})"><i class="fas fa-star text-warning"></i></a></td>
                                            <td class="mailbox-name" onclick="readMail({{$value->id }})"><a href="#">Admin</a></td>
                                            <td class="mailbox-subject" onclick="readMail({{$value->id }})"><b>{{Str::limit($value->subject, 57)}}-</b> {{ Str::limit($value->description, 40, $end='...') }}
                                            </td>
                                            <td class="mailbox-attachment" onclick="readMail({{$value->id }})"></td>
                                            <td class="mailbox-date" onclick="readMail({{$value->id }})"> {{ \Carbon\Carbon::parse($value->created_at)->diffForHumans() }}</td>
                                          </tr>
                                          @include('admin.notifications.read-mail-modal')
                                        @endforeach
                                      @else
                                          <tr>
                                              <td colspan="10">There are no data.</td>
                                          </tr>
                                      @endif
                                   
                                    
                                    </tbody>
                                  </table>
                                  <!-- /.table -->
                                  {!! $data->links() !!}
                                </div>
                                <!-- /.mail-box-messages -->
                              </div>
                              <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                    <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>
    </div>
    @include('admin.notifications.modal-box')

@endsection
@section('css')
<style>
   tr {
      cursor: pointer;
    }
</style>
   
@endsection
    

@section('scripts')

<script>
   $(function () {
    // let ip_address = '127.0.0.1';
    let ip_address = '18.183.164.200';
    let socket_port = '8005';
    let user_id = $('#user_id').val();
    let socket = io(ip_address + ':' + socket_port);
    socket.on("notification-channel-"+user_id, function (message)
    {
      location.reload();
    });
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })

    //Handle starring for font awesome
    $('.mailbox-star').click(function (e) {
      e.preventDefault()
      //detect type
      var $this = $(this).find('a > i')
      var fa    = $this.hasClass('fa')

      //Switch states
      if (fa) {
        $this.toggleClass('fa-star')
        $this.toggleClass('fa-star-o')
      }
    })

    //modal box
    $('#createNewProduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });
    //save mail
    $('#saveBtn').click(function (e) {
        e.preventDefault();
       
        $.ajax({
            data: $('#mailForm').serialize(),
            url: "/add-noti",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if($.isEmptyObject(data.error)){
                    $('#mailForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    location.reload();
                    // table.draw();
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
  //read mail modal
  function readMail(id) {
    $('#read-mail-'+id).modal('show');
  };
  function deleteMail() {
    // e.preventDefault();
    var checkedVals = $('.mailbox-messages input[type=\'checkbox\']:checkbox:checked').map(function() {
        return this.value;
    }).get();
    if(checkedVals.length == 0) return true;
    
    $.ajax({
        data:  {data : checkedVals}, 
        url: "/delete-notification",
        type: "POST",
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if($.isEmptyObject(data.error)){
            location.reload();
          }else{
              alert("fail to delete Mails");
          }
        }
    });
  };

  // reload page
  function locationreload() {
    location.reload();
  };
  
</script>
@endsection
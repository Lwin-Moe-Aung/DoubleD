<div class="modal fade" id="read-mail-{{ $value->id }}"  aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header  w-20 bg-warning">
          <h4 class="modal-title">{{ $value->subject }}</h4>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="w-20 bg-info" style="padding: 0.5rem;">
            <span class="float-right" style="font-size: 11px">{{ \Carbon\Carbon::parse($value->created_at)->diffForHumans() }}</span>
        </div>
        <div class="modal-body w-20 bg-info">
          <p>{{ $value->description }}</p>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
          <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
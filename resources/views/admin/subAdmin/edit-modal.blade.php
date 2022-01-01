<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    
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
                                    id="inputPassword" placeholder="********" value="{{Request::old('password')}}">
                            </div>
                          
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right ml-2" id="editBtn">Save</button>
                        {{-- <button  class="btn btn-default float-right">Cancle</button> --}}
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


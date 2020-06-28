<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" autocomplete="off" autofocus="autofocus" required="required" onblur="isUserAlreadyExist()">
    </div>
    <div class="col-sm-6 mb-3 mb-sm-0">
        <input type="text" class="form-control form-control-user" id="password" name="password" placeholder="Password" autocomplete="off" autofocus="autofocus" required="required">
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-6 mb-3 mb-sm-0">
        <select class="form-control" name="status" id="status" required="required">
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>
    <div class="col-sm-6">
        <button class="btn btn-primary btn-user btn-block">
            Save
        </button>
    </div>
</div>
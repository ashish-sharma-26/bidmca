</div>
</div>
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="get" action="{{url('/admin/application-status')}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Application Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" value="" id="applicationId" name="application">
                        <input type="hidden" value="" id="appStatus" name="status">
                        <div class="col-md-12" id="reasonField">
                            <div class="form-group">
                                <label>Reason for rejection</label>
                                <textarea class="form-control" name="reason"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" id="dateField">
                                <label>Closing Date</label>
                                <input class="form-control" type="text" name="closing_date"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://www.gstatic.com/firebasejs/8.6.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.0/firebase-database.js"></script>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/admin-firebase.js') }}"></script>

</body>

</html>

</div>
</div>
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="get" action="{{url('/admin/application-status/4')}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Application Rejection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" value="" id="applicationId" name="application">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Reason for rejection</label>
                                <textarea class="form-control" name="reason" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/admin/assets/scripts/main.js') }}"></script>

</body>

</html>

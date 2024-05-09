<div class="modal fade" id="addSubscriberModal" tabindex="-1" role="dialog"
    aria-labelledby="addSubscriberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="addSubscriberModalLabel"></h5> --}}
                <p style="text-align: center;font-weight: 900; margin-bottom: 25px;">
                    نوع الحساب</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-deck">
                    <!-- Add New Office Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="row account_row">
                                    <div class="col-sm-12 col-md-6 account_type next-step disabled">
                                        <div class="img-smm">
                                            <img src="{{ asset('HOME_PAGE_copy/images/new/building-_5_.png') }}" class="img-fluid">
                                        </div>
                                        <p>مكتب</p>
                                        <div class="disabled-overlay">
                                            <span>مكتب قريبا </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 account_type" onclick="redirectToCreateBroker()">
                                        <div class="img-smm-y">
                                            <img src="{{ asset('HOME_PAGE_copy/images/new/real-estate-agent.png') }} "
                                                class="img-fluid">
                                        </div>
                                        <p>مسوق عقاري</p>
                                    </div>
                            </div>

                        </div>
                    </div>
                    <!-- Add New Broker Card -->

                </div>
            </div>


        </div>

    </div>
</div>
</div>

@extends('admin.layouts.layout-basic')

@section('title', 'Bookings position & passengers list')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.bookingDetailsPageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">{{ trans('messages.bookingDetailsBreadcrumb1') }}</a></li>
                <li class=""><a href="{{route('admin.bookings.index')}}">{{ trans('messages.bookingDetailsBreadcrumb2') }}</a></li>
                <li class="active">{{ trans('messages.bookingDetailsBreadcrumb3') }}</li>
            </ol>
        </div>
        @if(session()->has('updateStatus'))
            <?php flash()->success(trans('messages.positionUpdatePageFormUpdateMsg')); ?>
        @endif
        @if(session()->has('createStatus'))
            <?php flash()->success(trans('messages.positionSavePageFormUpdateMsg')); ?>
        @endif
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ trans('messages.bookingDetailsTableHead') }}</h3>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="detail-row">
                                    {{ trans('messages.bookingDetailsTableHeadSource') }}: {{ $orderDetail->source }}
                                </p>
                                <p class="detail-row">
                                    {{ trans('messages.bookingDetailsTableHeadPayedAt') }}: @if($orderDetail->payed_at) {{ date('d.m.Y H:i', strtotime($orderDetail->payed_at)) }} @endif
                                </p>
                                <p class="detail-row">
                                    {{ trans('messages.bookingDetailsTableHeadCancelledAt') }}: @if($orderDetail->cancelled_at) {{ date('d.m.Y H:i', strtotime($orderDetail->cancelled_at)) }} @endif
                                </p>
                                <p class="detail-row">
                                    {{ trans('messages.bookingDetailsTableHeadCreatedAt') }}: {{ date('d.m.Y H:i', strtotime($orderDetail->created_at)) }}
                                </p>
                                <p class="detail-row">
                                    {{ trans('messages.bookingDetailsTableHeadUpdatedAt') }}: {{ date('d.m.Y H:i', strtotime($orderDetail->updated_at)) }}
                                </p>
                                @if(file_exists(storage_path('app').'/invoice_archive/Rechnung-'.$orderDetail->invoice_id. '.pdf'))
                                    <div>
                                        <a href="{{route('adminInvoiceDownload', $orderDetail->id)}}" role="button" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> {{ trans('messages.bookingDetailsDownloadInvoiceButton') }}</a>
                                    </div>
                                @endif
                                @if(count($orderPositions)>0 && ($orderDetail->status=='confirmed' || $orderDetail->status=='finished'))
                                    <div>
                                        <button id="sendInvBtn" data-route="{{route('adminCustomerOrderInvoice', $orderDetail->id)}}" type="button" class="btn btn-warning ladda-button m-t-1" data-style="expand-left"><i class="fa fa-envelope"></i> {{ trans('messages.bookingDetailsSendInvoiceButton') }}</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3>{{ trans('messages.bookingDetailsFinanceTableHead') }}</h3>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#incomingInvoice">
                                    {{ trans('messages.bookingDetailsCreateIncomingInvoice') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                {!! $financeDetails !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h3>{{ trans('messages.bookingDetailsPositionTableHead') }}</h3>
                            </div>
                            <div class="col-sm-3">
                                <a href="{{route('adminBookingPositionCreateForm', $orderDetail->id)}}" class="btn btn-primary pull-right">
                                    {{ trans('messages.bookingDetailsCreatePositionButton') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-block">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="10%">{{ trans('messages.bookingDetailsPositionTableHeadQuan') }}</th>
                                <th width="25%">{{ trans('messages.bookingDetailsPositionTableHeadTitle') }}</th>
                                <th width="45%">{{ trans('messages.bookingDetailsPositionTableHeadDesc') }}</th>
                                <th width="15%">{{ trans('messages.bookingDetailsPositionTableHeadprice') }}</th>
                                <th width="5%"><i class="fa fa-cog"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orderPositions as $orderPosition)
                                <tr>
                                    <td>{{ $orderPosition->quantity }}</td>
                                    <td>{{ $orderPosition->title }}</td>
                                    <td>{{ $orderPosition->description }}</td>
                                    <td>{{ $orderPosition->price }}</td>
                                    <td><a href="{{route('adminBookingPositionUpdateForm',$orderPosition->id)}}"><i class="fa fa-pencil"></i></a></td>
                                </tr>
                            @empty
                                <p>{{ trans('messages.bookingDetailsPositionNoDataMsg') }}</p>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 pull-right">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ trans('messages.bookingDetailsPassengersTableHead') }}</h3>
                    </div>
                    <div class="card-block">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="100%">{{ trans('messages.bookingDetailsPassengersTableHeadCust') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orderPassengers as $orderPassenger)
                                <tr>
                                    <td>{{ $orderPassenger->firstname }} {{ $orderPassenger->lastname }}</td>
                                </tr>
                            @empty
                                <p>{{ trans('messages.bookingDetailsPassengersNoDataMsg') }}</p>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{--Incoming invoice Modal--}}
    <div class="modal fade" id="incomingInvoice" tabindex="-1" role="dialog" aria-labelledby="modalLbl" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLbl">{{ trans('messages.incomingInvoiceModalLabel') }}</h4>
                </div>
                <div class="modal-body">
                    <form id="incomingInvoiceFrm">
                        <div class="form-group">
                            <label for="total">{{ trans('messages.incomingInvoiceFormLabelTotal') }}</label>
                            <input class="form-control" id="total" name="total" placeholder="00.00" type="text" required>
                        </div>
                        <div class="form-group">
                            <label for="freetext">{{ trans('messages.incomingInvoiceFormLabelFreetext') }}</label>
                            <input class="form-control" id="freetext" name="freetext" type="text" required>
                        </div>
                        <input type="hidden" name="booking_id" value="{{ $orderDetail->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('messages.incomingInvoiceFormButtonClose') }}</button>
                    <button type="button" class="btn btn-primary" id="saveInvoiceBtn">{{ trans('messages.incomingInvoiceFormButtonSave') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('scripts')
    <script src="/assets/admin/js/bookings/bookings.js"></script>
    <script src="/assets/admin/js/bookings/notifications.js"></script>
    <script src="/assets/admin/js/bookings/validation.js"></script>
    <script>
        /*save incoming invoice*/
        $('#saveInvoiceBtn').click( function () {
            if ($("#incomingInvoiceFrm").valid()) {
                $.post("/admin/incoming/invoice/save", $("#incomingInvoiceFrm").serialize(), function (data) {
                    if (data.mes == 'done') {
                        toastr['success']('Created Successfully', "Success");
                        $('#incomingInvoice').modal('hide');
                        window.setTimeout('location.reload()', 1000);
                    }
                    else {
                        toastr['error'](data.mes, "Error");
                    }
                }, 'json');
            }
        });
        $('#incomingInvoice').on('hidden.bs.modal', function (e) {
            $("#incomingInvoiceFrm")[0].reset();
        });

        /* send order invoice*/
        $('#sendInvBtn').click( function () {
            var l = Ladda.create(this);
            $url = $(this).data('route');
            l.start();
            $.post($url, function (data) {
                if (data.mes == 'done') {
                    l.stop();
                    toastr['success']('Invoice sent successfully', "Success");
                    window.setTimeout('location.reload()', 1000);
                }
                else {
                    l.stop();
                    toastr['error'](data.mes, "Error");
                }
            }, 'json');
        });
    </script>
@stop
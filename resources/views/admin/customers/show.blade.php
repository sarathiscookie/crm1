@extends('admin.layouts.layout-basic')

@section('title', 'Customer Detail')

@section('scripts')
    <script src="/assets/admin/js/customers/customers.js"></script>
    <script>
        /*save Membership*/
        $('#saveMbrshipBtn').click( function () {
            var saveForm = $('#createMembershipFrm');
            if ($('#school').val()=='') {
                toastr['error']('Value should not be empty', "Error");
                return false;
            }
            $.post(saveForm.attr('action'), saveForm.serialize(), function (data) {
                if (data.mes == 'done') {
                    toastr['success']('Created Successfully', "Success");
                    $('#createMembership').modal('hide');
                    window.setTimeout('location.reload()', 1000);
                }
                else {
                    toastr['error'](data.mes, "Error");
                }
            }, 'json');

        });
        $('#createMembership').on('hidden.bs.modal', function (e) {
            $("#createMembershipFrm")[0].reset();
            $('#school').val('').trigger('change');
        })

        /* create order*/
        $('#newOdrBtn').click( function () {
            $url = $(this).data('url');
            $.post($url, function (data) {
                if (data.mes == 'done') {
                    location.href= data.redirect;
                }
                else {
                    toastr['error'](data.mes, "Error");
                }
            }, 'json');
        });
    </script>
@stop

@section('content')
    <div class="main-content page-profile">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.customerDetailPageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li><a href="{{route('admin.customers.index')}}">Customers</a></li>
                <li class="active">{{ title_case($customer->firstname) .' '. title_case($customer->lastname)}}</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>{{ title_case($customer->firstname) .' '. title_case($customer->lastname) }} <a href="{{route('admin.customer.edit',$customer->id)}}"> <i class="fa fa-pencil"></i></a></h4>
                                <p class="detail-row"><i class="fa fa-map-marker"></i>
                                    @if($customer->street){{ $customer->street }}@endif,
                                    @if($customer->postal){{ $customer->postal }}@endif {{ $customer->city }},
                                    {{ $customer->country }}
                                </p>
                                @if($customer->birthdate)<p class="detail-row"><i class="fa fa-birthday-cake"></i> {{ date('d.m.Y', strtotime($customer->birthdate)) }} </p> @endif
                                <p class="detail-row"><i class="fa fa-envelope"></i> <a href="mailto:{{ $customer->mail }}">{{ $customer->mail }} </a></p>
                                @if($customer->phone)<p class="detail-row"><i class="fa fa-phone"></i> {{ $customer->phone }} </p> @endif
                                <div>
                                    @if($membership)
                                        Membership since {{ date('d.m.Y', strtotime($membership->joined_at)) }}
                                    @else
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#createMembership">{{ trans('messages.customerDetailsCreateMembershipButton') }}</button>
                                    @endif
                                </div>
                                <div>
                                    <button type="button" id="newOdrBtn" data-url="{{ route('adminCreateOrder', $customer->id) }}" class="btn btn-primary m-t-1">{{ trans('messages.customerDetailCreateOrderButton') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ trans('messages.customerDetailsBookingTableHeading') }}</h3>
                    </div>

                    <div class="card-block">
                        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('messages.customerDetailsBookingTableOrderId') }}</th>
                                <th>{{ trans('messages.customerDetailsBookingTableInvoiceId') }}</th>
                                <th>{{ trans('messages.customerDetailsBookingTableStatus') }}</th>
                                <th>{{ trans('messages.customerDetailsBookingTableDate') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td><a href="{{route('adminBookingShow',$booking->id)}}">{{ $booking->id }}</a></td>
                                    <td>{{ $booking->invoice_id }}</td>
                                    <td>{{ $booking->status }}</td>
                                    <td>{{ date('d.m.Y H:i', strtotime($booking->created_at)) }}</td>
                                </tr>
                            @empty
                                <p>{{ trans('messages.customerDetailsBookingNoRecords') }}</p>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Create Membership Modal--}}
    <div class="modal fade" id="createMembership" tabindex="-1" role="dialog" aria-labelledby="membershipModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="membershipModal">{{ trans('messages.createMembershipModalLabel') }}</h4>
                </div>
                <div class="modal-body">
                    <form id="createMembershipFrm" action="{{ route('adminMembershipSave', $customer->id) }}">
                        <div class="form-group">
                            <label for="school">{{ trans('messages.createMembershipFormLabelSchool') }}</label>
                            <select class="form-control ls-bootstrap-select show-tick" id="school" name="school" data-size="10">
                                <option value="" title="Select school" >--Select school--</option>
                                <option value="1" >School 1</option>
                                <option value="2" >School 2</option>
                                <option value="3" >School 3</option>
                                <option value="4" >School 4</option>
                            </select>
                        </div>
                        <div class="form-group"><br></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('messages.createMembershipFormButtonClose') }}</button>
                    <button type="button" class="btn btn-primary" id="saveMbrshipBtn">{{ trans('messages.createMembershipFormButtonSave') }}</button>
                </div>
            </div>
        </div>
    </div>{{-- Create Membership Modal END--}}
@stop

@extends('admin.layouts.layout-basic')

@section('title', 'Bookings List')

@section('scripts')
    <script src="/assets/admin/js/bookings/bookings.js"></script>
@stop

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.bookingListPageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="active">Bookings</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ trans('messages.bookingListPageTableHeading') }}</h3>
                    </div>
                    <div class="card-block">
                        <table id="bookings-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('messages.bookingListTableOrderId') }}</th>
                                <th>{{ trans('messages.bookingListTableInvoiceId') }}</th>
                                <th>{{ trans('messages.bookingListTableStatus') }}</th>
                                <th>{{ trans('messages.bookingListTableDate') }}</th>
                            </tr>
                            </thead>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td><a href="{{route('adminBookingShow',$booking->id)}}">{{$booking->id}}</a></td>
                                    <td>{{ $booking->invoice_id }}</td>
                                    <td><fieldset class="form-group"><select id="status_{{ $booking->id }}" name="status" class="form-control ls-bootstrap-select show-tick statusChange">
                                            @foreach($statuses as $value=>$label)
                                                <option value="{{ $value }}" @if(($booking->status=='offered' || $booking->status=='booked') && $value!='confirmed') disabled="disabled" @elseif($booking->status=='confirmed' && $value!='finished') disabled="disabled" @elseif($booking->status=='finished' && $value!='finished') disabled="disabled" @endif @if($value==$booking->status) selected="selected" @endif >{{ $label }}</option>
                                            @endforeach
                                        </select></fieldset></td>
                                    <td>{{ date('d.m.Y H:i', strtotime($booking->created_at)) }}</td>
                                </tr>
                            @endforeach
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
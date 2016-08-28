@extends('admin.layouts.layout-basic')

@section('title', 'Customer Edit')

@section('scripts')
    <script src="/assets/admin/js/customers/customers.js"></script>
    <script>
        $('.datepickerInp').datepicker({
            format: 'dd.mm.yyyy',
            autoclose: true,
            orientation: "bottom auto",
        });
    </script>
@stop

@section('content')
    <div class="main-content page-profile">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.customerEditPageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li><a href="{{route('admin.customers.index')}}">Customers</a></li>
                <li><a href="{{route('admin.customer.show',$customer->id)}}">{{ title_case($customer->firstname) .' '. title_case($customer->lastname)}}</a></li>
                <li class="active">Edit</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <form method="post" action="{{route('admin.customer.update', $customer->id)}}">
                            {{ csrf_field() }}
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelFirstName') }}</label>
                                    <input class="form-control" name="firstname" value="{{ $customer->firstname }}" type="text">
                                </fieldset>
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelLastName') }}</label>
                                    <input class="form-control" name="lastname" value="{{ $customer->lastname }}"  type="text">
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelEmail') }}</label>
                                    <input class="form-control" name="mail" value="{{ $customer->mail }}" type="email">
                                </fieldset>
                                <fieldset class="form-group col-sm-3">
                                    <label for="name">{{ trans('messages.customerEditFormLabelDOB') }}</label>
                                    <div class="input-group">
                                    <input class="form-control datepickerInp" name="birthdate" value="@if($customer->birthdate) {{ date('d.m.Y', strtotime($customer->birthdate)) }} @endif" type="text" readonly="readonly">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group col-sm-3">
                                    <label for="name">{{ trans('messages.customerEditFormLabelPhone') }}</label>
                                    <input class="form-control" name="phone" value="{{ $customer->phone }}" type="text">
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelStreet') }}</label>
                                    <input class="form-control" name="street" value="{{ $customer->street }}" type="text">
                                </fieldset>
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelPostal') }}</label>
                                    <input class="form-control" name="postal" value="{{ $customer->postal }}" type="text">
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelCity') }}</label>
                                    <input class="form-control" name="city" value="{{ $customer->city }}" type="text">
                                </fieldset>
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelCountry') }}</label>
                                    <select class="form-control ls-bootstrap-select show-tick dropup" name="country" data-dropupAuto="false" data-size="10">
                                    @foreach($countryList as $country_key => $country_value)
                                    <option value="{{ ($country_value) }}" title="{{ ($country_value) }}" @if ($country_value == $customer->country) selected="selected" @endif >{{ ($country_value) }}</option>
                                    @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerEditFormLabelStatus') }}</label>
                                    <select class="form-control ls-bootstrap-select show-tick dropup" name="status" data-dropupAuto="false" data-size="10">
                                        @foreach($statusList as $status_value => $status_label)
                                            <option value="{{ $status_value }}" title="{{ $status_label }}" @if ($status_value == $customer->status) selected="selected" @endif >{{ $status_label }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary btn-lg btn-block">{{ trans('messages.customerEditFormSubmitButton') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
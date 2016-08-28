@extends('admin.layouts.layout-basic')

@section('title', 'Customer Create')

@section('scripts')
    <script src="/assets/admin/js/customers/customers.js"></script>
    <script>
        $('.datepickerInp').datepicker({
            format: 'dd.mm.yyyy',
            autoclose: true,
            orientation: "bottom auto",
        });

        $(document).ready( function () {
            $('#actionInp').val('customer');
            $('#orderBtn').click(function (e) {
                e.preventDefault();
                $('#actionInp').val('order');
                $('#createCustomerFrm').submit();
            });
        })
    </script>
@stop

@section('content')
    <div class="main-content page-profile">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.customerCreatePageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li><a href="{{route('admin.customers.index')}}">Customers</a></li>
                <li class="active">Create</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <form id="createCustomerFrm" method="post" action="{{route('admin.customer.save')}}">
                            {{ csrf_field() }}
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelFirstName') }}</label>
                                    <input class="form-control" name="firstname" value="{{ old('firstname') }}" type="text">
                                </fieldset>
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelLastName') }}</label>
                                    <input class="form-control" name="lastname" value="{{ old('lastname') }}"  type="text">
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelEmail') }}</label>
                                    <input class="form-control" name="mail" value="{{ old('mail') }}" type="email">
                                </fieldset>
                                <fieldset class="form-group col-sm-3">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelDOB') }}</label>
                                    <div class="input-group">
                                    <input class="form-control datepickerInp" name="birthdate" value="{{ old('birthdate') }}" type="text" readonly="readonly">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group col-sm-3">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelPhone') }}</label>
                                    <input class="form-control" name="phone" value="{{ old('phone') }}" type="text">
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelStreet') }}</label>
                                    <input class="form-control" name="street" value="{{ old('street') }}" type="text">
                                </fieldset>
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelPostal') }}</label>
                                    <input class="form-control" name="postal" value="{{ old('postal') }}" type="text">
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelCity') }}</label>
                                    <input class="form-control" name="city" value="{{ old('city') }}" type="text">
                                </fieldset>
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelCountry') }}</label>
                                    <select class="form-control ls-bootstrap-select show-tick dropup" name="country" data-dropupAuto="false" data-size="10">
                                    @foreach($countryList as $country_key => $country_value)
                                    <option value="{{ ($country_value) }}" title="{{ ($country_value) }}" @if ($country_value == 'Deutschland' || $country_value == old('country')) selected="selected" @endif >{{ ($country_value) }}</option>
                                    @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="row">
                                <fieldset class="form-group col-sm-6">
                                    <label for="name">{{ trans('messages.customerCreateFormLabelStatus') }}</label>
                                    <select class="form-control ls-bootstrap-select show-tick dropup" name="status" data-dropupAuto="false" data-size="10">
                                        @foreach($statusList as $status_value => $status_label)
                                            <option value="{{ $status_value }}" title="{{ $status_label }}" @if ($status_value == 'customer' || $status_value == old('status')) selected="selected" @endif >{{ $status_label }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <input id="actionInp" name="mode" type="hidden" value="customer">
                            <div class="row form-group">
                                <div class="col-sm-6">
                                    <button class="btn btn-primary btn-lg btn-block">{{ trans('messages.customerCreateFormSubmitButton') }}</button>
                                </div>
                                <div class="col-sm-6">
                                    <button id="orderBtn" class="btn btn-success btn-lg btn-block pull-right">{{ trans('messages.customerCreateFormSubmitButton2') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
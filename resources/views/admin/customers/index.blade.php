@extends('admin.layouts.layout-basic')

@section('title', 'Customers List')

@section('scripts')
    <script src="/assets/admin/js/customers/customers.js"></script>
@stop

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.customerListPageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="active">Customers</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3>{{ trans('messages.customerListPageTableHeading') }}</h3>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ route('admin.customer.create') }}" role="button" class="btn btn-primary pull-right">
                                    <i class="fa fa-plus"></i>
                                    {{ trans('messages.customerListPageCreateCustomerButton') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <table id="customers-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('messages.customerListTableFirstname') }}</th>
                                <th>{{ trans('messages.customerListTableLastname') }}</th>
                                <th>{{ trans('messages.customerListTableMail') }}</th>
                                <th>{{ trans('messages.customerListTablePhone') }}</th>
                            </tr>
                            </thead>
                            @foreach($customers as $customer)
                                <tr>
                                    <td><a href="{{route('admin.customer.show',$customer->id)}}">{{$customer->firstname}}</a></td>
                                    <td>{{$customer->lastname}}</td>
                                    <td>{{$customer->mail}}</td>
                                    <td>{{ $customer->phone}}</td>
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
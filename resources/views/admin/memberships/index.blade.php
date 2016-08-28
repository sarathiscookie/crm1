@extends('admin.layouts.layout-basic')

@section('title', 'Membership List')

@section('scripts')
    <script src="/assets/admin/js/memberships/memberships.js"></script>
    <script>
        $('.cancel-btn').on('click',function(){
            $this = $(this);
            notie.confirm('Really wanted to Cancel?', 'Yes!', 'Cancel', function() {
                var url = $this.data('url');
                $.post( url, function (data) {
                    if (data.mes == 'done') {
                        toastr['success']("Successfully cancelled", "Success");
                        window.setTimeout('location.reload()', 1000);
                    }
                    else {
                        toastr['error'](data.mes, "Error");
                    }
                }, 'json');
            });
            return false;
        });
    </script>
@stop

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.membershipListPageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="active">Memberships</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3>{{ trans('messages.membershipListPageTableHeading') }}</h3>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-warning ladda-button pull-right" data-style="expand-left" id="renewBtn">
                                    <i class="fa fa-envelope"></i>
                                    {{ trans('messages.membershipListRenewButton') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <table id="memberships-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="30%">{{ trans('messages.membershipListTableFirstname') }}</th>
                                <th width="25%">{{ trans('messages.membershipListTableLastname') }}</th>
                                <th width="15%">{{ trans('messages.membershipListTableJoined') }}</th>
                                <th width="15%">{{ trans('messages.membershipListTableRenewed') }}</th>
                                <th width="10%">{{ trans('messages.membershipListTableCancelled') }}</th>
                                <th width="5%"><i class="fa fa-cog"></i></th>
                            </tr>
                            </thead>
                            @foreach($memberships as $membership)
                                <tr>
                                    <td><a href="{{route('admin.customer.show',$membership->customer_id)}}">{{$membership->firstname}}</a></td>
                                    <td>{{$membership->lastname}}</td>
                                    <td>{{ date('d.m.Y', strtotime($membership->joined_at)) }}</td>
                                    <td>@if($membership->renewed_at!=null) {{ date('d.m.Y H:i', strtotime($membership->renewed_at)) }} @else {{ $membership->renewed_at }} @endif</td>
                                    <td>@if($membership->cancelled_at!=null) {{ date('d.m.Y', strtotime($membership->cancelled_at)) }} @else {{ $membership->cancelled_at }} @endif</td>
                                    <td>@if($membership->cancelled_at==null) <a href="javascript:void(0)" class="cancel-btn" title="Cancel membership" data-url="{{ route('adminMembershipCancel', $membership->id) }}" data-confirmation="notie"><i class="fa fa-ban"></i></a> @endif</td>
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
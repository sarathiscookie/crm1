@extends('admin.layouts.layout-basic')

@section('title', 'Create Position')

@section('scripts')
@stop

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.positionSavePageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">{{ trans('messages.positionSavePageBreadcrumb1') }}</a></li>
                <li class=""><a href="{{route('admin.bookings.index')}}">{{ trans('messages.positionSavePageBreadcrumb2') }}</a></li>
                <li class=""><a href="{{route('adminBookingShow', $orderID)}}">{{ trans('messages.positionSavePageBreadcrumb3') }}</a></li>
                <li class="active">{{ trans('messages.positionSavePageBreadcrumb4') }}</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <form action="{{ route('adminBookingPositionSave', $orderID) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }} col-sm-6">
                                    <label for="title">{{ trans('messages.positionUpdatePageTableTitle') }}</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           placeholder="Title" value="{{ old('title') }}">
                                </div>
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }} col-sm-3">
                                    <label for="price">{{ trans('messages.positionUpdatePageTablePrice') }}</label>
                                    <input type="text" name="price" id="price" class="form-control"
                                           placeholder="00.00" value="{{ old('price') }}">
                                </div>
                                <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }} col-sm-3">
                                    <label for="cost">{{ trans('messages.positionUpdatePageTableCost') }}</label>
                                    <input type="text" name="cost" id="cost" class="form-control"
                                           placeholder="00.00" value="{{ old('cost') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} col-sm-6">
                                    <label for="description">{{ trans('messages.positionUpdatePageTableDesc') }}</label>
                                    <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }} col-sm-3">
                                    <label for="quantity">{{ trans('messages.positionUpdatePageTableQuantity') }}</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control"
                                           placeholder="Quantity" value="{{ old('quantity') }}">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="type">{{ trans('messages.positionUpdatePageTableType') }}</label>
                                    <select class="form-control" id="type" name="type">
                                        @if(isset($types))
                                            @foreach($types as $value=>$label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-lg btn-block">{{ trans('messages.positionSavePageFormUpdateButton') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
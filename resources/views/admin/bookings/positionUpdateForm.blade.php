@extends('admin.layouts.layout-basic')

@section('title', 'Update Positions')

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol']],
                    ['mesc', ['undo', 'redo']],
                ]
            });

            $('.datepickerInp').datepicker({
                format: 'dd.mm.yyyy',
                autoclose: true,
                orientation: "bottom auto",
            });


            $('.metaRowBtn').click( function () {
                var clicked = $(this);
                var id = clicked.attr('id').split('_')[1];
                var type = clicked.data('param').split('_')[1];
                var updtForm = $('#updateMetaFrm_'+id);

                if(type=='id' || type=='begin' || type=='end' || type=='type') {
                    if ($.trim($('#row_'+id).val()) == '') {
                        toastr['error']('Value should not be empty', "Error");
                        return false;
                    }
                }
                if(type=='id' || type=='type') {
                    if (Math.floor($('#row_'+id).val()) != $('#row_'+id).val() || !$.isNumeric($('#row_'+id).val())) {
                        toastr['error']('Value should be an Integer', "Error");
                        return false;
                    }
                }
                if(type=='details') {
                    if ($('#row_'+id).summernote('isEmpty')) {
                        toastr['error']('Value should not be empty', "Error");
                        return false;
                    }
                }

                $.post(updtForm.attr('action'), updtForm.serialize(), function (data) {
                    if (data.mes == 'done') {
                        toastr['success']('Updated Successfully', "Success");
                        $('#incomingInvoice').modal('hide');
                        window.setTimeout('location.reload()', 1000);
                    }
                    else {
                        toastr['error'](data.mes, "Error");
                    }
                }, 'json');

            });
            /*Create meta - choose input*/
            $('#metaNameInp').on('change', function () {
                var actionEle = $(this);
                var typeVal  = actionEle.val();
                var type     = '';
                if(typeVal!='')
                    type =  typeVal.split('_')[1];

                $('#metaValueInp').summernote('destroy');
                $('#metaValueInp').remove();

                if(type=='details') {
                    $('<textarea />', {
                        id: 'metaValueInp',
                        class: 'form-control',
                        name: 'meta_value'
                    }).appendTo('#fieldContainer');
                    $('#metaValueInp').summernote({
                        toolbar: [
                            // [groupName, [list of button]]
                            ['style', ['bold', 'italic', 'underline']],
                            ['font', ['strikethrough']],
                            ['para', ['ul', 'ol']],
                            ['mesc', ['undo', 'redo']],
                        ]
                    });
                }
                else {
                    if(type=='begin' || type=='end') {
                        $('<input />', {
                            id: 'metaValueInp',
                            type:'text',
                            class: 'form-control',
                            name: 'meta_value'
                        }).attr('readonly', true).appendTo('#fieldContainer');

                        $('#metaValueInp').datepicker({
                            format: 'dd.mm.yyyy',
                            autoclose: true,
                            orientation: "bottom auto",
                        });
                    }
                    else{
                        if(type!='') {
                            $('<input />', {
                                id: 'metaValueInp',
                                type:'text',
                                class: 'form-control',
                                name: 'meta_value'
                            }).appendTo('#fieldContainer');
                        }
                        else {
                            $('<input />',{ type:'text', id:'metaValueInp', class:'form-control'}).attr('disabled', true).appendTo('#fieldContainer')
                            return false;
                        }
                    }
                }
            });

            /*save Meta*/
            $('#saveMetaBtn').click( function () {
                var typeVal = $('#metaNameInp');
                var addForm = $('#addMetaFrm');
                var err=0;
                var type='';
                if(typeVal.val()!='')
                    type=typeVal.val().split('_')[1];

                if(typeVal.val()=='') {
                    toastr['error']('Meta name should not be empty', "Error");
                    err++;
                    return false;
                }
                if(type=='id' || type=='begin' || type=='end' || type=='type') {
                    if ($.trim($('#metaValueInp').val()) == '') {
                        toastr['error']('Meta value should not be empty', "Error");
                        err++;
                        return false;
                    }
                }
                if(type=='id' || type=='type') {
                    if (Math.floor($('#metaValueInp').val()) != $('#metaValueInp').val() || !$.isNumeric($('#metaValueInp').val())) {
                        toastr['error']('Meta value should be an Integer', "Error");
                        err++;
                        return false;
                    }
                }
                if(type=='details') {
                    if ($('#metaValueInp').summernote('isEmpty')) {
                        toastr['error']('Meta value should not be empty', "Error");
                        err++;
                        return false;
                    }
                }
                if(err==0) {
                    $.post(addForm.attr('action'), addForm.serialize(), function (data) {
                        if (data.mes == 'done') {
                            toastr['success']('Meta created Successfully', "Success");
                            $('#createMetaModal').modal('hide');
                            window.setTimeout('location.reload()', 1000);
                        }
                        else {
                            toastr['error'](data.mes, "Error");
                        }
                    }, 'json');
                }
            });
            /*reset form*/
            $('#createMetaModal').on('hidden.bs.modal', function (e) {
                $("#addMetaFrm")[0].reset();
                $('#metaNameInp').val('').trigger('change');
            });
        });
    </script>
@stop

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.positionUpdatePageHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">{{ trans('messages.positionUpdatePageBreadcrumb1') }}</a></li>
                <li class=""><a href="{{route('admin.bookings.index')}}">{{ trans('messages.positionUpdatePageBreadcrumb2') }}</a></li>
                <li class=""><a href="{{route('adminBookingShow', $orderPositionDetail->order_id)}}">{{ trans('messages.positionUpdatePageBreadcrumb3') }}</a></li>
                <li class="active">{{ trans('messages.positionUpdatePageBreadcrumb4') }} - {{ $orderPositionDetail->title }}</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-block">
                        @if(isset($orderPositionDetail))
                            <form action="{{route('adminBookingPositionUpdate',$orderPositionDetail->id)}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="title">{{ trans('messages.positionUpdatePageTableTitle') }}</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           placeholder="Title" value="{{ $orderPositionDetail->title }}">
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="description">{{ trans('messages.positionUpdatePageTableDesc') }}</label>
                                    <textarea class="form-control" name="description" id="description" rows="3">{{ $orderPositionDetail->description }}</textarea>
                                </div>
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                    <label for="price">{{ trans('messages.positionUpdatePageTablePrice') }}</label>
                                    <input type="text" name="price" id="price" class="form-control"
                                           placeholder="00.00" value="{{ $orderPositionDetail->price }}">
                                </div>
                                <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                                    <label for="cost">{{ trans('messages.positionUpdatePageTableCost') }}</label>
                                    <input type="text" name="cost" id="cost" class="form-control"
                                           placeholder="00.00" value="{{ $orderPositionDetail->cost }}">
                                </div>
                                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                    <label for="quantity">{{ trans('messages.positionUpdatePageTableQuantity') }}</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control"
                                           placeholder="Quantity" value="{{ $orderPositionDetail->quantity }}">
                                </div>
                                <div class="form-group">
                                    <label for="type">{{ trans('messages.positionUpdatePageTableType') }}</label>
                                    <select class="form-control" id="type" name="type">
                                        @if(isset($types))
                                            @foreach($types as $value=>$label)
                                                <option value="{{ $value }}" @if($value==$orderPositionDetail->type) selected="selected" @endif >{{ $label }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button class="btn btn-primary btn-lg btn-block">{{ trans('messages.positionUpdatePageFormUpdateButton') }}</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3>{{ trans('messages.positionUpdatePageMetaListHead') }}</h3>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createMetaModal">
                                    {{ trans('messages.positionUpdatePageCreateMetaButton') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12">
                                @forelse($position_meta as $meta)
                                    <div class="card card-block">
                                        <form method="post" id="updateMetaFrm_{{ $meta->id }}" action="{{route('adminPositionMetaUpdate',$meta->id)}}">
                                        <div class="form-group">
                                            <label for="name">{{ $metanames[$meta->name] }}</label>
                                            @if(strstr($meta->name, 'details'))
                                                <textarea name="meta_{{$meta->id}}" id="row_{{ $meta->id }}" class="summernote">{!! $meta->value !!}</textarea>
                                            @else
                                                <input type="text" name="meta_{{$meta->id}}" id="row_{{ $meta->id }}" @if(strstr($meta->name, 'begin') || strstr($meta->name, 'end')) readonly="readonly" class="form-control datepickerInp" value="{{ date('d.m.Y', $meta->value) }}" @else class="form-control" value="{{ $meta->value }}" @endif >
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary metaRowBtn" data-param="{{  $meta->name }}" id="btnUpdate_{{ $meta->id }}">{{ trans('messages.positionMetaUpdateButton') }}</button>
                                        </form>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Add new meta Modal--}}
    <div class="modal fade" id="createMetaModal" tabindex="-1" role="dialog" aria-labelledby="createMetaLbl" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="createMetaLbl">{{ trans('messages.createPositionMetaModalLabel') }}</h4>
                </div>
                <div class="modal-body">
                    <form id="addMetaFrm" action="{{route('adminPositionMetaSave',$orderPositionDetail->id)}}">
                        <div class="form-group">
                            <label for="total">{{ trans('messages.createPositionMetaFormLabelName') }}</label>
                            <select class="form-control ls-bootstrap-select show-tick dropup" id="metaNameInp" name="meta_name" data-dropupAuto="false" data-size="10">
                                <option value="" title="Select meta name" >--Select meta name-</option>
                                @foreach($metanames as $name => $label)
                                    <option value="{{ $name }}" title="{{ $label }}" >{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="fieldContainer">
                            <label for="metaValueInp">{{ trans('messages.createPositionMetaFormLabelValue') }}</label>
                            <input class="form-control" id="metaValueInp" type="text" disabled>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('messages.createPositionMetaFormButtonClose') }}</button>
                    <button type="button" class="btn btn-primary" id="saveMetaBtn">{{ trans('messages.createPositionMetaFormButtonSave') }}</button>
                </div>
            </div>
        </div>
    </div>{{--Add new meta Modal End--}}
@stop
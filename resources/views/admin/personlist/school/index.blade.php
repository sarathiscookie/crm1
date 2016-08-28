@extends('admin.layouts.layout-basic')

@section('title', 'School')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.personalListSchoolCardHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">{{ trans('messages.personalListSchoolBreadcrumb1') }}</a></li>
                <li class="">{{ trans('messages.personalListSchoolBreadcrumb2') }}</li>
                <li class="active">{{ trans('messages.personalListSchoolBreadcrumb3') }}</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>School</h3>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 m-b-3">
                                <h5 class="section-semi-title">
                                    {{ trans('messages.personalListSchoolHeading') }}
                                </h5>
                                @if(isset($schools))
                                    <div class="col-md-4 m-b-3">
                                        <select class="form-control ls-bootstrap-select selectSchool" data-live-search="true" name="selectSchool">
                                            @forelse($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->title }}</option>
                                            @empty
                                                <option>No schools</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-4 m-b-3">
                                        <form action="{{ route('schoolPdfGenerate') }}" method="POST">
                                            {!! csrf_field() !!}
                                            <input type="hidden" value="1" name="schoolID" id="schoolID">
                                            <button class="btn btn-primary ladda-button" data-style="expand-left"><span class="ladda-label">{{ trans('messages.personalListSchoolButton') }}</span></button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="/assets/admin/js/bookings/bookings.js"></script>
    <script>
        $(function() {
            $(" .selectSchool ").on("change", function () {
                var schoolID = $(this).val();
                $(" #schoolID ").attr('value', schoolID);
                return false;
            });
        });

        // Ladda Buttons
        Ladda.bind( 'div:not(.progress-demo) .ladda-button', { timeout: 2000 } );

        // Bind progress buttons and simulate loading progress
        Ladda.bind( '.progress-demo button', {
            callback: function( instance ) {
                var progress = 0;
                var interval = setInterval( function() {
                    progress = Math.min( progress + Math.random() * 0.1, 1 );
                    instance.setProgress( progress );

                    if( progress === 1 ) {
                        instance.stop();
                        clearInterval( interval );
                    }
                }, 200 );
            }
        } );
    </script>
@stop
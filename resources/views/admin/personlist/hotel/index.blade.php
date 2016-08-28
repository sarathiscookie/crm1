@extends('admin.layouts.layout-basic')

@section('title', 'Hotel')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">{{ trans('messages.personalListHotelCardHeading') }}</h3>
            <ol class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}">{{ trans('messages.personalListHotelBreadcrumb1') }}</a></li>
                <li class="">{{ trans('messages.personalListHotelBreadcrumb2') }}</li>
                <li class="active">{{ trans('messages.personalListHotelBreadcrumb3') }}</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Hotel</h3>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12 m-b-3">
                                <h5 class="section-semi-title">
                                    {{ trans('messages.personalListHotelHeading') }}
                                </h5>
                                @if(isset($hotels))
                                    <div class="col-md-4 m-b-3">
                                        <select class="form-control ls-bootstrap-select selectHotel" data-live-search="true">
                                            @forelse($hotels as $hotel)
                                                <option value="{{ $hotel->id }}">{{ $hotel->title }}</option>
                                            @empty
                                                <option>No hotel</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-md-4 m-b-3">
                                        <form action="{{ route('hotelPdfGenerate') }}" method="POST">
                                            {!! csrf_field() !!}
                                            <input type="hidden" value="1" name="hotelID" id="hotelID">
                                            <button class="btn btn-primary ladda-button" data-style="expand-left"><span class="ladda-label">{{ trans('messages.personalListHotelButton') }}</span></button>
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
            $(" .selectHotel ").on("change", function () {
                var hotelID = $(this).val();
                $(" #hotelID ").attr('value', hotelID);
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
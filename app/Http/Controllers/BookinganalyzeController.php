<?php

namespace Laraspace\Http\Controllers;

use Illuminate\Http\Request;

use Laraspace\Http\Requests;

use Laraspace\Booking;

use DB;

use Laraspace\Http\Requests\BookinganalyzeRequest;

class BookinganalyzeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Line graph for booking and membership type. Fetching last three months data*/
        $orderStats = Booking::select(DB::raw("MONTHNAME(created_at) as monthname"), DB::raw("SUM(type = 'booking') as Booking"), DB::raw("SUM(type = 'membership') as Membership"))
            ->where('created_at', '>=', DB::raw("NOW()-INTERVAL 3 MONTH"))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MIN(created_at)"))
            ->get();

        return view('admin.statistics.booking.index', ['ordersCountBooking' => $orderStats->lists('Booking'), 'ordersMonth' => $orderStats->lists('monthname'), 'ordersCountMembership' => $orderStats->lists('Membership')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BookinganalyzeRequest $request)
    {
        $fromDateReplace     = str_replace('/', '-', $request->fromDate);
        $fromDate            = date("Y-m-d", strtotime($fromDateReplace));

        $toDateReplace       = str_replace('/', '-', $request->toDate);
        $toDate              = date("Y-m-d", strtotime($toDateReplace));

        $dateDiff            = date_diff(date_create($fromDate),date_create($toDate));

        if($dateDiff->format('%a') < 45)
        {
            /* Line graph for booking and membership type. Fetching data using daterange
             * Condition is < 45. So chart X label shows days.
             */
            $orderStats = Booking::select(DB::raw("DATE_FORMAT(created_at, '%D') as monthname"), DB::raw("type = 'booking' as Booking"), DB::raw("type = 'membership' as Membership"))
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->orderBy('created_at')
                ->get();
        }
        else
        {
            /* Line graph for booking and membership type. Fetching data using daterange
             * Condition is > 45. So chart X label shows months.
             */
            $orderStats = Booking::select(DB::raw("MONTHNAME(created_at) as monthname"), DB::raw("SUM(type = 'booking') as Booking"), DB::raw("SUM(type = 'membership') as Membership"))
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->orderBy(DB::raw("MIN(created_at)"))
                ->get();
        }

        return response()->json(['ordersCountBooking' => $orderStats->lists('Booking'), 'ordersMonth' => $orderStats->lists('monthname'), 'ordersCountMembership' => $orderStats->lists('Membership')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

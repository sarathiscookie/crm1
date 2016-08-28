<?php

namespace Laraspace\Http\Controllers;

use Illuminate\Http\Request;

use Laraspace\Http\Requests;

use Laraspace\Customer;

use Laraspace\Booking;

use Laraspace\Orderpositions;

use Laraspace\Orderpositionmeta;

use DB;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /* Hotel name and count of last three months */
        $topHotelCount = Orderpositionmeta::select('order_position_metas.value', 'hotels.title', 'order_position_metas.name', DB::raw("COUNT(*) as count"))
            ->join('hotels', 'order_position_metas.value', '=', 'hotels.id')
            ->where('order_position_metas.name', 'hotel_id')
            ->where('order_position_metas.created_at', '>=', DB::raw("NOW()-INTERVAL 3 MONTH"))
            ->groupBy('order_position_metas.value')
            ->groupBy('hotels.title')
            ->groupBy('order_position_metas.name')
            ->orderBy('count', 'DESC')
            ->take(1)
            ->first();

        /* School name and count of last three months */
        $topSchoolCount = Orderpositionmeta::select('order_position_metas.value', 'schools.title', 'order_position_metas.name', DB::raw("COUNT(*) as count"))
            ->join('schools', 'order_position_metas.value', '=', 'schools.id')
            ->where('order_position_metas.name', 'school_id')
            ->where('order_position_metas.created_at', '>=', DB::raw("NOW()-INTERVAL 3 MONTH"))
            ->groupBy('order_position_metas.value')
            ->groupBy('schools.title')
            ->groupBy('order_position_metas.name')
            ->orderBy('count', 'DESC')
            ->take(1)
            ->first();

        /* School name and count of last three months */
        $topOfferCount = Orderpositionmeta::select('order_position_metas.value', 'offers.title', 'order_position_metas.name', DB::raw("COUNT(*) as count"))
            ->join('offers', 'order_position_metas.value', '=', 'offers.id')
            ->where('order_position_metas.name', 'offer_id')
            ->where('order_position_metas.created_at', '>=', DB::raw("NOW()-INTERVAL 3 MONTH"))
            ->groupBy('order_position_metas.value')
            ->groupBy('offers.title')
            ->groupBy('order_position_metas.name')
            ->orderBy('count', 'DESC')
            ->take(1)
            ->first();

        /* Last 10 customers details */
        $customers   = Customer::select('id', 'firstname', 'lastname', 'city', 'created_at')
            ->orderBY('created_at', 'DESC')
            ->take(10)
            ->get();

        /* last 10 booking details */
        $bookings    = Booking::select('id', 'invoice_id', 'created_at')
            ->orderBY('created_at', 'DESC')
            ->where('cancelled_at', NULL)
            ->take(10)
            ->get();

        /* Bar graph of total price and cost*/
        $salesCharts = Orderpositions::select(DB::raw("SUM(quantity * price) as salesprice"), DB::raw("SUM(quantity * cost) as salescost"), DB::raw("MONTHNAME(created_at) as monthname"))
            ->orderBy("created_at")
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->where(DB::raw("YEAR(created_at)"), date('Y', strtotime(Carbon::now())))
            ->get();

        /* Line graph for booking and membership type */
        $orderStats = Booking::select(DB::raw("MONTHNAME(created_at) as monthname"), DB::raw("SUM(type = 'booking') as Booking"), DB::raw("SUM(type = 'membership') as Membership"))
            ->where(DB::raw("YEAR(created_at)"), date('Y', strtotime(Carbon::now())))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy(DB::raw("MIN(created_at)"))
            ->get();

        return view('admin.dashboard.basic', ['topOfferCount' => $topOfferCount, 'topSchoolCount' => $topSchoolCount, 'topHotelCount' => $topHotelCount,  'customers' => $customers, 'bookings' => $bookings, 'salesPrice' => $salesCharts->lists('salesprice'), 'salesCost' => $salesCharts->lists('salescost'), 'salesMonth' => $salesCharts->lists('monthname'), 'ordersCountBooking' => $orderStats->lists('Booking'), 'ordersCountMembership' => $orderStats->lists('Membership'), 'ordersMonth' => $orderStats->lists('monthname')]);
    }

}

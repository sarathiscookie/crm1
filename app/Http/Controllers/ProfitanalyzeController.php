<?php

namespace Laraspace\Http\Controllers;

use Illuminate\Http\Request;

use Laraspace\Http\Requests;

use Laraspace\Orderpositions;

use DB;

use Laraspace\Http\Requests\ProfitanalyzeRequest;

class ProfitanalyzeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Line chart of profit. profit = price - cost */
        $profitChart = Orderpositions::select(DB::raw("SUM((quantity * price)-(quantity * cost)) as profit"), DB::raw("MONTHNAME(created_at) as labelname"))
            ->where('created_at', '>=', DB::raw("NOW()-INTERVAL 3 MONTH"))
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy("created_at")
            ->get();

        return view('admin.statistics.profit.index', ['profit' => $profitChart->lists('profit'), 'labelName' => $profitChart->lists('labelname')]);
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
    public function store(ProfitanalyzeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProfitanalyzeRequest $request)
    {
        $fromDateReplace     = str_replace('/', '-', $request->fromDate);
        $fromDate            = date("Y-m-d", strtotime($fromDateReplace));

        $toDateReplace       = str_replace('/', '-', $request->toDate);
        $toDate              = date("Y-m-d", strtotime($toDateReplace));

        $dateDiff            = date_diff(date_create($fromDate),date_create($toDate));

        if($dateDiff->format('%a') < 45)
        {
            /* Line chart of profit between dates. profit = price - cost
             * Condition is < 45. So chart X label shows days.
             */
            $profitChart = Orderpositions::select(DB::raw("(quantity * price)-(quantity * cost) as profit"), DB::raw("DATE_FORMAT(created_at, '%D') as labelname"))
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->orderBy("created_at")
                ->get();
        }
        else
        {
            /* Line chart of profit between dates. profit = price - cost
             * Condition is > 45. So chart X label shows months.
             */
            $profitChart = Orderpositions::select(DB::raw("SUM((quantity * price)-(quantity * cost)) as profit"), DB::raw("MONTHNAME(created_at) as labelname"))
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->orderBy("created_at")
                ->get();
        }

        return response()->json(['profit' => $profitChart->lists('profit'), 'labelName' => $profitChart->lists('labelname')]);
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

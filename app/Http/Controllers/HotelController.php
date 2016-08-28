<?php

namespace Laraspace\Http\Controllers;

use Illuminate\Http\Request;

use Laraspace\Http\Requests;

use Laraspace\Hotel;

use Laraspace\Http\Requests\HotelRequest;

use Laraspace\Orderpassengers;

use Laraspace\Orderpositionmeta;

use HTML2PDF;

use HTML2PDF_exception;

use Carbon\Carbon;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::select('id', 'title')->get();
        return view('admin.personlist.hotel.index', ['hotels' => $hotels]);
    }

    /**
     * Download pdf.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download(HotelRequest $request)
    {
        if(isset($request->hotelID))
        {
            $html         = '';

            /* For hotel title */
            $hotelTitles  = Orderpositionmeta::select('order_position_metas.order_position_id', 'hotels.title AS hoteltitle')
                ->join('hotels', 'hotels.id', '=', 'order_position_metas.value')
                ->where('order_position_metas.name', 'hotel_id')
                ->where('order_position_metas.value', $request->hotelID)
                ->get();

            if(count($hotelTitles))
            {
                foreach($hotelTitles as $hotelTitle)
                {
                    $html .= '<h1>'.$hotelTitle->hoteltitle.'</h1>';
                    /* For getting hotel begin and hotel end */
                    $beginEndTitles = Orderpositionmeta::select('order_position_metas.name', 'order_position_metas.value', 'order_positions.order_id')
                        ->join('order_positions', 'order_positions.id', '=', 'order_position_metas.order_position_id')
                        ->where('order_position_metas.order_position_id', $hotelTitle->order_position_id)
                        ->get();

                    foreach ($beginEndTitles as $beginEndTitle) {
                        if ($beginEndTitle->name == 'hotel_begin') {
                            $beginValue = date('d-m-Y', strtotime(Carbon::createFromTimestamp($beginEndTitle->value)));
                            $html .= '<h2>Begin : ' . $beginValue . '</h2>';
                        }

                        if ($beginEndTitle->name == 'hotel_end') {
                            $endValue = date('d-m-Y', strtotime(Carbon::createFromTimestamp($beginEndTitle->value)));
                            $html .= '<h2>End : ' . $endValue . '</h2>';

                            /* For getting customer details */
                            $customerDetails = Orderpassengers::select('order_passengers.customer_id', 'customers.firstname', 'customers.lastname')
                                ->join('customers', 'customers.id', '=', 'order_passengers.customer_id')
                                ->where('order_id', $beginEndTitle->order_id)
                                ->get();

                            foreach ($customerDetails as $customerDetail)
                            {
                                $html .= '<ul><li>' . $customerDetail->firstname . ' ' . $customerDetail->lastname .'</li></ul>';
                            }
                        }
                    }
                }
                try {
                    $html2pdf = new HTML2PDF('P', 'A4', 'de', TRUE, 'UTF-8', [10,0,10,0]);
                    $html2pdf->pdf->SetDisplayMode('fullpage');
                    $html2pdf->setDefaultFont("Helvetica");
                    $html2pdf->writeHTML($html);
                    $html2pdf->Output('hotels.pdf');
                } catch (HTML2PDF_exception $e) {
                    exit;
                }
            }
            else
            {
                flash()->info(trans('Sorry! No details currently available'));
                return redirect()->back();
            }

        }
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
    public function show($id)
    {
        //
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

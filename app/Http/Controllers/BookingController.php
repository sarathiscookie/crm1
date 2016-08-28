<?php

namespace Laraspace\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Laraspace\Booking;

use Laraspace\Coursetype;
use Laraspace\Customer;
use Laraspace\Hotel;
use Laraspace\Http\Requests;

use Laraspace\Orderincominginvoice;
use Laraspace\Orderpositionmeta;
use Laraspace\Orderpositions;

use Laraspace\Orderpassengers;

use Laraspace\Http\Requests\OrderpositionsRequest;
use Laraspace\Http\Requests\PositionmetaRequest;

use HTML2PDF;
use HTML2PDF_exception;
use Laraspace\School;
use Mail;
use Exception;

class BookingController extends Controller
{
    public $statuses  = array();
    public $metaNames = array();
    public $taxRate   = 1.19;

    public function __construct()
    {
        $this->statuses = [
            'offered'   => trans("messages.bookingStatusOfferedLabel"),
            'booked'    => trans("messages.bookingStatusBookedLabel"),
            'confirmed' => trans("messages.bookingStatusConfirmedLabel"),
            'finished'  => trans("messages.bookingStatusFinishedLabel")
        ];

        $this->metaNames = [
            'course_begin'   => trans("messages.positionMetaNameCourseBegin"),
            'course_end'     => trans("messages.positionMetaNameCourseEnd"),
            'course_type'    => trans("messages.positionMetaNameCourseType"),
            'course_details' => trans("messages.positionMetaNameCourseDetails"),
            'school_id'      => trans("messages.positionMetaNameSchoolId"),
            'school_details' => trans("messages.positionMetaNameSchoolDetails"),
            'hotel_id'       => trans("messages.positionMetaNameHotelId"),
            'hotel_begin'    => trans("messages.positionMetaNameHotelBegin"),
            'hotel_end'      => trans("messages.positionMetaNameHotelEnd"),
            'hotel_details'  => trans("messages.positionMetaNameHotelDetails")
        ];
    }

    /* order position types */
    public function types()
    {
        $type = [
            'course'   => trans("messages.positionUpdatePageTableTypeCourse"),
            'hotel'    => trans("messages.positionUpdatePageTableTypeHotel"),
            'bundle'   => trans("messages.positionUpdatePageTableTypeBundle"),
            'other'    => trans("messages.positionUpdatePageTableTypeOther")
        ];
        return $type;
    }


    /**
     * Booking List
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $bookings = Booking::orderBY('created_at', 'DESC')->get();

        return view('admin.bookings.index', ['bookings' => $bookings, 'statuses'=> $this->statuses]);
    }

    /**
     * update booking status- Ajax
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        if(!$request->ajax()){
            return response()->json(['mes'=> 'bad request']);
        }
        $order_id = $request->orderid;
        $status   = $request->status;
        $booking  = Booking::find($order_id);
        $booking->status = $status;
        $booking->save();
        $affected = $booking->id;
        if($affected>0){
            if($status=='confirmed')
                $this->sendOrderConfirmation($order_id);
            elseif ($status=='finished') {
                $this->sendVoucher($order_id);
                $booking  = Booking::find($order_id);
                $booking->payed_at = Carbon::now();
                $booking->save();
            }

            return response()->json(['mes'=> 'done']);
        }
        else{
            return response()->json(['mes'=> 'Error! status not updated']);
        }
    }

    /**
     * Booking details
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $orderDetail     = Booking::findOrFail($id);

        $orderPositions  = Orderpositions::where('order_id', $id)
            ->orderBY('created_at', 'DESC')
            ->get();

        $orderPassengers = Orderpassengers::select('customers.firstname', 'customers.lastname', 'order_passengers.*')
            ->join('customers', 'order_passengers.customer_id', '=', 'customers.id')
            ->where('order_passengers.order_id', $id)
            ->orderBY('order_passengers.created_at', 'DESC')
            ->get();

        $financeDetails = '';
        if($orderDetail->status=='finished') {
            $financeDetails = $this->getFinanceDetails($id, $orderPositions);
        }

        return view('admin.bookings.show', ['orderDetail' => $orderDetail, 'financeDetails'=>$financeDetails, 'orderPositions' => $orderPositions, 'orderPassengers' => $orderPassengers ]);
    }


    /**
     * Get Finance details
     * @param $id
     * @param $orderPositions
     * @return string
     */
    protected function getFinanceDetails($id, $orderPositions)
    {
        $priceTotal  =0;
        $costTotal   =0;
        foreach ($orderPositions as $position) {
            $price    = $position->price;
            $cost     = $position->cost;
            $quantity = $position->quantity;
            $priceTotal += $price*$quantity;
            $costTotal  += $cost*$quantity;
        }
        $calc_profit   = $priceTotal-$costTotal;

        $invoices      ='';
        $incomingTotal =0;
        $real_profit   =0;
        $incoming_invoices = Orderincominginvoice::where('order_id', $id)->get();
        if(count($incoming_invoices)>0){
            foreach ($incoming_invoices as $incoming_invoice){
                $totalVal = $incoming_invoice->total;
                $incomingTotal +=  $totalVal;
                $invoices .='<div>'.$incoming_invoice->freetext.': <span class="pull-right"> -'.number_format($totalVal, 2, ',', '.').' EUR</span></div>';
            }
            $real_profit = $priceTotal-$incomingTotal;
            $invoices .= '<hr><div>&nbsp;<span class="pull-right"> '.number_format($real_profit, 2, ',', '.').' EUR</span></div><hr>';
        }

        $balance = $real_profit-$calc_profit;

        $financeDetail ='<div>New booking:<span class="pull-right"> ' . number_format($priceTotal, 2, ',', '.') .' EUR</span></div>
                                    ' . $invoices . '
                                    <div>Calculated profit:<span class="pull-right"> ' . number_format($calc_profit, 2, ',', '.') . ' EUR</span></div>
                                    <div>Balance:<span class="pull-right"> ' .number_format($balance, 2, ',', '.') . ' EUR</span></div>';

        return $financeDetail;

    }

    /**
     * Position Edit mode
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function positionUpdateForm($id)
    {
        $orderPositionDetail     = Orderpositions::find($id);
        $types                   = $this->types();
        $position_meta = Orderpositionmeta::where('order_position_id', $id)->get();


        return view('admin.bookings.positionUpdateForm', ['orderPositionDetail' => $orderPositionDetail, 'types' => $types, 'position_meta'=>$position_meta, 'metanames' =>$this->metaNames ]);
    }

    /**
     * Update position
     * @param OrderpositionsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function positionUpdate(OrderpositionsRequest $request, $id)
    {
        $orderPosition              = Orderpositions::find($id);

        $orderPosition->title       = $request->title;
        $orderPosition->description = $request->description;
        $orderPosition->price       = $request->price;
        $orderPosition->cost        = $request->cost;
        $orderPosition->quantity    = $request->quantity;
        $orderPosition->type        = $request->type;
        $orderPosition->save();
        flash()->success(trans('messages.positionUpdatePageFormUpdateMsg'));
        return redirect(route('adminBookingShow', $orderPosition->order_id));

    }

    /**
     * Add new position - from
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function positionCreateForm($id)
    {
        $types                   = $this->types();
        return view('admin.bookings.positionCreateForm', ['orderID' => $id, 'types' => $types]);
    }

    /**
     * Save new position
     * @param OrderpositionsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function positionSave(OrderpositionsRequest $request, $id)
    {
        $orderPosition              = new Orderpositions;
        $orderPosition->order_id    = $id;
        $orderPosition->title       = $request->title;
        $orderPosition->description = $request->description;
        $orderPosition->price       = $request->price;
        $orderPosition->cost        = $request->cost;
        $orderPosition->quantity    = $request->quantity;
        $orderPosition->type        = $request->type;
        $orderPosition->save();
        flash()->success(trans('messages.positionSavePageFormUpdateMsg'));
        return redirect(route('adminBookingShow', $id));

    }



    /**
     * Send booking confirmation Mail with invoice and service information pdfs
     * @param $order_id
     */
    protected function sendOrderConfirmation($order_id)
    {
        $invoice_data = [];
        $position_meta = '';

        $booking = Booking::where('id', $order_id)->first();
        if ($booking->invoice_id > 0) {
            $invoiceID = $booking->invoice_id;
        }
        else {
            $select_invoiceId = Booking::select('invoice_id')->orderBy('invoice_id', 'DESC')->take(1)->first();
            $invoiceID = $select_invoiceId->invoice_id + 1;
            Booking::where('id', $order_id)->update(['invoice_id' => $invoiceID]);
        }

        $order_passengers = $this->getOrderPassengers($booking->id);
        $order_customer = Orderpassengers::select('customer_id')
            ->where('invoice', 'yes')
            ->where('order_id', $order_id)
            ->first();
        if (count($order_customer) > 0) {
            $customer = Customer::find($order_customer->customer_id);

            $positions = Orderpositions::where('order_id', $order_id)->get();

            $due_date = 'Immediate';
            if ($booking->due_at != NULL)
                $due_date = date('d.m.Y', strtotime($booking->due_at));

            $invoice_data['invoice_number'] = $invoiceID;
            $invoice_data['customer_number'] = $customer->id;
            $invoice_data['invoice_date'] = date('d.m.Y', time());
            $invoice_data['invoice_due'] = $due_date;
            $invoice_data['invoice_address'] = $customer->firstname . " " . $customer->lastname . '<br />' . $customer->street . '<br />' . $customer->postal . " " . $customer->city . '<br />' . $customer->country;

            $subTotal = 0;
            $order_items = '';
            foreach ($positions as $position) {
                $position_meta .= $this->getPositionMeta($position->id, $position->type);
                $item_price = $position->price;
                $quantity = $position->quantity;
                $order_items .= '<tr>
                            <td valign="top" align="center" bgcolor="#DDD" style="padding: 12px;">' . $quantity . '</td>
                            <td valign="top" bgcolor="#DDD" style="padding: 12px; width: 270px; word-wrap:break-word;">
                                ' . $position->title . '
                            </td>
               
                            <td valign="top" align="center" bgcolor="#DDD" style="padding: 12px;">' . number_format($item_price, 2, ',', '.') . ' EUR</td>
                            <td valign="top" align="center" bgcolor="#DDD" style="padding: 12px;">' . number_format($item_price * $quantity, 2, ',', '.') . ' EUR</td>
                        </tr>';
                $subTotal = $subTotal + $item_price * $quantity;
            }

            $order_items .= '<tr>
                    	<td></td>
                        <td bgcolor="#102533" colspan="2" valign="top" align="left" style="color: #FFF; padding: 12px;">Zwischensumme</td>                         
                        <td bgcolor="#102533" valign="top" align="center" style="color: #FFF; padding: 12px;">' . number_format($subTotal, 2, ',', '.') . ' EUR</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td bgcolor="#DDD" style="padding: 12px;"><strong>enthalten 19% MwSt</strong></td>
                        <td bgcolor="#DDD" align="center" style="padding: 12px;"><strong>' . number_format(($subTotal) - ($subTotal / ($this->taxRate * 100) * 100), 2, ',', '.') . ' EUR</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td bgcolor="#102533" style="color: #FFF; padding: 12px;"><strong>Gesamtsumme</strong></td>
                        <td bgcolor="#102533" align="center" style="color: #FFF; padding: 12px;"><strong>' . number_format($subTotal, 2, ',', '.') . ' EUR</strong></td>
                    </tr>';

            $invoice_data['invoice_order'] = $order_items;

            $invoiceHtml = view('admin.bookings.invoicePdf', ['invoice' => $invoice_data])->render();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'de', TRUE, 'UTF-8', 0);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->setDefaultFont("Helvetica");
                $html2pdf->writeHTML($invoiceHtml);
                $html2pdf->Output(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf', 'F');
            } catch (HTML2PDF_exception $e) {
                exit;
            }

            $servicesInfoHtml = view('admin.bookings.serviceInformationPdf', ['invoice' => $invoice_data, 'position_meta' => $position_meta, 'passengers' => $order_passengers])->render();
            try {
                $html2pdf_info = new HTML2PDF('P', 'A4', 'de', TRUE, 'UTF-8', 0);
                $html2pdf_info->pdf->SetDisplayMode('fullpage');
                $html2pdf_info->setDefaultFont("Helvetica");
                $html2pdf_info->writeHTML($servicesInfoHtml);
                $serviceInfo = $html2pdf_info->Output('', TRUE);
            } catch (HTML2PDF_exception $e) {
                exit;
            }
            $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);
            try {
                Mail::send('admin.emails.orderConfirmation', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID, $serviceInfo) {
                    $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                        ->subject('Order Confirmation');
                    $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                    $message->attachData($serviceInfo, 'serviceInformation.pdf');
                });
            } catch (Exception $e) {
                //$e->getMessage();
            }
        }

    }

    /**
     * Prepare meta details
     * @param $position_id
     * @param $type
     * @return string
     */
    protected function getPositionMeta($position_id, $type)
    {
        $metaInfo = array();
        $course_info  = '';
        $hotel_info   = '';
        $position_meta = Orderpositionmeta::where('order_position_id', $position_id)->get();
        if(count($position_meta)>0) {
            foreach ($position_meta as $meta){
                    $metaInfo[$meta->name] = $meta->value;
            }

            if($type=='course' || $type=='bundle') {
                $school = School::select('title')->findOrFail($metaInfo['school_id']);
                $course_type = Coursetype::select('title')->findOrFail($metaInfo['course_type']);
                $course_info = '<tr><td valign="top" align="left" style="padding: 30px 0"><h2>GolfSchool '.$school->title.'</h2>
<table cellspacing="0" cellpadding="0" style="width: 100%;">
<tr>
<td bgcolor="#DDD" style="padding: 12px;">Course Start: '.$metaInfo['course_begin'].'</td>
</tr>
<tr>
<td bgcolor="#DDD" style="padding: 12px;">Course End: '.$metaInfo['course_end'].'</td>
</tr>
<tr>
<td bgcolor="#DDD" style="padding: 12px;">Course Title: '.$course_type->title.'</td>
</tr>
<tr>
<td bgcolor="#DDD" style="padding: 12px; width:80%; word-wrap:break-word;">Course Details: <p>'.$metaInfo['course_details'].'</p></td>
</tr>
<tr>
<td bgcolor="#DDD" style="padding: 12px; width:80%; word-wrap:break-word;">School Details: <p>'.$metaInfo['school_details'].'</p></td>
</tr>
</table></td></tr>';
            }
            if($type=='hotel' || $type=='bundle') {
                $hotel = Hotel::select('title', 'services')->findOrFail($metaInfo['hotel_id']);
                $hotel_info = '<tr><td valign="top" align="left" style="padding: 30px 0"><h2>Hotel '.$hotel->title.'</h2>
<table cellspacing="0" cellpadding="0" style="width: 100%;">
<tr>
<td bgcolor="#DDD" style="padding: 12px;">Arrival: '.$metaInfo['hotel_begin'].'</td>
</tr>
<tr>
<td bgcolor="#DDD" style="padding: 12px;">Departure: '.$metaInfo['hotel_end'].'</td>
</tr>
<tr>
<td bgcolor="#DDD" style="padding: 12px; width:80%; word-wrap:break-word;">Freetext Services: <p>'.$hotel->services.'</p></td>
</tr>
<tr>
<td bgcolor="#DDD" style="padding: 12px; width:80%; word-wrap:break-word;">Hotel Details: <p>'.$metaInfo['hotel_details'].'</p></td>
</tr>
</table></td></tr>';
            }
        }
        return $hotel_info.$course_info;
    }

    /**
     * Prepare order passengers list
     * @param $order_id
     * @return mixed
     */
    protected function getOrderPassengers($order_id)
    {
        $order_passengers = Orderpassengers::select('firstname','lastname', 'mail')
            ->where('order_id', $order_id)
            ->join('customers', 'customers.id', '=', 'order_passengers.customer_id')
            ->groupBy('customers.id')
            ->orderBy('firstname')
            ->get();
        return $order_passengers;
    }


    /**
     * Send booking Voucher PDF as Mail with booking information & passengers list
     * @param $order_id
     */
    protected function sendVoucher($order_id)
    {
        $voucher_data = [];

        $booking = Booking::where('id', $order_id)->first();
        if ($booking->invoice_id > 0) {
            $invoiceID = $booking->invoice_id;

            if ($booking->type == 'booking') {
                $order_passengers = $this->getOrderPassengers($booking->id);
                $order_customer = Orderpassengers::select('customer_id')
                    ->where('invoice', 'yes')
                    ->where('order_id', $order_id)
                    ->first();
                if (count($order_customer) > 0) {
                    $customer = Customer::find($order_customer->customer_id);

                    $voucher_data['invoice_number'] = $invoiceID;
                    $voucher_data['customer_number'] = $customer->id;
                    $voucher_data['invoice_date'] = date('d.m.Y', time());
                    $voucher_data['invoice_address'] = $customer->firstname . " " . $customer->lastname . '<br />' . $customer->street . '<br />' . $customer->postal . " " . $customer->city . '<br />' . $customer->country;

                    $positions = Orderpositions::where('order_id', $order_id)->get();
                    $order_items = '';
                    foreach ($positions as $position) {
                        $quantity = $position->quantity;
                        $order_items .= '<tr>
                            <td valign="top" align="center" bgcolor="#DDD" style="padding: 12px;">' . $quantity . '</td>
                            <td valign="top" bgcolor="#DDD" style="padding: 12px; width: 270px; word-wrap:break-word;">
                                ' . $position->title . '
                            </td>               
                        </tr>';
                    }

                    $voucher_data['booking_data'] = $order_items;

                    $voucherHtml = view('admin.bookings.voucherPdf', ['invoice' => $voucher_data, 'passengers' => $order_passengers])->render();
                    try {
                        $html2pdf = new HTML2PDF('P', 'A4', 'de', TRUE, 'UTF-8', 0);
                        $html2pdf->pdf->SetDisplayMode('fullpage');
                        $html2pdf->setDefaultFont("Helvetica");
                        $html2pdf->writeHTML($voucherHtml);
                        $voucherInfo  = $html2pdf->Output('', true);
                    } catch (HTML2PDF_exception $e) {
                        exit;
                    }

                    $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);
                    try {
                        Mail::send('admin.emails.orderVoucher', ['customer_name' => $customer_name], function ($message) use ($customer, $voucherInfo) {
                            $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                                ->subject('Order Voucher');
                            $message->attachData($voucherInfo, 'bookingVoucher.pdf');
                        });
                    } catch (Exception $e) {
                        //$e->getMessage();
                    }
                }
            }
        }
    }

    /**
     * save Incoming Invoice - Ajax
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveIncomingInvoice(Request $request)
    {
        if(!$request->ajax()){
            return response()->json(['mes'=> 'bad request']);
        }

        $invoice    = new Orderincominginvoice();
        $invoice->order_id  = $request->booking_id;
        $invoice->total     = $request->total;
        $invoice->freetext  = $request->freetext;
        $invoice->payed_at  = Carbon::now();
        $invoice->save();
        if($invoice->id>0){
            return response()->json(['mes'=> 'done']);
        }
        else{
            return response()->json(['mes'=> 'Error! invoice not created']);
        }

    }

    /**
     * @param PositionmetaRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function savePositionMeta(PositionmetaRequest $request, $id)
    {
        if(!$request->ajax()){
            return response()->json(['mes'=> 'bad request']);
        }
        $value = $request->meta_value;
        if(strstr($request->meta_name, "begin") || strstr($request->meta_name, "end"))
            $value = strtotime($request->meta_value);
        $meta = new Orderpositionmeta();
        $meta->order_position_id = $id;
        $meta->name  = $request->meta_name;
        $meta->value = $value;
        $meta->save();

        if($meta->id>0){
            return response()->json(['mes'=> 'done']);
        }
        else{
            return response()->json(['mes'=> 'Error! Meta not saved']);
        }
    }

    /**
     * update Position Meta - Ajax
     * @param PositionmetaRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePositionMeta(PositionmetaRequest $request, $id)
    {
        if(!$request->ajax()){
            return response()->json(['mes'=> 'bad request']);
        }
        $meta = Orderpositionmeta::findOrFail($id);
        $input ='meta_'.$id;
        $value = $request->$input;
        if(strstr($meta->name, "begin") || strstr($meta->name, "end"))
            $value = strtotime($request->$input);

        $positionMeta = Orderpositionmeta::find($id);
        $positionMeta->value = $value;
        $positionMeta->save();
        $affected = $positionMeta->id;

        if($affected>0){
            return response()->json(['mes'=> 'done']);
        }
        else{
            return response()->json(['mes'=> 'Meta not updated']);
        }

    }


    /**
     * Download invoice
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadInvoice($order_id)
    {
        $order = Booking::select('invoice_id')->where('id', $order_id)->first();
        if($order->invoice_id>0) {
            $invoice_pdf = storage_path('app') . '/invoice_archive/Rechnung-' .$order->invoice_id. '.pdf';
            if (file_exists($invoice_pdf)) {
                return response()->download($invoice_pdf);
            }
        }
        else
            return redirect(route('adminBookingShow', $order_id));
    }



    /**
     * send invoice - from booking detail - Ajax
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendInvoice(Request $request, $order_id)
    {
        if (!$request->ajax()) {
            return response()->json(['mes' => 'bad request']);
        }

        $bookingObj = new BookingController();
        $this->taxRate = $bookingObj->taxRate;
        $invoice_data = [];

        $booking = Booking::where('id', $order_id)->first();
        if ($booking->invoice_id > 0) {
            $invoiceID = $booking->invoice_id;
        } else {
            $select_invoiceId = Booking::select('invoice_id')->orderBy('invoice_id', 'DESC')->take(1)->first();
            $invoiceID = $select_invoiceId->invoice_id + 1;
            Booking::where('id', $order_id)->update(['invoice_id' => $invoiceID]);
        }

        $order_customer = Orderpassengers::select('customer_id')
            ->where('invoice', 'yes')
            ->where('order_id', $order_id)
            ->first();
        if (count($order_customer) > 0) {
            $customer = Customer::find($order_customer->customer_id);

            $positions = Orderpositions::where('order_id', $order_id)->get();

            $invoice_data['invoice_number']  = $invoiceID;
            $invoice_data['customer_number'] = $customer->id;
            $invoice_data['invoice_date']    = date('d.m.Y', time());
            if ($booking->due_at != NULL)
                $invoice_data['invoice_due']     = date('d.m.Y', strtotime($booking->due_at));
            $invoice_data['invoice_address'] = $customer->firstname . " " . $customer->lastname . '<br />' . $customer->street . '<br />' . $customer->postal . " " . $customer->city . '<br />' . $customer->country;

            $subTotal = 0;
            $order_items = '';
            foreach ($positions as $position) {
                $item_price = $position->price;
                $quantity = $position->quantity;
                $order_items .= '<tr>
                            <td valign="top" align="center" bgcolor="#DDD" style="padding: 12px;">' . $quantity . '</td>
                            <td valign="top" bgcolor="#DDD" style="padding: 12px; width: 270px; word-wrap:break-word;">
                                ' . $position->title . '
                            </td>
               
                            <td valign="top" align="center" bgcolor="#DDD" style="padding: 12px;">' . number_format($item_price, 2, ',', '.') . ' EUR</td>
                            <td valign="top" align="center" bgcolor="#DDD" style="padding: 12px;">' . number_format($item_price * $quantity, 2, ',', '.') . ' EUR</td>
                        </tr>';
                $subTotal = $subTotal + $item_price * $quantity;
            }

            $order_items .= '<tr>
                    	<td></td>
                        <td bgcolor="#102533" colspan="2" valign="top" align="left" style="color: #FFF; padding: 12px;">Zwischensumme</td>                         
                        <td bgcolor="#102533" valign="top" align="center" style="color: #FFF; padding: 12px;">' . number_format($subTotal, 2, ',', '.') . ' EUR</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td bgcolor="#DDD" style="padding: 12px;"><strong>enthalten 19% MwSt</strong></td>
                        <td bgcolor="#DDD" align="center" style="padding: 12px;"><strong>' . number_format(($subTotal) - ($subTotal / ($this->taxRate * 100) * 100), 2, ',', '.') . ' EUR</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td bgcolor="#102533" style="color: #FFF; padding: 12px;"><strong>Gesamtsumme</strong></td>
                        <td bgcolor="#102533" align="center" style="color: #FFF; padding: 12px;"><strong>' . number_format($subTotal, 2, ',', '.') . ' EUR</strong></td>
                    </tr>';

            $invoice_data['invoice_order'] = $order_items;

            $invoiceHtml = view('admin.bookings.invoicePdf', ['invoice' => $invoice_data])->render();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'de', TRUE, 'UTF-8', 0);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->setDefaultFont("Helvetica");
                $html2pdf->writeHTML($invoiceHtml);
                $html2pdf->Output(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf', 'F');
            } catch (HTML2PDF_exception $e) {
                return response()->json(['mes' => 'Invoice not generated']);
            }

            $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);
            if ($customer->mail != '') {
                try {
                    Mail::send('admin.emails.customerOrderInvoice', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID) {
                        $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                            ->subject('Order Confirmation');
                        $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                    });
                    $message = 'done';
                } catch (Exception $e) {
                    $message = 'Mail not send';
                }
                return response()->json(['mes' => $message]);
            }
        }
        return response()->json(['mes' => 'Request not processed']);
    }


}

<?php

namespace Laraspace\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Laraspace\Booking;
use Laraspace\Customer;
use Laraspace\Http\Requests;
use Laraspace\Membership;
use Laraspace\Orderpassengers;
use Laraspace\Orderpositions;

use HTML2PDF;
use HTML2PDF_exception;
use Mail;
use Exception;

class MembershipController extends Controller
{
    public $taxRate;

    /**
     * Show Membership list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $memberships = Membership::select('CM.firstname', 'CM.lastname', 'memberships.id', 'customer_id', 'joined_at', 'renewed_at', 'cancelled_at')
            ->join('customers AS CM', 'CM.id', '=', 'memberships.customer_id')
            ->orderBY('joined_at', 'DESC')
            ->get();

        return view('admin.memberships.index', ['memberships' => $memberships]);
    }

    /**
     * save Membership
     * @param Request $request
     * @param $customer_id
     * @return \Illuminate\Http\JsonResponse
     */
    //TODO School_id - need to change dummy values of select box
    public function save(Request $request, $customer_id)
    {
        if(!$request->ajax()){
            return response()->json(['mes'=> 'bad request']);
        }

        $membership    = new Membership();
        $membership->customer_id  = $customer_id;
        $membership->school_id    = $request->school;
        $membership->created_at   = Carbon::now();
        $membership->joined_at    = Carbon::now();
        $membership->save();
        if($membership->id>0){
            $created = $this->saveMembershipBooking($request->school, $customer_id);
            if($created>0)
                return response()->json(['mes'=> 'done']);
            else
                return response()->json(['mes'=> 'Membership created but Order not placed']);
        }
        else{
            return response()->json(['mes'=> 'Membership not created']);
        }
    }

    /**
     * save membership booking
     * @param $school
     * @param $customer_id
     * @return int|mixed
     */
    protected function saveMembershipBooking($school, $customer_id)
    {
        $order = new Booking();
        $order->status    = 'finished';
        $order->source    = 'website';
        $order->type      = 'membership';
        $order->payed_at  = Carbon::now();
        $order->save();
        if($order->id>0){
            $order_id = $order->id;
            $order_position = new Orderpositions();
            $order_position->order_id = $order_id;
            $order_position->quantity = 1;
            $order_position->title = 'Membership';
            $order_position->description = 'Membership for one year at golf place ' . $school;
            $order_position->price = 0;
            $order_position->cost  = 0;
            $order_position->type  = 'membership';
            $order_position->save();

            $order_passenger = new Orderpassengers();
            $order_passenger->order_id    = $order_id;
            $order_passenger->customer_id = $customer_id;
            $order_passenger->invoice     = 'yes';
            $order_passenger->save();

            $this->sendMembershipInvoice($order_id, $customer_id);

            return $order_position->id;
        }
        return 0;
    }

    /**
     * send Membership invoice
     * @param $order_id
     * @param $customer_id
     */
    protected function sendMembershipInvoice($order_id, $customer_id)
    {
        $bookingObj = new BookingController();
        $this->taxRate = $bookingObj->taxRate;
        $invoice_data  = [];

        $booking = Booking::where('id', $order_id)->first();
        if ($booking->invoice_id > 0) {
            $invoiceID = $booking->invoice_id;
        } else {
            $select_invoiceId = Booking::select('invoice_id')->orderBy('invoice_id', 'DESC')->take(1)->first();
            $invoiceID = $select_invoiceId->invoice_id + 1;
            Booking::where('id', $order_id)->update(['invoice_id' => $invoiceID]);
        }
        if($booking->status=='finished') {
            $customer = Customer::find($customer_id);
            $positions = Orderpositions::where('order_id', $order_id)->get();

            $invoice_data['invoice_number']  = $invoiceID;
            $invoice_data['customer_number'] = $customer->id;
            $invoice_data['invoice_date']    = date('d.m.Y', time());
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
                exit;
            }

            $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);
            try {
                Mail::send('admin.emails.membershipInvoice', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID) {
                    $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                        ->subject('Membership Booking Invoice');
                    $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                });
            } catch (Exception $e) {
                //$e->getMessage();
            }

        }
    }

    /**
     * Membership renewal
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renewMemberships(Request $request)
    {
        ini_set('max_execution_time', 600);
        if(!$request->ajax()){
            return response()->json(['mes'=> 'bad request']);
        }
        $year = date('Y', strtotime('+1 year'));
        $memberships = Membership::select('id', 'customer_id', 'school_id')
            ->whereNull('cancelled_at')
            ->whereNull('renewed_at')
            ->get();

        $i=0;
        if(count($memberships)>0){
            foreach ($memberships as $membership) {
                $customer_id = $membership->customer_id;
                $school_id   = $membership->school_id;
                $order = new Booking();
                $order->status    = 'confirmed';
                $order->source    = 'other';
                $order->type      = 'membership';
                $order->due_at    = Carbon::now()->addDays(14);
                $order->save();
                if($order->id>0) {
                    $order_id = $order->id;
                    $order_position = new Orderpositions();
                    $order_position->order_id = $order_id;
                    $order_position->quantity = 1;
                    $order_position->title = 'Membership for ' . $year;
                    $order_position->description = 'Membership for one year at golf place ' . $school_id;
                    $order_position->price = 149;
                    $order_position->cost = 149;
                    $order_position->type = 'membership';
                    $order_position->save();
                    $position_id = $order_position->id;

                    $order_passenger = new Orderpassengers();
                    $order_passenger->order_id = $order_id;
                    $order_passenger->customer_id = $customer_id;
                    $order_passenger->invoice = 'yes';
                    $order_passenger->save();
                    $passenger_id = $order_passenger->id;

                    if ($position_id > 0 && $passenger_id > 0) {
                        $membership_update = Membership::find($membership->id);
                        $membership_update->renewed_at = Carbon::now();
                        $membership_update->save();
                        $this->sendMembershipRenewalInvoice($order_id, $customer_id);
                        $i++;
                    }
                }
            }
        }
        if($i>0)
            return response()->json(['mes'=> 'done', 'description' => $i. ' Memberships renewed']);
        else
            return response()->json(['mes'=> 'No memberships renewed', 'description' => '']);
    }


    /**
     * Send renewal invoice
     * @param $order_id
     * @param $customer_id
     */
    protected function sendMembershipRenewalInvoice($order_id, $customer_id)
    {
        $bookingObj = new BookingController();
        $this->taxRate = $bookingObj->taxRate;
        $invoice_data  = [];

        $booking = Booking::where('id', $order_id)->first();
        if ($booking->invoice_id > 0) {
            $invoiceID = $booking->invoice_id;
        } else {
            $select_invoiceId = Booking::select('invoice_id')->orderBy('invoice_id', 'DESC')->take(1)->first();
            $invoiceID = $select_invoiceId->invoice_id + 1;
            Booking::where('id', $order_id)->update(['invoice_id' => $invoiceID]);
        }
        if($booking->status=='confirmed') {
            $customer = Customer::find($customer_id);
            $positions = Orderpositions::where('order_id', $order_id)->get();

            $invoice_data['invoice_number']  = $invoiceID;
            $invoice_data['customer_number'] = $customer->id;
            $invoice_data['invoice_date']    = date('d.m.Y', time());
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
            } catch (HTML2PDF_exception $e) { }

            $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);
            if($customer->mail!='') {
                try {
                    Mail::send('admin.emails.membershipInvoice', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID) {
                        $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                            ->subject('Membership Renewal Invoice');
                        $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                    });
                } catch (Exception $e) { }
            }
        }
    }

    public function cancelMembership(Request $request, $id)
    {
        if(!$request->ajax()){
            return response()->json(['mes'=> 'bad request']);
        }

        $update = Membership::find($id);
        $update->cancelled_at = Carbon::now();
        $update->save();

        $affected =$update->id;
        if($affected>0){
            $membership = Membership::select('customer_id', 'cancelled_at')->where('id', $id)->first();
            $customer = Customer::find($membership->customer_id);
            $cancelled_on = date('d.m.Y', strtotime($membership->cancelled_at));
            if(!empty($customer)){
                $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);
                if($customer->mail!='') {
                    try {
                        Mail::send('admin.emails.membershipCancelled', ['customer_name' => $customer_name, 'cancelled_on' =>$cancelled_on ], function ($message) use ($customer) {
                            $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                                ->subject('Membership has been cancelled');
                        });
                    } catch (Exception $e) { }
                }
            }
            return response()->json(['mes'=> 'done']);
        }
        else
            return response()->json(['mes'=> 'Membership not cancelled']);
    }
}

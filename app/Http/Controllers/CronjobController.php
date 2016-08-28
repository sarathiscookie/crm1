<?php

namespace Laraspace\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Laraspace\Booking;
use Laraspace\Customer;
use Laraspace\Http\Requests;
use Laraspace\Membership;
use Laraspace\Orderpassengers;
use Laraspace\Orderpositionmeta;
use Laraspace\Orderpositions;
use Mail;
use Exception;

class CronjobController extends Controller
{
    /**
     * Send birthday greetings - cron
     */
    public function sendBirthdayGreetings()
    {
        $customers = Customer::select('firstname', 'lastname', 'mail')
            ->where('status','<>', 'blocked')
            ->whereNotNull('birthdate')
            ->whereDay('birthdate', '=', Carbon::today()->day)
            ->whereMonth('birthdate', '=', Carbon::today()->month)
            ->get();
        foreach ($customers as $customer){
            try {
                Mail::send('admin.emails.birthdayGreeting', ['customer' => $customer], function ($message) use ($customer) {
                    $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                        ->subject('Birthday Greetings');
                });
            } catch (Exception $e) {

            }
        }
    }


    /**
     * Send Payment reminder - Cron
     */
    public function sendPaymentReminder()
    {
        $bookings = Booking::select('id', 'invoice_id', 'type')
            ->where('status', 'confirmed')
            ->whereNull('payed_at')
            ->whereNotNull('due_at')
            ->get();
        if(count($bookings)>0) {
            foreach ($bookings as $booking) {
                $invoiceID = $booking->invoice_id;
                $order_customer   = Orderpassengers::select('customer_id')
                    ->where('invoice','yes')
                    ->where('order_id', $booking->id)
                    ->first();
                if(count($order_customer)>0) {
                    $customer = Customer::find($order_customer->customer_id);
                    $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);

                    if($booking->type=='membership'){
                        $membership_due1 = Membership::where('customer_id', $customer->id)
                            ->where('created_at', '=', Carbon::now()->subDays(14)->toDateString())
                            ->first();
                        if(count($membership_due1)>0){
                            try {
                                Mail::send('admin.emails.paymentReminderFirst', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID) {
                                    $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                                        ->subject('First reminder for making payment');
                                    $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                                });
                                Booking::where('id', $booking->id)->update(['reminded1_at' => Carbon::now()]);
                            } catch (Exception $e) {

                            }
                        }
                        else {
                            $membership_due2 = Membership::where('customer_id', $customer->id)
                                ->where('created_at', '=', Carbon::now()->subDays(21)->toDateString())
                                ->first();
                            if(count($membership_due2)>0){
                                try {
                                    Mail::send('admin.emails.paymentReminderSecond', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID) {
                                        $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                                            ->subject('Second reminder for making payment');
                                        $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                                    });
                                    Booking::where('id', $booking->id)->update(['reminded2_at' => Carbon::now()]);
                                } catch (Exception $e) {

                                }
                            }
                        }
                    }
                    else { // for order type booking
                        $position = Orderpositionmeta::select('value')
                            ->join('order_positions AS OP', 'OP.id', '=', 'order_position_metas.order_position_id')
                            ->where('OP.order_id', $booking->id)
                            ->where('order_position_metas.name', 'LIKE', '%_begin')
                            ->where('order_position_metas.value', '>', strtotime(date('d.m.Y')))
                            ->orderBy('order_position_metas.value', 'ASC')
                            ->take(1)
                            ->first();

                        if (count($position) > 0) {
                            $remind_date1 = date('d.m.Y', strtotime("+14 day"));
                            $remind_date2 = date('d.m.Y', strtotime("+9 day"));
                            $begin_date = $position->value;

                            if (strtotime($remind_date1) == $begin_date) {
                                try {
                                    Mail::send('admin.emails.paymentReminderFirst', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID) {
                                        $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                                            ->subject('First reminder for making payment');
                                        $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                                    });
                                    Booking::where('id', $booking->id)->update(['reminded1_at' => Carbon::now()]);
                                } catch (Exception $e) {

                                }
                            } elseif (strtotime($remind_date2) == $begin_date) {
                                try {
                                    Mail::send('admin.emails.paymentReminderSecond', ['customer_name' => $customer_name], function ($message) use ($customer, $invoiceID) {
                                        $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                                            ->subject('Second reminder for making payment');
                                        $message->attach(storage_path('app') . '/invoice_archive/Rechnung-' . $invoiceID . '.pdf');
                                    });
                                    Booking::where('id', $booking->id)->update(['reminded2_at' => Carbon::now()]);
                                } catch (Exception $e) {

                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Welcome back mail to customer with feedback url -Cron
     */
    //TODO update feedback url
    public function sendWelcomeBackMail()
    {
        $bookings = Booking::select('id', 'invoice_id')
            ->where('status', 'finished')
            ->whereNotNull('payed_at')
            ->get();

        if(count($bookings)>0) {
            foreach ($bookings as $booking) {
                $order_customer   = Orderpassengers::select('customer_id')
                    ->where('invoice','yes')
                    ->where('order_id', $booking->id)
                    ->first();

                if(count($order_customer)>0) {
                    $customer = Customer::find($order_customer->customer_id);
                    $customer_name = title_case($customer->firstname) . ' ' . title_case($customer->lastname);

                    $position = Orderpositionmeta::select('value')
                        ->join('order_positions AS OP', 'OP.id', '=', 'order_position_metas.order_position_id')
                        ->where('OP.order_id', $booking->id)
                        ->where('order_position_metas.name', 'LIKE', '%_end')
                        ->where('order_position_metas.value', '<=', strtotime(date('d.m.Y',strtotime("-2 week"))))
                        ->orderBy('order_position_metas.value', 'DESC')
                        ->take(1)
                        ->first();

                    if (count($position) > 0) {
                        try {
                            Mail::send('admin.emails.customerWelcomeBack', ['customer_name' => $customer_name, 'orderId' => $booking->id], function ($message) use ($customer) {
                                $message->to($customer->mail, title_case($customer->firstname) . ' ' . title_case($customer->lastname))
                                    ->subject('Welcome Back');
                            });
                        } catch (Exception $e) {

                        }
                    }
                }
            }
        }
    }

}

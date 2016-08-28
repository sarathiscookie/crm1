<?php

namespace Laraspace\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Laraspace\Booking;
use Laraspace\Customer;
use Laraspace\Http\Requests;
use Laraspace\Http\Requests\CustomerRequest;
use Laraspace\Membership;
use Laraspace\Orderpassengers;


class CustomerController extends Controller
{
    public $taxRate;
    public $countryList = array(
        "GB" => "United Kingdom",
        "US" => "United States",
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua And Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia And Herzegowina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, The Democratic Republic Of The",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote D'Ivoire",
        "HR" => "Croatia (Local Name: Hrvatska)",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "TP" => "East Timor",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "FX" => "France, Metropolitan",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Deutschland",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard And Mc Donald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran (Islamic Republic Of)",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic Of",
        "KR" => "Korea, Republic Of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau",
        "MK" => "Macedonia, Former Yugoslav Republic Of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States Of",
        "MD" => "Moldova, Republic Of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "KN" => "Saint Kitts And Nevis",
        "LC" => "Saint Lucia",
        "VC" => "Saint Vincent And The Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome And Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia (Slovak Republic)",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia, South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SH" => "St. Helena",
        "PM" => "St. Pierre And Miquelon",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard And Jan Mayen Islands",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic Of",
        "TH" => "Thailand",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad And Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks And Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands (British)",
        "VI" => "Virgin Islands (U.S.)",
        "WF" => "Wallis And Futuna Islands",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "YU" => "Yugoslavia",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"
    );

    public function index()
    {
        $customers = Customer::orderBY('created_at', 'DESC')->get();

        return view('admin.customers.index')->with('customers',$customers);
    }


    /**
     * Backend - Search
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        if(!$request->ajax()) {
            return response()->json(['result'=>'bad request']);
        }

        $keyword =  $request->key;
        $result_customers = $this->searchCustomers($keyword);
        $result_bookings  = $this->searchBookings($keyword);

        $results = $result_customers.$result_bookings;

        return response()->json(['result'=>$results]);
    }


    /**
     * search customers
     * @param $keyword
     * @return string
     */
    protected function searchCustomers($keyword)
    {
        $result_customer ='';
        $customers             = Customer::select('id', 'firstname', 'lastname')
            ->where(function ($query) use($keyword) {
                $query->where('firstname', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('lastname', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('mail', 'LIKE', '%'.$keyword.'%');
            })
            ->orderBy('firstname')
            ->get();
        if(count($customers)>0) {
            $result_customer = '<div class="list-group"><h5 class="list-group-item-heading">CUSTOMERS ('.count($customers).')</h5>';
            foreach ($customers as $customer) {
                $result_customer .= '<a href="'.route('admin.customer.show',$customer->id).'" class="list-group-item">
'.title_case($customer->firstname).' '.title_case($customer->lastname).'
</a>';
            }
            $result_customer .='</div>';
        }
        return  $result_customer;
    }

    /**
     * search Bookings
     * @param $keyword
     * @return string
     */
    protected function searchBookings($keyword)
    {
        $result_booking ='';
        $bookings             = Booking::select('id', 'invoice_id')
            ->where(function ($query) use($keyword) {
                $query->where('invoice_id', 'LIKE', '%'.$keyword.'%');
            })
            ->orderBy('invoice_id')
            ->get();
        if(count($bookings)>0) {
            $result_booking = '<div class="list-group"><h5 class="list-group-item-heading">BOOKINGS ('.count($bookings).')</h5>';
            foreach ($bookings as $booking) {
                $result_booking .= '<a href="'.route('adminBookingShow',$booking->id).'" class="list-group-item">
'.$booking->invoice_id.'
</a>';
            }
            $result_booking .='</div>';
        }
        return  $result_booking;
    }


    public function create()
    {
        $statusList = $this->getStatusList();

        return view('admin.customers.create', ['countryList' => $this->countryList, 'statusList' =>$statusList ]);
    }

    public function save(CustomerRequest $request)
    {
        $dob = NULL;
        if($request->birthdate!='')
            $dob = date('Y.m.d', strtotime($request->birthdate));
        $customer = new Customer();
        $customer->firstname = $request->firstname;
        $customer->lastname  = $request->lastname;
        $customer->mail      = $request->mail;
        $customer->phone     = $request->phone;
        $customer->birthdate = $dob;
        $customer->street    = $request->street;
        $customer->postal    = $request->postal;
        $customer->city      = $request->city;
        $customer->country   = $request->country;
        $customer->status    = $request->status;
        $customer->save();
        if($customer->id>0) {
            $customer_id = $customer->id;
            if($request->mode=='customer'){
                flash()->success(trans('messages.customerCreatedSuccessMsg'));
                return redirect(route('admin.customer.show', $customer_id));
            }
            elseif ($request->mode=='order'){
                $order = new Booking();
                $order->status    = 'confirmed';
                $order->source    = 'website';
                $order->type      = 'other';
                $order->due_at    = Carbon::now()->addDays(14);
                $order->save();
                if($order->id>0){
                    $order_id = $order->id;
                    $order_passenger = new Orderpassengers();
                    $order_passenger->order_id    = $order_id;
                    $order_passenger->customer_id = $customer_id;
                    $order_passenger->invoice     = 'yes';
                    $order_passenger->save();

                    if($order_passenger->id>0){
                        flash()->success(trans('messages.customerAndOrderCreatedSuccessMsg'));
                        return redirect(route('adminBookingShow', $order_id));
                    }
                }
            }
        }
        else{
            flash()->warning(trans('messages.customerCreateErrorMsg'));
            return redirect()->back();
        }

    }

    /**
     * Customer Details
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $bookings = Booking::select('orders.id', 'invoice_id', 'orders.status', 'orders.created_at')
            ->join('order_passengers AS OP','OP.order_id', '=', 'orders.id')
            ->where('OP.invoice', 'yes')
            ->where('OP.customer_id', $id)
            ->groupBy('orders.id')
            ->orderBy('orders.created_at', 'DESC')
            ->get();

        $membership = Membership::where('customer_id', $id)->first();

        return view('admin.customers.show',['customer' => $customer, 'bookings'=>$bookings, 'membership'=>$membership ]);
    }

    /**
     * Customer Edit mode
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $customer   = Customer::findOrFail($id);
        $statusList = $this->getStatusList();

        return view('admin.customers.edit', ['customer' => $customer, 'countryList' => $this->countryList, 'statusList' =>$statusList ]);
    }

    /**
     * customer update
     * @param CustomerRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CustomerRequest $request, $id)
    {
        $dob = NULL;
        if($request->birthdate!='')
            $dob = date('Y.m.d', strtotime($request->birthdate));
        $customer = Customer::findOrFail($id);
        $customer->firstname = $request->firstname;
        $customer->lastname  = $request->lastname;
        $customer->mail      = $request->mail;
        $customer->phone     = $request->phone;
        $customer->birthdate = $dob;
        $customer->street    = $request->street;
        $customer->postal    = $request->postal;
        $customer->city      = $request->city;
        $customer->country   = $request->country;
        $customer->status    = $request->status;
        $customer->save();

        return redirect(route('admin.customer.show', $id));
    }

    /**
     * Status list
     * @return array
     */
    protected function getStatusList()
    {
        return $statuses = [
            'customer' => trans('messages.customerStatusCustomer'),
            'vip'      => trans('messages.customerStatusVip'),
            'blocked'  => trans('messages.customerStatusBlocked'),
            'deleted'  => trans('messages.customerStatusDeleted'),
        ];
    }

    /**
     * create order from customer details -Ajax
     * @param Request $request
     * @param $customer_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createOrder(Request $request, $customer_id)
    {
        if(!$request->ajax()) {
            return response()->json(['mes'=>'bad request']);
        }
        $order = new Booking();
        $order->status    = 'confirmed';
        $order->source    = 'website';
        $order->type      = 'other';
        $order->due_at    = Carbon::now()->addDays(14);
        $order->save();
        if($order->id>0){
            $order_id = $order->id;
            $order_passenger = new Orderpassengers();
            $order_passenger->order_id    = $order_id;
            $order_passenger->customer_id = $customer_id;
            $order_passenger->invoice     = 'yes';
            $order_passenger->save();

            if($order_passenger->id>0){
                flash()->success(trans('messages.customerOrderCreatedSuccessMsg'));
                return response()->json(['mes'=>'done', 'redirect' => route('adminBookingShow', $order_id)]);
            }
        }
        else
            return response()->json(['mes'=>'Order not created', 'redirect'=>'']);

    }



}

<?php

namespace Laraspace\Http\Controllers;

use Illuminate\Http\Request;

use Laraspace\Http\Requests;

use Laraspace\Http\Requests\SchoolRequest;

use Laraspace\Orderpassengers;

use Laraspace\School;

use Laraspace\Orderpositionmeta;

use Laraspace\Coursetype;

use HTML2PDF;

use HTML2PDF_exception;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::select('id', 'title')->get();
        return view('admin.personlist.school.index', ['schools' => $schools]);
    }

    /**
     * Download pdf.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download(SchoolRequest $request)
    {
        if(isset($request->schoolID))
        {
            $html         = '';

            /* For school title */
            $schoolTitle  = Orderpositionmeta::select('order_position_metas.order_position_id', 'schools.title AS schooltitle')
                ->join('schools', 'schools.id', '=', 'order_position_metas.value')
                ->where('order_position_metas.name', 'school_id')
                ->where('order_position_metas.value', $request->schoolID)
                ->first();

            if(count($schoolTitle))
            {
                $html .= '<h1>'.$schoolTitle->schooltitle.'</h1>';

                /* For getting course begin, course end*/
                $beginEndCourseTitles = Orderpositionmeta::select('order_position_metas.name', 'order_position_metas.value', 'order_positions.order_id')
                    ->join('order_positions', 'order_positions.id', '=', 'order_position_metas.order_position_id')
                    ->where('order_position_metas.order_position_id', $schoolTitle->order_position_id)
                    ->get();

                if(count($beginEndCourseTitles))
                {
                    foreach ($beginEndCourseTitles as $beginEndCourseTitle) {
                        if ($beginEndCourseTitle->name == 'course_begin')
                        {
                            $courseBeginValue = $beginEndCourseTitle->value;
                            $html .= '<h2>Course Begin - ' . $courseBeginValue .'</h2>';
                        }

                        if ($beginEndCourseTitle->name == 'course_end')
                        {
                            $courseEndValue = $beginEndCourseTitle->value;
                            $html .= '<h2>Course End - ' . $courseEndValue .'</h2>';
                        }

                        if($beginEndCourseTitle->name == 'course_type')
                        {
                            $courseTypeValue = $beginEndCourseTitle->value;

                            /* For getting course type title */
                            $courseTypeTitle = Coursetype::select('title')
                                ->where('id', $courseTypeValue)
                                ->first();
                            $html .= '<h3>'  .$courseTypeTitle->title. '</h3>';

                            /* For getting customer details */
                            $customerDetails = Orderpassengers::select('order_passengers.customer_id', 'customers.firstname', 'customers.lastname')
                                ->join('customers', 'customers.id', '=', 'order_passengers.customer_id')
                                ->where('order_id', $beginEndCourseTitle->order_id)
                                ->get();
                            foreach ($customerDetails as $customerDetail)
                            {
                                $html .= '<ul><li>' . $customerDetail->firstname . ' ' . $customerDetail->lastname .'</li></ul>';
                            }
                        }
                    }
                    try {
                        $html2pdf = new HTML2PDF('P', 'A4', 'de', TRUE, 'UTF-8', [10,0,10,0]);
                        $html2pdf->pdf->SetDisplayMode('fullpage');
                        $html2pdf->setDefaultFont("Helvetica");
                        $html2pdf->writeHTML($html);
                        $html2pdf->Output('schools.pdf');
                    } catch (HTML2PDF_exception $e) {
                        exit;
                    }
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
    public function store(SchoolRequest $request)
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
    public function update(SchoolRequest $request, $id)
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

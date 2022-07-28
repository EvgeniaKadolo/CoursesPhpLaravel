<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $header = 'Языковая школа LINGVO';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $courses = array();
        foreach (Auth::user()->courses as $course) {
//            dd(Course::find($course->pivot->course_id));
            $courses[] = Course::find($course->pivot->course_id);
        }
        return view('home')->with(['header'=>$this->header, 'courses' => $courses]);
    }
}

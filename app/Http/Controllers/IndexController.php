<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Auth;

class IndexController extends Controller
{
    public $header = 'Языковая школа LINGVO';

    public function index() {
        if (session('filter') && session('filter') == 1)
            $courses = Course::where('date', '>', date('Y-m-d'))->get();
        else if (session('filter') && session('filter') == 2)
            $courses = Course::where('date', '<=', date('Y-m-d'))->get();
        else if (session('filter') && session('filter') == 3)
            $courses = Course::where('number', 0)->get();
        else
            $courses = Course::get();
        return view('index')->with(['header'=>$this->header, 'courses'=>$courses]);
    }

    public function courses($id) {
        $title = Language::findOrFail($id);
        if (session('filter') && session('filter') == 1)
            $courses = Course::where('date', '>', date('Y-m-d'))->where('language_id', $id)->get();
        else if (session('filter') && session('filter') == 2)
            $courses = Course::where('date', '<=', date('Y-m-d'))->where('language_id', $id)->get();
        else if (session('filter') && session('filter') == 3)
            $courses = Course::where('number', 0)->where('language_id', $id)->get();
        else
            $courses = Course::where('language_id', $id)->get();
        return view('courses')->with(['header'=>$this->header, 'title'=>$title->name, 'courses'=>$courses]);
    }

    public function course($id) {
        $course = Course::findOrFail($id);
        $title = Language::findOrFail($course->language_id);
        return view('course')->with(['header'=>$this->header, 'title'=>$title->name, 'course'=>$course]);
    }

    public function delete(Course $course) {
        $this->authorize('delete');
        $info = '';
        if (empty(($course->users)->toArray())) {
            $course->delete();
        }
        else $info = 'Нельзя удалить, на курс есть записи';
        return redirect()->back()->with('success', $info);
    }

    public function add() {
        $this->authorize('store');
        $language = Language::get();
        return view('add')->with(['language'=>$language]);
    }

    public function change(Course $course)
    {
        $this->authorize('edit');
        $language = Language::get();
        return view('edit')->with(['course'=>$course, 'language'=>$language]);
    }

    public function store(Request $request)
    {
        $this->authorize('store');

        $validated = $request->validate([
            'name'     => ['required'],
            'description' => ['required'],
            'date'    => ['required', 'date', 'after:'.date('d.m.Y')],
            'number' => ['required', 'numeric', 'min:0']
        ]);

        $course = new Course();
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $course->date = $request->input('date');
        $course->number = $request->input('number');
        $course->image = $request->input('image');
        $course->language_id = $request->input('language_id');
        $course->save();
//        dd($request->all());
        return redirect()->route('course', ['id' => $course->id]);
    }

    public function edit(Course $course, Request $request)
    {
        $this->authorize('edit');

        $validated = $request->validate([
            'name'     => ['sometimes'],
            'description' => ['sometimes'],
            'date'    => ['sometimes', 'date'],
            'number' => ['sometimes', 'numeric', 'min:0'],
            'image' => ['sometimes']
        ]);

//        dd($request->input('image'));

        if (!empty($request->input('image'))) {
            $course->update([
                'image'   => $request->get('image')
            ]);
        }
        $course->update([
            'name'     => $request->get('name'),
            'description' => $request->get('description'),
            'date'    => $request->get('date'),
            'number'    => $request->get('number'),
            'language_id'   => $request->get('language_id')
        ]);
        return redirect()->route('course', ['id' => $course->id]);
    }

    public function record(Course $course) {
//        dd($user->courses->contains($course->id));
        if ($course->number > 0 && !Auth::user()->courses->contains($course->id) && $course->date > date('Y-m-d')) {
            Auth::user()->courses()->attach($course->id);
            $course->update([
                'number'    => $course->number - 1
            ]);
            $info = 'Вы успешно записались на курс';
        }
        else if (Auth::user()->courses->contains($course->id)) {
            $info = 'Вы уже записаны на данный курс';
        }
        else if ($course->date <= date('Y-m-d')) {
            $info = 'Дата начала курса уже прошла';
        }
        else {
            $info = 'Места на данный курс закончились';
        }
        return redirect()->back()->with('success', $info);
//        return view('person')->with(['header'=>$this->header, 'info'=>$info, 'courses' => $courses]);
//        return redirect()->route('person', ['info' => $info]);
    }

    public function unsubscribe(Course $course) {
//        dd($course->date < date('y-m-d'));
        if ($course->date > date(('Y-m-d'), strtotime(date('Y-m-d'). ' + 1 day')) && Auth::user()->courses->contains($course->id)) {
            Auth::user()->courses()->detach($course->id);
            $course->update([
                'number'    => $course->number + 1
            ]);
            $info = 'Вы успешно отписались от курса';
        }
        else {
            $info = 'Нельзя отписаться, курс уже начался';
        }
        return redirect()->back()->with('success', $info);
    }

    public function filter(Request $request)
    {
        return redirect()->back()->with('filter', $request->get('filter'));
    }

    public function list_records(Course $course)
    {
        $users = array();
        $info = '';
        foreach ($course->users as $user) {
            $users[] = User::find($user->pivot->user_id);
        }
        if (empty($users)) $info = 'Записей нет';
        return redirect()->back()->with(['users' => $users, 'info' => $info]);
    }

    public function delete_user(User $user, Course $course) {
        $this->authorize('delete');
        $user->courses()->detach($course->id);
        $course->update([
            'number'    => $course->number + 1
        ]);
        return redirect()->back();
    }
}

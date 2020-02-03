<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;

class FeedbacksController extends Controller
{
    //
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('feedbacks.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        return view('feedbacks.show', compact('feedback'));
    }

    public function create()
    {
        return view('feedbacks.create');
    }

    public function store()
    {
        $request_arr = $this->validate(request(), [
            'email' => 'required | email:rfc',
            'message' => 'required',
        ]);
        Feedback::create($request_arr);
        return redirect('/posts');
    }
}

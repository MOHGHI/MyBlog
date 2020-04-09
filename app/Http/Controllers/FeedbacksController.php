<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\User;
use Illuminate\Http\Request;

class FeedbacksController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('show');
    }

    public function index()
    {
        if (auth()->user() && auth()->user()->isAdmin())
        {
            $feedbacks = Feedback::latest()->get();
            return view('feedbacks.index', compact('feedbacks'));
        }

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
        return redirect('/');
    }
}

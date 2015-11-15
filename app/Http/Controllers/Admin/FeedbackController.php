<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Feedback;

class FeedbackController extends Controller
{
    public function showList()
    {
        $feedbacks = Feedback::all();
        return view('admin.feedback', [
            'active' => 'feedback',
            'feedbacks' => $feedbacks
            ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Feedback;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function showList()
    {
        $feedbacks = Feedback::newest()->paginate(10);

        return view('admin.feedback', [
            'active'    => 'feedback',
            'feedbacks' => $feedbacks,
            ]);
    }
}

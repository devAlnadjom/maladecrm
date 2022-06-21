<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreFeedbackRequest;

class FeedbackController extends Controller
{

    public function index(Request $request)
    {
        if(auth()->user()->email != 'dev.alnadjom@gmail.com')
            abort(403);
        if($request->has('view')){
            $feedback= Feedback::findOrFail($request->get('view'));
            $feedback->load('user');
        }
        $feedbacks=Feedback::Select(['id','user_id', 'type','created_at'])
                            ->with('user:id,name')
                            ->paginate(10);

       // dd($feedback)
        return Inertia::render('Feedbacks/Index',[
            'feedbacks'=> $feedbacks,
            'feedback'=> isset($feedback)?$feedback:false,
        ]);
    }



    public function store(StoreFeedbackRequest $request)
    {
        $validated = $request->validated();
        $user_id =auth()->user()->id;
        $feedback=Feedback::create($validated + ['user_id'=>$user_id]);

        return Redirect::route('dashboard')->with('success', "Feedback added successfully");
    }


    public function show( $customer)
    {
        $feedback= Feedback::findOrFail($customer);
       // dd($customer);
        return Inertia::render('Feedbacks/Edit',[
            'feedback'=> $feedback,
        ]);
    }
}

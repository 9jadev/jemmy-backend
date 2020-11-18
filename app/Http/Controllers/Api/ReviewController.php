<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $id = Auth::id();

        $inv = User::find($id)->reviews;

        return response(['review' => $inv, 'status' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $inv = User::where('nickname', $id)->first();
        // $id = $inv->i;
        // $request->user_id = $id;
        
        $request->validate([
            'review' => 'required|string|min:25',
        ]);
        $review = Review::create([
            'user_id' => $inv->id,
            'review' => $request->review
        ]);
        return response(['review' => $review, 'status' => true]);
        // return $inv;
    }

}

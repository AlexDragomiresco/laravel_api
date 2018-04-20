<?php

namespace App\Http\Controllers;

use App\Poll;
use App\Http\Resources\Poll as PollResource;
use Illuminate\Http\Request;
use Validator;

class PollsController extends Controller
{
    public function index()
    {
        return response()->json(Poll::get(), 200); //get polls from DB
    }

    public function show($id)
    {
        $poll = Poll::find($id);

        if (is_null($poll)) {
            return response()->json(null, 404);
        }

        $response = new PollResource(Poll::findOrFail($id), 200);

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'titles' => 'required|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);
        // dd($validator->fails()); //debug and die
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $poll = Poll::create($request->all());
        return response()->json($poll, 201); //new poll is created
    }

    public function update(Request $request, Poll $poll)
    {
        $poll->update($request->all());
        return response()->json($poll, 200);
    }

    public function delete(Request $request, Poll $poll)
    {
        $poll->delete();
        return response()->json(null, 204);
    }

    public function errors()
    {
        return response()->json(['message' => 'No money no fun'], 501);
    }

    public function questions(Request $request, Poll $poll)
    {
        $question = $poll->questions;
        return response()->json($question, 200);
    }
}

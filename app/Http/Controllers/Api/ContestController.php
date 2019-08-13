<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Eloquent\Contest;
use App\Models\Eloquent\Answer;

class ContestController extends Controller
{
    public function status()
    {
        return response()->json([
            'ret'  => 200,
            'desc' => 'successful',
            'data' => Contest::status(),
        ]);
    }

    public function submitted(Request $request)
    {
        $user_id = $request->user()->id;
        return response()->json([
            'ret'  => 200,
            'desc' => 'successful',
            'data' => Answer::fetch($user_id),
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'problem_id' => 'required|integer',
            'option'     => 'string',
            'content'    => 'string',
        ]);
        $option = $request->input('option',null);
        $config = [
            'problem_id' => $request->input('problem_id'),
            'user_id'    => $request->user()->id,
            'content'    => $request->input('content'),
        ];
        if(!empty($option)){
            $config['option'] = $option;
        }
        Answer::submit($config);
        return response()->json([
            'ret'   => 200,
            'desc'  => 'successful',
            'data'  => null
        ]);
    }

    public function modify(Request $request)
    {
        $request->validate([
            'start' => 'required|integer',
            'end'   => 'required|integer',
            'required|integer'  => 'string',
        ]);
        $name = $request->input('name',null);
        $config = [
            'start' => $request->input('start'),
            'end'   => $request->input('end'),
        ];
        if(!empty($name)){
            $config['name'] = $name;
        }
        Contest::set($config);
        return response()->json([
            'ret'   => 200,
            'desc'  => 'successful',
            'data'  => null
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\DetailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $data = DetailUser::with('user')->get();

        foreach ($data as $value) {
            $detail[] = [
                'id' => $value['id'],
                'address' => $value['address'],
                'gender' => $value['gender'],
                'no_hp' => $value['no_hp'],
                'user_id' => $value->user->name,
            ];
        }

        return response()->json([
            'message' => 'Created detail user success',
            'data' => $data,
        ], 201);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'gender' => 'required|string',
            'no_hp' => 'required|string',
            'user_id' => 'int|unique:detail_user',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $detailExist = DetailUser::where('user_id', auth()->user()->id)->first();

        if ($detailExist) {
            return response()->json([
                'message' => 'data is ready',
                'data' => $detailExist,
            ], 400);
        } else {
            $data = DetailUser::create([
                'address' => $request->get('address'),
                'gender' => $request->get('gender'),
                'no_hp' => $request->get('no_hp'),
                'user_id' => auth()->user()->id,
            ]);

            return response()->json([
                'message' => 'Created detail user success',
                'data' => $data
            ], 201);
        }
    }
}

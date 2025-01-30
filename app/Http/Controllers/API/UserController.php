<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $response = [];
        foreach ($users as $user) {
            $response[] = [
                'id' => $user->id,
                'name' => $user->name,
                'renewal_subscription_date' => $user->renewal_subscription_date,
                'end_subscription_date' => $user->end_subscription_date,
                'phone' => $user->phone,
                'price' => $user->price,
                'visits_number' => $user->visits_number,
                'attendance_count' => $user->attendances()->count(),
                'code' => $user->code ?? ''
            ];
        }

        return [
            'status' => 200,
            'users' => $response
        ];
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'renewal_subscription_date' => 'required|date',
            'end_subscription_date' => 'required|date',
            'phone' => 'required',
            'price' => 'required',
            'visits_number' => 'required',
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => 'Invalid Data'
            ], 404);
        }

        $user = new User();
        $user->name = $request->name;
        $user->renewal_subscription_date = $request->renewal_subscription_date;
        $user->end_subscription_date = $request->end_subscription_date;
        $user->phone = $request->phone;
        $user->price = $request->price;
        $user->visits_number = $request->visits_number;
        $user->code = $request->code;
        $user->save();

        return [
            'status' => 200,
            'message' => 'New User added successfully!',
            'user' => $user
        ];
    }

    public function edit($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            $user = User::where('code', $id)->first();
            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found'
                ], 404);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'renewal_subscription_date' => 'required|date',
            'end_subscription_date' => 'required|date',
            'phone' => 'required',
            'price' => 'required',
            'visits_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => 'Invalid Data'
            ], 404);
        }

        $user->name = $request->name;
        $user->renewal_subscription_date = $request->renewal_subscription_date;
        $user->end_subscription_date = $request->end_subscription_date;
        $user->phone = $request->phone;
        $user->price = $request->price;
        $user->visits_number = $request->visits_number;
        $user->save();

        return [
            'status' => 200,
            'message' => 'User updated successfully!',
            'user' => $user
        ];
    }
}

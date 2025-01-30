<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all();
        $response = [];
        foreach ($attendances as $attendance) {
            $response[] = [
                'user_name' => $attendance->user->name,
                'attendance_date' => $attendance->attendance_date
            ];
        }

        return [
            'status' => 200,
            'attends' => $response
        ];
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attendances.*.code' => 'required',
            'attendances.*.attendance_date' => 'required|date:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => 'Invalid Data'
            ], 404);
        }
        foreach ($request->attendances as $attendance) {
            $user = User::where('code', $attendance['code'])->first();
            if (!$user) {
                continue;
            }
            if (strtotime($user->end_subscription_date) <= strtotime($attendance['attendance_date'])) {
                return response()->json([
                    'status' => 404,
                    'message' => 'User subscription ended!'
                ], 404);
            }

            Attendance::create([
                'user_id' => $user->id,
                'attendance_date' => $attendance['attendance_date']
            ]);
        }

        return [
            'status' => 200,
            'message' => 'New Attendance added successfully!',
        ];
    }
}

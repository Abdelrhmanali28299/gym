<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function users(Request $request)
    {
        $users = User::when(!empty($request['from_renewal_subscription_date'] ?? '') && !empty($request['to_renewal_subscription_date'] ?? ''), function ($q) use ($request) {
            $q->where('renewal_subscription_date', '>=', $request['from_renewal_subscription_date'])
                ->where('renewal_subscription_date', '<=', $request['to_renewal_subscription_date']);
        })
            ->when(!empty($request['from_end_subscription_date'] ?? '') && !empty($request['to_end_subscription_date'] ?? ''), function ($q) use ($request) {
                $q->where('end_subscription_date', '>=', $request['from_end_subscription_date'])
                    ->where('end_subscription_date', '<=', $request['to_end_subscription_date']);
            })
            ->when(!empty($request['name'] ?? ''), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request['name'] . '%');
            })
            ->when(!empty($request['phone'] ?? ''), function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request['phone'] . '%');
            })->get();

        $response = [];
        $total = 0;
        foreach ($users as $user) {
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'renewal_subscription_date' => $user->renewal_subscription_date,
                'end_subscription_date' => $user->end_subscription_date,
                'phone' => $user->phone,
                'price' => $user->price,
                'visits_number' => $user->visits_number,
            ];

            $dateDifference = strtotime($user->end_subscription_date) - strtotime(date('Y-m-d'));
            if ($dateDifference > 0) {
                $userData['remaining_days']  = floor($dateDifference / (60 * 60 * 24));
            } else {
                $userData['remaining_days'] = 0;
            }
            $response[] = $userData;
            $total += $user->price;
        }

        return view('report/users', ['data' => $response, 'total' => $total]);
    }
}

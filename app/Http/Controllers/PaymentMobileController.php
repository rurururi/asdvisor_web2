<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;


class PaymentMobileController extends Controller
{

    public function store(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage'), $imageName);
            }

            $newPayment = Payment::create([
                'parent_id' => $request->input("parent_id"),
                'doctor_id' => $request->input("doctor_id"),
                'appointment_id' => $request->input("appointment_id"),
                'ref_no' => $request->input("ref_no"),
                'amount' => $request->input('amount'),
                'image' => $imageName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment created successfully',
                'data' => $newPayment
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create Payment',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function getAppointPayment(Request $request)
    {
        try {
            $payment = Payment::select("parent_id", "appointment_id", "doctor_id", "image", "ref_no", "amount")
                ->where("appointment_id", $request->input("appId"))
                ->get();

            // Check if there are any payments before processing
            if ($payment->isEmpty()) {
                return response()->json([
                    "data" => [], // Return an empty array for no payments
                ]);
            }

            return response()->json([
                "data" => $payment,
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to get payment',
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}

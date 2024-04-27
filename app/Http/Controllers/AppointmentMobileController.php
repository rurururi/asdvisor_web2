<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UniqueAppointmentSet implements \Illuminate\Contracts\Validation\Rule
{
    public function passes($attribute, $value)
    {
        // Extract appointment attributes from the request
        $attributes = request()->only(['doctor_id', 'parent_id', 'appointment_date', 'appointment_end_date']);

        // Query appointments with the same set of attributes
        $existingAppointments = Appointment::where($attributes)->get();

        // Check if any existing appointment matches the provided data
        return $existingAppointments->isEmpty();
    }

    public function message()
    {
        return 'An appointment with the same set of records already exists.';
    }
}


class AppointmentMobileController extends Controller
{

    public function store(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'appointment_date' => [
                    'required',
                    Rule::unique('appointments', 'appointment_date')->where(function ($query) {
                        // Add condition for status being 'approved'
                        $query->where('status', 'approved');
                    }),
                ],
            ]);

            $validator2 = Validator::make($request->all(), [
                'doctor_id' => 'required',
                'parent_id' => 'required',
                'appointment_date' => ['required', new UniqueAppointmentSet],
                'appointment_end_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => "There already an existing appointment"], 400);
            }

            if ($validator2->fails()) {
                return response()->json(['error' => "You already have an existing appointment"], 400);
            }

            Appointment::create([
                'doctor_id' => $request->input("doctor_id"),
                'parent_id' => $request->input("parent_id"),
                'appointment_date' => $request->input("appointment_date"),
                'appointment_end_date' => $request->input("appointment_end_date"),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully',
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to create Appointment',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function AllAppointments(Request $request)
    {
        $appointments = Appointment::where("parent_id", "=", $request->input("parent_id"))
            ->select("id", "doctor_id", "appointment_date", "status")
            ->orderBy("appointment_date")->get();

        $appointments->each(function ($appointment) {
            $doctor = User::find($appointment->doctor_id);
            if ($doctor) {
                $appointment->doctor_name = $doctor->name;
                $imageUrl = asset('storage/' . $doctor->image);
                $appointment->doctorImage = $imageUrl;
            }
        });

        return response()->json([
            "appointments" => $appointments
        ]);
    }


    public function AllAppointmentsDoc(Request $request)
    {
        $appointments = Appointment::where("doctor_id", "=", $request->input("doctor_id"))
            ->select("id", "parent_id", "appointment_date", "status")
            ->orderBy("appointment_date")->get();

        $appointments->each(function ($appointment) {
            $parent = User::find($appointment->parent_id);
            if ($parent) {
                $appointment->parent_name = $parent->name;
                $imageUrl = asset('storage/' . $parent->image);
                $appointment->parentImage = $imageUrl;
            }
        });

        return response()->json([
            "appointments" => $appointments
        ]);
    }

    public function AllAppointmentsDocToday(Request $request)
    {
        $today = Carbon::today()->startOfDay()->format('Y-m-d H:i:s');
        $todayEnd = Carbon::today()->endOfDay()->format('Y-m-d H:i:s');
        $appointments = Appointment::where("doctor_id", "=", $request->input("doctor_id"))
            ->where("status", "=", "Approved")
            ->whereBetween("appointment_date", [$today, $todayEnd])
            ->select("id", "parent_id", "appointment_date", "status")
            ->orderBy("appointment_date")->get();

        $appointments->each(function ($appointment) {
            $parent = User::find($appointment->parent_id);
            if ($parent) {
                $appointment->parent_name = $parent->name;
                $imageUrl = asset('storage/' . $parent->image);
                $appointment->parentImage = $imageUrl;
            }
        });

        return response()->json([
            "appointments" => $appointments
        ]);
    }

    public function firstApp(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        // $today = Carbon::today()->format('Y-m-d H:i:s');
        $appointment = Appointment::where("parent_id", "=", $request->input("parent_id"))
            ->where("status", "=", "Approved")
            ->where("appointment_date", ">=", $today)
            ->select("id", "doctor_id", "appointment_date", "status")
            ->orderBy("appointment_date")
            ->first();

        if ($appointment) {
            $doctor = User::find($appointment->doctor_id);
            if ($doctor) {
                $appointment->doctor_name = $doctor->name;
                $imageUrl = asset('storage/' . $doctor->image);
                $appointment->doctorImage = $imageUrl;
            }
        }

        return response()->json([
            "appointment" => $appointment
        ]);
    }


    public function firstAppDoc(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $appointment = Appointment::where("doctor_id", "=", $request->input("doctor_id"))
            ->where("status", "=", "Approved")
            ->where("appointment_date", ">=", $today)
            ->select("id", "parent_id", "appointment_date", "status")
            ->orderBy("appointment_date")
            ->first();

        if ($appointment) {
            $parent = User::find($appointment->parent_id);
            if ($parent) {
                $appointment->parent_name = $parent->name;
                $imageUrl = asset('storage/' . $parent->image);
                $appointment->parentImage = $imageUrl;
            }
        }

        return response()->json([
            "appointment" => $appointment
        ]);
    }

    public function cancel(Request $request)
    {
        // Find the record by ID
        $app = Appointment::findOrFail($request->input("id"));

        // Update the status to "canceled"
        $app->status = 'Cancelled';
        $app->save();

        return response()->json(['message' => 'Appointment canceled successfully'], 200);
    }

    public function confirm(Request $request)
    {
        // Find the record by ID
        $app = Appointment::findOrFail($request->input("id"));

        // Update the status to "canceled"
        $app->status = 'Approved';
        $app->save();

        return response()->json(['message' => 'Appointment Confirmed successfully'], 200);
    }


    public function countAllAppointments(Request $request)
    {
        try {
            $today = Carbon::today()->startOfDay()->format('Y-m-d H:i:s');
            $todayEnd = Carbon::today()->endOfDay()->format('Y-m-d H:i:s');
            $endOfWeek = Carbon::today()->endOfWeek()->format('Y-m-d H:i:s');

            $count = Appointment::where("doctor_id", "=", $request->input("doctor_id"))->whereBetween("appointment_date", [$today, $todayEnd])->where("status", "=", "Approved")->count();
            $countEndOfWeek = Appointment::where("doctor_id", "=", $request->input("doctor_id"))->whereBetween("appointment_date", [$today, $endOfWeek])->count();
            $todayValue = Carbon::now()->format('Y-m-d H:i:s');

            $totalPatients = Child::where("doctor_id", "=", $request->input("doctor_id"))->count();
            return response()->json([
                "count" => $count,
                "totalPatients" => $totalPatients,
                "today" => $today,
                "todayValue" => $todayValue,
                "endOfWeek" => $endOfWeek,
                "countEndOfWeek" => $countEndOfWeek
            ]);
        } catch (\Exception $error) {
            return response()->json([
                "error" => $error
            ]);
        }
    }
}

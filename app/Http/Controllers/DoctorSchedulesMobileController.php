<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorSchedule;

class DoctorSchedulesMobileController extends Controller
{
    public function get(Request $request)
    {
        $schedules =  DoctorSchedule::select("id", "doctor_id", "weekdays", "start_time", "end_time")->where("doctor_id", $request->input("doctor_id"))->get();
        return response()->json([
            "data" => $schedules
        ]);
    }

    public function create(Request $request)
    {
        try {
            $newDoctorSchedule = DoctorSchedule::create([
                'doctor_id' => $request->input("doctor_id"),
                'weekdays' => $request->input("weekdays"),
                'start_time' => $request->input("start_time"),
                'end_time' => $request->input("end_time"),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Daily Care created successfully',
                'data' => $newDoctorSchedule,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create Daily Care',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        $sched = DoctorSchedule::find($request->input("id"));

        try{
            $sched->weekdays = $request->input("weekdays");
            $sched->start_time = $request->input("start_time");
            $sched->end_time = $request->input("end_time");
            $sched->save();

            return response()->json(['message' => 'Schedule updated successfully']);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to edit Schedule',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $sched = DoctorSchedule::find($request->input("id"));

        if ($sched) {
            $sched->delete();
            return response()->json(['message' => 'Schedule Deleted Successfully']);
        } else {
            return response()->json(['message' => 'Schedule not found'], 404);
        }
    }
}

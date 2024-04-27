<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;

class ChildMobileController extends Controller
{
    public function store(Request $request)
    {
        try {
            $newChildProfile = Child::create([
                'first_name' => $request->input("first_name"),
                'middle_name' => $request->input("middle_name"),
                'last_name' => $request->input("last_name"),
                "parent_id" => $request->input("parent_id"),
                "date_of_birth" => $request->input("date_of_birth"),
                "doctor_id" => $request->input("doctor_id"),
            ]);

            // Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Child profile created successfully',
                'data' => $newChildProfile,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create child profile',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function get(Request $request)
    {
        try {
            $childRecords = Child::where('parent_id', '=', $request->input('parent_id'))->get();
            // Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Child profile created successfully',
                'data' => $childRecords,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create child profile',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function getDoc(Request $request)
    {
        try {
            $childRecords = Child::where('doctor_id', '=', $request->input('doctor_id'))->get();
            // Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Child profile created successfully',
                'data' => $childRecords,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create child profile',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $sched = Child::find($request->input("id"));

        if ($sched) {
            $sched->delete();
            return response()->json(['message' => 'Child Deleted Successfully']);
        } else {
            return response()->json(['message' => 'Child not found'], 404);
        }
    }

    public function getAll()
    {
        try {
            $childRecords = Child::all();
            return response()->json([
                'success' => true,
                'message' => 'Child profile created successfully',
                'data' => $childRecords,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create child profile',
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}

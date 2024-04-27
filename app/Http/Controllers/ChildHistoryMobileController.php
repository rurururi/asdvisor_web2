<?php

namespace App\Http\Controllers;

use App\Models\ChildInformationHistory;
use App\Models\User;
use Illuminate\Http\Request;


class ChildHistoryMobileController extends Controller
{
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imageUrl = asset('images/' . $imageName);
            }

            $newChildHistory = ChildInformationHistory::create([
                'child_id' => $request->input("child_id"),
                'parent_id' => $request->input("parent_id"),
                'behavior' => $request->input("behavior"),
                'assessment' => $request->input("assessment"),
                'doctor_id' => $request->input("doctor_id"),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Child History created successfully',
                'data' => $newChildHistory,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create Child History',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $sched = ChildInformationHistory::find($request->input("id"));

        if ($sched) {
            $sched->delete();
            return response()->json(['message' => 'Child History Deleted Successfully']);
        } else {
            return response()->json(['message' => 'Child History not found'], 404);
        }
    }

    public function get(Request $request)
    {
        $childHistories = ChildInformationHistory::select("id", "behavior", "assessment", "parent_id","doctor_id", "created_at", "image" )->where("child_id", $request->input("child_id"))->get();

        $childHistories->each(function ($childHistory) {
            $parent = User::find($childHistory->parent_id);
            if ($parent) {
                $childHistory->parent_name = $parent->name;
            }
        });

        return response()->json([
            'success' => true,
            'child_histories' => $childHistories
        ]);
    }

    public function getOne(Request $request)
    {
        $childHistory = ChildInformationHistory::select("behavior", "assessment", "parent_id","doctor_id", "created_at", "image" )->where("id", $request->input("id"))->first();

       if($childHistory) {
            $parent = User::find($childHistory->parent_id);
            if ($parent) {
                $childHistory->parent_name = $parent->name;
            }
        };

        return response()->json([
            'success' => true,
            'child_history' => $childHistory
        ]);
    }

    public function updateAssessment(Request $request){
        $record = ChildInformationHistory::find($request->input("id"));
        $record->behavior = $request->input("behavior");
        $record->assessment = $request->input("assessment");
        $record->save();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyCare;
use App\Models\User;

class DailyCareMobileController extends Controller
{
    public function get()
    {
        $daily_cares =  DailyCare::select("id", "doctor_id", "title", "image")->get();

        $daily_cares->each(function ($daily_care) {
            $doctor = User::find($daily_care->doctor_id);
            if ($doctor) {
                $daily_care->doctor_name = $doctor->name;
            }

            $imageUrl = asset('storage/' . $daily_care->image);
            $daily_care->image = $imageUrl;
        });


        return response()->json([
            "data" => $daily_cares
        ]);
    }

    public function gettwo()
    {
        $daily_cares =  DailyCare::select("id", "doctor_id", "title", "image")->take(2)->get();
        $daily_cares->each(function ($daily_care) {
            $doctor = User::find($daily_care->doctor_id);
            if ($doctor) {
                $daily_care->doctor_name = $doctor->name;
            }

            $imageUrl = asset('storage/' . $daily_care->image);
            $daily_care->image = $imageUrl;
        });
        return response()->json([
            "data" => $daily_cares
        ]);
    }


    public function getBody(Request $request){
        $daily_care = DailyCare::select("body", "title")->where("id", $request->input("id"))->get();

        return response()->json([
            "data" => $daily_care
        ]);
    }


    public function edit(Request $request)
    {
        $sched = DailyCare::find($request->input("id"));

        try{
            $sched->title = $request->input("title");
            $sched->body = $request->input("body");
            $sched->save();

            return response()->json(['message' => 'Daily Care updated successfully']);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to edit Daily Care',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $sched = DailyCare::find($request->input("id"));

        if ($sched) {
            $sched->delete();
            return response()->json(['message' => 'Daily Care Deleted Successfully']);
        } else {
            return response()->json(['message' => 'Daily Care not found'], 404);
        }
    }

    public function changeImage(Request $request)
    {
        $user = DailyCare::where("id", $request->input("id"))->first();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage'), $imageName);
            $user->image = $imageName;
            $user->save();
            $imageUrl = asset('storage/' . $imageName);
            return response()->json(['success' => true, 'message' => 'Image uploaded successfully', 'data' => $imageUrl]);
        } else {
            return response()->json(['success' => false, 'message' => 'No image uploaded']);
        }
    }



    public function createguide(Request $request)
    {
        try {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage'), $imageName);

                // return response()->json(['success' => true, 'message' => 'Image uploaded successfully', 'data' => $imageUrl]);
            }
            // else {
            //     return response()->json(['success' => false, 'message' => 'No image uploaded']);
            // }

            $newDailyCare = DailyCare::create([
                'doctor_id' => $request->input("doctor_id"),
                'title' => $request->input("title"),
                'body' => $request->input("body"),
                'image' => $imageName,
            ]);

            $newDailyCare->body = "";
            // Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Daily Care created successfully',
                'data' => $newDailyCare,
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
}

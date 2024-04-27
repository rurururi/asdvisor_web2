<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserMobileController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $newAccount = User::create([
                'name' => $request->input("name"),
                'email' => $request->input("email"),
                'password' => bcrypt($request->input("password")),
                'account_level' => "Parents",
            ]);

            $responseId =  User::where('email', '=', $newAccount->email)
                ->select("id")->first();

            $responseData = [
                "id" => $responseId->id,
                "name" => $newAccount->name,
                'email' => $newAccount->email,
            ];

            // Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully',
                'tokenData' => "",
                'data' => $responseData,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create account',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function get(Request $request)
    {
        $token = Str::random(32);
        try {
            $columns = User::where('email', '=', $request->input('email'))
                ->select("id", "name", "email", "password", "account_level", "image")->first();



            $imageUrl = asset('storage/'.$columns->image);
            $columns->image = $imageUrl;
            if (Hash::check($request->input('password'), $columns->password)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successfully',
                    'tokenData' => $token,
                    'data' => $columns
                ]);
            } else {
                return response()->json(['error' => ["Email or Password is incorrect!"]], 400);
            }
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'error' => ["Email or Password is incorrect!"],
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function getDoctors()
    {
        $doctors = User::where("account_level", "=", "Doctor")
            ->select("id", "name", "email", "image")->get();

            $doctors->each(function ($doctor) {
                $imageUrl = asset('storage/' . $doctor->image);
                $doctor->image = $imageUrl;
            });

        return response()->json([
            "doctors" => $doctors,
        ]);
    }

    public function getParents()
    {
        $parents = User::where("account_level", "=", "Parents")
            ->select("id", "name",)->get();

        return response()->json([
            "parents" => $parents,
        ]);
    }

    public function changeProfile(Request $request)
    {
        $user = User::where("id", $request->input("user_id"))->first();

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
}

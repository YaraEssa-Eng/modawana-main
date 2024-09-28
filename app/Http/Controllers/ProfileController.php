<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile($id)
    {
        $user_name = User::where('id', $id)->with('profile')->first();
        $profile_inf = Profile::where('id', $id)->with('user')->first(); 
        return view('site.profile.index', compact('user_name','profile_inf'));
    }

    public function edit_profile_form($id)
    {
        $user_profile = Profile::findOrFail($id);
        return view('site.profile.edit_profile', compact('user_profile'));
    }


    public function update_profile(Request $request, string $id)
    {
        
        try {
            $user = Profile::findOrFail($id);

            // المصوفة للتحديث  
            $updateData = $request->only([
                'name',
                'bio',
                'location',
                'skills',
                'professional_title',
                'date_of_birth',
                'school_name',
                'universe_name',
                'phone_number',
                'interests',
                'email'
            ]);

            // إعداد مسار التخزين  
            $user_name = $user->name;
            $userDirectory = "public/media/users/$user_name/images/profile";

            // تحقق مما إذا كان هناك صورة جديدة للملف الشخصي  
            if ($request->hasFile('image')) {
                $updateData['avatar'] = $request->file('image')->store($userDirectory, 'local');
            } else {
                $updateData['avatar'] = $user->avatar; // استخدام الصورة القديمة  
            }

            // تحقق مما إذا كان هناك صورة جديدة لصورة الغلاف  
            if ($request->hasFile('cover_image')) {
                $updateData['cover_image'] = $request->file('cover_image')->store($userDirectory, 'local');
            } else {
                $updateData['cover_image'] = $user->cover_image; // استخدام صورة الغلاف القديمة  
            }

            // تحديث الملف الشخصي  
            $user->update($updateData);

            return redirect()->route('user.edit_profile_form', $user->id)
                ->with('success', 'The profile has been updated successfully');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Something happened: ' . $e->getMessage()]);
        }
    }

    // public function upload_profile_photo(Request $request, $id)
    // {
    //     $user = Profile::where('id', $id)->first(); // استخدم first() للحصول على نتيجة واحدة  

    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     if (!$request->hasFile('image')) {
    //         return response()->json(['error' => 'Image not provided'], 400);
    //     }

    //     $user_name = $user->name; // احصل على اسم المستخدم  

    //     // upload image  

    //     $userDirectory = "public/media/users/$user_name/images/profile";

    //     // تحقق من وجود المجلد، إذا لم يكن موجودًا قم بإنشائه  
    //     if (!Storage::exists($userDirectory)) {
    //         Storage::makeDirectory($userDirectory);
    //     }

    //     // احصل على الملف  
    //     $file = $request->file('image');

    //     // قم بتحديد اسم الملف  
    //     $filename = $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

    //     // قم بتخزين الصورة في المجلد الخاص بالمستخدم  
    //     $file->storeAs($userDirectory, $filename);
    //     $user->avatar = json_encode(['filename' => $filename]);
    //     $user->save();
    //     return response()->json(['filename' => $filename], 200);
    // }


    // public function upload_profile_cover(Request $request, $id)
    // {
    //     $user = Profile::where('id', $id)->first(); // استخدم first() للحصول على نتيجة واحدة  

    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     if (!$request->hasFile('cover_image')) {
    //         return response()->json(['error' => 'Image not provided'], 400);
    //     }

    //     $user_name = $user->name; // احصل على اسم المستخدم  

    //     // upload image  
    //     $userDirectory = "public/media/users/$user_name/images/cover";
    //     // تحقق من وجود المجلد، إذا لم يكن موجودًا قم بإنشائه  
    //     if (!Storage::exists($userDirectory)) {
    //         Storage::makeDirectory($userDirectory);
    //     }

    //     // احصل على الملف  
    //     $file = $request->file('cover_image');

    //     // قم بتحديد اسم الملف  
    //     $filename = time() . '.' . $file->getClientOriginalExtension();

    //     // قم بتخزين الصورة في المجلد الخاص بالمستخدم  
    //     $file->storeAs($userDirectory, $filename);
    //     $user->avatar = json_encode(['filename' => $filename]);
    //     $user->save();
    //     return response()->json(['filename' => $filename], 200);
    // }



    public function upload_profile_photo(Request $request, $id)
    {
        $user = Profile::where('id', $id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'Image not provided'], 400);
        }

        $user_name = $user->name;

        // upload image  
        $userDirectory = "public/media/users/$user_name/images/profile";

        if (!Storage::exists($userDirectory)) {
            Storage::makeDirectory($userDirectory);
        }

        $file = $request->file('image');
        $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($userDirectory, $filename);

        // تخزين اسم الملف في الحقل avatar  
        $user->avatar = json_encode(['filename' => $filename]);
        $user->save();

        return response()->json(['filename' => $filename], 200);
    }

    public function upload_profile_cover(Request $request, $id)
    {
        $user = Profile::where('id', $id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!$request->hasFile('cover_image')) {
            return response()->json(['error' => 'Image not provided'], 400);
        }

        $user_name = $user->name;
        // upload image  
        $userDirectory = "public/media/users/$user_name/images/cover";

        if (!Storage::exists($userDirectory)) {
            Storage::makeDirectory($userDirectory);
        }

        $file = $request->file('cover_image');
        $filename = $user->id . '_cover_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($userDirectory, $filename);

        // تخزين اسم الملف في الحقل cover_image  
        $user->cover_image = json_encode(['filename' => $filename]); // تأكد من وجود حقل cover_image في قاعدة البيانات  
        $user->save();

        return response()->json(['filename' => $filename], 200);
    }
}
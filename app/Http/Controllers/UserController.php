<?php

namespace App\Http\Controllers;

use App\Insurance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    public function index()
    {
        $insurances = Insurance::all();
        return view('Home.handy',['insurances'=>$insurances]);
    }

    public function user_detail(){
        $user = Auth::user();
        return view('users.userDetail.detail', ['user' => $user]);
    }

    public function change_password(Request $request)
    {
        $user = Auth::user();

        if (!(Hash::check($request->get('current-password'), $user->password))) {
            Alert::error('คุณใส่รหัสผ่านเก่าไม่ถูกต้อง!', 'กรุณาลองอีกครั้ง')->persistent('ปิด');
            return redirect()->back();
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            Alert::error('คุณใส่รหัสผ่านใหม่ซํ้ากับรหัสผ่านเก่า!', 'กรุณาใส่รหัสผ่านใหม่อีกครั้ง')->persistent('ปิด');
            return redirect()->back();
        }

        if (strcmp($request->get('new-password'), $request->get('new-password_confirmation')) != 0){
            Alert::error('รหัสผ่านไม่ตรงกัน!', 'กรุณาใส่รหัสผ่านใหม่อีกครั้ง')->persistent('ปิด');
            return redirect()->back();
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6',
        ]);
        //Change Password
        try {
            $user->password =Hash::make($request->get('new-password'));
            $user->save();
            Alert::success('สำเร็จ!', 'เปลี่ยนรหัสผ่านรียบร้อย')->autoclose(2000);
            return redirect()->back();
        } catch (Exception $x) {
            Alert::error('เกิดข้อผิดพลาด!', 'กรุณาลองอีกครั้ง')->persistent('ปิด');
            return redirect()->back();

        }
    }

    public function edit_detail(Request $request)
    {
//        $this->validate($request,[
//            'name_edit' => 'required' ,
//            'email_edit' => 'required',
//            'telephone_edit' => 'required'
//        ]);

        $user = Auth::user();
        $img_path = null;

        if($request->hasFile('user_img')) {
            $files = $request->file('user_img');
            $file = Input::file('user_img')->getClientOriginalName();
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $path = $filename . '-' . time() . '.' . $files->getClientOriginalExtension();
            $destinationPath = storage_path('/imgs/user_avatar/');
            $files->move($destinationPath, $path);
            $img_path = $path;
            $user->avatar = $img_path;
        };

        $user->name = $request->name_edit;
        $user->email = $request->email_edit;
        $user->telephone = $request->telephone_edit;

        try {
            $user->save();
            Alert::success('สำเร็จ!', 'อัพเดทข้อมูลเรียบร้อย')->autoclose(2000);
            return redirect()->back();
        } catch (Exception $x) {
            Alert::error('เกิดข้อผิดพลาด!', 'กรุณาลองอีกครั้ง')->persistent('ปิด');
            return redirect()->back();
        }
    }
}

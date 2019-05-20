<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active');
    }

    public function save_review(Request $request)
    {
        if (!$request->score || $request->score == null){
            Alert::error('กรุณาให้คะแนนด้วย','ลองอีกครั้ง!')->persistent('ปิด');
            return redirect()->back();
        }

        if ($request->new_review != null && $request->score){
            $review = new Review([
                'user_id'=>Auth::user()->id,
                'shop_id' => $request->shop_id,
                'message'=>$request->new_review,
                'rating'=>$request->score,
                'token'=>str_random(16),
            ]);

            try{
                $review->save();
                Alert::success('เพิ่มรีวิวของคุณแล้ว','สำเร็จ!')->autoclose(2000);
                return redirect()->back();

            }catch (\Exception $x){
                Alert::error('เกิดข้อผิดพลาด','กรุณาลองอีกครั้ง!')->persistent('ปิด');
                return back()->withInput();
            }
        }else{
            Alert::error('กรุณากรอกข้อมูล','ลองอีกครั้ง!')->persistent('ปิด');
            return back()->withInput();
        }
    }


}

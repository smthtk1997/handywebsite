<?php

namespace App\Http\Controllers;

use App\SocialFacebookAccount;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Alert;
use Illuminate\Support\Facades\Input;

class SocialAuthFacebookController extends Controller
{
    /**
     * Create a redirect method to facebook api.
     *
     * @return void
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback($provider)
    {

        $user = $this->createOrGetUser(Socialite::driver($provider));
        try {
            $code = $user->getStatusCode(); //ลองเอา error มา (กรณีมี error)
        } catch (\Exception $x) { // ถ้าไม่มีให้เป็น 0 แล้ว login
            $code = 0;
        }
        if ($code != 302){
            try {
                auth()->login($user);
            } catch (\Exception $x) {
                Alert::error('เกิดข้อผิดพลาดในการลงชื่อเข้าใช้!', 'กรุณาลองอีกครั้ง')->persistent('ปิด');
                return redirect()->back();
            }
        }else{
            Alert::error('มีอีเมลนี้อยู่ในระบบแล้ว!', 'กรุณาลองอีกครั้ง')->persistent('ปิด');
        }

        return redirect()->to('/');

    }

    public function createOrGetUser(Provider $provider){
        $providerUser = $provider->user();
        $providerName = class_basename($provider);


        $account = SocialFacebookAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account){
            return $account->user;
        }else{

            if ($providerUser->avatar_original){
                $name = strtolower(str_random(16).'.jpeg');
                $fileContent = file_get_contents($providerUser->avatar_original);
                File::put(storage_path().'/imgs/user_avatar/'.$name,$fileContent);
                $avatar = $name;
            }else{
                $avatar = 'user.jpg';
            }

            $user = new User([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => Hash::make($providerUser->getEmail()),
                'telephone' => null,
                'avatar' => $avatar,
                'token' => str_random(16),
            ]);

            try {
                $user->save();

            } catch (\Exception $x) {
                Alert::error('เกิดข้อผิดพลาด!', 'กรุณาลองอีกครั้ง')->persistent('ปิด');
                return redirect()->back();
            }


            $account = new SocialFacebookAccount([
                'user_id'=>$user->id,
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName,
                'token'=>str_random(16)
            ]);

            try {
                $account->save();

            } catch (\Exception $x) {
                Alert::error('เกิดข้อผิดพลาด!', 'กรุณาลองอีกครั้ง')->persistent('ปิด');
                return redirect()->back();
            }

            return $user;
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}

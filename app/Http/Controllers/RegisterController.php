<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;

class RegisterController extends Controller
{
    //新規登録画面を表示
    public function showRegisterForm()
    {
        $countries = Country::all();
        return view('auth.register', compact('countries'));
    }

    //新規登録処理
    public function register(Request $request) 
    {
        //バリデーションルール
        $rules = [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'min:8', 'same:password'],
            'role' => ['required', 'in:0,1'],
            'country_id' => ['required_if:role,1', 'exists:countries,id'],
        ];

        //バリデーションメッセージ
        $messages = [
            'email.required' => 'この項目は必須入力です。',
            'email.email' => 'emailの形式で入力してください。',
            'email.unique' => '入力されたメールアドレスはすでに登録されています。',

            'password.required' => 'この項目は必須入力です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',

            'password_confirmation.required' => 'この項目は必須入力です。',
            'password_confirmation.min' => 'パスワードは8文字以上で入力してください。',
            'password_confirmation.same' => 'パスワードが確認用と一致していません。',

            'role.required' => 'この項目は必須入力です。',
            'role.in' => '不正な値が選択されました。',

            'country_id.required_if' => 'この項目は必須入力です。',
            'country_id.exists' => '選択された国が存在しません。',
        ];

        $request->validate($rules, $messages);

        //roleとcountry_idの初期値設定
        $role = (int)$request->role;

        //管理者の場合country_idを0に設定
        if ($role === 0) {
            $countryId = 0;
        
        //一般ユーザーの場合country_idをリクエストから取得
        } else {
            $countryId = (int)$request->country_id;
        }

        //ユーザー登録
        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'country_id' => $countryId,
        ]);
        
        //登録完了後ログイン画面へリダイレクト
        return redirect()->route('login.show')->with('success', '登録が完了しました。ログインしてください。');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    //ログイン画面を表示
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    //ログイン処理
    public function login(Request $request)
    {
        //バリデーションルール
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];

        //バリデーションメッセージ
        $messages = [
            'email.required' => 'この項目は必須入力です。',
            'email.email' => 'emailの形式で入力してください。',
            'password.required' => 'この項目は必須入力です。',
        ];

        $request->validate($rules, $messages);


        //emailチェック
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'このメールアドレスは登録されていません。',
            ])->withInput();
        }

        //パスワードチェック
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => '入力されたパスワードは登録されている内容と違います。',
            ])->withInput();
        }

        Auth::login($user);
        return redirect('/players');
    }

    //ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();

        // セッションを無効化
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログイン画面へリダイレクト
        return redirect()->route('login.show');
    }
}

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title> 
    <link rel="stylesheet" href="{{ asset('css/style4.css') }}">
</head>
<body>
    <h2>ログイン</h2>

    <form action="{{ route('login.process') }}" method="POST" novalidate>
        @csrf

        {{-- メールアドレス --}}
        <div class="form-group">
            <label for="email">ログインID:</label>
            
            @if ($errors->has('email'))
                <div class="error-massage" id="login_validation">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <input type="email" name="email" id="login_id_input" value="{{ old('email') }}" placeholder="メールアドレス">
        </div>

        {{-- パスワード --}}
        <div class="form-group">
            <label for="password">パスワード:</label>

            @if ($errors->has('password'))
                <div class="error-message" id="password_validation">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <input type="password" name="password" id="password_input" placeholder="パスワード">
        </div>

        {{-- ログインボタン --}}
        <div class="form-group">
            <button type="submit" id="login_button">ログイン</button>
        </div>

        {{-- 新規登録フォームへのリンク --}}
        <div class="form-group">
            <a href="{{ route('register.form') }}" id="register_form">新規登録はこちら</a>
        </div>
    </form>
</body>
</html>




<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録画面</title>
    <link rel="stylesheet" href="{{ asset('css/style5.css') }}">
</head>
<body>
    <h2>新規登録画面</h2>

    <form action="{{ route('register.process') }}" method="POST" novalidate>
        @csrf

        {{-- ログインID --}}
        <div class="form-group">
            <label for="registration_login_id_input">ログインID:</label>

            @if ($errors->has('email'))
                <div class="error-message" id="registration_login_validation">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <input type="email" name="email" id="registration_login_id_input" value="{{ old('email') }}" placeholder="メールアドレス">
        </div>

        {{-- パスワード --}}
        <div class="form-group">
            <label for="registration_password_input">パスワード:</label>

            @if ($errors->has('password'))
                <div class="error-message" id="registration_password_validation">
                    {{ $errors->first('password') }}
                </div>
            @endif
            <input type="password" name="password" id="registration_password_input" placeholder="パスワード">
        </div>

        {{-- パスワード確認 --}}
        <div class="form-group">
            <label for="registration_re_password_input">パスワード確認:</label>

            @if ($errors->has('password_confirmation'))
                <div class="error-message" id="registration_re_password_validation">
                    {{ $errors->first('password_confirmation') }}
                </div>
            @endif

            <input type="password" name="password_confirmation" id="registration_re_password_input" placeholder="パスワード確認">
        </div>

        {{-- ユーザー種別選択 --}}
        <div class="form-group">
            <label for="registration_user_type_radio">ユーザー種別:</label>

            @if ($errors->has('role'))
                <div class="error-message" id="registration_user_type_validation">
                    {{ $errors->first('role') }}
                </div>
            @endif

            <div class="radio-group">
                <input type="radio" name="role" value="1" id="registration_user_type_radio" {{ old('role') == '1' ? 'checked' : '' }}>一般ユーザー
                <input type="radio" name="role" value="0" id="registration_user_type_radio_admin" {{ old('role') == '0' ? 'checked' : '' }}>管理ユーザー
            </div>
        </div>

        {{-- 所属国選択 --}}
        <div class="form-group">
            <label for="registration_country_select">所属国選択:</label>

            @if ($errors->has('country_id'))
                <div class="error-message" id="registration_country_id_validation">
                    {{ $errors->first('country_id') }}
                </div>  
            @endif

            <select name="country_id" id="registration_country_select">
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" 
                        {{ old('country_id', 1) == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- 登録ボタン --}}
        <button type="submit" id="registration_button">登録</button>

        {{-- ログイン画面へのリンク --}}
        <p><a href="{{ route('login.show') }}" id="registration_back_button">ログイン画面に戻る</a></p>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const countrySelect = document.getElementById('registration_country_select');
            const form = document.querySelector('form');

            // ユーザー種別の選択に応じて所属国選択の有効/無効を切り替え
            function toggleCountrySelect() {
                const selectedRadio = document.querySelector('input[name="role"]:checked');
                if (!selectedRadio) {
                    countrySelect.disabled = true;
                    return;
                }
                const selectedValue = selectedRadio.value;
                countrySelect.disabled = (selectedValue === '0');
            }

            // ユーザー種別の選択が変更されたときに切り替えを実行
            roleRadios.forEach(radio => {
                radio.addEventListener('change', toggleCountrySelect);
            });

            // 初期表示時に切り替えを実行
            toggleCountrySelect();
            
            // 登録時のconfirm確認
            form.addEventListener('submit', function(event) {
                const result = window.confirm('登録を実行します。よろしいですか？');
                if (!result) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>




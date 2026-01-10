<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>選手編集画面</title>
    <link rel="stylesheet" href="/css/style3.css">
</head>
<body>
    <h1>選手編集画面</h1>
    <h2>■選手データ</h2>

    <form action="/players/{{ $player->id }}/update" method="post" novalidate>
        @csrf
        @method('post')

        <table>
            <tr>
                <th>No</th>
                <td><div id="id_number">{{ $player->id }}</div></td>
            </tr>
            <tr>
                <th>背番号</th>
                <td>
                    @if ($errors->has('uniform_num'))
                        <div class="error-message">{{ $errors->first('uniform_num') }}</div>
                    @endif
                    <input type="number" name="uniform_num" id="uniform_number" value="{{ $player->uniform_num }}">    
                </td>
            </tr>
            <tr>
                <th>ポジション</th>
                <td>
                    @if ($errors->has('position'))
                        <div class="error-message">{{ $errors->first('position') }}</div>
                    @endif
                    <select name="position" id="position">
                        <option value="GK" {{ $player->position === 'GK' ? 'selected' : '' }}>GK</option>
                        <option value="DF" {{ $player->position === 'DF' ? 'selected' : '' }}>DF</option>
                        <option value="MF" {{ $player->position === 'MF' ? 'selected' : '' }}>MF</option>
                        <option value="FW" {{ $player->position === 'FW' ? 'selected' : '' }}>FW</option>
                    </select>                
                </td>
            </tr>
            <tr>
                <th>名前</th>
                <td>
                    @if ($errors->has('name'))
                        <div class="error-message">{{ $errors->first('name') }}</div>
                    @endif
                    <input type="text" name="name" id="player_name" value="{{ $player->name }}">
                </td>
            </tr>
            <tr>
                <th>国</th>
                <td>
                    @if ($errors->has('country_id'))
                        <div class="error-message">{{ $errors->first('country_id') }}</div>
                    @endif
                    <select name="country_id" id="country_of_affiliation">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ $player->country_id === $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>所属</th>
                <td>
                    @if ($errors->has('club'))
                        <div class="error-message">{{ $errors->first('club') }}</div>
                    @endif
                    <input type="text" name="club" id="team_of_affiliation" value="{{ $player->club }}">
                </td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td>
                    @if ($errors->has('birth'))
                        <div class="error-message">{{ $errors->first('birth') }}</div>
                    @endif
                    <input type="date" name="birth" id="birthday" value="{{ $player->birth }}">  
                </td>
            </tr>
            <tr>
                <th>身長</th>
                <td>
                    @if ($errors->has('height'))
                        <div class="error-message">{{ $errors->first('height') }}</div>
                    @endif
                    <input type="number" name="height" id="body_height" value="{{ $player->height }}">
                </td>
            </tr>
            <tr>
                <th>体重</th>
                <td>
                    @if ($errors->has('weight'))
                        <div class="error-message">{{ $errors->first('weight') }}</div>
                    @endif
                    <input type="number" name="weight" id="body_weight" value="{{ $player->weight }}">                    
                </td>
            </tr>
        </table>
        <button type="submit" id="player_edit_button">編集</button>
        <div>
            <a href="/players" class="detail-link" id="player_back_button">戻る</a>
        </div>
    </form>
</body>
</html>
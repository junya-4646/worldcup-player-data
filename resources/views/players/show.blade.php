<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>選手詳細画面</title>
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
</head>
<body>
    <h1>選手データ</h1>
    <table>
        <tr>
            <th>No</th>
            <td>{{ $player->id }}</td>
        </tr>
        <tr>
            <th>背番号</th>
            <td>{{ $player->uniform_num }}</td>
        </tr>
        <tr>
            <th>ポジション</th>
            <td>{{ $player->position }}</td>
        </tr>
        <tr>
            <th>名前</th>
            <td>{{ $player->name }}</td>
        </tr>
        <tr>
            <th>所属</th>
            <td>{{ $player->club }}</td>
        </tr>
        <tr>
            <th>誕生日</th>
            <td>{{ $player->birth }}</td>
        </tr>
        <tr>
            <th>身長</th>
            <td>{{ $player->height }}</td>
        </tr>
        <tr>
            <th>体重</th>
            <td>{{ $player->weight }}</td>
        </tr>
    </table>

    <div>
        <a href="/players" class="detail-link" id="back_index">戻る</a>
    </div>
</body>
</html>
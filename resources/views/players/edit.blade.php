<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <tittle>選手編集画面</tittle>
    <link rel="stylesheet" href="/css/style3.css">
</head>
<body>
    <h1>選手編集画面</h1>
    <h1>■選手データ</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>背番号</th>
                <th>ポジション</th>
                <th>名前</th>
                <th>国</th>
                <th>所属</th>
                <th>誕生日</th>
                <th>身長</th>
                <th>体重</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($players as $player)
            <tr>
                <td>{{ $player->id }}</td>
                <td>{{ $player->uniform_num }}</td>
                <td>{{ $player->position }}</td>
                <td>{{ $player->club }}</td>
                <td>{{ $player->name }}</td>
                <td>{{ $player->country_name }}</td>
                <td>{{ $player->birth }}</td>
                <td>{{ $player->height }}</td>
                <td>{{ $player->weight }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
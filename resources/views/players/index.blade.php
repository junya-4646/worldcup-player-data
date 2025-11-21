<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>選手一覧画面</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>選手一覧画面</h1>
    <h2>■選手データ</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>背番号</th>
                <th>ポジション</th>
                <th>所属</th>
                <th>名前</th>
                <th>誕生日</th>
                <th>身長</th>
                <th>体重</th>
                <th>詳細</th>
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
                <td>{{ $player->birth }}</td>
                <td>{{ $player->height }}</td>
                <td>{{ $player->weight }}</td>
                <td><a href="/players/{{ $player->id }}" class="detail-link" id="detailed-{{ $player->id }}">詳細</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ページネーションリンク --}}
    <div class="paginate">
        {{ $players->links() }}
    </div>
</body>
</html>
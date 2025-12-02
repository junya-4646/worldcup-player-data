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
                <th>国</th>
                <th>誕生日</th>
                <th>身長</th>
                <th>体重</th>
                <th></th>
                <th></th>
                <th></th>
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
                <td>
                    {{-- 詳細 --}}
                    <a href="/players/{{ $player->id }}" class="detail-link" id="detail_button">詳細</a>
                </td>
                <td>
                    {{-- 編集 --}}
                    <a href="/players/{{ $player->id }}/edit" class="edit-link" id="edit_button">編集</a>
                </td>
                <td>
                    {{-- 削除ボタン --}}
                    <form action="/players/{{ $player->id }}/delete"
                          method="post" 
                          onsubmit="return confirm('この選手データを削除しますか？')"
                          style="display:inline;">
                        @csrf
                        <button type="submit" class="delete-button" id="delete_button">削除</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ページネーションリンク --}}
    <div class="paginate" id="page_{{ $players->currentPage() }}">
        {{ $players->links() }}
    </div>
</body>
</html>
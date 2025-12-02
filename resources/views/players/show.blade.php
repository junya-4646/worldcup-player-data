<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>選手詳細画面</title>
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
</head>
<body>
    <h1>■選手データ</h1>
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
            <th>国</th>
            <td>{{ $player->country_name }}</td>
        </tr>
        <tr>
            <th>所属</th>
            <td>{{ $player->club }}</td>
        </tr>
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
        @if ($goal_count > 0)
            {{-- 総得点 --}}
            <tr>
                <th>総得点</th>
                <td>{{ $goal_count }}点</td>
            </tr>

            {{-- 得点履歴 --}}
            <tr>
                <th>得点履歴</th>
                <td>
                    @foreach ($goals_history as $index => $goal)
                        <div class="goal-history-item">
                            ･ {{ $goal->kickoff }}開始
                            {{ $goal->enemy_country_name }}戦
                            {{ $goal->goal_time }}:
                            {{ $index + 1 }}得点目
                        </div>
                    @endforeach
                </td>
            </tr>
        @else
            {{-- 無得点 --}}
            <tr>
                <th>総得点</th>
                <td>無得点</td>
            </tr>
            <tr>
                <th>得点履歴</th>
                <td></td>
            </tr>
        @endif
    </table>

    <div>
        <a href="/players" class="detail-link" id="back_button">戻る</a>
    </div>
</body>
</html>
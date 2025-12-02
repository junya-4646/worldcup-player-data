<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        // DBから選手データを取得
        $players = DB::table('players')
            ->join('countries', 'players.country_id', '=', 'countries.id')
            ->select(
                'players.id',
                'players.uniform_num',
                'players.position',
                'players.club',
                'players.name',
                'players.birth',
                'players.height',
                'players.weight',
                'countries.name as country_name'
            )
            ->where('players.del_flg', 0)
            ->paginate(20);
        
        // 取得データをビューに渡す
        return view('players.index', ['players' => $players]);

    }

    public function show($id)
    {
        // 一覧から来た場合のみ許可
        if (!session()->pull('from_list', false)) {
            return redirect('/players');
        }

        // IDに該当する選手情報を取得
        $player = DB::table('players')
            ->join('countries', 'players.country_id', '=', 'countries.id')
            ->select(
                'players.id',
                'players.uniform_num',
                'players.position',
                'players.club',
                'players.name',
                'players.birth',
                'players.height',
                'players.weight',
                'countries.name as country_name'
            )
            ->where('players.id', $id)
            ->first();
        
        $goal_count = DB::table('goals')
            ->where('player_id', $id)
            ->count();
            
        $goals_history = DB::table('goals')
            ->join('pairings', 'goals.pairing_id', '=', 'pairings.id')
            ->join('countries', 'pairings.enemy_country_id', '=', 'countries.id')
            ->select(
                'goals.goal_time',
                'pairings.kickoff',
                'countries.name as enemy_country_name'
            )
            ->where('goals.player_id', $id)
            ->orderBy('goals.goal_time', 'asc')
            ->get();

        // 総得点と得点履歴をビューに渡す
        return view('players.show', [
            'player' => $player,
            'goal_count' => $goal_count,
            'goals_history' => $goals_history
        ]);

        // 該当データがない場合
        if (!$player) {
            return redirect('/players');
        }

        // ビューに渡す
        return view('players.show', ['player' => $player]);
    }

    public function edit($id) 
    {
        // 選手を取得
        $player = DB::table('players')
            ->where('id', $id)
            ->first();
        
        //　もし選手が存在しなければ一覧にリダイレクト
        if (!$player) {
            return redirect('/players');
        }

        //　編集画面へ
        return view('players.edit', ['player' => $player]);
    }


    public function delete($id)
    {
        // 選手の論理削除
        DB::table('players')
            ->where('id', $id)
            ->update(['del_flg' => 1]);

        // 一覧にリダイレクト
        return redirect('/players');
    }
}
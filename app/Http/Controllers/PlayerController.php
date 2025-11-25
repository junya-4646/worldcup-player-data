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
        
        // 該当データがない場合
        if (!$player) {
            return redirect('/players');
        }

        // ビューに渡す
        return view('players.show', ['player' => $player]);
    }
}
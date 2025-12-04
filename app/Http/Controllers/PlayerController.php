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

        // 国一覧を取得
        $countries = DB::table('countries')
            ->get();
        
        //　もし選手が存在しなければ一覧にリダイレクト
        if (!$player) {
            return redirect('/players');
        }

        //　編集画面へ
        return view('players.edit', [
            'player' => $player,
            'countries' => $countries
        ]);
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

    public function update(Request $request, $id)
    {
        // バリデーションルール
        $rules = [
            'uniform_num' => ['required', 'regex:/^[0-9]+$/', 'integer', 'between:1,99'],
            'position' => ['required', 'in:GK,DF,MF,FW'],
            'name' => ['required', 'string', 'max:100'],
            'country_id' => ['required', 'exists:countries,id'],
            'club' => ['required', 'string', 'max:100'],
            'birth' => ['required', 'date'],
            'height' => ['required', 'regex:/^[0-9]+$/', 'integer'],
            'weight' => ['required', 'regex:/^[0-9]+$/', 'integer']
        ];

        // バリデーションメッセージ
        $messages = [
            'uniform_num.required' => 'この項目は必須入力です。',
            'uniform_num.regex'    => 'この項目は半角数字で入力してください。',
            'uniform_num.integer'  => 'この項目は整数で入力してください。',
            'uniform_num.between'  => 'この項目は1〜99の範囲で入力してください。',

            'position.required' => 'この項目は必須入力です。',
            'position.in' => 'この項目はGK、DF、MF、FWのいずれかで選択してください。',

            'name.required' => 'この項目は必須入力です。',
            'name.string' => 'この項目は文字列で入力してください。',
            'name.max' => 'この項目は100文字以内で入力してください。',
            
            'country_id.required' => 'この項目は必須入力です。',
            'country_id.exists' => 'この項目は選択可能な国で入力してください。',

            'club.required' => 'この項目は必須入力です。',
            'club.string' => 'この項目は文字列で入力してください。',
            'club.max' => 'この項目は100文字以内で入力してください。',

            'birth.required' => 'この項目は必須入力です。',
            'birth.date' => 'この項目は「YYYY-MM-DD」で入力してください。',

            'height.required' => 'この項目は必須入力です。',
            'height.regex' => 'この項目は半角数字で入力してください。',
            'height.integer' => 'この項目は整数で入力してください。',

            'weight.required' => 'この項目は必須入力です。',
            'weight.regex' => 'この項目は半角数字で入力してください。',
            'weight.integer' => 'この項目は整数で入力してください。',
        ];

        //　バリデーション実行
        $request->validate($rules, $messages);

        // 選手情報を更新
        DB::table('players') 
            ->where('id', $id)
            ->update([
                'uniform_num' => $request->uniform_num,
                'position' => $request->position,
                'name' => $request->name,
                'country_id' => $request->country_id,
                'club' => $request->club,
                'birth' => $request->birth,
                'height' => $request->height,
                'weight' => $request->weight,
            ]);

        return redirect('/players');
    }
}
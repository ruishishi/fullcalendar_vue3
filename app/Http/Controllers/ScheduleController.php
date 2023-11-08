<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * イベントを登録
     */

    public function scheduleAdd(Request $request)
    {
        //バリデーション
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer',
            'event_name' => 'required|max:32',
        ]);

        //登録処理
        $schedule = new Schedule;
        //日付に変換。JSのタイムスタンプはミリ秒なので秒に変換
        $schedule->start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $schedule->end_date = date('Y-m-d', $request->input('end_date') / 1000);
        $schedule->event_name = $request->input('event_name');
        $schedule->save();

        return;
    }

    public function scheduleGet(Request $request)
    {
        //バリデーション
        $request->validate([
            'start_date' => 'required|integer',
            'end_date' => 'required|integer'
        ]);

        //カレンダー表示期間
        $start_date = date('Y-m-d', $request->input('start_date') / 1000);
        $end_date = date('Y-m-d', $request->input('end_date') / 1000);

        //登録処理
        return Schedule::query()
            ->select(
                //FullCalendarの形式に合わせる()
                'id as id',
                'start_date as start',
                'end_date as end',
                'event_name as title'
            )
            //FullCalendarの表示領域のみ表示
            ->where('end_date', '>', $start_date)
            ->where('start_date', '<', $end_date)
            ->get();
    }

    public function scheduleUpdate(Request $request)
    {
        $event = Schedule::find($request->input('event_id'));
        $event->update([
            'event_name' => $request->input('title')
        ]);
    }
}

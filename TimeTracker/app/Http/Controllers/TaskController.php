<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function TaskCreate(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'task_comment' => 'required|string|max:255',
            'task_date' => 'required|date',
            'task_time' => 'required',
        ]);

        DB::insert('INSERT INTO task (name, comment, date, time, status_id, settings, user_id) VALUES (?, ?, ?, ?, 0, 0, 0)', [
            $request->task_name,
            $request->task_comment,
            $request->task_date,
            $request->task_time,
        ]);

        return redirect()->back()->with('success', 'Данные успешно сохранены!');
    }

    public function TaskAccess(Request $request)
    {
        $request->validate([
            'task' => '',
            'mode' => '',
        ]);
        $tasks = $request->task;
        for($i = 0; $i < count($tasks); $i++){
            DB::update('UPDATE task SET status_id = ? WHERE id = ?', [$request->mode, $tasks[$i]['id']]);
        }

        return redirect()->back()->with('success', 'Данные успешно сохранены!');
    }

    public function TaskSelect()
    {
        Carbon::setLocale(config('app.locale'));
        $today = Carbon::today();

        $tasks = [];
        $lastDate = null;

        for ($i = 0; $i < 14; $i++) {
            $currentDate = $today->copy()->addDays($i);
            $dailyData = DB::select(
                'SELECT id, name, comment, date, time, status_id, settings FROM task WHERE `date` = ?  ORDER BY time',
                [$currentDate->format('Y-m-d')]
            );
            $tasks[$i]['task'] = $dailyData;
            $tasks[$i]['date'] = $currentDate->format('Y-m-d');
            $tasks[$i]['day'] = $currentDate->format('d');
            $tasks[$i]['month'] = $currentDate->format('F');
            $tasks[$i]['fulldate'] = $currentDate->format('d. M');
            $tasks[$i]['fullweek'] = $currentDate->format('l');
            $tasks[$i]['dateofweek'] = $currentDate->format('D');

            $lastDate = $currentDate->format('Y-m-d');
        }

        Session::put('last_processed_date', $lastDate);

        return view('task', ['tasks' => $tasks]);
    }

    public function getDates(Request $request)
    {
        $currentDate = $request->input('current_date');
        $dates = $this->generateFutureDates($currentDate);

        return response()->json($dates);
    }

    private function generateFutureDates($currentDate)
    {
        $dates = [];
        $currentDate = \Carbon\Carbon::createFromFormat('Y-m-d', $currentDate);
        
        for ($i = 0; $i < 14; $i++) {
            $nextDate = $currentDate->copy()->addDays($i + 1);
            
            $dailyData = DB::select(
                'SELECT id, name, comment, date, time, status_id, settings FROM task WHERE `date` = ?  ORDER BY time',
                [$nextDate->format('Y-m-d')]
            );

            $dates[] = [
                'day' => $nextDate->format('d'),
                'dateofweek' => $nextDate->format('D'),
                'date' => $nextDate->format('Y-m-d'),
                'month' => $nextDate->format('F'),
                'fulldate' => $nextDate->format('d. M'),
                'fullweek' => $nextDate->format('l'),
                'task' => json_encode($dailyData),
            ];
        }
        
        return $dates;
    }
}

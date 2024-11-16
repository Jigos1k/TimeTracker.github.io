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
            $formattedDate = $currentDate->format('d. M.');
            $dayOfWeek = $currentDate->format('l');
            $dailyData = DB::select(
                'SELECT id, name, comment, date, time, status_id, settings FROM task WHERE `date` = ?  ORDER BY time',
                [$currentDate->format('Y-m-d')]
            );
            $tasks[$formattedDate]['task'] = $dailyData;
            $tasks[$formattedDate]['date'] = $formattedDate;
            $tasks[$formattedDate]['dateofweek'] = $dayOfWeek;

            $lastDate = $formattedDate;
        }

        Session::put('last_processed_date', $lastDate);

        return view('task', ['tasks' => $tasks]);
    }
}

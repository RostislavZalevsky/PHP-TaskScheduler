<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PersonArea\AuthorizationController;
use Illuminate\Http\Request;
use DB;

class TaskController extends Controller
{
    public function Task()
    {
        if(!AuthorizationController::VerifyAccount())
            return view('personal_area');

        return view('tasks', ['tasks'=>$this->GetTasks()]);
    }

    public function AddTask(Request $request)
    {
        if(!AuthorizationController::VerifyAccount())
            return null;

        DB::table('TaskS')->insert([
            'UserId' => $_SESSION['UserId'],
            'Task' => $request->input('Task'),
            'ReminderDate' => date('Y-m-d\TH:i:s', strtotime($request->input('ReminderDate'))),
        ]);

        return json_encode($this->GetTasks());
    }

    public function EditTask(Request $request)
    {
        if(!AuthorizationController::VerifyAccount())
            return null;

        DB::table('TaskS')
            ->where('Id', $request->input('Id'))
            ->update([
                'Task' => $request->input('Task'),
                'ReminderDate' => date('Y-m-d\TH:i:s', strtotime($request->input('ReminderDate'))),
            ]);

        return json_encode($this->GetTasks());
    }

    public function DeleteTask(Request $request)
    {
        if(!AuthorizationController::VerifyAccount())
            return null;

        DB::table('TaskS')
            ->where('UserId', $_SESSION['UserId'])
            ->where('Id', $request->input('Id'))
            ->delete();

        return json_encode($this->GetTasks());
    }

    private function GetTasks()
    {
        $table = DB::table('TaskS')->where('UserId', $_SESSION['UserId'])->orderBy('ReminderDate', 'asc')->get();
        return $table;
    }
}

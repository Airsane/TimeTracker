<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function export(){
        $tasks = Task::all();
        $data = [];

        foreach ($tasks as $task) {
            $data[] = [
                'description' => $task->description,
                'time_taken' => $task->time_taken,
                'date' => $task->date,
            ];
        }

        // Define the filename and storage path
        $filename = 'tasks_export_' . now()->format('Y-m-d_His') . '.json';
        $filePath = storage_path('app/public/' . $filename);

        // Save the JSON file
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

        // Ensure the file exists before downloading
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 500);
        }

        // Return file download response
        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function import(){
        // get the file from the request
        $file = request()->file('file');
        $data = json_decode(file_get_contents($file), true);

        foreach ($data as $task) {
            Task::create($task);
        }

        return redirect()->back()->with('success', 'Tasks imported successfully');
    }

}

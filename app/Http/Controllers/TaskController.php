<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        foreach ($tasks as $data) {
            $data->formattedCreatedAt = Carbon::parse($data->created_at)->format('Y-m-d'); // Cambia el formato según tus necesidades
        }
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $task = Task::create($request->only('name','description'));
        $response = "No se guardó la tarea.";
        $code = 200;
        if (isset($task)) {
            $response = "Tarea guardada con éxito.";
            $code = 201;
        }

        return response()->json(['response' => $response], $code);
    }

    public function updateTasks(Request $request)
    {
        $updateData = json_decode($request->getContent());

        if (empty($updateData)) {
            $response = "No hay datos en el request.";
        }else{
            foreach ($updateData as $data) {
                $task = Task::find($data->id);
                $task->status_id = $data->status_id;
                $task->save();
            }
            $response = "Estados actualizados.";
        }        
        return response()->json(['response' => $response], 200);
    }

    public function deleteTasks(Request $request)
    {
        $deleteData = json_decode($request->getContent());

        if (empty($deleteData)) {
            $response = "No hay datos en el request.";
        }else{
            foreach ($deleteData as $data) {
                $task = Task::find($data->id);
                $task->delete(); 
            }
            $response = "Tareas eliminadas.";
        }        
        return response()->json(['response' => $response], 200);
    }

    public function csv(){
        $tasks = Task::all();

        $csv = \League\Csv\Writer::createFromString('');
        $csv->insertOne(['Fecha(Y-M-D)', 'Nombre', 'Descripcion', 'Estado']); 

        foreach ($tasks as $data) {
            $data->formattedCreatedAt = Carbon::parse($data->created_at)->format('Y-m-d');
            $status = Status::find($data->status_id);
            $csv->insertOne([$data->formattedCreatedAt, $data->name, $data->description,$status->description]); 
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tareas.csv"',
        ];    
        return response($csv, 200, $headers);
    }
}

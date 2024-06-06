<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            DB::beginTransaction();
            $task = Task::create($request->all());
            DB::commit();
            return response()->json(["message" => "Registro creado con éxito", "data" => $task], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["message" => $th->getMessage()], 204);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $task = Task::findOrFail($id);
            $task->update($request->validated());
            DB::commit();
            return response()->json(["message" => "Registro actualizado con éxito", "data" => $task], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $task = Task::findOrFail($id);
            $task->delete();
            DB::commit();
            return response()->json(["message" => "Registro eliminado con éxito"], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }
}

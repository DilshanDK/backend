<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    // Get all tasks
    public function index()
    {
        try {
            $todos = Todo::all();

            // Ensure _id is properly formatted
            $todos = $todos->map(function($todo) {
                return [
                    '_id' => (string) $todo->_id,
                    'title' => $todo->title,
                    'description' => $todo->description,
                    'start_time' => $todo->start_time,
                    'end_time' => $todo->end_time,
                    'status' => $todo->status,
                    'created_at' => $todo->created_at,
                    'updated_at' => $todo->updated_at,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $todos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Get single task
    public function show($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => [
                    '_id' => (string) $todo->_id,
                    'title' => $todo->title,
                    'description' => $todo->description,
                    'start_time' => $todo->start_time,
                    'end_time' => $todo->end_time,
                    'status' => $todo->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found'
            ], 404);
        }
    }

    // Add new task
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date_format:Y-m-d H:i:s',
                'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
                'status' => 'required|in:pending,completed'
            ]);

            $todo = Todo::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Task created successfully',
                'data' => [
                    '_id' => (string) $todo->_id,
                    'title' => $todo->title,
                    'description' => $todo->description,
                    'start_time' => $todo->start_time,
                    'end_time' => $todo->end_time,
                    'status' => $todo->status,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Update task
    public function update(Request $request, $id)
    {
        try {
            $todo = Todo::findOrFail($id);

            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date_format:Y-m-d H:i:s',
                'end_time' => 'sometimes|date_format:Y-m-d H:i:s|after:start_time',
                'status' => 'sometimes|in:pending,completed'
            ]);

            $todo->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Task updated successfully',
                'data' => [
                    '_id' => (string) $todo->_id,
                    'title' => $todo->title,
                    'description' => $todo->description,
                    'start_time' => $todo->start_time,
                    'end_time' => $todo->end_time,
                    'status' => $todo->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Change task status
    public function changeStatus(Request $request, $id)
    {
        try {
            $todo = Todo::findOrFail($id);

            $validated = $request->validate([
                'status' => 'required|in:pending,completed'
            ]);

            $todo->update(['status' => $validated['status']]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
                'data' => [
                    '_id' => (string) $todo->_id,
                    'title' => $todo->title,
                    'status' => $todo->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Delete task
    public function destroy($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found'
            ], 404);
        }
    }
}

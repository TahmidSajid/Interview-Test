<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Response;
use App\Http\Requests\User\CompleteTaskRequest;
use App\Http\Requests\User\DeleteTaskRequest;
use App\Http\Requests\User\SearchTaskRequest;
use App\Http\Requests\User\StoreTaskRequest;
use App\Http\Requests\User\UpdateTaskRequest;
use App\Http\Resources\User\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->paginate(3);

        return Response::success('Task Fetched Successfully', [
            'task' => TaskResource::collection($tasks),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'total' => $tasks->total(),
            ],
            'links' => [
                'next' => $tasks->nextPageUrl(),
                'prev' => $tasks->previousPageUrl(),
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        try {
            Task::create([
                'user_id'     => auth()->user()->id,
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'status'      => $validated['status'],
                'due_date'    => Carbon::createFromFormat('d-m-Y', $validated['due_date'])->format('Y-m-d'),
            ]);
        } catch (Exception $e) {
            return Response::error('Something Went Wrong! Please Try Again', [], 400);
        }

        return Response::success('Task Added Successfully', [], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request)
    {
        $validated = $request->validated();

        try {
            Task::where('id', $validated['id'])->update([
                'title'       => $validated['title'],
                'description' => $validated['description'],
                'status'      => $validated['status'],
                'due_date'    => Carbon::createFromFormat('d-m-Y', $validated['due_date'])->format('Y-m-d'),
            ]);
        } catch (Exception $e) {
            return Response::error('Something Went Wrong! Please Try Again', [], 400);
        }

        return Response::success('Task Updated Successfully', [], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(DeleteTaskRequest $request)
    {
        $validated = $request->validated();

        try {
            Task::where('id', $validated['id'])->delete();
        } catch (Exception $e) {
            return Response::error('Something Went Wrong! Please Try Again', [], 400);
        }

        return Response::success('Task Deleted Successfully', [], 200);
    }


    public function complete(CompleteTaskRequest $request)
    {
        $validated = $request->validated();

        try {
            Task::where('id', $validated['id'])->update([
                'status'      => 'completed',
            ]);
        } catch (Exception $e) {
            return Response::error('Something Went Wrong! Please Try Again', [], 400);
        }

        return Response::success('Task Marked As Completed', [], 200);
    }


    public function search(SearchTaskRequest $request)
    {
        $validated = $request->validated();

        $due_date = isset($validated['due_date']) ? Carbon::createFromFormat('d-m-Y', $validated['due_date'])->format('Y-m-d') : '';

        $tasks = Task::where('user_id', auth()->user()->id)->searchTitle($validated['title'] ?? '')
            ->filterStatus($validated['status'] ?? '')
            ->filterDueDate($due_date)
            ->latest()
            ->paginate(3)
            ->withQueryString();

        return Response::success('Task Search Successful', [
            'task' => TaskResource::collection($tasks),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'total' => $tasks->total(),
            ],
            'links' => [
                'next' => $tasks->nextPageUrl(),
                'prev' => $tasks->previousPageUrl(),
            ]
        ], 200);
    }
}

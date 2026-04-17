<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Response;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->get();

        return Response::success('Task Fetched Successfully', [
            'task' => $tasks,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string',
            'description' => 'required|string',
            'status'      => 'required|' . Rule::in(['pending', 'in_progress', 'completed']),
            'due_date'    => 'nullable|date|date_format:d-m-Y|after_or_equal:today'
        ]);

        if ($validator->fails()) {
            return Response::validation($validator->errors()->all(), [], 400);
        }

        $validated = $validator->validated();

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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string|exists:tasks,id',
            'title'       => 'required|string',
            'description' => 'required|string',
            'status'      => 'required|' . Rule::in(['pending', 'in_progress', 'completed']),
            'due_date'    => 'nullable|date|date_format:d-m-Y|after_or_equal:today'
        ]);

        if ($validator->fails()) {
            return Response::validation($validator->errors()->all(), [], 400);
        }

        $validated = $validator->validated();

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
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return Response::validation($validator->errors()->all(), [], 400);
        }

        $validated = $validator->validated();

        try {
            Task::where('id', $validated['id'])->delete();
        } catch (Exception $e) {
            return Response::error('Something Went Wrong! Please Try Again', [], 400);
        }

        return Response::success('Task Deleted Successfully', [], 200);
    }


    public function complete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return Response::validation($validator->errors()->all(), [], 400);
        }

        $validated = $validator->validated();


        try {
            Task::where('id', $validated['id'])->update([
                'status'      => 'completed',
            ]);
        } catch (Exception $e) {
            return Response::error('Something Went Wrong! Please Try Again', [], 400);
        }

        return Response::success('Task Marked As Completed', [], 200);
    }


    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'nullable|string',
            'status'      => 'nullable|' . Rule::in(['pending', 'in_progress', 'completed']),
            'due_date'    => 'nullable|date|date_format:d-m-Y|after_or_equal:today'
        ]);

        if ($validator->fails()) {
            return Response::validation($validator->errors()->all(), [], 400);
        }

        $validated = $validator->validated();

        $task = Task::where('user_id', auth()->user()->id)->searchTitle($validated['title'])
            ->filterStatus($validated['status'])
            ->filterDueDate(Carbon::createFromFormat('d-m-Y', $validated['due_date'])->format('Y-m-d'))
            ->latest()
            ->get()->all();



        return Response::success('Task Search Successful', [
            'task' => $task
        ], 200);
    }
}

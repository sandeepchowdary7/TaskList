<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Task;

class TaskController extends Controller
{
	protected $tasks;
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        // $this->middleware('auth');

        $this->tasks = $tasks;
    }

	 /**
	 * Display a list of all of the user's task.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		//$tasks = Task::where('used_id', $request->user()->id)->get();
	    return view('tasks.index', [
	    	'tasks' => $this->tasks->forUser($request->user()),
	    ]);
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:255',
		]);

	$request->user()->tasks()->create([

		'name' => $request->name,

	]);
	    
	return redirect('/tasks');

	}

	public function destroy(Request $request, Task $task)
	{
		 
	$this->authorize('destroy', $task);

    $task->delete();

    return redirect('/tasks');
	}
}

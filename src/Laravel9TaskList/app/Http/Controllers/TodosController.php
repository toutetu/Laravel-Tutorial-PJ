<?php
namespace AppHttpControllers;
use AppModelsTodo;
use IlluminateHttpRequest;
use AppHttpControllersController;
use IlluminateSupportFacadesAuth;
use IlluminateSupportFacadesLog;
class TodosController extends Controller
{
  public function index(Request $request)
  {
    $todos = Todo::all();
    Log::warning('User is accessing all the Todos', ['user' => Auth::user()->id]);
    return view('dashboard')->with(['todos' => $todos]);
  }
  public function byUserId(Request $request)
  {
    $todos = Todo::where('user_id', Auth::user()->id)->get();
    Log::info('User is accessing all his todos', ['user' => Auth::user()->id]);
    return view('dashboard')->with(['todos' => $todos]);
  }
  public function show(Request $request, $id)
  {
    $todo = Todo::find($id);
    Log::info('User is accessing a single todo', ['user' => Auth::user()->id, 'todo' => $todo->id]);
    return view('show')->with(['todo' => $todo]);
  }
  public function update(Request $request, $id)
  {
    # Validations before updating
    $todo = Todo::where('user_id', Auth::user()->id)->where('id', $id)->first();
    Log::warning('Todo found for updating by user', ['user' => Auth::user()->id, 'todo' => $todo]);
    if ($todo) {
      $todo->title = $request->title;
      $todo->desc = $request->desc;
      $todo->status = $request->status == 'on' ? 1 : 0;
      if ($todo->save()) {
        Log::info('Todo updated by user successfully', ['user' => Auth::user()->id, 'todo' => $todo->id]);
        return view('show', ['todo' => $todo]);
      }
      Log::warning('Todo could not be updated caused by invalid todo data', ['user' => Auth::user()->id, 'todo' => $todo->id, 'data' => $request->except('password')]);
      return; // 422
    }
    Log::error('Todo not found by user', ['user' => Auth::user()->id, 'todo' => $id]);
    return; // 401
  }
  public function store(Request $request)
  {
    Log::warning('User is trying to create a single todo', ['user' => Auth::user()->id, 'data' => $request->except('password')]);
    # Validations before updating
    $todo = new Todo;
    $todo->title = $request->title;
    $todo->desc = $request->desc;
    $todo->user_id = Auth::user()->id;
    if ($todo->save()) {
      Log::info('User create a single todo successfully', ['user' => Auth::user()->id, 'todo' => $todo->id]);
      return view('show', ['todo' => $todo]);
    }
    Log::warning('Todo could not be created caused by invalid todo data', ['user' => Auth::user()->id, 'data' => $request->except('password')]);
    return; // 422
  }
  public function delete(Request $request, $id)
  {
    Log::warning('User is trying to delete a single todo', ['user' => Auth::user()->id, 'todo' => $id]);
    $todo = Todo::where('user_id', Auth::user()->id)->where('id', $id)->first();
    if ($todo) {
      Log::info('User deleted a single todo successfully', ['user' => Auth::user()->id, 'todo' => $id]);
      $todo->delete();
      return view('index');
    }
    Log::error('Todo not found by user for deleting', ['user' => Auth::user()->id, 'todo' => $id]);
    return; // 404
  }
}

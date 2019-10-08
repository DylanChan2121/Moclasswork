<?php
# @Date:   2019-10-01T14:11:28+01:00
# @Last modified time: 2019-10-08T15:14:25+01:00




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo; //used so app knows what to do with $todos

class TodoController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::orderBy('created_at','desc')->paginate(8);

        return view('todos.index',[
          'todos'=> $todos,//$todos is not the same as 'todos'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //validation rules
$rules = [
  'title' => 'required|string|unique:todos,title|min:2|max:191',
  'body'  => 'required|string|min:5|max:1000',
];
//custom validation error messages
$messages = [
  'title.unique' => 'Todo title should be unique', //syntax: field_name.rule
];
//First Validate the form data
$request->validate($rules,$messages);
//Create a Todo
$todo = new Todo;
$todo->title = $request->title;
$todo->body = $request->body;
$todo->save(); // save it to the database.
//Redirect to a specified route with flash message.
return redirect()
  ->route('todos.index')
  ->with('status','Created a new Todo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $todo = Todo::findOrFail($id);
      return view('todos.show',[
        'todo'=> $todo,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todos.edit',[
          'todo'=> $todo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
          'title' => "required|string|unique:todos,title,{$id}|min:2|max:191",
          'body' => "required|string|min:5|max:1000",
        ];

        $messages = [
          'title.unique' => 'todo titles should be unquie',
        ];

        $request->validate($rules,$messages);

        $todo = todo::findOrFail($id);

        $todo->title = $request->title;
        $todo->body = $request->body;

        $todo->save();

        return redirect()->route('todos.show',$id)
        ->with('status','updatedtheselectedtodo');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)//deleting
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()
        ->route('todos.index')
        ->with('status','Deleted the selected Todo!');
    }
}

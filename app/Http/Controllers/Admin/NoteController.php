<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Note;

class NoteController extends Controller
{
  public function index(Request $request)
  {
    $notes = Note::all();
    return view('admin.note.index', compact('notes'));
  }

  public function create()
  {
    return view('admin.note.create');
  }

  public function store(Request $request)
  {
    $note = new Note;
    $note->create([
      'hour' => $request->hour,
      'venue' => $request->venue,
      'company' => $request->company,
      'content' => $request->content,
    ]);
    return redirect()->route('admin.note');
  }

  public function edit($id)
  {
    $notes = Note::all();
    return view('admin.note.edit', compact('notes', 'id'));
  }

  public function update(Request $request)
  {
    $note = Note::find($request->note_id);
    $note->update([
      'hour' => $request->hour,
      'venue' => $request->venue,
      'company' => $request->company,
      'content' => $request->content,
    ]);
    return redirect()->route('admin.note');
  }


  public function destroy($id)
  {
    $note = Note::find($id);
    $note->delete();
    return redirect()->route('admin.note');
  }
}

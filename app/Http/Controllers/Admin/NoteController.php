<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Models\Note;

class NoteController extends Controller
{
  public function index(Request $request)
  {
    $date = $request->date;
    $notes = Note::where('date', $date)->get()->sortBy('sort_no')->toArray();
    return view('admin.note.index', compact('notes', 'date'));
  }

  public function create(Request $request)
  {
    $date = $request->date;
    $notes = Note::where('date', $date)->get()->toArray();
    return view('admin.note.create', compact('notes', 'date'));
  }

  public function store(Request $request): RedirectResponse
  {
    $note_count = Note::where('date', $request->date)->get()->count();
    $note_count++;
    $note = new Note;
    $note->create([
      'hour' => $request->hour,
      'venue' => $request->venue,
      'company' => $request->company,
      'content' => $request->content,
      'date' => $request->date,
      'sort_no' => $note_count,
    ]);
    return redirect()->route('admin.note', ['date' => $request->date]);
  }

  public function edit($date, $id)
  {
    dump($date, $id);
    $notes = Note::where('date', $date)->get()->toArray();
    return view('admin.note.edit', compact('notes', 'date', 'id'));
  }

  public function update(Request $request): RedirectResponse
  {
    $note = Note::find($request->note_id);
    $note->update([
      'hour' => $request->hour,
      'venue' => $request->venue,
      'company' => $request->company,
      'content' => $request->content,
    ]);
    return redirect()->route('admin.note', ['date' => $note->date]);
  }

  public function destroy($id, $date): RedirectResponse
  {
    $note = Note::find($id);
    $note->delete();
    return redirect()->route('admin.note', ['date' => $date]);
  }

  public function sortNoUpdate(Request $request)
  {
    foreach ($request->ary as $key => $value) {
      $note = Note::find($value);
      $note->update(['sort_no' => $key + 1]);
    }
  }
}

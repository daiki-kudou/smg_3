<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<section class="mt-5">
  <a href="{{url('admin/note')}}">戻る</a>

  <table class="table table-bordered" style="width:100%">
    <tbody>
      <tr>
        <td>時間</td>
        <td>会場</td>
        <td>会社名</td>
        <td>対応内容</td>
        <td>編集</td>
      </tr>
    </tbody>
    <tbody id="sortableArea" class="main_table" style="table-layout: fixed;">
      @foreach ($notes as $note)
      @if ($id==$note->id)
      {{ Form::open(['url' => 'admin/note/update', 'method' => 'post','id'=>'add_note_form']) }}
      @csrf
      <tr>
        <td>{{Form::text('hour',$note->hour)}}</td>
        <td>{{Form::text('venue',$note->venue)}}</td>
        <td>{{Form::text('company',$note->company)}}</td>
        <td>{{Form::textarea('content',$note->content)}}</td>
        <td>
          {{Form::hidden('note_id',$note->id)}}
          {{ Form::submit('更新', ['class' => 'btn']) }}
        </td>
      </tr>
      {{ Form::close() }}
      @else
      <tr>
        <td>{{$note->hour}}</td>
        <td>{{$note->venue}}</td>
        <td>{{$note->company}}</td>
        <td>{{$note->content}}</td>
        <td>
      </tr>
      @endif
      @endforeach
    </tbody>

  </table>
</section>
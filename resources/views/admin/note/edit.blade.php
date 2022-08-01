<link href="{{ asset('css/adminlte.min.css')}}" rel="stylesheet">
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<section class="mt-5 px-5">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td>時間</td>
        <td>会場</td>
        <td>会社名</td>
        <td>対応内容</td>
        <td></td>
      </tr>
    </tbody>
    <tbody class="main_table" style="table-layout: fixed;">
      @foreach ($notes as $note)
      @if ($id==$note['id'])
      {{ Form::open(['url' => '/admin/note/update', 'method' => 'post','id'=>'add_note_form','autocomplete'=>'off',]) }}
      @csrf
      <td>{{Form::text('hour',$note['hour'], ['class' => 'form-control'])}}</td>
      <td>{{Form::text('venue',$note['venue'], ['class' => 'form-control'])}}</td>
      <td>{{Form::text('company',$note['company'], ['class' => 'form-control'])}}</td>
      <td>{{Form::text('content',$note['content'], ['class' => 'form-control'])}}</td>
      <td>
        {{Form::hidden('note_id',$note['id'])}}
        {{ Form::submit('更新する', ['class' => 'btn more_btn']) }}
      </td>
      {{ Form::close() }}
      @else
      <tr>
        <td>{{$note['hour']}}</td>
        <td>{{$note['venue']}}</td>
        <td>{{$note['company']}}</td>
        <td>{{$note['content']}}</td>
        <td></td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>

  <a class="btn more_btn" href="/admin/note?date={{$date}}">戻る</a>
</section>
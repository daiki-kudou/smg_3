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
    <tbody id="sortableArea" class="main_table" style="table-layout: fixed;">
      @foreach ($notes as $note)
      <tr>
        <td>{{$note['hour']}}</td>
        <td>{{$note['venue']}}</td>
        <td>{{$note['company']}}</td>
        <td>{!!nl2br(e($note['content']))!!}</td>
        <td></td>
      </tr>
      @endforeach
      {{ Form::open(['url' => '/admin/note/store', 'method' => 'post','id'=>'add_note_form','autocomplete'=>'off',]) }}
      @csrf
      <tr>
        <td>{{Form::text('hour',null , ['class' => 'form-control'])}}</td>
        <td>{{Form::text('venue',null , ['class' => 'form-control'])}}</td>
        <td>{{Form::text('company',null , ['class' => 'form-control'])}}</td>
        <td>{{Form::textarea('content',null , ['class' => 'form-control','rows'=>3])}}</td>
        <td>
          {{Form::hidden('date',$date )}}
          {{ Form::submit('追加する', ['class' => 'btn more_btn']) }}
        </td>
      </tr>
      {{ Form::close() }}
    </tbody>
  </table>
  <a class="btn more_btn mt-3" href="/admin/note?date={{$date}}">戻る</a>
</section>
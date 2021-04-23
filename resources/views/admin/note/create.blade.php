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
    {{ Form::open(['url' => 'admin/note/store', 'method' => 'post','id'=>'add_note_form']) }}
    @csrf
    <tbody id="sortableArea" class="main_table" style="table-layout: fixed;">
      <tr>
        <td>{{Form::text('hour',null)}}</td>
        <td>{{Form::text('venue',null)}}</td>
        <td>{{Form::text('company',null)}}</td>
        <td>{{Form::textarea('content',null)}}</td>
        <td>
          {{ Form::submit('保存', ['class' => 'btn']) }}
        </td>
      </tr>
    </tbody>
    {{ Form::close() }}

  </table>
</section>
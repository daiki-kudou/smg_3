<link href="{{ asset('/css/template.css') }}" rel="stylesheet">
<script src="{{ asset('/js/template.js') }}"></script>

<section class="mt-5">
  <a href="{{url('admin/note/create')}}">メモを追加する</a>
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
      <tr>
        <td>{{$note->hour}}</td>
        <td>{{$note->venue}}</td>
        <td>{{$note->company}}</td>
        <td>{!!nl2br(e($note->content))!!}</td>
        <td>
          <a class="edit" href="{{url('admin/note/edit/'.$note->id)}}">編集</a>
          <a class="delete" href="{{url('admin/note/delete/'.$note->id)}}">削除</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</section>
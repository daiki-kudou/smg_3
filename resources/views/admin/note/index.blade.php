<link href="{{ asset('css/adminlte.min.css')}}" rel="stylesheet">
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<section class="mt-5 px-5">
  <p class="text-right"><a class="btn more_btn3" href="{{url('admin/note/create')}}">メモを追加する</a></p>
  <table class="table table-bordered mt-3">
    <tbody>
      <tr>
        <th>時間</th>
        <th>会場</th>
        <th>会社名</th>
        <th>対応内容</th>
        <th class="text-center">編集</th>
        <th class="text-center">削除</th>
      </tr>
    </tbody>
    <tbody id="sortableArea" class="main_table">
      @foreach ($notes as $note)
      <tr>
        <td>{{$note->hour}}</td>
        <td>{{$note->venue}}</td>
        <td>{{$note->company}}</td>
        <td>{!!nl2br(e($note->content))!!}</td>
        <td class="text-center">
          <a class="edit btn more_btn" href="{{url('admin/note/edit/'.$note->id)}}">編集</a>
        </td>
        <td class="text-center">
          <a class="delete btn more_btn4" href="{{url('admin/note/delete/'.$note->id)}}">削除</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script>
  $(function() {
    $('.delete').on('click', function() {
      if (!confirm('本当に削除しますか？')) {
        return false;
      }
    })
  })
  //   ドラッグアンドドロップ------------------------------------------
  $(function() {
    $("#sortableArea").sortable();
  });
</script>
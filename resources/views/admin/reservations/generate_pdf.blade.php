<!doctype html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PDF</title>
  <style>
    @font-face {
      font-family: migmix-1p-regular;
      font-style: normal;
      font-weight: normal;
      src: url('{{ storage_path('fonts/migmix-1p-regular.ttf') }}') format('truetype');
    }

    @font-face {
      font-family: migmix-1p-regular;
      font-style: bold;
      font-weight: bold;
      src: url('{{ storage_path('fonts/migmix-1p-regular.ttf') }}') format('truetype');
    }

    body {
      font-family: migmix-1p-regular;
    }
table { border-collapse: collapse; border-spacing: 0; }

caption, th, td {
  vertical-align: middle;
}

/* board css------------------------------------------------------- */

.board-box {
  margin: 50px auto;
  padding: 30px;
  border: 1px solid #eee;
  box-shadow: 0 0 10px rgba(0, 0, 0, .15);
  font-size: 15px;
  line-height: 24px;
  color: #333;

}

.board-box .board-inner {
  width: 90%;
  margin: 10% auto 0;
  line-height: inherit;
  text-align: left;
}

.board-box .date td{
  font-size: 2rem;
  /* padding-bottom: 70px; */
}

.board-box .event-name td,
.board-box .event-name2 td {
  font-size: 3.5rem;
  /* padding-bottom: 60px; */
}

.board-box .event-owner td{
  font-size: 1.5rem;
  padding-top: 30px;
  /* padding-bottom: 100px; */
}

.board-box .venue td {
  font-size: 3rem;
  text-align: right;
  /* padding-top: 45px; */
  border-top: 2px solid #ddd;
}
  </style>
</head>

<body>
  
<!-- 
<div class="wrapper">
    <h1>{{$reservation->reserve_date}}</h1>
    <h1>{{$reservation->event_start}}~{{$reservation->event_finish}}</h1>
    <h1>{{$reservation->event_name1}}</h1>
    <h1>{{$reservation->event_name2}}</h1>
    <h1>主催：{{$reservation->event_owner}}</h1>

    <h1>{{$reservation->venue->name_area}}{{$reservation->venue->name_bldg}}{{$reservation->venue->name_venue}}</h1>
  </div> -->

  <div class="board-box print_pages wrapper">
    <table cellpadding="0" cellspacing="0" class="board-inner">
      <tr class="date">
        <td>
          <h2>2021年1月26日(金)13:30～14:30</h2>
        </td>
      </tr>
      <tr class="event-name">
        <td>
          <h1>イベントの名前は16文字までです</h1>
        </td>
      </tr>
      <tr class="event-name2">
        <td>
          <h1>イベントの名前は16文字までです</h1>
        </td>
      </tr>

      <tr class="event-owner">
        <td>
          <h4>主催：ここの主催者の名前は、30文字以内です。あままままままままま</h4>
        </td>
      </tr>

      <tr class="venue">
        <td>
          <h2>サンワールドビル2号室</h2>
        </td>
      </tr>



    </table>
  </div>

</body>

</html>
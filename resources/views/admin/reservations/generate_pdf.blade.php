<!doctype html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

    html {
      box-sizing: border-box;
      -webkit-text-size-adjust: 100%;
      /* Prevent adjustments of font size after orientation changes in iOS */
      word-break: break-all;
      -moz-tab-size: 4;
      tab-size: 4;
    }

    body {
      font-family: migmix-1p-regular;
      line-height: 0;
    }

    ul {
      margin: 0;
      padding: 0;
    }

    li {
      list-style: none;
    }

    /* board css------------------------------------------------------- */
    .board-box {
      width: 100%;
      font-size: 15px;
      color: #333;
      border: 10px solid #B08046;
      padding: 40px 30px 0 30px;
    }

    .board-table {
      border-collapse: collapse; 
      width: 100%;
      table-layout: fixed;
    }

    .board-table td{
      line-height: 10px;
    }

    .board-table .date td {
      font-size: 30px;
      padding-bottom: 30px;
      height: 50px;
      /* padding-bottom: 2%; */
    }

    .board-table .event-name td,
    .board-table .event-name2 td {
      font-size: 60px;
      height: 30px;
      font-weight: bold;
      /* padding-bottom: 30px; */
    }

    .board-table .event-owner td {
      font-size: 30px;
      height: 100px;
      /* padding-top: 30px; */
      /* padding-bottom: 15%; */
    }

    .board-table .venue td {
      /* height: 100px; */
      font-size: 50px;
      text-align: right;
      padding-top: 50px;
      height: 50px;
      border-top: 2px solid #ddd;
    }

    .board-table .venue td p{
      word-break: all;
    }


  </style>

</head>

<body>
  <!-- <div class="wrapper">
    <h1>{{$reservation->reserve_date}}</h1>
    <h1>{{$reservation->event_start}}~{{$reservation->event_finish}}</h1>
    <h1>{{$reservation->event_name1}}</h1>
    <h1>{{$reservation->event_name2}}</h1>
    <h1>主催：{{$reservation->event_owner}}</h1>
    <h1>{{$reservation->venue->name_area}}{{$reservation->venue->name_bldg}}{{$reservation->venue->name_venue}}</h1>

  </div>  -->

  <div class="board-box">
    <table  class="board-table">
      <tr class="date">
        <td>
          <span>{{ReservationHelper::formatDate($reservation->reserve_date)}}
          </span>
          <span>{{$reservation->event_start}}<span>~</span>{{$reservation->event_finish}}</span>
        </td>
      </tr>
      <tr class="event-name">
        <td>
          <p>{{$reservation->event_name1}}</p>
        </td>
      </tr>
      <tr class="event-name2">
        <td>
          <p>{{$reservation->event_name2}}</p>
        </td>
      </tr>

      <tr class="event-owner">
        <td>
          <p><span>主催：</span>{{$reservation->event_owner}}</p>
        </td>
      </tr>
      <tr class="venue">
        <td>
          <p>{{$reservation->venue->name_area}}{{$reservation->venue->name_bldg}}{{$reservation->venue->name_venue}}</p>
        </td>
      </tr>
    </table>
  </div>
</body>

</html>
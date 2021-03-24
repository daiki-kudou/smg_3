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
      /* padding: 0 30px; */
    }

    .board-table {
      /* background-color: red; */
      border-collapse: collapse; 
      width: 100%;
      margin: 0 30px;
      table-layout: fixed;
    }

    .board-table td{
      /* height: 80px; */
      line-height: 50px;
      overflow-wrap : break-word;
      width: 90%;
      /* border: 1px solid #333; */
    }

    .board-table .date td {
      font-size: 30px;
      padding-bottom: 30px;
      line-height: 80px;
      /* padding-bottom: 2%; */
    }

    .board-table .event-name td,
    .board-table .event-name2 td {
      font-size: 60px;
      font-weight: bold;
      /* padding-bottom: 30px; */
    }

    .board-table .event-owner td {
      font-size: 30px;
      line-height: 70px;
      /* padding-top: 30px; */
      /* padding-bottom: 15%; */
      border-bottom: 2px solid #ddd;
    }

    .board-table .venue td {
      line-height: 15px;
      font-size: 40px;
      text-align: right;
      padding-top: 130px;
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
          {{$reservation->event_name1}}
        </td>
      </tr>
      <tr class="event-name2">
        <td>
          {{$reservation->event_name2}}
        </td>
      </tr>
      <tr class="event-owner">
        <td>
          主催：{{$reservation->event_owner}}
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
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
      /* line-height: 0.3; */
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
      padding: 30px 30px 0 30px;
    }

    .board-box .date td {
      font-size: 30px;
      /* padding-bottom: 2%; */
    }

    .board-box .event-name td,
    .board-box .event-name2 td {
      font-size: 60px;
      /* padding-bottom: 30px; */
    }

    .board-box .event-owner td {
      font-size: 30px;
      /* padding-top: 30px; */
      /* padding-bottom: 15%; */
    }

    .board-box .venue td {
      font-size: 50px;
      text-align: right;
      /* padding-top: 5%; */
      /* padding-bottom: 2%; */
      border-top: 2px solid #ddd;
    }

    .board-inner li {
      /* height: 30px; */
      /* margin-bottom: 20px; */
      line-height: 25px;
    }

    .date  {
      margin-bottom: 25px;
    }

    .date span {
      font-size: 30px;
    }

    .event-name p,
    .event-name2 p {
      font-size: 60px;
    }
    .event-name2 p {
      margin-top: -20px;
    }

    .event-owner {
      margin-top: 25px;
    }

    .event-owner p {
      font-size: 35px;
    }

    .event-owner p::after {
      content: "";
      display: block;
      width: 100%;
      height: 1px;
      color: #ddd;
    }

    .venue {
      margin-top: 48px;
    }

    .venue p {
      font-size: 50px;
      text-align: right;
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
 
  <!-- <div class="board-box">
    <table  class="board-inner">
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
  </div> -->

  <div class="board-box">
    <ul class="board-inner">
      <li class="date">
        <span>{{ReservationHelper::formatDate($reservation->reserve_date)}}
        </span>
        <span>{{$reservation->event_start}}<span>~</span>{{$reservation->event_finish}}</span>
      </li>
      <li class="event-name">
        <p>{{$reservation->event_name1}}</p>
      </li>
      <li class="event-name2">
        <p>{{$reservation->event_name2}}</p>
      </li>

      <li class="event-owner">
        <p><span>主催：</span>{{$reservation->event_owner}}</p>
        <hr class="border_line">
      </li>
      <li class="venue">
        <p>{{$reservation->venue->name_area}}{{$reservation->venue->name_bldg}}{{$reservation->venue->name_venue}}</p>
      </li>
    </ul>
  </div>



</body>

</html>
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

    p {
      margin: 0;
      padding: 0;
    }

    /* board css------------------------------------------------------- */
    .board-box {
      /* width: 100%; */
      /* /* width: 297px; */
      /* height: 210px; */
      /* margin: 50px auto; */
      padding: 10px;
      /* border: 1px solid #eee; */
      /* box-shadow: 0 0 10px rgba(0, 0, 0, .15); */
      font-size: 15px;
      /* line-height: 24px; */
      color: #333;
      border: 10px solid #B08046;
      /* background: no-repeat center/98% url(data:image/png;base64,); */
    }

    .board-box .board-inner {
      width: 95%;
      margin: 0 auto;
      /* line-height: inherit; */
      text-align: left;
    }

    .board-box .date td {
      font-size: 30px;
      padding-bottom: 2%;
    }

    .board-box .event-name td,
    .board-box .event-name2 td {
      font-size: 60px;
      /* padding-bottom: 30px; */
    }

    .board-box .event-owner td {
      font-size: 30px;
      /* padding-top: 30px; */
      padding-bottom: 15%;
    }

    .board-box .venue td {
      font-size: 50px;
      text-align: right;
      padding-top: 5%;
      padding-bottom: 2%;
      border-top: 2px solid #ddd;
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
    <table cellpadding="0" cellspacing="0" class="board-inner">
      <tr class="date">
        <td>
          <span>{{$reservation->reserve_date}}</span>
          <span>{{$reservation->event_start}}<span>~</span>{{$reservation->event_finish}}</span>
        </td>
      </tr>
      <tr class="event-name">
        <td>
          <!-- <p>イベントの名前は16文字までです</p> -->
          <p>{{$reservation->event_name1}}</p>
        </td>
      </tr>
      <tr class="event-name2">
        <td>
          <!-- <p>イベントの名前は16文字までです</p> -->
          <p>{{$reservation->event_name2}}</p>
        </td>
      </tr>

      <tr class="event-owner">
        <td>
          <!-- <p>主催：ここの主催者の名前は、30文字以内です。あままままままままま</p> -->
          <p><span>主催：</span>{{$reservation->event_owner}}</p>
        </td>
      </tr>

      <tr class="venue">
        <td>
          <!-- <p>サンワールドビル2号室</p> -->
          <p>{{$reservation->venue->name_area}}{{$reservation->venue->name_bldg}}{{$reservation->venue->name_venue}}</p>
        </td>
      </tr>
    </table>
  </div>

</body>

</html>
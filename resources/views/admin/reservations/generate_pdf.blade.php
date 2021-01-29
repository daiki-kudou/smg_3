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

    p{
      margin: 0;
      padding:0;
    }

    /* board css------------------------------------------------------- */
.board-box {
  /* width: 100%; */
  /* /* width: 297px; */
  /* height: 210px; */ 
  /* margin: 50px auto; */
  /* padding: 30px; */
  /* border: 1px solid #eee; */
  /* box-shadow: 0 0 10px rgba(0, 0, 0, .15); */
  font-size: 15px;
  /* line-height: 24px; */
  color: #333;
  /* background: no-repeat center/98% url(data:image/png;base64,); */
  

}

.board-box .board-inner {
  width: 95%;
  margin: 0 auto;
  /* line-height: inherit; */
  text-align: left;
}

.board-box .date td{
  font-size: 30px;
  padding-bottom: 2%;
}

.board-box .event-name td,
.board-box .event-name2 td {
  font-size: 60px;
  /* padding-bottom: 30px; */
}

.board-box .event-owner td{
  font-size: 30px;
  padding-top: 30px;
  padding-bottom: 15%;
}

.board-box .venue td {
  font-size: 50px;
  text-align: right;
  padding-top: 2%;
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

  </div> -->
  <img src="data:image/png;base64,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
AJCOSAUAIB2RCgBAOiIVAIB0RCoAAOmIVAAA0hGpAACkI1IBAEhHpAIAkI5IBQAg
HZEKAEA6IhUAgHREKgAA6YhUAADSEakAAKQjUgEASEekAgCQjkgFACAdkQoAQDoi
FQCAdEQqAADpiFQAANIRqQAApCNSAQBIR6QCAJCOSAUAIB2RCgBAOiIVAIB0RCoA
AOmIVAAA0hGpAACkI1IBAEhHpAIAkI5IBQAgHZEKAEA6IhUAgHREKgAA6YhUAADS
EakAAKQjUgEASEekAgCQjkgFACAdkQoAQDoiFQCAdEQqAADpiFQAANIRqQAApCNS
AQBIR6QCAJCOSAUAIB2RCgBAOiIVAIB0RCoAAOmIVAAA0hGpAACkI1IBAEhHpAIA
kI5IBQAgHZEKAEA6IhUAgHREKgAA6YhUAADSEakAAKQjUgEASEekAgCQjkgFACAd
kQoAQDoiFQCAdEQqAADpiFQAANIRqQAApCNSAQBIR6QCAJCOSAUAIB2RCgBAOiIV
AIB0RCoAAOmIVAAA0hGpAACkI1IBAEhHpAIAkI5IBQAgHZEKAEA6IhUAgHREKgAA
6YhUAADSEakAAKQjUgEASEekAgCQjkgFACAdkQoAQDoiFQCAdEQqAADpiFQAANIR
qQAApCNSAQBIR6QCAJCOSAUAIB2RCgBAOiIVAIB0RCoAAOmIVAAA0hGpAACkI1IB
AEhHpAIAkI5IBQAgHZEKAEA6IhUAgHREKgAA6YhUAADSEakAAKQjUgEASEekAgCQ
jkgFACAdkQoAQDoiFQCAdEQqAADpiFQAANIRqQAApCNSAQBIR6QCAJCOSAUAIB2R
CgBAOiIVAIB0RCoAAOmIVAAA0hGpAACkI1IBAEhHpAIAkI5IBQAgHZEKAEA6IhUA
gHREKgAA6YhUAADSEakAAKQjUgEASEekAgCQjkgFACAdkQoAQDoiFQCAdEQqAADp
iFQAANIRqQAApCNSAQBIR6QCAJCOSAUAIB2RCgBAOiIVAIB0RCoAAOmIVAAA0hGp
AACkI1IBAEhHpAIAkI5IBQAgHZEKAEA6IhUAgHREKgAA6YhUAADSEakAAKQjUgEA
SEekAgCQjkgFACAdkQoAQDoiFQCAdEQqAADpiFQAANIRqQAApCNSAQBIR6QCAJCO
SAUAIB2RCgBAOiIVAIB0RCoAAOmIVAAA0hGpAACkI1IBAEhHpAIAkI5IBQAgHZEK
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
P1GMV5aDfHkuAAAAAElFTkSuQmCC" alt="">

  <div class="board-box">
    <table cellpadding="0" cellspacing="0" class="board-inner">
      <tr class="date">
        <td>
          <p>2021年1月26日(金)13:30～14:30</p>
        </td>
      </tr>
      <tr class="event-name">
        <td>
          <p>イベントの名前は16文字までです</p>
        </td>
      </tr>
      <tr class="event-name2">
        <td>
          <p>イベントの名前は16文字までです</p>
        </td>
      </tr>

      <tr class="event-owner">
        <td>
          <p>主催：ここの主催者の名前は、30文字以内です。あままままままままま</p>
        </td>
      </tr>

      <tr class="venue">
        <td>
          <p>サンワールドビル2号室</p>
        </td>
      </tr>
    </table>
  </div>
</body>

</html>
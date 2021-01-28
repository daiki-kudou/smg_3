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

    /* common css */

img {
  max-width: 100%;
  vertical-align: bottom;
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
  display: flex;
  padding-bottom: 70px;
}

.board-box .event-name td,
.board-box .event-name2 td {
  font-size: 3.5rem;
  padding-bottom: 60px;
}

.board-box .event-owner td{
  font-size: 1.5rem;
  display: flex;
  padding-top: 30px;
  padding-bottom: 100px;
}

.board-box .venue td {
  font-size: 3rem;
  text-align: right;
  padding-top: 45px;
  border-top: 2px solid #ddd;
}

   

  </style>
</head>

<body>

  <div class="board-box print_pages wrapper">
    <table cellpadding="0" cellspacing="0" class="board-inner">
      <tr class="date">
        <td>
          <p>2021年1月26日(金)</p>
          <p>13:30～14:30</p>
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
          <p>主催：</p>
          <p>ここの主催者の名前は、30文字以内です。あままままままままま</p>
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
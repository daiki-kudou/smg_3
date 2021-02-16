@extends('layouts.admin.app')

@section('content')
{{-- @include('layouts.admin.side') test--}}



<h1>ダッシュボード</h1>


<div class="container">
  <div class="row">
    <div class="col-sm">
      <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-7">
              <div>
                <h3 class="display-4"><strong>25</strong></h3>
              </div>
              <div>予約数</div>
            </div>
            <div class="col-sm-5"><i class="fas fa-shopping-bag fa-5x"></i></div>
          </div>
        </div>
      </div>
      <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-7">
              <div>
                <h3 class="display-4"><strong>25</strong></h3>
              </div>
              <div>本日の予約件数</div>
            </div>
            <div class="col-sm-5"><i class="far fa-calendar-alt fa-5x"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-7">
              <div>
                <h3 class="display-4"><strong>25</strong></h3>
              </div>
              <div>会員数</div>
            </div>
            <div class="col-sm-5"><i class="fas fa-user-check fa-5x fa-fw"></i></div>
          </div>
        </div>
      </div>
      <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-7">
              <div>
                <h3 class="display-4"><strong>25</strong></h3>
              </div>
              <div style="font-size: 14px;">入金期限間近の予約</div>
            </div>
            <div class="col-sm-5"><i class="far fa-calendar-alt fa-5x"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm">
      <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-7">
              <div>
                <h3 class="display-4"><strong>{{$venues}}</strong></h3>
              </div>
              <div>会場数</div>
            </div>
            <div class="col-sm-5"><i class="fas fa-building fa-5x"></i></div>
          </div>
        </div>
      </div>
      <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-7">
              <div>
                <h3 class="display-4"><strong>25</strong></h3>
              </div>
              <div>明日の予約件数</div>
            </div>
            <div class="col-sm-5"><i class="far fa-calendar-alt fa-5x"></i></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@extends('layouts.user.app')
@section('content')
<link href="{{ asset('/css/template.css') }}" rel="stylesheet">

<section class="container-field mt-5">
          <!-- 利用が完了していない予約がある場合 -->
          <div class="attention-box">
            <p class="text-center"><i class="fas alert-icon fa-exclamation-triangle"></i></p>
            <div class="text-center mt-3">
            <!-- <p class="section-ttl">利用が完了していない予約があります。</p> -->
            <p class="text-center">
            利用やお支払いが完了していない予約があるため、退会手続きを進めることができません。
            </p>
        </div>
          </div>
</section>
@endsection
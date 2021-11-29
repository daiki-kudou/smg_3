@if (Auth::user()->id===8)

<style>
  .sidebar a {
    color: white !important;
  }

  .nav-treeview>.nav-item>.nav-link.active {
    background-color: #999999 !important;
  }
</style>
@endif

<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      @if (Auth::user()->id!==8)　{{--提携会場用の制御 --}}
      <li class="nav-item has-treeview" id="pre_reservation_side_bar_parent">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-atom"></i>
          <p>仮押え<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{url('/admin/pre_reservations')}}" class="nav-link pre-reservations-index"
              id="pre_reservation_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>仮押え一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/multiples')}}" class="nav-link multiples-index" id="multiple_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一括仮押え一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/pre_reservations/create')}}" class="nav-link pre-reservations-create"
              id="pre_reservation_create_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/pre_agent_reservations/create')}}" class="nav-link pre-agent-reservations-create"
              id="pre_agent_reservation_create_side_bar_child">
              <div class="d-flex align-items-center">
                <i class="far fa-circle nav-icon ml-4"></i>
                <p>新規登録<br>(仲介会社経由)</p>
              </div>
            </a>
          </li>
        </ul>
      </li>
      @endif

      <li class="nav-item has-treeview" id="reservation_side_bar_parent">
        <a href=" #" class="nav-link">
          <i class="nav-icon fas fa-book-open"></i>
          <p>予約<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('/admin/reservations') }}" class="nav-link reservations-index"
              id="reservation_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/reservations/create') }}" class="nav-link reservations-create"
              id="reservation_create_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/agents_reservations/create') }}" class="nav-link agents-reservations-create"
              id="agent_reservation_create_side_bar_child">
              <div class="d-flex align-items-center">
                <i class="far fa-circle nav-icon ml-4"></i>
                <p>新規登録<br>(仲介会社経由)</p>
              </div>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview" id="calendar_side_bar_parent">
        <a href=" #" class="nav-link">
          <i class="nav-icon fas fa-calendar-week"></i>
          <p>予約状況カレンダー<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{url('/admin/calendar/date_calendar')}}" class="nav-link date_calendar"
              id="date_calendar_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>利用日時</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/calendar/venue_calendar')}}" class="nav-link venue_calendar"
              id="venue_calendar_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場別</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview" id="user_side_bar_parent">
        <a href="#" class="nav-link ">
          <i class="nav-icon fas fa-tasks"></i>
          <p>顧客管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('/admin/clients') }}" class="nav-link" id="user_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/clients/create') }}" class="nav-link" id="user_create_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview" id="venue_side_bar_parent">
        <a href=" #" class="nav-link venues">
          <i class="nav-icon fas fa-map-marker-alt"></i>
          <p>会場管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('/admin/venues') }}" class="nav-link" id="venue_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/venues/create') }}" class="nav-link" id="venue_create_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/frame_prices') }}" class="nav-link" id="frame_price_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場料金管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/dates') }}" class="nav-link" id="dates_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場営業時間管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/equipments') }}" class="nav-link" id="equipment_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>有料備品管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/services') }}" class="nav-link" id="service_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>有料サービス管理</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item" id="sales_side_bar_parent">
        <a href="{{url('/admin/sales')}}" class="nav-link">
          <i class="nav-icon fas fa-yen-sign"></i>
          <p>売上一覧</p>
        </a>
      </li>

      <li class="nav-item has-treeview" id="agent_side_bar_parent">
        <a href=" #" class="nav-link">
          <i class="nav-icon fas fa-building"></i>
          <p>仲介会社<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('/admin/agents') }}" class="nav-link" id="agents_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/admin/agents/create') }}" class="nav-link" id="agents_create_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview" id="mails_side_bar_parent">
        <a href="" class="nav-link">
          <i class="nav-icon fas fa-mail-bulk"></i>
          <p>メールテンプレート管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('/admin/mail_templates') }}" class="nav-link mail_templates" id="mails_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
        </ul>
        {{-- <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/cron_templates') }}" class="nav-link mail_templates" id="mails_side_bar_child2">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧（定期実行）</p>
            </a>
          </li>
        </ul> --}}
      </li>

      <li class="nav-item has-treeview" id="admin_side_bar_parent">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-shield"></i>
          <p>管理者管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{url('/admin/administer')}}" class="nav-link" id="admin_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/administer/create')}}" class="nav-link" id="admin_create_side_bar_child">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a class="nav-link" id="sync_btn">
          <i class="nav-icon fab fa-fedora"></i>
          <p>MovableTypeを同期する</p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

{{Form::open(['url' => '/admin/sync', 'method' => 'post', 'id'=>'sync'])}}
@csrf
{{Form::close()}}

<script>
  $("#sync_btn").on('click', function () {
    if (confirm("現在のMT環境をシステムと同期しますか？")) {
      $('#sync').submit();
    }
  })
</script>
<div class="sidebar">

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview 
        {{ReservationHelper::getController(Route::currentRouteName(),"admin","pre_reservations")}}
        {{ReservationHelper::getController(Route::currentRouteName(),"admin","multiples")}}
        {{ReservationHelper::getController(Route::currentRouteName(),"admin","pre_agent_reservations")}}
        ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-atom"></i>
          <p>仮押え<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{url('admin/pre_reservations')}}" class="nav-link pre-reservations-index
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_reservations.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_reservations.show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_reservations.edit')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_reservations.re_calculate')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>仮押え一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/multiples')}}" class="nav-link multiples-index
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.multiples.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.multiples.show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.multiples.switch')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.multiples.edit')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.multiples.edit_calculate')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.multiples.agent_show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.multiples.agent_edit')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一括仮押え一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/pre_reservations/create')}}" class="nav-link pre-reservations-create
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_reservations.create')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_reservations.check')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_reservations.calculate')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/pre_agent_reservations/create')}}" class="nav-link pre-agent-reservations-create
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_agent_reservations.create')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_agent_reservations.check')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.pre_agent_reservations.calculate')}}
            ">
              <div class="d-flex align-items-center">
                <i class="far fa-circle nav-icon ml-4"></i>
                <p>新規登録<br>(仲介会社経由)</p>
              </div>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview 
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","reservations")}}
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","agents_reservations")}}
      ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book-open"></i>
          <p>予約<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/reservations') }}" class="nav-link reservations-index
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.edit')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.edit_calculate')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.edit_check')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/reservations/create') }}" class="nav-link reservations-create
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.create')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.calculate')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.reservations.check')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/agents_reservations/create') }}" class="nav-link agents-reservations-create
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.agents_reservations.create')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.agents_reservations.calculate')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.agents_reservations.check')}}
            ">
              <div class="d-flex align-items-center">
                <i class="far fa-circle nav-icon ml-4"></i>
                <p>新規登録<br>(仲介会社経由)</p>
              </div>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-calendar-week"></i>
          <p>予約状況カレンダー<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{url('admin/calendar/date_calendar')}}" class="nav-link date_calendar">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>利用日時</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/calendar/venue_calendar')}}" class="nav-link venue_calendar">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場別</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","clients")}}">
        <a href="#" class="nav-link ">
          <i class="nav-icon fas fa-tasks"></i>
          <p>顧客管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/clients') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.clients.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.clients.show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.clients.edit')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/clients/create') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.clients.create')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item has-treeview 
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","venues")}}
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","equipments")}}
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","services")}}
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","dates")}}
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","frame_prices")}}
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","time_prices")}}
      ">
        <a href="#" class="nav-link venues">
          <i class="nav-icon fas fa-map-marker-alt"></i>
          <p>会場管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/venues') }}" class="nav-link 
              {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.venues.index')}}
              {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.venues.show')}}
              {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.venues.edit')}}
              ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/venues/create') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.venues.create')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場新規登録</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/frame_prices') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.frame_prices.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.frame_prices.show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.frame_prices.edit')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.time_prices.edit')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場料金管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/dates') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.dates.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.dates.show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.dates.create')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>会場営業時間管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/equipments') }}" class="nav-link
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.equipments.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.equipments.edit')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.equipments.create')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>有料備品管理</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/services') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.services.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.services.edit')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.services.create')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>有料サービス管理</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-yen-sign"></i>
          <p>売上請求情報<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>########</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview
      {{ReservationHelper::getController(Route::currentRouteName(),"admin","agents")}}
      ">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-building"></i>
          <p>仲介会社<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/agents') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.agents.index')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.agents.show')}}
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.agents.edit')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/agents/create') }}" class="nav-link 
            {{ReservationHelper::getRoute(Route::currentRouteName(),'admin.agents.create')}}
            ">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="" class="nav-link">
          <i class="nav-icon fas fa-mail-bulk"></i>
          <p>メールテンプレート管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ url('admin/mail_templates') }}" class="nav-link mail_templates">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li> --}}
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-user-shield"></i>
          <p>管理者管理<i class="right fas fa-angle-left"></i></p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>一覧</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon ml-4"></i>
              <p>新規登録</p>
            </a>
          </li>
        </ul>
      </li>



    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<script>
  $(function() {
    // こちらを参考
    // https://designsupply-web.com/media/knowledgeside/1592/
    // function link_check(link, classes) {
    //   var path = location.pathname;
    //   // console.log(path);
    //   if (path == link) {
    //     var target = $("." + classes);
    //     $(target).addClass('active');
    //     $(target).parent().parent().parent().addClass('menu-open');
    //   }
    // }
    // function get_show(link,classes){
    //   var path = location.pathname;
    //   var result=path.replace(link,'');
    //   if (result.match(/^\d+$/)) {
    //     var target = $("." + classes);
    //     $(target).addClass('active');
    //     $(target).parent().parent().parent().addClass('menu-open');
    //   }
    // }



    // function explodeLink(tarArray, resultNum, tarClass){
    //   var path = location.pathname;
    //   var result = path.split('/');
    //   var cnt=0;
    //   $.each(tarArray, function(key, value){
    //     $.each(result, function(key2, value2){
    //     if(value === value2){
    //         cnt++;
    //     }
    //     });
    //   });
    //   console.log(cnt,resultNum);
    //   if (cnt==resultNum) {
    //     var target = $("." + tarClass);
    //     $(target).addClass('active');
    //     $(target).parent().parent().parent().addClass('menu-open');
    //     console.log("あってる");
    //   }
    // }

    // explodeLink(["admin","venues"],2,'venues-index');
    // explodeLink(["admin","venues","create"],3,'venues-create');


    // link_check('/admin/venues', 'venues-index');
    // get_show('/admin/venues/', 'venues-index');


    // link_check('/admin/venues/create', 'venues-create');
    // link_check('/admin/equipments', 'venues-equipments');
    // link_check('/admin/services', 'venues-services');
    // link_check('/admin/dates', 'venues-dates');
    // link_check('/admin/frame_prices', 'venues-price');
    // link_check('/admin/agents', 'agent-index');
    // link_check('/admin/agents/create', 'agent-create');
    // link_check('/admin/clients', 'clients-index');
    // link_check('/admin/clients/create', 'clients-create');

    // link_check('/admin/reservations', 'reservations-index');
    // link_check('/admin/reservations/create', 'reservations-create');
    // link_check('/admin/calendar/venue_calendar', 'venue_calendar');
    // link_check('/admin/calendar/date_calendar', 'date_calendar');

    // link_check('/admin/agents_reservations/create', 'agents-reservations-create');
    // link_check('/admin/pre_reservations', 'pre-reservations-index');
    // link_check('/admin/pre_reservations/create', 'pre-reservations-create');
    // link_check('/admin/pre_agent_reservations/create', 'pre-agent-reservations-create');

    // link_check('/admin/multiples', 'multiples-index');
    // link_check('/admin/mail_templates', 'mail_templates');

  });
</script>
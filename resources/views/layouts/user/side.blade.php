<script>
  $(function() {
    // こちらを参考
    // https://designsupply-web.com/media/knowledgeside/1592/
    function link_check(link, classes) {
      var path = location.pathname
      if (path == link) {
        var target = $("." + classes);
        $(target).addClass('active');
        $(target).parent().parent().parent().addClass('menu-open');
      }
    }
    link_check('/user/home', 'user_home');
    link_check('/user/pre_reservations', 'user_pre_reservations');
  });
</script>

<div class="sidebar">
  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview">
        <a href="{{url('/user/home')}}" class="nav-link user_home">
          <i class="nav-icon fas fa-book-open" style=""></i>
          <p>予約一覧</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="{{url('/user/pre_reservations')}}" class="nav-link user_pre_reservations">
          <i class="nav-icon fas fa-book-open" style=""></i>
          <p>仮押え一覧</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="{{route('user.home.user_info')}}" class="nav-link ">
          <i class="nav-icon fas fa-user-shield" style=""></i>
          <p>会員情報</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="{{url('/')}}" target="_blank" class="nav-link venues">
          <i class="nav-icon fas fa-link" style=""></i>
          <p>予約する</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="https://system.osaka-conference.com/cancelpolicy/" class="nav-link" target="_blank" rel="noopener">
          <i class="nav-icon fas fa-clipboard-list" style=""></i>
          <p>変更キャンセルについて</p>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.sidebar-menu -->

</div>
<!-- /.sidebar -->
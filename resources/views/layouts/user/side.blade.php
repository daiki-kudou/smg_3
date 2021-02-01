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
    link_check('/admin/venues', 'venues-index');
    link_check('/admin/venues/create', 'venues-create');
    link_check('/admin/equipments', 'venues-equipments');
    link_check('/admin/services', 'venues-services');
    link_check('/admin/dates', 'venues-dates');
    link_check('/admin/frame_prices', 'venues-price');
    link_check('/admin/agents', 'agent-index');
    link_check('/admin/agents/create', 'agent-create');
    link_check('/admin/clients', 'clients-index');
    link_check('/admin/clients/create', 'clients-create');

    link_check('/admin/reservations', 'reservations-index');
    link_check('/admin/reservations/create', 'reservations-create');
  });
</script>

<div class="sidebar">

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book-open" style=""></i>
          <p>予約一覧</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book-open" style=""></i>
          <p>仮抑え一覧</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link ">
          <i class="nav-icon fas fa-user-shield" style=""></i>
          <p>登録情報</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link venues">
          <i class="nav-icon fas fa-link" style=""></i>
          <p>予約する</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-clipboard-list" style=""></i>
          <p>変更キャンセルについて</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-sign-out-alt" style=""></i>
          <p>退会</p>
        </a>
      </li>









    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
$(function () {
  var fix_current_route = (currentRouteName.split('.'));
  fix_current_route.pop();
  fix_current_route_parent = fix_current_route.join('.');
  side_bar_parent(fix_current_route_parent);
  console.log(currentRouteName);
  side_bar_child(currentRouteName);

  function side_bar_parent(fix_current_route_parent) {
    switch (fix_current_route_parent) {
      //仮押さえ
      case "admin.pre_reservations":
        $('#pre_reservation_side_bar_parent').addClass('menu-open')
        break;
      case "admin.pre_agent_reservations":
        $('#pre_reservation_side_bar_parent').addClass('menu-open')
        break;
      case "admin.multiples":
        $('#pre_reservation_side_bar_parent').addClass('menu-open')
        break;
      //予約
      case "admin.reservations":
        $('#reservation_side_bar_parent').addClass('menu-open')
        break;
      case "admin.agents_reservations":
        $('#reservation_side_bar_parent').addClass('menu-open')
        break;
      // カレンダー
      case "admin.calendar":
        $('#calendar_side_bar_parent').addClass('menu-open')
        break;
      // 顧客管理
      case "admin.clients":
        $('#user_side_bar_parent').addClass('menu-open')
        break;
      // 会場管理
      case "admin.venues":
        $('#venue_side_bar_parent').addClass('menu-open')
        break;
      case "admin.frame_prices":
        $('#venue_side_bar_parent').addClass('menu-open')
        break;
      case "admin.time_prices":
        $('#venue_side_bar_parent').addClass('menu-open')
        break;
      case "admin.dates":
        $('#venue_side_bar_parent').addClass('menu-open')
        break;
      case "admin.equipments":
        $('#venue_side_bar_parent').addClass('menu-open')
        break;
      case "admin.services":
        $('#venue_side_bar_parent').addClass('menu-open')
        break;
      // 売上請求一覧
      case "admin.sales":
        $('#sales_side_bar_parent').addClass('menu-open')
        break;
      // 仲介会社
      case "admin.agents":
        $('#agent_side_bar_parent').addClass('menu-open')
        break;
      // メール一覧
      case "admin.mail_templates":
        $('#mails_side_bar_parent').addClass('menu-open')
        break;
      // 管理者管理
      case "admin.administer":
        $('#admin_side_bar_parent').addClass('menu-open')
        break;
      default:
        break;
    }
  }

  function side_bar_child(currentRouteName) {
    switch (currentRouteName) {
      // 仮押さえ
      case "admin.pre_reservations.index":
        $('#pre_reservation_side_bar_child').addClass('active');
        break;
      case "admin.pre_reservations.create":
        $('#pre_reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.pre_reservations.calculate":
        $('#pre_reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.pre_reservations.check":
        $('#pre_reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.pre_reservations.show":
        $('#pre_reservation_side_bar_child').addClass('active');
        break;
      case "admin.pre_reservations.edit":
        $('#pre_reservation_side_bar_child').addClass('active');
        break;
      case "admin.pre_reservations.re_calculate":
        $('#pre_reservation_side_bar_child').addClass('active');
        break;
      case "admin.pre_agent_reservations.create":
        $('#pre_agent_reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.pre_agent_reservations.check":
        $('#pre_agent_reservation_create_side_bar_child').addClass('active');
        break;
        // 一括仮押さえ
        case "admin.multiples.index":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.show":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.switch":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.edit":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.edit_calculate":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.add_venue":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.agent_show":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.agent_switch":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.agent_add_venues":
          $('#multiple_side_bar_child').addClass('active');
          break;
        case "admin.multiples.agent_edit":
          $('#multiple_side_bar_child').addClass('active');
          break;

      default:
        break;
    }
  }
})
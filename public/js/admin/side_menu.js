$(function () {
  var fix_current_route = (currentRouteName.split('.'));
  fix_current_route.pop();
  fix_current_route_parent = fix_current_route.join('.');
  side_bar_parent(fix_current_route_parent);
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
      // 予約
      case "admin.reservations.index":
        $('#reservation_side_bar_child').addClass('active');
        break;
      case "admin.reservations.create":
        $('#reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.reservations.calculate":
        $('#reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.reservations.check":
        $('#reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.reservations.edit_check":
        $('#reservation_side_bar_child').addClass('active');
        break;
      case "admin.reservations.show":
        $('#reservation_side_bar_child').addClass('active');
        break;
      case "admin.reservations.edit":
        $('#reservation_side_bar_child').addClass('active');
        break;
      case "admin.reservations.re_calculate":
        $('#reservation_side_bar_child').addClass('active');
        break;
      case "admin.agents_reservations.create":
        $('#agent_reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.agents_reservations.calculate":
        $('#agent_reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.agents_reservations.check":
        $('#agent_reservation_create_side_bar_child').addClass('active');
        break;
      case "admin.agents_reservations.edit":
        $('#reservation_side_bar_child').addClass('active');
        break;
      case "admin.agents_reservations.edit_check":
        $('#reservation_side_bar_child').addClass('active');
        break;
      // 予約状況カレンダー
      case "admin.calendar.date_calendar":
        $('#date_calendar_side_bar_child').addClass('active');
        break;
      case "admin.calendar.venue_calendar":
        $('#venue_calendar_side_bar_child').addClass('active');
        break;
      // 顧客管理 一覧
      case "admin.clients.index":
        $('#user_side_bar_child').addClass('active');
        break;
      case "admin.clients.show":
        $('#user_side_bar_child').addClass('active');
        break;
      case "admin.clients.edit":
        $('#user_side_bar_child').addClass('active');
        break;
      case "admin.clients.create":
        $('#user_create_side_bar_child').addClass('active');
        break;
      // 仲介会社 一覧
      case "admin.agents.index":
        $('#agents_side_bar_child').addClass('active');
        break;
      case "admin.agents.show":
        $('#agents_side_bar_child').addClass('active');
        break;
      case "admin.agents.edit":
        $('#agents_side_bar_child').addClass('active');
        break;
      case "admin.agents.create":
        $('#agents_create_side_bar_child').addClass('active');
        break;
      // 会場
      case "admin.venues.index":
        $('#venue_side_bar_child').addClass('active');
        break;
      case "admin.venues.show":
        $('#venue_side_bar_child').addClass('active');
        break;
      case "admin.venues.edit":
        $('#venue_side_bar_child').addClass('active');
        break;
      case "admin.venues.create":
        $('#venue_create_side_bar_child').addClass('active');
        break;
      case "admin.frame_prices.index":
        $('#frame_price_side_bar_child').addClass('active');
        break;
      case "admin.frame_prices.show":
        $('#frame_price_side_bar_child').addClass('active');
        break;
      case "admin.frame_prices.create":
        $('#frame_price_side_bar_child').addClass('active');
        break;
      case "admin.frame_prices.edit":
        $('#frame_price_side_bar_child').addClass('active');
        break;
      case "admin.time_prices.create":
        $('#frame_price_side_bar_child').addClass('active');
        break;
      case "admin.time_prices.edit":
        $('#frame_price_side_bar_child').addClass('active');
        break;
      case "admin.dates.index":
        $('#dates_side_bar_child').addClass('active');
        break;
      case "admin.dates.index":
        $('#dates_side_bar_child').addClass('active');
        break;
      case "admin.dates.show":
        $('#dates_side_bar_child').addClass('active');
        break;
      case "admin.dates.create":
        $('#dates_side_bar_child').addClass('active');
        break;
      // 有料備品
      case "admin.equipments.index":
        $('#equipment_side_bar_child').addClass('active');
        break;
      case "admin.equipments.create":
        $('#equipment_side_bar_child').addClass('active');
        break;
      case "admin.equipments.edit":
        $('#equipment_side_bar_child').addClass('active');
        break;
      // 有料サービス
      case "admin.services.index":
        $('#service_side_bar_child').addClass('active');
        break;
      case "admin.services.create":
        $('#service_side_bar_child').addClass('active');
        break;
      case "admin.services.edit":
        $('#service_side_bar_child').addClass('active');
        break;
      // メールテンプレート
      case "admin.mail_templates.mail_templates":
        $('#mails_side_bar_child').addClass('active');
        break;
      case "admin.mail_templates.cron_templates":
        $('#mails_side_bar_child2').addClass('active');
        break;
      // 管理者
      case "admin.administer.index":
        $('#admin_side_bar_child').addClass('active');
        break;
      case "admin.administer.create":
        $('#admin_create_side_bar_child').addClass('active');
        break;
      case "admin.administer.edit":
        $('#admin_side_bar_child').addClass('active');
        break;


      default:
        break;
    }
  }
})
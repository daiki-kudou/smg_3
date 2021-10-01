<?php
///////////////////////////////////////////////////////////////////////////
// 会場管理
///////////////////////////////////////////////////////////////////////////
// 会場
Breadcrumbs::for('admin.home.index', function ($trail) {
  $trail->push('ホーム', route('admin.home.index'));
});
Breadcrumbs::for('admin.venues.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('会場一覧', route('admin.venues.index'));
});
Breadcrumbs::for('admin.venues.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('会場管理 新規登録', route('admin.venues.create'));
});
Breadcrumbs::for('admin.venues.show', function ($trail, $venue) {
  $trail->parent('admin.venues.index');
  $trail->push('会場管理 詳細', route('admin.venues.show', $venue));
});
Breadcrumbs::for('admin.venues.edit', function ($trail, $venue) {
  $trail->parent('admin.venues.show', $venue);
  $trail->push('会場管理 編集', route('admin.venues.edit', $venue));
});

// 備品
Breadcrumbs::for('admin.equipments.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('会場管理 有料備品管理', route('admin.equipments.index'));
});
Breadcrumbs::for('admin.equipments.create', function ($trail) {
  $trail->parent('admin.equipments.index');
  $trail->push('有料備品新規登録', route('admin.equipments.create'));
});
Breadcrumbs::for('admin.equipments.edit', function ($trail, $id) {
  $trail->parent('admin.equipments.index');
  $trail->push('有料備品管理 編集', route('admin.equipments.edit', $id));
});
// サービス
Breadcrumbs::for('admin.services.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('会場管理 有料サービス管理', route('admin.services.index'));
});
Breadcrumbs::for('admin.services.create', function ($trail) {
  $trail->parent('admin.services.index');
  $trail->push('有料サービス管理 新規登録', route('admin.services.create'));
});
Breadcrumbs::for('admin.services.edit', function ($trail, $id) {
  $trail->parent('admin.services.index');
  $trail->push('有料サービス管理　編集', route('admin.services.edit', $id));
});
// 営業時間管理
Breadcrumbs::for('admin.dates.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('会場管理 営業時間管理', route('admin.dates.index'));
});
Breadcrumbs::for('admin.dates.show', function ($trail, $id) {
  $trail->parent('admin.dates.index');
  $trail->push('営業時間管理 詳細', route('admin.dates.show', $id));
});
Breadcrumbs::for('admin.dates.create', function ($trail, $id) {
  $trail->parent('admin.dates.show', $id);
  $trail->push('営業時間管理 編集', route('admin.dates.create', $id));
});
// 料金管理
Breadcrumbs::for('admin.frame_prices.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('会場管理 料金管理', route('admin.frame_prices.index'));
});
Breadcrumbs::for('admin.frame_prices.create', function ($trail, $id) {
  $trail->parent('admin.frame_prices.show', $id);
  $trail->push('会場管理 新規登録(枠貸し)', route('admin.frame_prices.create', $id));
});
Breadcrumbs::for('admin.frame_prices.show', function ($trail, $id) {
  $trail->parent('admin.frame_prices.index');
  $trail->push('料金管理 詳細', route('admin.frame_prices.show', $id));
});
Breadcrumbs::for('admin.frame_prices.edit', function ($trail, $id) {
  $trail->parent('admin.frame_prices.show', $id);
  $trail->push('料金管理 新規登録(枠貸し)', route('admin.frame_prices.edit', $id));
});
Breadcrumbs::for('admin.time_prices.create', function ($trail, $id) {
  $trail->parent('admin.frame_prices.show', $id);
  $trail->push('料金管理 新規登録(時間貸し)', route('admin.time_prices.create', $id));
});
// 仲介会社
Breadcrumbs::for('admin.agents.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('仲介会社 一覧', route('admin.agents.index'));
});
Breadcrumbs::for('admin.agents.show', function ($trail, $id) {
  $trail->parent('admin.agents.index', $id);
  $trail->push('仲介会社 詳細', route('admin.agents.show', $id));
});
Breadcrumbs::for('admin.agents.edit', function ($trail, $id) {
  $trail->parent('admin.agents.show', $id);
  $trail->push('仲介会社 編集', route('admin.agents.edit', $id));
});
Breadcrumbs::for('admin.agents.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('仲介会社 新規登録', route('admin.agents.create'));
});

// 仮押さえ 一覧
Breadcrumbs::for('admin.pre_reservations.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('仮押え 一覧', route('admin.pre_reservations.index'));
});
Breadcrumbs::for('admin.pre_reservations.show', function ($trail, $id) {
  $trail->parent('admin.pre_reservations.index', $id);
  $trail->push('仮押え 詳細', route('admin.pre_reservations.show', $id));
});
Breadcrumbs::for('admin.pre_reservations.edit', function ($trail, $id) {
  $trail->parent('admin.pre_reservations.show', $id);
  $trail->push('仮押え 編集', route('admin.pre_reservations.edit', $id));
});
Breadcrumbs::for('admin.pre_agent_reservations.edit', function ($trail, $id) {
  $trail->parent('admin.pre_reservations.show', $id);
  $trail->push('仮押え(仲介会社経由) 編集', route('admin.pre_agent_reservations.edit', $id));
});
Breadcrumbs::for('admin.pre_reservations.re_calculate', function ($trail, $id) {
  $trail->parent('admin.pre_reservations.edit', $id);
  $trail->push('仮押え 編集 再計算', route('admin.pre_reservations.re_calculate', $id));
});
// 仮押さえ 作成
Breadcrumbs::for('admin.pre_reservations.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('仮押え 新規登録', route('admin.pre_reservations.create'));
});
Breadcrumbs::for('admin.pre_reservations.check', function ($trail) {
  $trail->parent('admin.pre_reservations.create');
  $trail->push('仮押え 詳細入力', route('admin.pre_reservations.check'));
});
Breadcrumbs::for('admin.pre_reservations.calculate', function ($trail) {
  $trail->parent('admin.pre_reservations.check');
  $trail->push('仮押え 詳細計算', route('admin.pre_reservations.calculate'));
});
// 仲介会社経由　仮押え　新規登録
Breadcrumbs::for('admin.pre_agent_reservations.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('仲介会社 仮押え 新規登録', route('admin.pre_agent_reservations.create'));
});
Breadcrumbs::for('admin.pre_agent_reservations.check', function ($trail) {
  $trail->parent('admin.pre_agent_reservations.create');
  $trail->push('仲介会社 仮押え 詳細入力画面', route('admin.pre_agent_reservations.check'));
});
Breadcrumbs::for('admin.pre_agent_reservations.calculate', function ($trail) {
  $trail->parent('admin.pre_agent_reservations.check');
  $trail->push('仲介会社 仮押え 計算', route('admin.pre_agent_reservations.calculate'));
});
// 一括仮押さえ
Breadcrumbs::for('admin.multiples.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('一括仮押え 一覧', route('admin.multiples.index'));
});
Breadcrumbs::for('admin.multiples.show', function ($trail, $id) {
  $trail->parent('admin.multiples.index');
  $trail->push('一括仮押え 詳細', route('admin.multiples.show', $id));
});
Breadcrumbs::for('admin.multiples.add_venue', function ($trail, $id) {
  $trail->parent('admin.multiples.show', $id);
  $trail->push('一括仮押え 日程の追加', route('admin.multiples.add_venue', $id));
});
Breadcrumbs::for('admin.multiples.switch', function ($trail, $id) {
  $trail->parent('admin.multiples.show', $id);
  $trail->push('一括仮押え 顧客情報情報編集', route('admin.multiples.switch', $id));
});
Breadcrumbs::for('admin.multiples.edit', function ($trail, $id, $venue) {
  $trail->parent('admin.multiples.show', $id);
  $trail->push('一括仮押え 編集', route('admin.multiples.edit', [$id, $venue]));
});
Breadcrumbs::for('admin.multiples.edit_calculate', function ($trail, $id, $venue) {
  $trail->parent('admin.multiples.show', $id);
  $trail->push('一括仮押え 編集', route('admin.multiples.edit_calculate', [$id, $venue]));
});
// 一括仮押さえ仲介会社
Breadcrumbs::for('admin.multiples.agent_show', function ($trail, $id) {
  $trail->parent('admin.multiples.index');
  $trail->push('一括仮押え(仲介会社経由) 詳細', route('admin.multiples.agent_show', $id));
});
Breadcrumbs::for('admin.multiples.agent_switch', function ($trail, $id) {
  $trail->parent('admin.multiples.agent_show', $id);
  $trail->push('一括仮押え(仲介会社経由) 変更', route('admin.multiples.agent_switch', $id));
});
Breadcrumbs::for('admin.multiples.agent_add_venue', function ($trail, $id) {
  $trail->parent('admin.multiples.agent_show', $id);
  $trail->push('一括仮押え(仲介会社経由) 日程追加', route('admin.multiples.agent_add_venue', $id));
});
Breadcrumbs::for('admin.multiples.agent_edit', function ($trail, $id, $venue) {
  $trail->parent('admin.multiples.agent_show', $id);
  $trail->push('一括仮押え(仲介会社経由) 編集', route('admin.multiples.agent_edit', [$id, $venue]));
});

// 顧客管理
Breadcrumbs::for('admin.clients.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('顧客管理 一覧', route('admin.clients.index'));
});
Breadcrumbs::for('admin.clients.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('顧客管理 新規登録', route('admin.clients.create'));
});
Breadcrumbs::for('admin.clients.show', function ($trail, $id) {
  $trail->parent('admin.clients.index');
  $trail->push('顧客管理 詳細', route('admin.clients.show', $id));
});
Breadcrumbs::for('admin.clients.edit', function ($trail, $id) {
  $trail->parent('admin.clients.show', $id);
  $trail->push('顧客管理 詳細', route('admin.clients.edit', $id));
});

// 管理者予約　一覧
Breadcrumbs::for('admin.reservations.index', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('予約 一覧', route('admin.reservations.index'));
});

Breadcrumbs::for('admin.reservations.show', function ($trail, $id) {
  $trail->parent('admin.reservations.index');
  $trail->push('予約 詳細', route('admin.reservations.show', $id));
});

Breadcrumbs::for('admin.reservations.edit', function ($trail, $id) {
  $trail->parent('admin.reservations.show', $id);
  $trail->push('予約 編集', route('admin.reservations.edit', $id));
});

Breadcrumbs::for('admin.reservations.edit_calculate', function ($trail, $id) {
  $trail->parent('admin.reservations.show', $id);
  $trail->push('予約 編集', route('admin.reservations.edit_calculate', $id));
});

Breadcrumbs::for('admin.reservations.edit_check', function ($trail, $id) {
  $trail->parent('admin.reservations.show', $id);
  $trail->push('予約 編集', route('admin.reservations.edit_check', $id));
});

// 予約作成
Breadcrumbs::for('admin.reservations.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('予約 新規登録', route('admin.reservations.create'));
});

Breadcrumbs::for('admin.reservations.calculate', function ($trail) {
  $trail->parent('admin.reservations.create');
  $trail->push('予約 新規登録 詳細入力', route('admin.reservations.calculate'));
});

Breadcrumbs::for('admin.reservations.check', function ($trail) {
  $trail->parent('admin.reservations.calculate');
  $trail->push('予約 詳細 確認', route('admin.reservations.check'));
});

// 仲介会社 予約作成
Breadcrumbs::for('admin.agents_reservations.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('(仲介会社)予約 新規登録', route('admin.agents_reservations.create'));
});

Breadcrumbs::for('admin.agents_reservations.calculate', function ($trail) {
  $trail->parent('admin.agents_reservations.create');
  $trail->push('(仲介会社)予約 詳細入力', route('admin.agents_reservations.calculate'));
});

Breadcrumbs::for('admin.agents_reservations.check', function ($trail) {
  $trail->parent('admin.agents_reservations.calculate');
  $trail->push('(仲介会社)予約 詳細 確認', route('admin.agents_reservations.check'));
});

Breadcrumbs::for('admin.agents_reservations.edit', function ($trail, $id) {
  $trail->parent('admin.reservations.show', $id);
  $trail->push('(仲介会社)予約 編集', route('admin.agents_reservations.edit', $id));
});

Breadcrumbs::for('admin.agents_reservations.edit_check', function ($trail, $id) {
  $trail->parent('admin.agents_reservations.edit', $id);
  $trail->push('(仲介会社)予約 再計算・確認', route('admin.agents_reservations.edit_check', $id));
});

Breadcrumbs::for('admin.agents_reservations.add_bills', function ($trail, $id) {
  $trail->parent('admin.reservations.show', $id);
  $trail->push('(仲介会社)追加請求書　作成', route('admin.agents_reservations.add_bills'));
});

Breadcrumbs::for('admin.agents_reservations.add_check', function ($trail, $id) {
  $trail->parent('admin.agents_reservations.add_bills', $id);
  $trail->push('(仲介会社)追加請求書　確認', route('admin.agents_reservations.add_check'));
});

// 追加請求書
Breadcrumbs::for('admin.bills.edit', function ($trail, $bill_id, $reservation_id) {
  $trail->parent('admin.reservations.show', $reservation_id);
  $trail->push('追加請求書　編集', route('admin.bills.edit', $bill_id));
});

Breadcrumbs::for('admin.bills.create', function ($trail, $id) {
  $trail->parent('admin.reservations.show', $id);
  $trail->push('追加請求書　作成', route('admin.bills.create', ['reservation_id' => $id]));
});

Breadcrumbs::for('admin.bills.check', function ($trail, $id) {
  $trail->parent('admin.bills.create', $id);
  $trail->push('追加請求書　確認', route('admin.bills.check'));
});


// 管理者　カレンダー
Breadcrumbs::for('admin.calendar.date_calendar', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('予約状況カレンダー 利用日別', route('admin.calendar.date_calendar'));
});

Breadcrumbs::for('admin.calendar.venue_calendar', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('予約状況カレンダー 会場別', route('admin.calendar.venue_calendar'));
});
//////////////////////////ユーザー///////////////////////////////////

// ユーザーホーム（予約）
Breadcrumbs::for('user.home.index', function ($trail) {
  $trail->push('Home', route('user.home.index'));
});

Breadcrumbs::for('user.home.show', function ($trail, $id) {
  $trail->parent('user.home.index');
  $trail->push('予約 詳細', route('user.home.show', $id));
});

// 仮押え
Breadcrumbs::for('user.pre_reservations.index', function ($trail) {
  $trail->parent('user.home.index');
  $trail->push('仮押え　一覧', route('user.pre_reservations.index'));
});

Breadcrumbs::for('user.pre_reservations.show', function ($trail, $id) {
  $trail->parent('user.pre_reservations.index');
  $trail->push('仮押え　申し込み', route('user.pre_reservations.show', $id));
});

Breadcrumbs::for('user.pre_reservations.show_calc', function ($trail, $id) {
  $trail->parent('user.pre_reservations.index');
  $trail->push('仮押え　申し込み', route('user.pre_reservations.show_calc', $id));
});

Breadcrumbs::for('user.pre_reservations.show_cfm', function ($trail) {
  $trail->parent('user.pre_reservations.index');
  $trail->push('仮押え　申し込み', route('user.pre_reservations.show_cfm'));
});

// キャンセル
Breadcrumbs::for('admin.cxl.edit', function ($trail, $cxl_id, $reservation_id) {
  $trail->parent('admin.reservations.show', $reservation_id);
  $trail->push('キャンセル請求書 編集', route('admin.cxl.edit', $cxl_id));
});

Breadcrumbs::for('admin.cxl.edit_calc', function ($trail, $id) {
  $trail->parent('admin.cxl.edit', $id);
  $trail->push('キャンセル請求書 編集', route('admin.cxl.edit_calc', $id));
});

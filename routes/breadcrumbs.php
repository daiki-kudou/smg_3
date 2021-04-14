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
  $trail->push('仮抑え 一覧', route('admin.pre_reservations.index'));
});
Breadcrumbs::for('admin.pre_reservations.show', function ($trail, $id) {
  $trail->parent('admin.pre_reservations.index', $id);
  $trail->push('仮抑え 詳細', route('admin.pre_reservations.show', $id));
});
Breadcrumbs::for('admin.pre_reservations.edit', function ($trail, $id) {
  $trail->parent('admin.pre_reservations.show', $id);
  $trail->push('仮抑え 編集', route('admin.pre_reservations.edit', $id));
});
Breadcrumbs::for('admin.pre_reservations.re_calculate', function ($trail, $id) {
  $trail->parent('admin.pre_reservations.edit', $id);
  $trail->push('仮抑え 編集 再計算', route('admin.pre_reservations.re_calculate', $id));
});
// 仮押さえ 作成
Breadcrumbs::for('admin.pre_reservations.create', function ($trail) {
  $trail->parent('admin.home.index');
  $trail->push('仮抑え 新規登録', route('admin.pre_reservations.create'));
});
Breadcrumbs::for('admin.pre_reservations.check', function ($trail) {
  $trail->parent('admin.pre_reservations.create');
  $trail->push('仮抑え 詳細入力', route('admin.pre_reservations.check'));
});
Breadcrumbs::for('admin.pre_reservations.calculate', function ($trail) {
  $trail->parent('admin.pre_reservations.check');
  $trail->push('仮抑え 詳細計算', route('admin.pre_reservations.calculate'));
});
// 仲介会社経由　仮抑え　新規登録
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











// Breadcrumbs::for('admin.equipments.index', function ($trail) {
//   $trail->parent('admin.home.index');
//   $trail->push('有料備品管理', route('admin.equipments.index'));
// });

// Breadcrumbs::for('admin.equipments.create', function ($trail) {
//   $trail->parent('admin.equipments.index');
//   $trail->push('有料備品　新規登録', route('admin.equipments.create'));
// });

// Breadcrumbs::for('admin.equipments.edit', function ($trail, $equipment) {
//   $trail->parent('admin.equipments.index');
//   $trail->push('有料備品　編集', route('admin.equipments.edit', $equipment));
// });


// // service
// Breadcrumbs::for('admin.services.index', function ($trail) {
//   $trail->parent('admin.home.index');
//   $trail->push('有料サービス管理', route('admin.services.index'));
// });

// Breadcrumbs::for('admin.services.edit', function ($trail, $service) {
//   $trail->parent('admin.services.index');
//   $trail->push('有料サービス管理　編集', route('admin.services.edit', $service));
// });

// Breadcrumbs::for('admin.services.create', function ($trail) {
//   $trail->parent('admin.services.index');
//   $trail->push('有料サービス　新規登録', route('admin.services.create'));
// });

// // dates
// Breadcrumbs::for('admin.dates.index', function ($trail) {
//   $trail->parent('admin.home.index');
//   $trail->push('営業時間管理', route('admin.dates.index'));
// });

// Breadcrumbs::for('admin.dates.show', function ($trail, $date) {
//   $trail->parent('admin.dates.index');
//   $trail->push('営業時間管理　詳細', route('admin.dates.show', $date));
// });

// Breadcrumbs::for('admin.dates.create', function ($trail, $date) {
//   $trail->parent('admin.dates.index');
//   $trail->push('営業時間管理　編集', route('admin.dates.create', $date));
// });



// // frame price
// Breadcrumbs::for('admin.frame_prices.index', function ($trail) {
//   $trail->parent('admin.home.index');
//   $trail->push('料金管理', route('admin.frame_prices.index'));
// });

// Breadcrumbs::for('admin.frame_prices.show', function ($trail, $frame_price) {
//   $trail->parent('admin.frame_prices.index');
//   $trail->push('料金管理　詳細', route('admin.frame_prices.show', $frame_price));
// });

// Breadcrumbs::for('admin.frame_prices.create', function ($trail, $frame_price) {
//   $trail->parent('admin.frame_prices.index');
//   $trail->push('料金管理　新規登録（枠貸し）', route('admin.frame_prices.create', $frame_price));
// });

// Breadcrumbs::for('admin.frame_prices.edit', function ($trail, $frame_price) {
//   $trail->parent('admin.frame_prices.index');
//   $trail->push('料金管理　編集（枠貸し）', route('admin.frame_prices.edit', $frame_price));
// });

// // time price
// Breadcrumbs::for('admin.time_prices.create', function ($trail, $time_price) {
//   $trail->parent('admin.frame_prices.index');
//   $trail->push('料金管理　新規登録（時間貸し）', route('admin.time_prices.create', $time_price));
// });

// Breadcrumbs::for('admin.time_prices.edit', function ($trail, $time_price) {
//   $trail->parent('admin.frame_prices.index');
//   $trail->push('料金管理　編集（時間貸し）', route('admin.time_prices.edit', $time_price));
// });


// // reservatioins
// Breadcrumbs::for('admin.reservations.create', function ($trail) {
//   $trail->parent('admin.home.index');
//   $trail->push('予約　新規登録', route('admin.reservations.create'));
// });

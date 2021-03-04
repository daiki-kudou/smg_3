<?php


///////////////////////////////////////////////////////////////////////////
// 会場
///////////////////////////////////////////////////////////////////////////
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
  $trail->parent('admin.venues.show');
  $trail->push('会場管理 編集', route('admin.venues.edit', $venue));
});
















// Breadcrumbs::for('admin.equipments.index', function ($trail) {
//   $trail->parent('admin.home.index');
//   $trail->push('有料備品管理', route('admin.equipments.index'));
// });

// Breadcrumbs::for('admin.equipments.create', function ($trail) {
//   $trail->parent('admin.equipments.index');
//   $trail->push('有料備品　新規作成', route('admin.equipments.create'));
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
//   $trail->push('有料サービス　新規作成', route('admin.services.create'));
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
//   $trail->push('料金管理　新規作成（枠貸し）', route('admin.frame_prices.create', $frame_price));
// });

// Breadcrumbs::for('admin.frame_prices.edit', function ($trail, $frame_price) {
//   $trail->parent('admin.frame_prices.index');
//   $trail->push('料金管理　編集（枠貸し）', route('admin.frame_prices.edit', $frame_price));
// });

// // time price
// Breadcrumbs::for('admin.time_prices.create', function ($trail, $time_price) {
//   $trail->parent('admin.frame_prices.index');
//   $trail->push('料金管理　新規作成（時間貸し）', route('admin.time_prices.create', $time_price));
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

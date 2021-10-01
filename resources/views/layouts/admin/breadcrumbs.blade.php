<div class="d-flex justify-content-end">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        @if (!empty($bill_id)&&!empty($reservation_id))
        {{ Breadcrumbs::render(Route::currentRouteName(),$bill_id,$reservation_id) }}
        @elseif(!empty($cxl_id)&&!empty($reservation_id))
        {{ Breadcrumbs::render(Route::currentRouteName(),$cxl_id,$reservation_id) }}
        @elseif(!empty($id))
        {{ Breadcrumbs::render(Route::currentRouteName(),$id) }}
        @elseif(!empty($reservation_id))
        {{ Breadcrumbs::render(Route::currentRouteName(),$reservation_id) }}
        @elseif(!empty($reservation_id)&&!empty($bill_id)&&!empty($multi))
        {{ Breadcrumbs::render(Route::currentRouteName(),$reservation_id,$bill_id, $multi ) }}
        @else
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        @endif
      </li>
    </ol>
  </nav>
</div>
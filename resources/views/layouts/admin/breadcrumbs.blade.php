<div class="d-flex justify-content-end">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        @if (!empty($id))
        {{ Breadcrumbs::render(Route::currentRouteName(),$id) }}
        @else
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        @endif
      </li>
    </ol>
  </nav>
</div>
@extends('theme::layouts.main')

@section('content')
  <!-- HEADER SECTION -->
  @include('theme::headers.product_page', ['product' => $item])

  <!-- CONTENT SECTION -->
  @include('theme::contents.product_page')

  <!-- RELATED ITEMS -->
  <section>
    <div class="feature">
      <div class="container-fluid">
        <div class="feature-inner">
          <div class="feature-header">
            <div class="sell-header">
              <div class="sell-header-title">
                <h2>{!! trans('theme.related_items') !!}</h2>
              </div>
              <div class="header-line">
                <span></span>
              </div>
              <div class="header-line">
                <span></span>
              </div>
              <div class="best-deal-arrow">
              </div>
            </div>
          </div>

          <div class="feature-items">
            <div class="feature-items-inner">

              @include('theme::partials._product_horizontal', ['products' => $related])

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- BROWSING ITEMS -->
  @include('theme::sections.recent_views')

  <!-- MODALS -->
  @include('theme::modals.shopReviews', ['shop' => $item->shop])

  @if (Auth::guard('customer')->check())
    @include('theme::modals.contact_seller', ['shop' => $item->shop, 'item' => $item])
  @endif
@endsection

@section('scripts')

  @if (is_incevio_package_loaded('liveChat'))
    @if (is_chat_enabled($item->shop))
      @include('liveChat::livechat', ['shop' => $item->shop, 'agent' => $item->shop->owner, 'agent_status' => trans('theme.online')])
    @endif
  @endif

  @include('theme::modals.ship_to')
  @include('theme::scripts.product_page')
  @include('scripts.flash_deal')
@endsection

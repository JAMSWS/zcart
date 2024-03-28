<div class="row product-list">
  @foreach ($giftCards as $item)
    <div class="col-md-3">
      <div class="product product-grid-view sc-product-item">
        <input name="product_price" value="{{ get_formated_decimal($item->current_sale_price(), true, 2) }}" type="hidden" />
        <input name="product_id" value="{{ $item->id }}" type="hidden" />
        <input name="shop_id" value="{{ $item->id }}" type="hidden" />

        {{-- <ul class="product-info-labels">
                    @if ($item->orders_count >= config('system.popular.hot_item.sell_count', 3))
                        <li>@lang('theme.hot_item')</li>
                    @endif
                    @if ($item->free_shipping == 1)
                        <li>@lang('theme.free_shipping')</li>
                    @endif
                    @if ($item->stuff_pick == 1)
                        <li>@lang('theme.stuff_pick')</li>
                    @endif
                    @if ($item->hasOffer())
                        <li>@lang('theme.percent_off', ['value' => get_percentage_of($item->sale_price, $item->offer_price)])</li>
                    @endif
                </ul> --}}

        <div class="product-img-wrap">
          <img class="product-img-primary lazy" src="{{ get_product_img_src($item, 'tiny', 'alt') }}" data-src="{{ get_product_img_src($item, 'full') }}" data-name="product_image" alt="{{ $item->title }}" title="{{ $item->title }}" />

          <img class="product-img-alt lazy" src="{{ get_product_img_src($item, 'tiny', 'alt') }}" data-src="{{ get_product_img_src($item, 'full', 'alt') }}" alt="{{ $item->title }}" title="{{ $item->title }}" />

          <a class="product-link" href="{{ route('show.product', $item->slug) }}" data-name="product_link"></a>
        </div>

        <div class="product-actions btn-group">
          <a class="btn btn-default rounded-0 add-to-wishlist" href="javascript:void(0);" data-link="{{ route('wishlist.add', $item) }}">
            <i class="far fa-heart" data-toggle="tooltip" title="@lang('theme.button.add_to_wishlist')"></i> <span>@lang('theme.button.add_to_wishlist')</span>
          </a>

          <a class="btn btn-default rounded-0 itemQuickView" href="javascript:void(0);" data-link="{{ route('quickView.product', $item->slug) }}" rel="nofollow noindex">
            <i class="far fa-eye" data-toggle="tooltip" title="@lang('theme.button.quick_view')"></i> <span>@lang('theme.button.quick_view')</span>
          </a>

          <a class="btn btn-primary rounded-0 sc-add-to-cart" data-link="#">
            <i class="fas fa-shopping-cart"></i> @lang('theme.button.add_to_cart')
          </a>
        </div>

        <div class="product-info">
          @include('theme::layouts.ratings', ['ratings' => $item->ratings, 'count' => $item->ratings_count])

          <a href="{{ route('show.product', $item->slug) }}" class="product-info-title" data-name="product_name">{{ $item->title }}</a>

          <div class="product-info-availability">
            @lang('theme.availability'): <span>{{ $item->stock_quantity > 0 ? trans('theme.in_stock') : trans('theme.out_of_stock') }}</span>
          </div>

          @include('theme::layouts.pricing', ['item' => $item])

          <div class="product-info-desc"> {{ $item->description }} </div>
          {{-- <div class="product-info-desc" data-name="product_description"> {{ $item->description }} </div> --}}
          <ul class="product-info-feature-list">
            <li>{{ $item->condition }}</li>
            {{-- <li>{{ $product->product_id }}</li> --}}
          </ul>
        </div><!-- /.product-info -->
      </div><!-- /.product -->
    </div><!-- /.col-md-* -->
  @endforeach
</div><!-- /.row -->

<hr />

<div class="row pagenav-wrapper">
  {{ $giftCards->links('theme::layouts.pagination') }}
</div><!-- /.row .pagenav-wrapper -->

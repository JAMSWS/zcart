<section>
  <div class="container-fluid">
    @if ($carts->count() > 0)
      @foreach ($carts as $cart)
        @php
          $cart_total = 0;
          
          $packaging_options = null;
          if (!$cart->is_digital && is_incevio_package_loaded('packaging')) {
              $packaging_options = optional($cart->shop)->packagings;
          
              if ($cart->shop) {
                  $default_packaging =
                      $cart->shippingPackage ??
                      (optional($cart->shop->packagings)
                          ->where('default', 1)
                          ->first() ??
                          $platformDefaultPackaging);
              } else {
                  $default_packaging = $cart->shippingPackage ?? $platformDefaultPackaging;
              }
          }
        @endphp

        <div class="row shopping-cart-wrapper mb-5 mt-3 {{ $expressId == $cart->id ? 'selected' : '' }}" id="cartId{{ $cart->id }}" data-cart="{{ $cart->id }}" data-cart-type="{{ $cart->is_digital ? 'digital' : 'physical' }}">
          <div class="col-md-9">
            {!! Form::model($cart, ['method' => 'PUT', 'route' => ['cart.checkout', $cart->id], 'id' => 'formId' . $cart->id]) !!}
            {{ Form::hidden('cart_id', $cart->id, ['id' => 'cart-id' . $cart->id]) }}
            {{ Form::hidden('shop_id', $cart->shop->id, ['id' => 'shop-id' . $cart->id]) }}
            {{ Form::hidden('tax_id', isset($shipping_zones[$cart->id]->id) ? $shipping_zones[$cart->id]->tax_id : null, ['id' => 'tax-id' . $cart->id]) }}
            {{ Form::hidden('taxrate', null, ['id' => 'cart-taxrate' . $cart->id]) }}
            {{ Form::hidden('ship_to', $cart->ship_to, ['id' => 'ship-to' . $cart->id]) }}
            {{ Form::hidden('shipping_zone_id', isset($shipping_zones[$cart->id]->id) ? $shipping_zones[$cart->id]->id : null, ['id' => 'zone-id' . $cart->id]) }}
            {{ Form::hidden('shipping_rate_id', $cart->shipping_rate_id, ['id' => 'shipping-rate-id' . $cart->id]) }}
            {{ Form::hidden('ship_to_country_id', $cart->ship_to_country_id, ['id' => 'shipto-country-id' . $cart->id]) }}
            {{ Form::hidden('ship_to_state_id', $cart->ship_to_state_id, ['id' => 'shipto-state-id' . $cart->id]) }}
            {{ Form::hidden('coupon_raw', json_encode($cart->coupon), ['id' => 'coupon-raw' . $cart->id]) }}
            {{ Form::hidden('handling_cost', optional($cart->shop->config)->order_handling_cost, ['id' => 'handling-cost' . $cart->id]) }}

            @if (!$cart->is_digital && is_incevio_package_loaded('packaging'))
              {{ Form::hidden('packaging_id', $default_packaging ? $default_packaging->id : null, ['id' => 'packaging-id' . $cart->id]) }}
            @endif

            <div class="shopping-cart-header">
              <div class="row">
                <div class="col-5">
                  <span>@lang('theme.store'):</span>
                  @if ($cart->shop->slug)
                    <a href="{{ route('show.store', $cart->shop->slug) }}"> {{ $cart->shop->name }}</a>
                  @else
                    @lang('theme.store_not_available')
                  @endif
                </div>
                <div class="col-3">
                  @lang('theme.cart_items') : {{ $cart->type }}
                </div>
                <div class="col-4">
                  <span class="pull-right">
                    @if ($cart->is_digital)
                      {{ trans('theme.applicable_taxes_for') }}:
                    @else
                      @lang('theme.ship_to'):
                    @endif
                    <a href="javascript:void(0);" id="shipTo{{ $cart->id }}" class="ship_to" data-cart="{{ $cart->id }}" data-country="{{ $cart->ship_to_country_id }}" data-state="{{ $cart->ship_to_state_id }}">
                      {{ $cart->ship_to_state_id ? $cart->state->name : $cart->country->name }}
                    </a>
                  </span>
                </div>
              </div>
            </div>

            <table class="table table shopping-cart-item-table" id="table{{ $cart->id }}">
              <thead>
                <tr>
                  <th width="65px">{{ trans('theme.image') }}</th>
                  @if ($cart->is_digital)
                    <th>{{ trans('theme.description') }}</th>
                    <th>{{ trans('theme.price') }}</th>
                  @else
                    <th width="52%" class="hidden-sm hidden-xs">{{ trans('theme.description') }}</th>
                    <th>{{ trans('theme.price') }}</th>
                    <th>{{ trans('theme.quantity') }}</th>
                    <th>{{ trans('theme.total') }}</th>
                  @endif
                  <th>&nbsp;</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($cart->inventories as $item)
                  @php
                    $unit_price = $item->current_sale_price();
                    $item_total = $unit_price * $item->pivot->quantity;
                    $cart_total += $item_total;
                  @endphp

                  <tr class="cart-item-tr">
                    <td>
                      {{-- @unless ($cart->is_digital) --}}
                      <input type="hidden" class="freeShipping{{ $cart->id }}" value="{{ $item->free_shipping }}">

                      <input type="hidden" id="unitWeight{{ $item->id }}" value="{{ $item->shipping_weight }}">

                      {{ Form::hidden('shipping_weight[' . $item->id . ']', $item->shipping_weight * $item->pivot->quantity, ['id' => 'itemWeight' . $item->id, 'class' => 'itemWeight' . $cart->id]) }}
                      {{-- @endunless --}}
                      <img class="img-mini lazy" src="data-src="{{ get_product_img_src($item, 'tiny') }}"" data-src="{{ get_product_img_src($item, 'mini') }}" alt="{{ $item->slug }}" title="{{ $item->slug }}" />
                    </td>

                    <td class="hidden-sm hidden-xs">
                      <div class="shopping-cart-item-title">
                        <a href="{{ route('show.product', $item->slug) }}" class="product-info-title">
                          {{ $item->pivot->item_description }}
                          @if ($item->isOutOfStock())
                            <span class="label label-danger text-right ml-3">{{ trans('mobile.out_of_stock') }}</span>
                          @endif
                        </a>
                      </div>
                    </td>

                    @unless ($cart->is_digital)
                      <td class="shopping-cart-item-price">
                        <span>
                          {{ get_currency_prefix() }}
                          <span id="item-price{{ $cart->id . '-' . $item->id }}" data-value="{{ $unit_price }}">
                            {{ number_format($unit_price, 2, '.', '') }}
                          </span>
                          {{ get_currency_suffix() }}
                        </span>
                      </td>
                      <td>
                        <div class="product-info-qty-item">
                          <button class="product-info-qty product-info-qty-minus">-</button>

                          <input name="quantity[{{ $item->id }}]" id="itemQtt{{ $item->id }}" class="product-info-qty product-info-qty-input" data-cart="{{ $cart->id }}" data-item="{{ $item->id }}" data-min="{{ $item->min_order_quantity }}" data-max="{{ $item->stock_quantity }}" type="text" value="{{ $item->pivot->quantity }}">

                          <button class="product-info-qty product-info-qty-plus">+</button>
                        </div>
                      </td>
                    @endunless

                    <td>
                      <span>
                        {{ get_currency_prefix() }}
                        <span id="item-total{{ $cart->id . '-' . $item->id }}" class="item-total{{ $cart->id }}">
                          {{ number_format($item_total, 2, '.', '') }}
                        </span>
                        {{ get_currency_suffix() }}
                      </span>
                    </td>

                    <td>
                      <a href="javascript:void(0);" class="cart-item-remove" data-cart="{{ $cart->id }}" data-item="{{ $item->id }}" data-toggle="tooltip" title="@lang('theme.remove_item')">&times;</a>
                    </td>
                  </tr> <!-- /.order-body -->
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <td colspan="6">
                    <div class="input-group w-100">
                      <span class="input-group-addon rounded-0">
                        <i class="fa fa-ticket"></i>
                      </span>
                      <input name="coupon" value="{{ $cart->coupon ? $cart->coupon->code : null }}" id="coupon{{ $cart->id }}" class="form-control rounded-0 type="text" placeholder="@lang('theme.placeholder.have_coupon_from_seller')">
                      <span class="input-group-btn">
                        <button class="btn btn-default rounded-0 apply_seller_coupon" type="button" data-cart="{{ $cart->id }}">@lang('theme.button.apply_coupon')</button>
                      </span>
                    </div><!-- /input-group -->
                  </td>
                </tr>
              </tfoot>
            </table>
            {!! Form::close() !!}

            <div class="notice notice-warning notice-sm hidden" id="shipping-notice{{ $cart->id }}">
              <strong>{{ trans('theme.warning') }}</strong> @lang('theme.notify.seller_doesnt_ship')
            </div>

            <div class="notice notice-danger notice-sm hidden" id="store-unavailable-notice{{ $cart->id }}">
              <strong>{{ trans('theme.warning') }}</strong> @lang('theme.notify.store_not_available')
            </div>
          </div><!-- /.col-md-9 -->

          <div class="col-md-3 mb-3">
            <div class="side-widget" id="cart-summary{{ $cart->id }}">
              <h3 class="cart-summary">
                <span>{{ trans('theme.cart_summary') }}</span>
              </h3>

              <ul class="shopping-cart-summary">
                <li>
                  <span>{{ trans('theme.subtotal') }}</span>
                  <span>
                    {{ get_currency_prefix() }}
                    <span id="summary-total{{ $cart->id }}">
                      {{ number_format($cart_total, 2, '.', '') }}
                    </span>
                    {{ get_currency_suffix() }}
                  </span>
                </li>

                @unless ($cart->is_digital)
                  <li>
                    <span>
                      <a class="dynamic-shipping-rates" href="javascript:void(0);" data-toggle="popover" data-cart="{{ $cart->id }}" data-options="{{ $shipping_options[$cart->id] }}" id="shipping-options{{ $cart->id }}" title="{{ trans('theme.shipping') }}">
                        <u>{{ trans('theme.shipping') }}</u>
                      </a>
                      <em id="summary-shipping-name{{ $cart->id }}" class="small text-muted"></em>
                    </span>
                    <span>{{ get_currency_prefix() }}
                      <span id="summary-shipping{{ $cart->id }}">{{ number_format(0, 2, '.', '') }}</span>{{ get_currency_suffix() }}
                    </span>
                  </li>

                  @if (is_incevio_package_loaded('packaging') && !empty(json_decode($packaging_options)))
                    <li>
                      <span>
                        <a class="packaging-options" href="javascript:void(0);" data-toggle="popover" data-cart="{{ $cart->id }}" data-options="{{ $packaging_options }}" title="{{ trans('theme.packaging') }}">
                          <u>{{ trans('theme.packaging') }}</u>
                        </a>
                        <em class="small text-muted" id="summary-packaging-name{{ $cart->id }}">
                          {{ $default_packaging ? $default_packaging->name : '' }}
                        </em>
                      </span>
                      <span>{{ get_currency_prefix() }}
                        <span id="summary-packaging{{ $cart->id }}">
                          {{ number_format($default_packaging ? $default_packaging->cost : 0, 2, '.', '') }}
                        </span>{{ get_currency_suffix() }}
                      </span>
                    </li>
                  @endif
                @endunless

                <li id="discount-section-li{{ $cart->id }}" style="display: {{ $cart->coupon ? 'block' : 'none' }};">
                  <span>{{ trans('theme.discount') }}
                    <em id="summary-discount-name{{ $cart->id }}" class="small text-muted">{{ $cart->coupon ? $cart->coupon->name . ' (' . $cart->coupon->getFormatedAmountText() . ')' : '' }}</em>
                  </span>
                  <span>-{{ get_currency_prefix() }}
                    <span id="summary-discount{{ $cart->id }}">{{ $cart->coupon ? number_format($cart->discount, 2, '.', '') : number_format(0, 2, '.', '') }}</span>{{ get_currency_suffix() }}
                  </span>
                </li>

                <li id="tax-section-li{{ $cart->id }}" style="{{ $cart->taxes ? '' : 'display: none' }};">
                  <span>{{ trans('theme.taxes') }}</span>
                  <span>{{ get_currency_prefix() }}
                    <span id="summary-taxes{{ $cart->id }}">{{ number_format($cart->taxes, 2, '.', '') }}</span>{{ get_currency_suffix() }}
                  </span>
                </li>

                <li>
                  <span>{{ trans('theme.total') }}</span>
                  <span>{{ get_currency_prefix() }}
                    <span id="summary-grand-total{{ $cart->id }}">{{ number_format($cart->grand_total, 2, '.', '') }}</span>{{ get_currency_suffix() }}
                  </span>
                </li>
              </ul>
            </div>

            @if (allow_checkout())
              <button type="submit" form="formId{{ $cart->id }}" id="checkout-btn{{ $cart->id }}" class="btn btn-primary btn-sm rounded-0 pull-right">
                <i class="fa fa-shopping-cart"></i> {{ trans('theme.button.buy_from_this_seller') }}
              </button>
            @else
              <a href="#nav-login-dialog" data-toggle="modal" data-target="#loginModal" class="btn btn-primary btn-sm rounded-0 pull-right">
                <i class="fa fa-shopping-cart"></i> {{ trans('theme.button.buy_from_this_seller') }}
              </a>
            @endif
          </div> <!-- /.col-md-3 -->
        </div> <!-- /.row -->
      @endforeach

      <div class="row">
        <div class="col-6 pr-1">
          <a href="{{ url('/') }}" class="btn btn-black">{{ trans('theme.button.continue_shopping') }}</a>
        </div>

        <div class="col-6 pl-1 text-right">
          @if (is_incevio_package_loaded('checkout'))
            @include('checkout::_checkout_button')
          @endif
        </div>
      </div>
    @else
      <div class="row">
        <div class="col-12">
          <p class="lead text-center my-5">
            {{ trans('theme.empty_cart') }}<br /><br />
            <a href="{{ url('/') }}" class="btn btn-primary">
              <i class="fa fa-shopping-cart"></i> @lang('theme.button.shop_now')
            </a>
          </p>
        </div>
      </div>
    @endif
  </div> <!-- /.container -->
</section>

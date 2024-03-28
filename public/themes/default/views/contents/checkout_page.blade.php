@php
  $geoip = geoip(get_visitor_IP());
  $geoip_country = $business_areas->where('iso_code', $geoip->iso_code)->first();
  
  $shipping_country_id = $cart->ship_to_country_id ?? optional($geoip_country)->id;
  
  if (!$cart->shipping_state_id) {
      $geoip_state = \DB::table('states')
          ->select('id', 'name', 'iso_code')
          ->where([['country_id', '=', $shipping_country_id], ['iso_code', '=', $geoip->state]])
          ->first();
  }
  
  $shipping_state_id = $cart->ship_to_state_id ?? optional($geoip_state)->id;
  
  // $shipping_zone = get_shipping_zone_of($cart->shop_id, $shipping_country_id, $shipping_state_id);
  // $shipping_options = isset($shipping_zone->id) ? getShippingRates($shipping_zone->id) : 'NaN';
  
  $packaging_options = null;
  if (!$cart->is_digital && is_incevio_package_loaded('packaging')) {
      $packaging_options = optional($cart->shop)->packagings;
  
      $default_packaging =
          $cart->shippingPackage ??
          (optional($cart->shop->packagings)
              ->where('default', 1)
              ->first() ??
              $platformDefaultPackaging);
  }
@endphp

<section>
  <div class="container-fluid">
    @if (Session::has('error'))
      <div class="notice notice-danger notice-sm">
        <strong>{{ trans('theme.error') }}</strong> {{ Session::get('error') }}
      </div>
    @endif

    <div class="notice notice-warning notice-sm mb-3" id="checkout-notice" style="display: {{ $cart->is_digital || $cart->shipping_rate_id || $cart->is_free_shipping() ? 'none' : 'block' }};">
      <strong>{{ trans('theme.warning') }}</strong>
      <span id="checkout-notice-msg">@lang('theme.notify.seller_doesnt_ship')</span>
    </div>

    {!! Form::open(['route' => ['order.create', $cart], 'id' => 'formId' . $cart->id, 'name' => 'checkoutForm', 'files' => true, 'data-toggle' => 'validator', 'autocomplete' => 'off', 'novalidate']) !!}
    <div class="row shopping-cart-wrapper radius mb-4" id="cartId{{ $cart->id }}" data-cart="{{ $cart->id }}" data-cart-type="{{ $cart->is_digital ? 'digital' : 'physical' }}">
      <div class="col-md-4 bg-light py-2">
        <div class="seller-info my-3">
          <div class="text-muted small mb-3">
            <i class="far fa-store"></i> {{ trans('theme.sold_by') }}
          </div>

          <div class="logo-wrapper">
            <img class="lazy vendor-logo" src="{{ get_storage_file_url(optional($shop->logoImage)->path, 'tiny_thumb') }}" data-src="{{ get_storage_file_url(optional($shop->logoImage)->path, 'medium') }}" alt="{{ $shop->name }}">

            <a href="{{ route('show.store', $shop->slug) }}" class="seller-info-name ml-2">
              <img>
              {!! $shop->getQualifiedName() !!}
            </a>
          </div> <!-- /.logo-wrapper -->


          {{-- <a href="{{ route('show.store', $shop->slug) }}" class="seller-info-name mr-3">
            <img class="seller-info-logo img-sm lazy" src="{{ get_storage_file_url(optional($shop->logoImage)->path, 'tiny') }}" data-src="{{ get_storage_file_url(optional($shop->logoImage)->path, 'thumbnail') }}" title="{{ $shop->name }}" alt="{{ trans('theme.logo') }}">
          </a>

          <a href="{{ route('show.store', $shop->slug) }}" class="seller-info-name">
            <span class="text-primary">{{ $shop->name }}</span>
          </a> --}}
        </div><!-- /.seller-info -->

        <div class="input-group w-100 radius mb-4">
          <span class="input-group-addon">
            <i class="fas fa-ticket no-fill"></i>
          </span>

          <input name="coupon" value="{{ $cart->coupon ? $cart->coupon->code : null }}" id="coupon{{ $cart->id }}" class="form-control" type="text" placeholder="@lang('theme.placeholder.have_coupon_from_seller')">

          <span class="input-group-btn">
            <button class="btn btn-default apply_seller_coupon" type="button" data-cart="{{ $cart->id }}">@lang('theme.button.apply_coupon')</button>
          </span>
        </div><!-- /input-group -->

        {{ Form::hidden('cart_id', $cart->id, ['id' => 'checkout-id']) }}
        {{ Form::hidden('cart_weight', $cart->shipping_weight, ['id' => 'cartWeight' . $cart->id]) }}
        {{ Form::hidden('free_shipping', $cart->is_free_shipping(), ['id' => 'freeShipping' . $cart->id]) }}
        {{ Form::hidden('shop_id', $cart->shop->id, ['id' => 'shop-id' . $cart->id]) }}
        {{ Form::hidden('tax_id', isset($shipping_zones[$cart->id]->i) ? $shipping_zones[$cart->id]->tax_id : null, ['id' => 'tax-id' . $cart->id]) }}
        {{ Form::hidden('taxrate', $cart->taxrate, ['id' => 'cart-taxrate' . $cart->id]) }}

        @if (!$cart->is_digital && is_incevio_package_loaded('packaging'))
          {{ Form::hidden('packaging_id', $cart->packaging_id ?? optional($default_packaging)->id, ['id' => 'packaging-id' . $cart->id]) }}
        @endif

        {{ Form::hidden('shipping_zone_id', $cart->shipping_zone_id, ['id' => 'zone-id' . $cart->id]) }}
        {{ Form::hidden('shipping_rate_id', $cart->shipping_rate_id, ['id' => 'shipping-rate-id' . $cart->id]) }}
        {{ Form::hidden('ship_to_country_id', $cart->ship_to_country_id, ['id' => 'shipto-country-id' . $cart->id]) }}
        {{ Form::hidden('ship_to_state_id', $cart->ship_to_state_id, ['id' => 'shipto-state-id' . $cart->id]) }}
        {{ Form::hidden('coupon_raw', json_encode($cart->coupon), ['id' => 'coupon-raw' . $cart->id]) }}
        {{ Form::hidden('handling_cost', $cart->handling_cost > 0 ? get_formated_price_value($cart->handling_cost) : getHandelingCostOf($cart->shop_id), ['id' => 'handling-cost' . $cart->id]) }}

        <h3 class="widget-title">{{ trans('theme.order_info') }}</h3>
        <ul class="shopping-cart-summary ">
          <li>
            <span>{{ trans('theme.item_count') }}</span>
            <span>{{ $cart->inventories_count }}</span>
          </li>

          @if (!$cart->is_digital)
            <li>
              <span>
                {{ trans('theme.quantity') }}
                {{-- <div class="small text-info"></div> --}}
              </span>
              <span>{{ $cart->quantity }}</span>
            </li>
          @endif

          <li>
            <span>{{ trans('theme.subtotal') }}</span>
            <span>{{ get_currency_prefix() }}
              <span id="summary-total{{ $cart->id }}" class="item-total{{ $cart->id }}">{{ number_format($cart->total, 2, '.', '') }}</span>{{ get_currency_suffix() }}
            </span>
          </li>

          @unless ($cart->is_digital)
            <li>
              <span>
                <a class="dynamic-shipping-rates" data-toggle="popover" data-cart="{{ $cart->id }}" data-options="{{ $shipping_options[$cart->id] }}" id="shipping-options{{ $cart->id }}" title="{{ trans('theme.shipping') }}">
                  <u>{{ trans('theme.shipping') }}</u>
                </a>
                <em id="summary-shipping-name{{ $cart->id }}" class="small text-muted"></em>
              </span>

              <span>{{ get_currency_prefix() }}
                <span id="summary-shipping{{ $cart->id }}">{{ number_format($cart->get_shipping_cost(), 2, '.', '') }}</span>{{ get_currency_suffix() }}
              </span>
            </li>

            @if (is_incevio_package_loaded('packaging'))
              @unless (empty(json_decode($packaging_options)))
                <li>
                  <span>
                    <a class="packaging-options" data-toggle="popover" data-cart="{{ $cart->id }}" data-options="{{ $packaging_options }}" title="{{ trans('theme.packaging') }}">
                      <u>{{ trans('theme.packaging') }}</u>
                    </a>

                    <em class="small text-muted" id="summary-packaging-name{{ $cart->id }}">
                      {{ optional($default_packaging)->name }}
                    </em>
                  </span>

                  <span>{{ get_currency_prefix() }}
                    <span id="summary-packaging{{ $cart->id }}">
                      {{ number_format($default_packaging ? get_formated_price_value($default_packaging->cost) : 0, 2, '.', '') }}
                    </span>{{ get_currency_suffix() }}
                  </span>
                </li>
              @endunless
            @endif
          @endunless

          <li id="discount-section-li{{ $cart->id }}" style="display: {{ $cart->discount > 0 ? 'block' : 'none' }};">
            <span>{{ trans('theme.discount') }}
              <em id="summary-discount-name{{ $cart->id }}" class="small text-muted">{{ $cart->coupon ? $cart->coupon->name . ' (' . $cart->coupon->getFormatedAmountText() . ')' : '' }}</em>
            </span>

            <span>-{{ get_currency_prefix() }}
              <span id="summary-discount{{ $cart->id }}">{{ $cart->coupon ? number_format($cart->discount, 2, '.', '') : number_format(0, 2, '.', '') }}</span>{{ get_currency_suffix() }}
            </span>
          </li>

          <li id="tax-section-li{{ $cart->id }}" style="display: {{ $cart->taxes > 0 ? 'block' : 'none' }};">
            <span>{{ trans('theme.taxes') }}</span>

            <span>{{ get_currency_prefix() }}
              <span id="summary-taxes{{ $cart->id }}">{{ number_format($cart->taxes, 2, '.', '') }}</span>{{ get_currency_suffix() }}
            </span>
          </li>

          <li>
            <span>{{ trans('theme.total') }}</span>

            <span>{{ get_currency_prefix() }}
              <span id="summary-grand-total{{ $cart->id }}">{{ number_format($cart->calculate_grand_total(), 2, '.', '') }}</span>{{ get_currency_suffix() }}
            </span>
          </li>
        </ul>

        @if ($trust_badge = get_trust_badge_url())
          <div class="my-4">
            <img src="{{ $trust_badge }}" />
          </div>
        @endif

        <div class="text-center mb-3 d-flex justify-content-around">
          <a class="btn btn-primary py-2 px-4" href="{{ route('cart.index') }}">
            {{ trans('theme.button.update_cart') }}
          </a>

          <a class="btn btn-primary py-2 px-4" href="{{ url('/') }}">
            {{ trans('theme.button.continue_shopping') }}
          </a>
        </div>
      </div> <!-- /.col-md-3 -->

      <div class="col-md-5 py-2 px-4 border-r">
        <h3 class="widget-title">
          @if ($cart->is_digital)
            {{ trans('theme.billing_address') }}:
          @else
            <i class="far fa-shipping-fast"></i> {{ trans('theme.ship_to') }}
          @endif

          {{-- <em class="text-primary text-italic">
              @if ($cart->ship_to_state_id)
                {{ $cart->state->name }}
              @elseif($cart->ship_to_country_id)
                {{ $cart->country->name }}
              @endif
            </em> --}}
        </h3>

        @if (isset($customer))
          <div class="row customer-address-list">
            @php
              $pre_select = null;
            @endphp

            @foreach ($customer->addresses as $address)
              @php
                $ship_to_this_address = null;
                
                // If any address not selected yet
                if ($pre_select == null) {
                    if ($customer->addresses->count() == 1) {
                        // Has onely address
                        $pre_select = 1;
                        $ship_to_this_address = true;
                    } elseif (Request::has('address')) {
                        // Just created this address
                        if (Request::get('address') == $address->id) {
                            $pre_select = 1;
                            $ship_to_this_address = true;
                        }
                    } elseif ($cart->ship_to_country_id == $address->country_id && $cart->ship_to_state_id == $address->state_id) {
                        // Zone selected at cart page
                        $pre_select = 1;
                        $ship_to_this_address = true;
                    } elseif ($cart->ship_to == null && $address->address_type === 'Shipping') {
                        // Customer's shipping address
                        $pre_select = 1;
                        $ship_to_this_address = true;
                    }
                }
              @endphp

              <div class="col-sm-12 col-md-6 p-0-{{ $loop->iteration % 2 == 1 ? 'right' : 'left' }}">
                <div class="address-list-item {{ $ship_to_this_address == true ? 'selected' : '' }}">
                  {!! $address->toHtml('<br/>', false) !!}
                  <input type="radio" class="ship-to-address" name="ship_to" value="{{ $address->id }}" {{ $ship_to_this_address == true ? 'checked' : '' }} data-country="{{ $address->country_id }}" data-state="{{ $address->state_id }}" required>
                </div>
              </div>

              @if ($loop->iteration % 2 == 0)
                <div class="clearfix"></div>
              @endif
            @endforeach
          </div>

          {{-- When the custoer has no address --}}
          {{-- @unless ($customer->addresses->count())
            @include('partials.address_form', ['countries' => $business_areas->pluck('name', 'id')])
          @endunless --}}

          <small id="ship-to-error-block" class="text-danger pull-right"></small>

          <div class="col-sm-12 my-3">
            <a href="{{ route('my.address.create') }}" class="modalAction btn btn-default btn-sm pull-right">
              <i class="fas fa-address-card-o"></i> @lang('theme.button.add_new_address')
            </a>
          </div>
        @else
          @include('partials.checkout_shiping_address')
        @endif

        <hr class="dotted" />

        @if (is_incevio_package_loaded('pharmacy'))
          @include('pharmacy::checkout_form')
        @endif

        <div class="form-group">
          {!! Form::label('buyer_note', trans('theme.leave_message_to_seller'), ['class' => 'buyer_note']) !!}
          {!! Form::textarea('buyer_note', null, ['class' => 'form-control summernote-without-toolbar', 'placeholder' => trans('theme.placeholder.message_to_seller'), 'rows' => '2', 'maxlength' => '250']) !!}
          <div class="help-block with-errors"></div>
        </div>
      </div> <!-- /.col-md-5 -->

      <div class="col-md-3 cart-payment-options py-2">
        @include('partials.payment_options')
      </div> <!-- /.col-md-4 -->
    </div><!-- /.row -->
    {!! Form::close() !!}
  </div>
</section>

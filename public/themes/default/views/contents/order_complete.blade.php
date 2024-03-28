<section>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <p class="lead">@lang('theme.notify.order_placed_thanks')</p>

        {{-- need to simplify redundency --}}
        @if (isset($orders) && is_array($orders))
          @foreach ($orders as $order)
            @php
              $payment_instructions = null;
              if (optional($order->paymentMethod)->type == \App\Models\PaymentMethod::TYPE_MANUAL) {
                  if (vendor_get_paid_directly()) {
                      $payment_method = $order->shop->config->manualPaymentMethods->where('id', $order->payment_method_id)->first();
              
                      $payment_instructions = optional($payment_method)->pivot->payment_instructions;
                  } else {
                      $payment_instructions = get_from_option_table('wallet_payment_info_' . $order->paymentMethod->code);
                  }
              }
            @endphp

            @if ($payment_instructions)
              <p class="text-primary mb-4">
                <strong>@lang('theme.payment_instruction'): </strong>
                {!! $payment_instructions !!}
              </p>
            @elseif(!$order->isPaid())
              <p class="text-danger mb-4">
                <strong>@lang('theme.payment_status'): </strong> {!! $order->paymentStatusName() !!}
              </p>
            @endif

            @if ($order->is_digital)
              <p class="my-4">
                @if (\Auth::guard('customer')->check())
                  @lang('messages.download_link_loggedin_customer')
                @else
                  @lang('messages.download_link_guest_customer')
                @endif
              </p>

              @foreach ($order->inventories as $item)
                <h3>{{ trans('theme.donwload_links_of') . ': ' . $item->title }}</h3>

                <ul class="my-3">
                  @foreach ($item->attachments as $attachment)
                    <li>
                      {{ route('order.attachment.download', ['attachment' => $attachment, 'order' => $order->id, 'inventory' => $item->id]) }}

                      <button class="btn btn-sm ml-3" onclick="navigator.clipboard.writeText('{{ route('order.attachment.download', ['attachment' => $attachment, 'order' => $order->id, 'inventory' => $item->id]) }}')">{{ trans('theme.copy_to_clipboard') }}</button>
                    </li>
                  @endforeach
                </ul>
              @endforeach
            @else
              @if ($order->pickup())
                @php
                  $warehouseIds = [];
                @endphp

                @foreach ($order->inventories as $key => $inventory)
                  @if (!empty($inventory->warehouse))
                    @if (!in_array($inventory->warehouse_id, $warehouseIds))
                      @php
                        $warehouseIds[] = $inventory->warehouse_id;
                      @endphp

                      <p class="small mb-1" style="margin-top: 10px"><i class="fas fa-info-circle"></i>
                        {{ trans('theme.notify.business_days') }}: <em>{{ $inventory->warehouse->business_days }}</em>
                      </p>

                      <p class="small mb-1"><i class="fas fa-info-circle"></i>
                        {{ trans('theme.notify.availability') }}: <em>{{ $inventory->warehouse->opening_time }} - {{ $inventory->warehouse->close_time }}</em>
                      </p>

                      <p class="small mb-1"><i class="fas fa-info-circle"></i>
                        {{ trans('theme.notify.order_number') }}: <em>{{ $order->order_number }}</em>
                      </p>

                      <p class="small mb-1"><i class="fas fa-info-circle"></i>
                        {{ trans('theme.notify.pick_up_order_from') }}: <br />
                        <em>{!! address_str_to_html($inventory->warehouse->address->toString()) !!}</em>
                      </p>
                    @endif
                  @endif
                @endforeach
              @else
                <p>
                  <i class="fas fa-info-circle"></i>
                  {{ trans('theme.notify.order_will_ship_to') }}: <em>{!! $order->shipping_address !!}</em>
                </p>
              @endif
            @endif

            <p class="lead text-center my-5">
              @if ($loop->last)
                <a class="btn btn-primary" href="{{ url('/') }}">{{ trans('theme.button.continue_shopping') }}</a>
              @endif

              @if (\Auth::guard('customer')->check())
                <a class="btn btn-default" href="{{ route('order.detail', $order) }}">@lang('theme.button.order_detail')</a>
              @endif
            </p>
          @endforeach
        @else
          @php
            $payment_instructions = null;
            if (optional($order->paymentMethod)->type == \App\Models\PaymentMethod::TYPE_MANUAL) {
                if (vendor_get_paid_directly()) {
                    $payment_method = $order->shop->config->manualPaymentMethods->where('id', $order->payment_method_id)->first();
            
                    $payment_instructions = optional($payment_method)->pivot->payment_instructions;
                } else {
                    $payment_instructions = get_from_option_table('wallet_payment_info_' . $order->paymentMethod->code);
                }
            }
          @endphp

          @if ($payment_instructions)
            <p class="text-primary mb-4">
              <strong>@lang('theme.payment_instruction'): </strong>
              {!! $payment_instructions !!}
            </p>
          @elseif(!$order->isPaid())
            <p class="text-danger mb-4">
              <strong>@lang('theme.payment_status'): </strong> {!! $order->paymentStatusName() !!}
            </p>
          @endif

          @if ($order->is_digital)
            <p class="my-4">
              @if (\Auth::guard('customer')->check())
                @lang('messages.download_link_loggedin_customer')
              @else
                @lang('messages.download_link_guest_customer')
              @endif
            </p>

            @foreach ($order->inventories as $item)
              <h3>{{ trans('theme.donwload_links_of') . ': ' . $item->title }}</h3>

              <ul class="my-3">
                @foreach ($item->attachments as $attachment)
                  <li>
                    {{ route('order.attachment.download', ['attachment' => $attachment, 'order' => $order->id, 'inventory' => $item->id]) }}

                    <button class="btn btn-sm ml-3" onclick="navigator.clipboard.writeText('{{ route('order.attachment.download', ['attachment' => $attachment, 'order' => $order->id, 'inventory' => $item->id]) }}')">{{ trans('theme.copy_to_clipboard') }}</button>
                  </li>
                @endforeach
              </ul>
            @endforeach
          @else
            @if ($order->pickup())
              @php
                $warehouseIds = [];
              @endphp

              @foreach ($order->inventories as $key => $inventory)
                @if (!empty($inventory->warehouse))
                  @if (!in_array($inventory->warehouse_id, $warehouseIds))
                    @php
                      $warehouseIds[] = $inventory->warehouse_id;
                    @endphp

                    <p class="small mb-1" style="margin-top: 10px"><i class="fas fa-info-circle"></i>
                      {{ trans('theme.notify.business_days') }}: <em>{{ $inventory->warehouse->business_days }}</em>
                    </p>
                    <p class="small mb-1"><i class="fas fa-info-circle"></i>
                      {{ trans('theme.notify.availability') }}: <em>{{ $inventory->warehouse->opening_time }} - {{ $inventory->warehouse->close_time }}</em>
                    </p>
                    <p class="small mb-1"><i class="fas fa-info-circle"></i>
                      {{ trans('theme.notify.order_number') }}: <em>{{ $order->order_number }}</em>
                    </p>
                    <p class="small mb-1"><i class="fas fa-info-circle"></i>
                      {{ trans('theme.notify.pick_up_order_from') }}: <br />
                      <em>{!! address_str_to_html($inventory->warehouse->address->toString()) !!}</em>
                    </p>
                  @endif
                @endif
              @endforeach
            @else
              <p>
                <i class="fas fa-info-circle"></i>
                {{ trans('theme.notify.order_will_ship_to') }}: <em>{!! $order->shipping_address !!}</em>
              </p>
            @endif
          @endif

          <p class="lead text-center my-5">
            <a class="btn btn-primary " href="{{ url('/') }}">{{ trans('theme.button.continue_shopping') }}</a>

            @if (\Auth::guard('customer')->check())
              <a class="btn btn-default " href="{{ route('order.detail', $order) }}">@lang('theme.button.order_detail')</a>
            @endif
          </p>
        @endif
      </div><!-- /.col-md-8 -->
    </div><!-- /.row -->
  </div> <!-- /.container -->
</section>

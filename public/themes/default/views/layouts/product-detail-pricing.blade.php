<div class="row">
  <div class="col-6 product-info-price pr-1">
    <span class="product-info-price-new">
      {!! get_formated_currency($item->current_sale_price(), config('system_settings.decimals', 2)) !!}
    </span>

    @if ($item->hasOffer())
      <span class="old-price">
        {!! get_formated_currency($item->sale_price, config('system_settings.decimals', 2)) !!}
      </span>
    @endif
  </div>

  @if ($item->sold_quantity > 0)
    <div class="col-6 pl-1">
      <div class="sold-qtt-progress">
        <div class="progress">
          <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width:{{ $item->product->downloadable ? 90 : ($item->sold_quantity / $item->stock_quantity) * 100 }}%;" aria-valuenow="{{ $item->sold_quantity }}" aria-valuemin="0" aria-valuemax="{{ $item->product->downloadable ? 90 : $item->stock_quantity }}"></div>

          <span class="sold-qtt-label">
            {{ trans('theme.qtt_sold_of', ['sold' => $item->sold_quantity, 'qtt' => $item->stock_quantity]) }}
          </span>
        </div> <!-- /.progress -->
      </div> <!-- /.sold-qtt-progress -->
    </div>
  @endif
</div>

{{-- <ul class="product-info-feature-labels">
    @foreach ($item->getLabels() as $label)
        <li>{!! $label !!}</li>
    @endforeach
</ul> --}}

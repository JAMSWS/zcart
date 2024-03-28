@if (count($featured_vendors))
  <section>
    <div class="product-type pt-3">
      <div class="container-fluid">
        <div class="product-type-inner">
          <div class="row">
            @foreach ($featured_vendors as $featured_vendor)
              <div class="col-md-4 col-12">
                <div class="product-list-col">
                  <div class="product-list-col-header">
                    <div class="sell-header">
                      <div class="mr-3">
                        <h2>
                          <img class="lazy brand-logo" src="{{ get_storage_file_url(optional($featured_vendor->logoImage)->path, 'tyni') }}" data-src="{{ get_storage_file_url(optional($featured_vendor->logoImage)->path, 'full') }}" class="seller-info-logo mb-1" alt="{{ trans('theme.logo') }}">
                        </h2>
                      </div>

                      <div class="header-line">
                        <span></span>
                      </div>

                      <div class="sell-header-title mx-3">
                        <a href="{{ route('show.store', $featured_vendor->slug) }}" class="seller-info-name" targer="_blank">
                          {!! $featured_vendor->getQualifiedName() !!}
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="product-list-col-product">

                    @include('theme::partials._product_vertical', ['products' => $featured_vendor->inventories->take(5)])

                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
@endif

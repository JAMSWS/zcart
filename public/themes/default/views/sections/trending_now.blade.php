@if (count($trending_categories))
  <section>
    <div class="feature">
      <div class="container-fluid">
        <div class="feature-inner">
          <div class="feature-header">
            <div class="sell-header">
              <div class="sell-header-title">
                <h2 class="mr-3">
                  {!! trans('theme.trending_now') !!}
                  <i class="fal fa-fire-alt"></i>
                </h2>
              </div>

              <div class="feature-tabs">
                <ul>
                  @foreach ($trending_categories as $trendingCat)
                    <li class="{{ $loop->first ? 'active' : '' }}">
                      <a href="#trending-{{ $trendingCat->slug }}">
                        {{ $trendingCat->name }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div> <!-- /.feature-tabs -->

              <div class="header-line">
                <span></span>
              </div>

              <div class="best-deal-arrow">
                {{-- <ul>
                  <li><button class="left-arrow slider-arrow slick-arrow feature-left1"><i class="fal fa-chevron-left"></i></button></li>
                  <li><button class="right-arrow slider-arrow slick-arrow feature-right1"><i class="fal fa-chevron-right"></i></button></li>
                </ul> --}}
              </div>
            </div> <!-- /.sell-header -->
          </div> <!-- /.feature-header -->

          <div class="feature-items">
            @foreach ($trending_categories as $trendingCat)
              <div class="feature-items-inner" id="trending-{{ $trendingCat->slug }}">
                @include('theme::partials._product_horizontal', ['products' => $trendingCat->listings])
              </div>
            @endforeach
          </div> <!-- /.feature-items -->
        </div>
      </div>
    </div>
  </section>
@endif

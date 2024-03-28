@isset($recent)
  <section>
    <div class="neckbands">
      <div class="container-fluid">
        <div class="neckbands-inner">
          <div class="neckbands-header">
            <div class="sell-header">
              <div class="sell-header-title">
                <h2>{{ trans('theme.recently_added') }}</h2>
              </div>

              <div class="header-line">
                <span></span>
              </div>

              <div class="best-deal-arrow">
                <ul>
                  <li><button class="left-arrow slider-arrow slick-arrow neckbands-left"><i class="fal fa-chevron-left"></i></button></li>
                  <li><button class="right-arrow slider-arrow slick-arrow neckbands-right"><i class="fal fa-chevron-right"></i></button></li>
                </ul>
              </div>
            </div>
          </div> <!-- /.neckbands-header -->

          <div class="neckbands-items">
            <div class="neckbands-items-inner">
              @include('theme::partials._product_horizontal', ['products' => $recent, 'ratings' => 1])
            </div>
          </div> <!-- /.neckbands-items -->
        </div> <!-- /.neckbands-inner -->
      </div> <!-- /.container -->
    </div> <!-- /.neckbands -->
  </section>
@endisset

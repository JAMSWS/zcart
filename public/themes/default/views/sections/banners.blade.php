<section>
  <div class="container-fluid mt-3 mb-md-0">
    <div class="row">
      @foreach ($banners as $banner)
        <div class="col-lg-{{ $banner['columns'] }} col-12 mb-2 mb-md-0">
          <a href="{{ $banner['link'] }}">
            <div class="image-banner {{ $banner['columns'] > 11 ? 'single-banner' : '' }}">
              <div class="banner-box {{ !empty($banner['effect']) ? 'outline-effect' : '' }}">
                @if (isset($banner['feature_image']['path']) && Storage::exists($banner['feature_image']['path']))
                  <img class="lazy" src="{{ $banner['group_id'] == 'group_1' || $banner['columns'] == '12' ? get_storage_file_url($banner['feature_image']['path'], 'tiny') : '/images/loading.webp' }}" data-src="{{ get_storage_file_url($banner['feature_image']['path'], 'full') }}" alt="{{ $banner['title'] ?? 'Banner Image' }}" title="{{ $banner['title'] ?? 'Banner Image' }}">
                @else
                  <img src="{{ get_storage_file_url() }}" alt="{{ $banner['title'] ?? 'Banner Image' }}" title="{{ $banner['title'] ?? 'Banner Image' }}">
                @endif

                <div class="banner-overlay">
                  <div class="banner-texts">
                    <div class=banner-overlay-title>
                      <h3>{!! $banner['title'] !!}</h3>
                    </div>

                    <div class="banner-overlay-text">
                      <p>{!! $banner['description'] !!}</p>
                    </div>
                  </div>

                  @if ($banner['link_label'])
                    <div class="neckbands-button">
                      <span>
                        {!! $banner['link_label'] ? $banner['link_label'] . ' <i class="fas fa-caret-right"></i>' : '' !!}
                      </span>
                    </div>
                  @endif

                  {{-- <div class="banner-overlay-price-text">
                      <p>STARTING FROM</p>
                      <h3>$399,00</h3>
                    </div> --}}
                </div> <!-- /.banner-overlay -->
              </div> <!-- /.banner-box -->
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

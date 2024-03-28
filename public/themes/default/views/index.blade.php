@extends('theme::layouts.main')

@section('content')
  <!-- MAIN SLIDER -->
  @desktop
    @include('theme::sections.slider')
  @elsedesktop
    @include('theme::sections.slider_mobile')
  @enddesktop

  <!-- Banner grp one -->
  @if (!empty($banners['group_1']))
    @include('theme::sections.banners', ['banners' => $banners['group_1']])
  @endif

  <!-- Featured category stat -->
  @include('theme::sections.featured_category-new')

  <!-- Flash deals -->
  @include('theme::sections.flash_deals')

  <!-- Banner grp two -->
  @if (!empty($banners['group_2']))
    @include('theme::sections.banners', ['banners' => $banners['group_2']])
  @endif

  <!-- Trending start -->
  @include('theme::sections.trending_now')


  <!-- Deal of Day start -->
  @include('theme::sections.deal_of_the_day')

  <!-- Banner grp three -->
  @if (!empty($banners['group_3']))
    @include('theme::sections.banners', ['banners' => $banners['group_3']])
  @endif

  <!-- Recently Added -->
  @include('theme::sections.recently_added')

  <!-- Banner grp four -->
  @if (!empty($banners['group_4']))
    @include('theme::sections.banners', ['banners' => $banners['group_4']])
  @endif

  <!-- Bundle start -->
  {{-- @include('theme::sections.bundle_offer') --}}

  <!-- Featured vendors start -->
  @include('theme::sections.featured_vendors')

  <!-- Feature brand start -->
  @include('theme::sections.featured_brands')

  <!-- Popular Product type start -->
  {{--  @include('theme::sections.popular') --}}

  <!-- Additional Items -->
  @include('theme::sections.additional_items')

  <!-- Banner grp five -->
  @if (!empty($banners['group_5']))
    @include('theme::sections.banners', ['banners' => $banners['group_5']])
  @endif

  <!-- Best finds under $99 deals start -->
  @include('theme::sections.best_finds')

  <!-- Banner grp six -->
  @if (!empty($banners['group_6']))
    @include('theme::sections.banners', ['banners' => $banners['group_6']])
  @endif

  <!-- Best selling Now   -->
  {{-- @include('theme::sections.best_selling') --}}

  <!-- Recently Viewed -->
  @include('theme::sections.recent_views')

  <!-- Dynamic Popup -->
  @if (is_incevio_package_loaded('dynamic-popup'))
    @include('DynamicPopup::popup_modal')
  @endif
@endsection

@section('scripts')
  <script src="{{ theme_asset_url('js/eislideshow.js') }}"></script>
  <script type="text/javascript">
    // Main slider
    $('#ei-slider').eislideshow({
      animation: 'center',
      autoplay: true,
      slideshow_interval: 4000,
    });

    // $("#top_vendors").slick({
    //   slidesToShow: 3,
    //   slidesToScroll: 1,
    //   autoplay: true,
    //   autoplaySpeed: 2000,
    // });

    // Trending now tabs
    $(function() {
      $('.feature-tabs a').click(function() {
        let targetDom = $(this).attr('href');

        // Display active tab
        $('.feature-items .feature-items-inner').hide();
        $(targetDom).show();

        $(targetDom).slick('refresh');

        // Check for active
        $('.feature-tabs li').removeClass('active');
        $(this).parent().addClass('active');

        return false;
      });
    });

    // Owl Sliders    
    $('.owl-carousel').owlCarousel({
      loop: true,
      lazyLoad: true,
      dots: false,
      margin: 10,
      smartSpeed: 900,
      autoHeight: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      nav: true,
      responsive: {
        0: {
          items: 3
        },
        576: {
          items: 4
        },
        992: {
          items: 6
        },
        1400: {
          items: 7
        },
        1600: {
          items: 8
        }
      }
    })
  </script>

  <!-- Flash deals script -->
  @include('scripts.flash_deal')

  <!-- Dynamic Popup -->
  @if (is_incevio_package_loaded('dynamic-popup'))
    @include('DynamicPopup::scripts')
  @endif
@endsection

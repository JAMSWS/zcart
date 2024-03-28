@extends('theme::layouts.main')

@section('content')
  <!-- CONTENT SECTION -->
  <div class="row">
    <div class="cover-img-wrapper">
      <img class="lazy w-100" src="{{ get_cover_img_src($brand, 'brand', 'cover_thumb') }}" data-src="{{ get_cover_img_src($brand, 'brand') }}">
    </div>
  </div>

  <div class="row" id="profile-container">
    <div class="col-12 mb-4">
      <div class="row profile-header border">
        <div class="col-md-2 col-sm-4 col-xs-12 text-center my-3">
          <div class="d-flex thumbnail rounded-circle justify-content-center align-items-center mx-auto p-2">
            <img class="lazy" src="{{ get_storage_file_url(optional($brand->logoImage)->path, 'tiny_thumb') }}" data-src="{{ get_storage_file_url(optional($brand->logoImage)->path, 'logo_square') }}" alt="{{ $brand->name }}">
          </div>
        </div>

        <div class="col-md-10 col-sm-8 col-xs-12 profile-info">
          <div class="header-fullname">{{ $brand->name }}</div>

          <div class="small">
            {{ trans('theme.listed_at') . ' ' . $brand->created_at->toFormattedDateString() }}
          </div>

          <span class="seller-location">
            <i class="fa fa-map-marker"></i> {!! optional($brand->country)->name !!}
          </span>

          {{-- <a href="javascript:void(0);" class="btn btn-default btn-sm contact-seller-btn" data-toggle="modal" data-target="{{ Auth::guard('customer')->check() ? '#latest_reviewsellerModal' : '#loginModal' }}">
          <i class="far fa-envelope"></i> @lang('theme.button.contact_seller')
        </a> --}}

          <div class="header-information show-hide-content mb-0 less">
            {!! $brand->description !!}
          </div>
          <a href="javascript::void(0)" class="small show-hide-content-btn">
            {{ trans('theme.show_more') }} <i class="fa fa-angle-down"></i>
          </a>
        </div>
      </div> <!-- /.profile-header -->
    </div>
  </div>

  <section>
    <div class="container-fluid">
      @include('theme::contents.product_list', ['colum' => 3])
    </div><!-- /.container -->
  </section>

  <!-- BROWSING ITEMS -->
  @include('theme::sections.recent_views')
@endsection

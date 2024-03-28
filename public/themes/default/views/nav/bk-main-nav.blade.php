<div class="container mt-5">
  <div class="header-main-inner">
    <div class="header-menu-icon">
      <div class="menu-icon">
        <a class="main-menu-toggle" href="javascript:void(0);"><i class="fal fa-bars"></i></a>
      </div>
    </div>

    <div class="header-logo mr-3">
      <a href="{{ url('/') }}">
        <img src="{{ get_logo_url('system', 'logo') }}" class="brand-logo" alt="{{ trans('theme.logo') }}" title="{{ trans('theme.logo') }}">
      </a>
    </div>

    <!-- Customer Care -->
    {{-- <div class="d-none d-xl-block col-md-auto"> --}}
    {{-- <div class="d-flex"> --}}
    {{-- <i class="fal fa-user-headset fa-3x"></i> --}}
    {{-- <div class="ml-2"> --}}
    {{-- <div class="phone"> --}}
    {{-- <strong>{{ trans('theme.support') }}:</strong> <a href="tel:{{ config('system_settings.support_phone') }}" class="text-info">{{ config('system_settings.support_phone') }}</a> --}}
    {{-- </div> --}}
    {{-- <div class="email"> --}}
    {{-- {{ trans('theme.email') }}: <a href="mailto:{{ config('system_settings.support_email') }}" class="text-info"> --}}
    {{-- {{ config('system_settings.support_email') }} --}}
    {{-- </a> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    <!-- End Customer Care -->

    <div class="header-search ml-lg-2">
      {{-- Trending Keywords --}}
      @if (is_incevio_package_loaded('trendingKeywords'))
        <div class="text-center mb-1">
          @include('trendingKeywords::_keyword_lists')
        </div>
      @endif

      {!! Form::open(['route' => 'inCategoriesSearch', 'method' => 'GET', 'id' => 'search-categories-form', 'class' => 'navbar-left navbar-search mb-1', 'role' => 'search']) !!}
      <div class="search-box header-search-border-color">
        <div class="search-box-select d-none d-sm-block">
          <i class="fas fa-caret-down"></i>
          <select class="category search-category-select" name="insubgrp">
            <option value="all">{{ trans('theme.all_categories') }}</option>
            @foreach ($search_category_list as $search_category_grp)
              <optgroup label="{{ $search_category_grp->name }}">
                @foreach ($search_category_grp->subGroups as $search_category)
                  <option value="{{ $search_category->slug }}" {{ Request::get('insubgrp') == $search_category->slug ? 'selected' : '' }}>
                    {{ $search_category->name }}
                  </option>
                @endforeach
              </optgroup>
            @endforeach
          </select>
        </div> <!-- /.search-box-select -->

        <div class="search-box-input">
          {!! Form::text('q', Request::get('q'), ['id' => 'autoSearchInput', 'placeholder' => trans('theme.main_searchbox_placeholder'), 'autocomplete' => 'off', 'data-search']) !!}
        </div>

        <div class="search-box-button">
          <button type="submit" class="navbar-search-submit">
            <i class="fal fa-search"></i>
          </button>
        </div>

        {{-- Search Autocomplete package load --}}
        @if (is_incevio_package_loaded('searchAutocomplete'))
          @include('searchAutocomplete::_autoComplete')
        @endif
      </div>
      {!! Form::close() !!}

      <p id="search-nav-feedabck" class="pl-4 text-danger small hide">{{ trans('theme.type_min_char', ['min' => 3]) }}</p>
    </div>

    <div class="header-utility ml-md-4">
      <ul>
        <li>
          <a href="{{ route('account', 'account') }}">
            <i class="fal fa-user" data-toggle="tooltip" data-placement="top" title="{{ trans('theme.your_account') }}"></i>
            <!-- <img src="images/big-user.svg" alt=""> -->
          </a>
        </li>

        @if (is_incevio_package_loaded('comparison'))
          @php
            $comparison_item = !empty(Session::get('comparables')) ? count(Session::get('comparables')) : 0;
          @endphp
          <li>
            <a href="{{ route('product.comparables') }}">
              <i class="fal fa-balance-scale" data-toggle="tooltip" data-placement="top" title="{{ trans('theme.your_comparisons') }}"></i>
              {{-- <i class="far fa-repeat-alt"></i> --}}
              {{-- <i class="fal fa-balance-scale-right"></i> --}}
              <span id="globalCompareItemCount" class="badge {{ $comparison_item == 0 ? 'hidden' : '' }}">{{ $comparison_item }}</span>
            </a>
          </li>
        @endif

        <li>
          <a href="{{ route('account', 'wishlist') }}">
            <i class="fal fa-heart" data-toggle="tooltip" data-placement="top" title="{{ trans('theme.your_wishlist') }}"></i>
            <span id="globalWishlistItemCount" class="badge {{ $wishlist_item_count == 0 ? 'hidden' : '' }}">{{ $wishlist_item_count }}</span>
            <!-- <img src="images/big-heart.svg" alt=""> -->
            {{-- <span class="badge">2</span> --}}
          </a>
        </li>

        <li>
          <a href="{{ route('cart.index') }}">
            <i class="fal fa-shopping-cart" data-toggle="tooltip" data-placement="top" title="{{ trans('theme.your_cart') }}"></i>
            <!-- <img src="images/shopping-bag.svg" alt=""> -->
            <span id="globalCartItemCount" class="badge {{ $cart_item_count == 0 ? 'hidden' : '' }}">{{ $cart_item_count }}</span>
          </a>
        </li>

        {{-- <li>
              <a href="#">
                <i class="fas fa-wallet"></i>
                <!-- <img src="images/wal.svg" alt=""> -->
                <span>$159.00</span>
              </a>
            </li> --}}
      </ul>
    </div>

    {{-- @if (is_incevio_package_loaded('trendingKeywords'))
          <div class="ml-md-2">
            @include('trendingKeywords::_keyword_lists')
          </div>
        @endif --}}

  </div>
</div>

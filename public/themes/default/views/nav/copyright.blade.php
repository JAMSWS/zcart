<div class="copyright-area">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <ul class="links-list">
          @foreach ($pages->where('position', 'copyright_area') as $page)
            <li><a href="{{ get_page_url($page->slug) }}" target="_blank" rel="noopener">{{ $page->title }}</a></li>
          @endforeach

          <li><a href="{{ url('admin/dashboard') }}">{{ trans('theme.nav.merchant_dashboard') }}</a></li>
          <li class="copyright-text">© {{ date('Y') }} <a href="{{ url('/') }}">{{ get_platform_title() }}</a></li>
        </ul>
      </div>
    </div>
  </div>
</div> <!-- /.copyright-area -->

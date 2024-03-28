<section>
  <div id="all-categories-wrapper" class="container-fluid">
    <div class="row">
      @foreach ($all_categories as $categoryGroup)
        @if ($categoryGroup->subGroups->count())
          <div class="col-12 mb-3 pt-4 pb-3 category-grp-wrapper ">
            <h2 class="mb-1">
              <a href="{{ route('categories') }}" class="border-x">
                {{ $categoryGroup->name }}
              </a>
            </h2>

            <div class="row px-3">
              @foreach ($categoryGroup->subGroups as $subGroup)
                <div class="col-6 col-md-4 col-lg-3 pl-1 pr-3 my-2">
                  <h3 class="nav-category-inner-title my-1">
                    <a href="{{ route('categories.browse', $subGroup->slug) }}">{{ $subGroup->name }}</a>
                  </h3>

                  <ul class="nav-category-inner-list show-hide-content less">
                    @foreach ($subGroup->categories as $cat)
                      <li>
                        <a href="{{ route('category.browse', $cat->slug) }}">{{ $cat->name }}</a>
                      </li>
                    @endforeach
                  </ul>

                  @if ($subGroup->categories->count() > 3)
                    <a href="javascript::void(0)" class="small show-hide-content-btn">
                      {{ trans('theme.show_more') }} <i class="fa fa-angle-down"></i>
                    </a>
                  @endif
                </div><!-- /.col-3 -->
              @endforeach
            </div> <!-- /.row -->
          </div><!-- /.col-12 -->
        @endif
      @endforeach
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</section>

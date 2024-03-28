<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\System;
use App\Models\Category;
use App\Models\Inventory;
use App\Helpers\ListHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Validations\UpdateBestFindsRequest;
use App\Http\Requests\Validations\UpdateFeaturedCategories;
use App\Http\Requests\Validations\UpdateDealOfTheDayRequest;
use App\Http\Requests\Validations\UpdateFeaturedItemsRequest;
use App\Http\Requests\Validations\UpdateFeaturedBrandsRequest;
use App\Http\Requests\Validations\UpdateFeaturedVendorsRequest;
use App\Http\Requests\Validations\UpdateMainNavCategoryRequest;
use App\Http\Requests\Validations\UpdatePromotionalTaglineRequest;
use App\Http\Requests\Validations\UpdateTrendingNowCategoryRequest;

class PromotionsController extends Controller
{
    // use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.promotions.options');
    }

    /**
     * Show the form for deal of the day.
     * @return \Illuminate\Http\Response
     */
    public function editDealOfTheDay()
    {
        $id = get_from_option_table('deal_of_the_day' . Auth::user()->shop_id);

        $item = Inventory::where('id', $id)->first();

        return view('admin.promotions._edit_deal_of_the_day', compact('item'));
    }

    /**
     * Update deal of the day.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDealOfTheDay(UpdateDealOfTheDayRequest $request)
    {
        $field = 'deal_of_the_day' . Auth::user()->shop_id;

        if (update_or_create_option_table_record($field, $request->item_id)) {
            // Clear deal_of_the_day from cache
            Cache::forget($field);

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.updated_deal_of_the_day'));
        }

        return redirect()->route('admin.promotions')->with('error', trans('messages.failed'));
    }

    /**
     * Edit Featured Products
     *
     * @return \Illuminate\Http\Response
     */
    public function editFeaturedItems()
    {
        $featured_items = ListHelper::featured_items(Auth::user()->shop_id);

        return view('admin.promotions._edit_featured_items', compact('featured_items'));
    }

    /**
     * Update Featured Products
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFeaturedItems(UpdateFeaturedItemsRequest $request)
    {
        $field = 'featured_items' . Auth::user()->shop_id;

        if (update_or_create_option_table_record($field, $request->featured_items)) {
            // Clear featured_items from cache
            Cache::forget($field);

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.featured_items_updated'));
        }

        return redirect()->route('admin.promotions')->with('error', trans('messages.failed'));
    }

    /**
     * Show the form for featuredCategories.
     * @return \Illuminate\Http\Response
     */
    public function editFeaturedBrands()
    {
        $brands = ListHelper::manufacturers();

        $featured_brands = ListHelper::featured_brands();

        return view('admin.promotions._edit_featured_brands', compact('featured_brands', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFeaturedBrands(UpdateFeaturedBrandsRequest $request)
    {
        $update = DB::table(get_option_table_name())->updateOrInsert(
            ['option_name' => 'featured_brands'],
            [
                'option_name' => 'featured_brands',
                'option_value' => serialize($request->featured_brands),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        if ($update) {
            // Clear featured_brands from cache
            Cache::forget('featured_brands');

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.featured_brands_updated'));
        }

        return redirect()->route('admin.promotions')
            ->with('warning', trans('messages.failed'));
    }

    /**
     * Show the form for featuredCategories.
     * @return \Illuminate\Http\Response
     */
    public function editFeaturedVendors()
    {
        $vendors = ListHelper::shops();

        $featured_vendors = ListHelper::featured_vendors();

        return view('admin.promotions._edit_featured_vendors', compact('featured_vendors', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFeaturedVendors(UpdateFeaturedVendorsRequest $request)
    {
        $update = DB::table(get_option_table_name())->updateOrInsert(
            ['option_name' => 'featured_vendors'],
            [
                'option_name' => 'featured_vendors',
                'option_value' => serialize($request->featured_vendors),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        if ($update) {
            // Clear featured_vendors from cache
            Cache::forget('featured_vendors');

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.featured_vendors_updated'));
        }

        return redirect()->route('admin.promotions')
            ->with('warning', trans('messages.failed'));
    }

    /**
     * Show the form for featuredCategories.
     * @return \Illuminate\Http\Response
     */
    public function editFeaturedCategories()
    {
        $featured_categories = ListHelper::featured_categories()->toArray();

        return view('admin.promotions._edit_featured_categories', compact('featured_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFeaturedCategories(UpdateFeaturedCategories $request)
    {
        try {
            // Reset all featured categories
            Category::where('featured', true)->update(['featured' => null]);

            if ($featured_categories = $request->input('featured_categories')) {
                Category::whereIn('id', $featured_categories)->update(['featured' => true]);
            }

            // Clear featured_categories from cache
            Cache::forget('featured_categories');
        } catch (\Exception $e) {
            return redirect()->route('admin.promotions')->with('warning', $e->getMessage());
        }

        return redirect()->route('admin.promotions', '#settings-tab')
            ->with('success', trans('messages.updated_featured_categories'));
    }

    /**
     * Promotional Tagline
     * @return \Illuminate\Http\Response
     */
    public function editTagline()
    {
        $tagline = get_from_option_table('promotional_tagline', []);

        return view('admin.promotions._edit_tagline', compact('tagline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTagline(UpdatePromotionalTaglineRequest $request)
    {
        $data = [
            'text' => $request->text,
            'action_url' => $request->action_url,
        ];

        if (update_or_create_option_table_record('promotional_tagline', $data)) {
            // Clear promotional_tagline from cache
            Cache::forget('promotional_tagline');

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.updated_promotional_tagline'));
        }

        return redirect()->route('admin.promotions')->with('error', trans('messages.failed'));
    }

    /**
     * Promotional Top Bar
     * @return \Illuminate\Http\Response
     */
    public function editTopBanner()
    {
        $top_bar_banner = get_from_option_table('top_bar_banner');

        return view('admin.promotions._edit_top_banner', compact('top_bar_banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTopBanner(Request $request)
    {
        $request->validate([
            'top_bar_img' => 'image|mimes:jpeg,png,jpg|max:2048',
            'action_url' => 'nullable|string'
        ]);

        $data = get_top_bar_banner_data();
        $data['action_url'] = $request->action_url;

        if ($request->hasFile('top_bar_img')) {
            if (isset($data['img'])) {        // Delete the old img if any
                Storage::delete($data['img']);
            }

            $image = $request->file('top_bar_img');

            $converted = convert_img_to($image->getRealPath(), 'webp');

            // Make path and upload
            $path = image_storage_dir() . '/' . uniqid() . '.webp';

            Storage::put($path, $converted);

            $data['img'] = $path;
        }

        update_or_create_option_table_record('top_bar_banner', $data);

        // Clear promotional_tagline from cache
        Cache::forget('top_bar_banner');

        return redirect()->route('admin.promotions')
            ->with('success', trans('messages.updated_top_bar_banner'));
    }

    /**
     * Show form for Trending Categories.
     * @return \Illuminate\Http\Response
     */
    public function editTrendingNow()
    {
        $trending_categories = ListHelper::trending_categories();

        return view('admin.promotions._edit_trending_categories', compact('trending_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTrendingNow(UpdateTrendingNowCategoryRequest $request)
    {
        if (update_or_create_option_table_record('trending_categories', $request->trending_categories)) {
            // Clear trending_categories from cache
            Cache::forget('trending_categories');

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.trending_now_category_updated'));
        }

        return redirect()->route('admin.promotions')
            ->with('warning', trans('messages.failed'));
    }

    /**
     * Edit Best Finds
     * @return \Illuminate\Http\Response
     */
    public function editBestFinds()
    {
        $bestFinds = get_from_option_table('best_finds_under' . Auth::user()->shop_id);

        return view('admin.promotions._edit_best_finds', compact('bestFinds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBestFinds(UpdateBestFindsRequest $request)
    {
        if (update_or_create_option_table_record('best_finds_under' . Auth::user()->shop_id, $request->price)) {
            // Reset the cached value
            Cache::forget('deals_under' . Auth::user()->shop_id);

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.best_finds_under_updated'));
        }

        return redirect()->route('admin.promotions')->with('error', trans('messages.failed'));
    }

    /**
     * Show form for Main Nav Categories.
     * @return \Illuminate\Http\Response
     */
    public function editNavCategories()
    {
        $categories = ListHelper::categories();

        $nav_categories = (get_main_nav_categories())->pluck('id');

        return view('admin.promotions._edit_nav_categories', compact('categories', 'nav_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateNavCategories(UpdateMainNavCategoryRequest $request)
    {
        if (update_or_create_option_table_record('main_nav_categories', $request->main_nav_categories)) {
            // Clear trending_categories from cache
            Cache::forget('main_nav_categories');

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.main_nav_category_updated'));
        }

        return redirect()->route('admin.promotions')
            ->with('warning', trans('messages.failed'));
    }

    /**
     * Edit the nagivation items
     * @return \Illuminate\Http\Response
     */
    public function editNavigation()
    {
        $navigations = ListHelper::navigations();

        $hidden_items = hidden_menu_items();

        return view('admin.promotions._edit_navigation', compact('navigations', 'hidden_items'));
    }

    /**
     * Update the nagivation items
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateNavigation(Request $request)
    {
        $hidden = $request->hide ?? [];

        if (update_or_create_option_table_record('hidden_menu_items', $hidden)) {
            // Clear trending_categories from cache
            Cache::forget('hidden_menu_items');

            return redirect()->route('admin.promotions')
                ->with('success', trans('messages.main_nav_category_updated'));
        }

        return redirect()->route('admin.promotions')
            ->with('warning', trans('messages.failed'));
    }
}

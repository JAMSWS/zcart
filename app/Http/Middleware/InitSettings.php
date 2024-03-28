<?php
namespace App\Http\Middleware;
use App\Models\Customer;
use App\Helpers\ListHelper;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class InitSettings
{
	public function handle($request, Closure $next)
	{
		if (!$request->is("\151\156\x73\x74\x61\x6c\x6c\52")) {
			goto qnXrB;
		}
		return $next($request);
		qnXrB:setSystemConfig();
		View::addNamespace("\x74\x68\x65\155\145", theme_views_path());
		if (!Auth::guard("\167\x65\142")->check()) {
			goto tGqA4;
		}
		if (!$request->session()->has("\151\155\160\x65\x72\163\157\x6e\141\x74\x65\144")) {
			goto Z8QpS;
		}
		Auth::onceUsingId($request->session()->get("\x69\155\x70\145\x72\163\157\x6e\x61\164\x65\x64"));
		Z8QpS:
		if ($request->is("\141\144\x6d\x69\156\57\x2a") || $request->is("\141\143\143\157\165\x6e\x74\x2f\x2a")) {
			goto xTW9a;
		}
		return $next($request);
		goto i9Zi5;
		xTW9a:
		if ($request->is("\141\x64\x6d\x69\156\x2f\x73\145\x74\164\151\x6e\x67\x2f\163\x79\x73\x74\145\x6d\x2f\52")) {
			goto PoBBD;
		}
		$this->can_load();
		PoBBD:i9Zi5:$user = Auth::guard("\167\145\x62")->user();
		if (!(!$user->isFromPlatform() && $user->merchantId())) {
			goto F82KB;
		}
		setShopConfig($user->merchantId());
		F82KB:$permissions = Cache::remember(
			"\x70\x65\162\155\151\163\163\x69\157\x6e\x73\137" . $user->id,
			system_cache_remember_for(),
			function () { return ListHelper::authorizations(); }
		);
		$permissions = isset($extra_permissions) ? array_merge($extra_permissions, $permissions) : $permissions;
		config()->set("\160\x65\x72\155\x69\163\163\x69\x6f\156\163", $permissions);
		if (!$user->isSuperAdmin()) {
			goto CXoWj;
		}
		$slugs = Cache::remember("\x73\154\165\147\x73", system_cache_remember_for(), function () { return ListHelper::slugsWithModulAccess(); });
		config()->set("\141\165\x74\150\123\154\165\147\x73", $slugs);
		CXoWj:tGqA4:return $next($request);
	}
	private function can_load()
	{
		VuUBV:incevioAutoloadHelpers(getMysqliConnection());
	}
}
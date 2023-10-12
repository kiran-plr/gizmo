<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function trackShipmentForm()
    {
        return view('frontend.track-shipment');
    }

    public function sellIphone()
    {
        $category = Category::where('slug', 'phones')->first();
        $brand = Brand::where('slug', 'apple')->first();
        return view('frontend.sell-iphone', compact('category', 'brand'));
    }

    public function cmsPages(Request $request)
    {
        $slug = $request->slug;
        if (!in_array($slug, ['our-story', 'do-good', 'press', 'corporate-recycling', 'help-center', 'terms-condition', 'privacy-policy', 'retail-partners', 'buy-a-device', 'how-does-it-works'])) {
            abort(404);
        }
        return view('frontend.cms_pages.master', compact('slug'));
    }
}

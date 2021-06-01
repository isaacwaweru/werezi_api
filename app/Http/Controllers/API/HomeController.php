<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HomePageSlide;
use App\Models\FeaturedItem;
use App\Traits\HandlesNavigation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HandlesNavigation;

    public function home()
    {
        return [
            'slider' => $this->getSlides(),
            'featured' => $this->getFeatured()
        ];
    }

    private function getFeatured()
    {
        return FeaturedItem::where('published', 1)->get()->map(function($item) {
            return [
                'title' => $item->title,
                'target' => $item->target,
                'books' => $this->getBooks($item)
            ];
        });
    }

    public function getBooks($item)
    {
        return $this->resolve($item->target)['instance']->featuredBooks();
    }

    private function getSlides()
    {
        return HomePageSlide::all()->map(function($slide) {
            return [
                'image' => $slide->url(),
                'target' => $slide->target
            ];
        });
    }
}

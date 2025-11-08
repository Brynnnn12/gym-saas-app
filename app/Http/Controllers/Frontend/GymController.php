<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use Illuminate\Http\Request;

class GymController extends Controller
{
    public function home()
    {
        $featuredGyms = Gym::with(['plans' => function ($query) {
            $query->where('is_active', true)->orderBy('price');
        }])
            ->limit(6)
            ->get();

        return view('frontend.home', compact('featuredGyms'));
    }

    public function index(Request $request)
    {
        $query = Gym::with(['plans' => function ($q) {
            $q->where('is_active', true);
        }]);

        // Search by name or city
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->get('city'));
        }

        $gyms = $query->paginate(12);
        $cities = Gym::distinct()->pluck('city')->sort();

        return view('frontend.gyms.index', compact('gyms', 'cities'));
    }

    public function show($slug)
    {
        $gym = Gym::with(['plans' => function ($query) {
            $query->where('is_active', true)->orderBy('price');
        }])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.gyms.show', compact('gym'));
    }
}

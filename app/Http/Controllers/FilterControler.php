<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\FilteringResource;
use App\Models\Category;
use App\Http\Resources\category\CategoryIndexResource;
use App\Models\Course_category;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class FilterControler extends Controller
{
    public function level_show($id)
    {
        $level = 0;
        if ($id == 1) {
            $level = Course::all();
        } else  if ($id == 2) {
            $level = Course::where('level', 'beginner')->get();
        } else if ($id == 3) {
            $level = Course::where('level', 'intemediate')->get();
        } else if ($id == 4) {
            $level = Course::where('level', 'advanced')->get();
        }
        $numberOfCourses = $level->count();

        return response()->json([
            'number_courses' => $numberOfCourses,
            'courses' => FilteringResource::collection($level),
        ]);    }
    public function price_show($id)
    {
        $price = 0;
        if ($id == 1) {
            $price = Course::where('price', null)->get();
        }
        if ($id == 2) {
            $price = Course::whereNotNull('price')->get();
        }

        $numberOfCourses = $price->count();

        return response()->json([
            'number_courses' => $numberOfCourses,
            'courses' => FilteringResource::collection($price),
        ]);
    }
    public function Sort_by($id)
    {
        $course = 0;
        if ($id == 1) {
            $course = Course::orderBy('created_at', 'desc')->get();
        }
        if ($id == 2) {
            $course  = Course::with(['user'])
                ->leftJoin('rates', 'courses.id', '=', 'rates.course_id')
                ->select('courses.*', DB::raw('AVG(rates.value) as average_rating'))
                ->groupBy('courses.id', 'courses.title', 'courses.photo', 'courses.category_id', 'courses.description', 'courses.coupon_id', 'courses.price', 'courses.level', 'courses.user_id', 'courses.course_duration', 'courses.created_at', 'courses.updated_at')
                ->orderByDesc('average_rating')
                ->get();
        }
        if ($id == 3) {
            $course = Course::orderBy('price', 'desc')->get();
        }
        $numberOfCourses = $course->count();

        return response()->json([
            'number_courses' => $numberOfCourses,
            'courses' => FilteringResource::collection($course),
        ]);
    }

    public function course_explore()
    {
        $courses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(12)
            ->get();

        return FilteringResource::collection($courses);
    }

    public function category_explore()
    {
        $category = Category::withCount('courses')->orderBy('courses_count', 'desc')->take(12)->get();
        
        return CategoryIndexResource::collection($category);
    }
    public function review_explore()
    {
        $review = Review::take(12)->get();
        return CategoryIndexResource::collection($review);
    }
}

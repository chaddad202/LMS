<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\FilteringResource;
use App\Models\Category;
use App\Http\Resources\category\CategoryIndexResource;
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
            $level = Course::where('level', 'meduim')->get();
        } else if ($id == 4) {
            $level = Course::where('level', 'master')->get();
        }
        return  FilteringResource::collection($level);
    }
    public function price_show($id)
    {
        $price = 0;
        if ($id == 1) {
            $price = Course::where('price', null)->get();
        }
        if ($id == 2) {
            $price = Course::where('price', notNullValue())->get();
        }
        return FilteringResource::collection($price);
    }
    public function order_show($id)
    {
        $course = 0;
        if ($id == 1) {
            $course = Course::orderBy('created_at', 'desc')->get();
        }
        if ($id == 2) {
            $course = Course::orderBy('rating', 'desc')->get();
        }
        if ($id == 3) {
            $course = Course::orderBy('price', 'desc')->get();
        }
        return FilteringResource::collection($course);
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
    public function related_courses($course_id)
    {
        $course = Course::find($course_id);

        $categoryId = $course->pluck('categories');

        // Query to find other courses with the same category
        $relatedCourses = Course::select('courses.*', DB::raw('COUNT(courses.id) as common_categories'))
            ->where('categories', $categoryId)
            ->where('id', '!=', $course_id)
            ->groupBy('courses.id')
            ->orderBy('common_categories', 'desc')
            ->take(12)
            ->get();
        return FilteringResource::collection($relatedCourses);
    }
}

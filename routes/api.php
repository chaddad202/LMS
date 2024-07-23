<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Course\CategoryController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\Course\CommentController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\EnrollmentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Course\SectionController;
use App\Http\Controllers\teacher_profileController;
use App\Http\Controllers\student_profileController;
use App\Http\Controllers\Course\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Course\SkillsController;
use App\Http\Controllers\FilterControler;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReviewController;
use App\Http\Resources\FilteringResource;
use App\Models\Review;
use App\Models\teacher_profile;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register_Admin', [AuthController::class, 'register_Admin']);

Route::post('/register_Student', [AuthController::class, 'register_Student']);
// Route::middleware('role:teacher')->get('/users', function () {
//     // ...
// });

Route::group(['middleware' => ['checkTeacherRole', 'auth:sanctum']], function () {
    Route::post('/profile_teacher', [teacher_profileController::class, 'store']);
    Route::post('/profile_teacher/update', [teacher_profileController::class, 'update']);
    Route::post('/profile_teacher/destroy', [teacher_profileController::class, 'destroy']);
    Route::post('/course_store', [CourseController::class, 'store']);
    Route::post('/course_update/{id}', [CourseController::class, 'update']);
    Route::get('/course_destroy/{id}', [CourseController::class, 'destroy']);
    Route::get('/showEnrollment', [CourseController::class, 'showEnrollment']);
    Route::post('/section_store/{course_id}', [SectionController::class, 'store']);
    Route::post('/section_update/{id}', [SectionController::class, 'update']);
    Route::get('/section_destroy/{id}', [SectionController::class, 'destroy']);
    Route::post('/lesson_store/{section_id}', [LessonController::class, 'store']);
    Route::post('/lesson_update/{id}', [LessonController::class, 'update']);
    Route::get('/lesson_destroy/{id}', [LessonController::class, 'destroy']);
    Route::post('/quiz_store/{section_id}', [QuizController::class, 'store']);
    Route::post('/quiz_update/{quiz_id}', [QuizController::class, 'update']);
    Route::get('/quiz_destroy/{quiz_id}', [QuizController::class, 'destroy']);
    Route::post('/question_store/{quiz_id}', [QuestionController::class, 'store']);
    Route::post('/question_update', [QuestionController::class, 'update']);
    Route::post('/question_destroy', [QuestionController::class, 'destroy']);
    Route::post('/choice_store', [ChoiceController::class, 'store']);
    Route::post('/choice_update', [ChoiceController::class, 'update']);
    Route::post('/choice_destroy', [ChoiceController::class, 'destroy']);
});
Route::group(['middleware' => ['checkStudentRole', 'auth:sanctum']], function () {
    Route::post('/profile_student', [student_profileController::class, 'store']);
    Route::post('/profile_student/show', [student_profileController::class, 'show']);
    Route::post('/profile_student/update', [student_profileController::class, 'update']);
    Route::post('/profile_student/destroy', [student_profileController::class, 'destroy']);
    Route::post('/teacher_search', [teacher_profileController::class, 'search']);
    Route::post('/enrollment_store/{course_id}', [EnrollmentController::class, 'store']);
    Route::post('/favorite_store', [FavoriteController::class, 'store']);
    Route::get('/favorite_index', [FavoriteController::class, 'index']);
    Route::post('/favorite_destroy', [FavoriteController::class, 'destroy']);
    Route::post('/Quiz_show', [QuizController::class, 'show']);
    Route::post('/answer_store', [AnswerController::class, 'store']);
    Route::post('/my_mark_show', [AnswerController::class, 'my_mark']);
    Route::post('/rate_store/{course_id}', [RateController::class, 'store']);
    Route::post('/rate_update/{rate_id}', [RateController::class, 'update']);
    Route::post('/rate_destroy/{rate_id}', [RateController::class, 'destroy']);
});
Route::group(['middleware' => ['checkAdminRole', 'auth:sanctum']], function () {
    Route::post('/skill_store', [SkillsController::class, 'store']);
    Route::post('/skill_update/{id}', [SkillsController::class, 'update']);
    Route::get('/skill_destroy/{id}', [SkillsController::class, 'destroy']);
    Route::post('/category_store', [CategoryController::class, 'store']);
    Route::post('/category_update/{id}', [CategoryController::class, 'update']);
    Route::get('/category_destroy/{id}', [CategoryController::class, 'destroy']);
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/register_Teacher', [AuthController::class, 'register_Teacher']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/comment_store/{id}', [CommentController::class, 'store']);
    Route::post('/comment_update/{id}', [CommentController::class, 'update']);
    Route::get('/comment_destroy/{id}', [CommentController::class, 'destroy']);
    Route::post('/comment_reply/{id}', [CommentController::class, 'reply']);
    Route::get('/enrollment_index', [EnrollmentController::class, 'index']);
    Route::get('/lesson_show/{id}', [LessonController::class, 'show']);
    Route::post('/review_store/{course_id}', [ReviewController::class, 'store']);
    Route::post('/review_update/{review_id}', [ReviewController::class, 'update']);
    Route::post('/review_destroy/{review_id}', [ReviewController::class, 'destroy']);
});

Route::post('/profile_teacher_show', [teacher_profileController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/category_index', [CategoryController::class, 'index']);
Route::get('/course_index', [CourseController::class, 'index']);
Route::get('/course_show/{id}', [CourseController::class, 'show']);
Route::post('/course_search', [CourseController::class, 'search']);

Route::post('/teacher_courses', [CourseController::class, 'teacher_courses']);
Route::get('/section_index/{course_id}', [SectionController::class, 'index']);
Route::get('/section_show/{id}', [SectionController::class, 'show']);
Route::get('/lesson_index/{section_id}', [LessonController::class, 'index']);
Route::post('/enrollment_show/{course_id}', [EnrollmentController::class, 'show']);
Route::get('/skill_show/{id}', [SkillsController::class, 'show']);
Route::get('/skill_index', [SkillsController::class, 'index']);
Route::get('/review_show/{id}', [ReviewController::class, 'show']);
Route::get('/review_index', [ReviewController::class, 'index']);
Route::get('/Rate_show/{id}', [RateController::class, 'show']);


/////////////////filters///////////////////////////////

Route::get('/level_show/{id}', [FilterControler::class, 'level_show']);
Route::get('/price_show/{id}', [FilterControler::class, 'price_show']);
Route::get('/order_show/{id}', [FilterControler::class, 'order_show']);
Route::post('/category_show/{id}', [CategoryController::class, 'show']);


////////////////explore////////////////////////////////

Route::get('/course_explore', [FilterControler::class, 'course_explore']);
Route::get('/category_explore', [FilterControler::class, 'category_explore']);
Route::get('/review_explore', [FilterControler::class, 'review_explore']);
Route::get('/related_courses/{course_id}', [FilterControler::class, 'related_courses']);

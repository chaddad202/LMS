<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\AuthController;
use App\Http\Controllers\Course\CategoryController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\course\CouponController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\EnrollmentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Course\SectionController;
use App\Http\Controllers\teacher_profileController;
use App\Http\Controllers\Course\LessonController;
use App\Http\Controllers\Course\Q_aController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Course\SkillsController;
use App\Http\Controllers\Course_skillsController;
use App\Http\Controllers\user\CustomerController;
use App\Http\Controllers\FilterControler;
use App\Http\Controllers\Gain_prequistController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\user\GiftController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\ReviewController;
use App\Models\Customer;
use App\Models\Gain_prequist;

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



Route::post('/register_Teacher', [AuthController::class, 'register_Teacher']);
Route::post('/register_Student', [AuthController::class, 'register_Student']);


Route::group(['middleware' => ['checkTeacherRole', 'auth:sanctum']], function () {
    Route::get('/profile_destroy/{id}', [CustomerController::class, 'destroy']);
    Route::post('/course_store', [CourseController::class, 'store']);
    Route::post('/course_update/{id}', [CourseController::class, 'update']);
    Route::delete('/course_destroy/{id}', [CourseController::class, 'destroy']);
    Route::post('/course_skills_store/{course_id}', [Course_skillsController::class, 'store']);
    Route::post('/course_skills_update/{id}', [Course_skillsController::class, 'update']);
    Route::delete('/course_skills_destroy/{id}', [Course_skillsController::class, 'destroy']);
    Route::post('/Gain_prequist_store/{course_id}', [Gain_prequistController::class, 'store']);
    Route::post('/Gain_prequist_update/{id}', [Gain_prequistController::class, 'update']);
    Route::delete('/Gain_prequist_destroy/{id}', [Gain_prequistController::class, 'destroy']);
    Route::get('/showEnrollment', [CourseController::class, 'showEnrollment']);
    Route::post('/section_store/{course_id}', [SectionController::class, 'store']);
    Route::post('/section_update/{id}', [SectionController::class, 'update']);
    Route::delete('/section_destroy/{id}', [SectionController::class, 'destroy']);
    Route::post('/lesson_store/{section_id}', [LessonController::class, 'store']);
    Route::post('/lesson_update/{id}', [LessonController::class, 'update']);
    Route::delete('/lesson_destroy/{id}', [LessonController::class, 'destroy']);
    Route::post('/quiz_store/{section_id}', [QuizController::class, 'store']);
    Route::post('/quiz_update/{quiz_id}', [QuizController::class, 'update']);
    Route::delete('/quiz_destroy/{quiz_id}', [QuizController::class, 'destroy']);
    Route::post('/question_store/{quiz_id}', [QuestionController::class, 'store']);
    Route::post('/question_update/{question_id}', [QuestionController::class, 'update']);
    Route::delete('/question_destroy', [QuestionController::class, 'destroy']);
    Route::post('/choice_store', [ChoiceController::class, 'store']);
    Route::post('/choice_update', [ChoiceController::class, 'update']);
    Route::delete('/choice_destroy', [ChoiceController::class, 'destroy']);
    Route::post('/coupon_store', [CouponController::class, 'store']);
    Route::post('/coupon_update/{id}', [CouponController::class, 'update']);
    Route::delete('/coupon_destroy/{id}', [CouponController::class, 'destroy']);
});
Route::group(['middleware' => ['checkStudentRole', 'auth:sanctum']], function () {
    Route::post('/enrollment_store/{course_id}', [EnrollmentController::class, 'store']);
    Route::get('/favorite_store/{course_id}', [FavoriteController::class, 'store']);
    Route::get('/favorite_index', [FavoriteController::class, 'index']);
    Route::get('/favorite_show/{id}', [FavoriteController::class, 'show']);
    Route::delete('/favorite_destroy/{id}', [FavoriteController::class, 'destroy']);
    Route::post('/answer_store/{quiz_id}', [AnswerController::class, 'store']);
    Route::post('/my_mark_show', [AnswerController::class, 'my_mark']);
    Route::post('/rate_store/{course_id}', [RateController::class, 'store']);
    Route::post('/rate_update/{rate_id}', [RateController::class, 'update']);
    Route::delete('/rate_destroy/{rate_id}', [RateController::class, 'destroy']);
    Route::post('/note_store/{lesson_id}', [NoteController::class, 'store']);
    Route::post('/note_update/{id}', [NoteController::class, 'update']);
    Route::delete('/note_destroy/{id}', [NoteController::class, 'destroy']);
    Route::get('/note_show/{id}', [NoteController::class, 'show']);
    Route::post('/order_store', [OrderController::class, 'store']);
    Route::post('/gift_store/{course_id}', [GiftController::class, 'store']);
});
Route::group(['middleware' => ['checkAdminRole', 'auth:sanctum']], function () {
    Route::delete('/user_destroy/{id}', [AuthController::class, 'destroy']);
    Route::post('/enrollment_destroy/{id}', [EnrollmentController::class, 'destroy']);
    Route::post('/skill_store', [SkillsController::class, 'store']);
    Route::post('/skill_update/{id}', [SkillsController::class, 'update']);
    Route::delete('/skill_destroy/{id}', [SkillsController::class, 'destroy']);
    Route::post('/category_store', [CategoryController::class, 'store']);
    Route::post('/category_update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category_destroy/{id}', [CategoryController::class, 'destroy']);
    Route::get('/order_index', [OrderController::class, 'index']);
    Route::get('/order_show/{order_id}', [OrderController::class, 'show']);
    Route::get('/order_submit/{order_id}', [OrderController::class, 'submit']);
    Route::post('/user_update/{id}', [AccountController::class, 'user_update']);

});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/register_Teacher', [AuthController::class, 'register_Teacher']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/q_a_store/{id}', [Q_aController::class, 'store']);
    Route::post('/q_a_update/{id}', [Q_aController::class, 'update']);
    Route::delete('/q_a_destroy/{id}', [Q_aController::class, 'destroy']);
    Route::get('/enrollment_index', [EnrollmentController::class, 'index']);
    Route::get('/lesson_show/{id}', [LessonController::class, 'show']);
    Route::post('/review_store/{course_id}', [ReviewController::class, 'store']);
    Route::post('/review_update/{review_id}', [ReviewController::class, 'update']);
    Route::delete('/review_destroy/{review_id}', [ReviewController::class, 'destroy']);
    Route::get('/q_a_index/{lesson_id}', [Q_aController::class, 'index']);
    Route::get('/my_profile_show', [CustomerController::class, 'my_profile']);
    Route::post('email_update',[AccountController::class, 'email_update']);
    Route::post('password_update',[AccountController::class, 'password_update']);
    Route::delete('account_delete',[AccountController::class, 'account_delete']);
    Route::post('profile_update',[AccountController::class, 'profile_update']);
});

Route::get('/Quiz_show/{id}', [QuizController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/category_index', [CategoryController::class, 'index']);
Route::post('/course_index', [CourseController::class, 'index']);
Route::get('/course_show/{id}', [CourseController::class, 'show']);
Route::post('/course_search', [CourseController::class, 'search']);
Route::get('/teacher_courses/{user_id}', [CourseController::class, 'teacher_courses']);
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
Route::get('/Sort_by/{id}', [FilterControler::class, 'Sort_by']);
Route::get('/category_show/{id}', [CategoryController::class, 'show']);

////////////////explore////////////////////////////////

Route::get('/course_explore', [FilterControler::class, 'course_explore']);
Route::get('/category_explore', [FilterControler::class, 'category_explore']);
Route::get('/review_explore', [FilterControler::class, 'review_explore']);
Route::get('/profile_show/{id}', [CustomerController::class, 'show']);
Route::get('/user_show/{id}', [AuthController::class, 'show']);
Route::get('/user_index', [AuthController::class, 'index']);

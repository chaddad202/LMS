<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\EnrollmentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Course\SectionController;
use App\Http\Controllers\teacher_profileController;
use App\Http\Controllers\student_profileController;
use App\Http\Controllers\Course\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SkillsController;
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
Route::post('/register_Teacher', [AuthController::class, 'register_Teacher']);
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
    Route::post('/category_store', [CategoryController::class, 'store']);
    Route::post('/category_update/{course_old_id}/{category_id_old}', [CategoryController::class, 'update']);
    Route::post('/category_destroy', [CategoryController::class, 'destroy']);
    Route::post('/section_store/{course_id}', [SectionController::class, 'store']);
    Route::post('/section_update/{id}', [SectionController::class, 'update']);
    Route::get('/section_destroy/{id}', [SectionController::class, 'destroy']);
    Route::post('/quiz_store', [QuizController::class, 'store']);
    Route::post('/quiz_update', [QuizController::class, 'update']);
    Route::post('/quiz_destroy', [QuizController::class, 'destroy']);
    Route::post('/question_store', [QuestionController::class, 'store']);
    Route::post('/question_update', [QuestionController::class, 'update']);
    Route::post('/question_destroy', [QuestionController::class, 'destroy']);
    Route::post('/choice_store', [ChoiceController::class, 'store']);
    Route::post('/choice_update', [ChoiceController::class, 'update']);
    Route::post('/choice_destroy', [ChoiceController::class, 'destroy']);
    Route::post('/lesson_store', [LessonController::class, 'store']);
    Route::post('/lesson_update/{id}', [LessonController::class, 'update']);
    Route::get('/lesson_destroy/{id}', [LessonController::class, 'destroy']);
    Route::post('/skill_store', [SkillsController::class, 'store']);
    Route::post('/skill_update', [SkillsController::class, 'update']);
    Route::post('/skill_destroy', [SkillsController::class, 'destroy']);
});
Route::group(['middleware' => ['checkStudentRole', 'auth:sanctum']], function () {
    Route::post('/profile_student', [student_profileController::class, 'store']);
    Route::post('/profile_student/show', [student_profileController::class, 'show']);
    Route::post('/profile_student/update', [student_profileController::class, 'update']);
    Route::post('/profile_student/destroy', [student_profileController::class, 'destroy']);
    Route::post('/teacher_search', [teacher_profileController::class, 'search']);
    Route::post('/enrollment_store/{course_id}', [EnrollmentController::class, 'store']);
    Route::get('/enrollment_index', [EnrollmentController::class, 'index']);
    Route::post('/favorite_store', [FavoriteController::class, 'store']);
    Route::get('/favorite_index', [FavoriteController::class, 'index']);
    Route::post('/favorite_destroy', [FavoriteController::class, 'destroy']);
    Route::post('/Quiz_show', [QuizController::class, 'show']);
    Route::post('/answer_store', [AnswerController::class, 'store']);
    Route::post('/my_mark_show', [AnswerController::class, 'my_mark']);
});
Route::group(['middleware' => ['checkAdminRole', 'auth:sanctum']], function () {
});


Route::post('/profile_teacher_show', [teacher_profileController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/comment_store', [CommentController::class, 'store']);
    Route::post('/comment_update', [CommentController::class, 'update']);
    Route::post('/comment_destroy', [CommentController::class, 'destroy']);
    Route::post('/comment_reply', [CommentController::class, 'reply']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/category', [CategoryController::class, 'show']);
Route::get('/course_index', [CourseController::class, 'index']);
Route::get('/course_show/{id}', [CourseController::class, 'show']);
Route::post('/course_search', [CourseController::class, 'search']);

Route::post('/teacher_courses', [CourseController::class, 'teacher_courses']);
Route::get('/section_show/{id}', [SectionController::class, 'show']);
Route::get('/lesson_index/{section_id}', [LessonController::class, 'index']);
Route::get('/lesson_show/{id}', [LessonController::class, 'show']);
Route::post('/enrollment_show/{course_id}', [EnrollmentController::class, 'show']);
Route::post('/skill_show', [SkillsController::class, 'show']);

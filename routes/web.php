<?php

use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\DictionaryController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Student\BookmarkController;
use App\Http\Controllers\Student\ReadingController as StudentReadingController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\ReadingPassageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WritingTopicController;
use App\Http\Controllers\Admin\ListeningMaterialController;
use App\Http\Controllers\Student\WritingController;
use App\Http\Controllers\Student\ListeningController;
use App\Http\Controllers\PreferencesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\VocabularyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = request()->user();

    if ($user) {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = request()->user();

    if ($user?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->role === 'student') {
        return redirect()->route('student.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified', 'no.back.history'])->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin', 'no.back.history'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('courses', CourseController::class);
    Route::resource('lessons', LessonController::class)->except(['show']);
    Route::resource('quizzes', QuizController::class)->except(['show']);
    Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::delete('quizzes/{quiz}/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');
    Route::resource('readings', ReadingPassageController::class)->parameters(['readings' => 'reading'])->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('users/create-admin', [UserController::class, 'createAdmin'])->name('users.create-admin');
    Route::post('users/create-admin', [UserController::class, 'storeAdmin'])->name('users.store-admin');
    Route::resource('writing-topics', WritingTopicController::class)->except(['show']);
    Route::resource('listening-materials', ListeningMaterialController::class)->except(['show']);
    Route::post('listening-materials/{listeningMaterial}/questions', [ListeningMaterialController::class, 'storeQuestion'])->name('listening-materials.questions.store');
    Route::delete('listening-materials/{listeningMaterial}/questions/{listeningQuestion}', [ListeningMaterialController::class, 'destroyQuestion'])->name('listening-materials.questions.destroy');
});

Route::prefix('student')->name('student.')->middleware(['auth', 'student', 'no.back.history'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/checkout', [StudentCourseController::class, 'checkout'])->name('courses.checkout');
    Route::post('/courses/{course}/enroll', [StudentCourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/lessons', [StudentLessonController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/{lesson}', [StudentLessonController::class, 'show'])
        ->middleware('completed.lesson')
        ->name('lessons.show');

    // Writing practice routes
    Route::get('/writing', [WritingController::class, 'index'])->name('writing.index');
    Route::get('/writing/{writingTopic}', [WritingController::class, 'show'])->name('writing.show');
    Route::post('/writing/{writingTopic}/submit', [WritingController::class, 'submit'])->name('writing.submit');
    Route::get('/writing/result/{submission}', [WritingController::class, 'result'])->name('writing.result');

    // Listening practice routes
    Route::get('/listening', [ListeningController::class, 'index'])->name('listening.index');
    Route::get('/listening/{listeningMaterial}', [ListeningController::class, 'show'])->name('listening.show');
    Route::post('/listening/{listeningMaterial}/submit', [ListeningController::class, 'submit'])->name('listening.submit');

    Route::get('/dictionary', [DictionaryController::class, 'index'])->name('dictionary.index');
    Route::get('/dictionary/lookup/{word}', [DictionaryController::class, 'lookup'])->name('dictionary.lookup');
    Route::post('/dictionary/save', [DictionaryController::class, 'save'])->name('dictionary.save');

    // Readings Route
    Route::get('/readings', [StudentReadingController::class, 'index'])->name('readings.index');
    Route::get('/readings/{reading}', [StudentReadingController::class, 'show'])->name('readings.show');

    // Quizzes Route
    Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');

    // Bookmarks Route
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/lessons/{lesson}/toggle', [BookmarkController::class, 'toggleLesson'])->name('bookmarks.lessons.toggle');
    Route::post('/bookmarks/vocabularies/{vocabulary}/toggle', [BookmarkController::class, 'toggleVocabulary'])->name('bookmarks.vocabularies.toggle');
});

Route::middleware(['auth', 'no.back.history'])->group(function () {
    Route::post('/preferences', [PreferencesController::class, 'update'])->name('preferences.update');
    Route::delete('/preferences', [PreferencesController::class, 'destroy'])->name('preferences.destroy');
});

Route::middleware(['auth', 'no.back.history'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

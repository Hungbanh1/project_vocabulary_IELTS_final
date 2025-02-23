<?php

use App\Type;
use App\Vocabulary;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {

//     $vocabulary = Vocabulary::orderBy('english', 'asc')->get();
//     $type = Type::all();
//     return view('index', compact('vocabulary', 'type'));
// });
Route::get('/', "VocabularyController@index")->name('home');
Route::post('/add_voca', "VocabularyController@add")->name('add');
Route::post('/add_parapharse', "VocabularyController@add_parapharse")->name('add_parapharse');
// Route::get('/delete', "VocabularyController@delete")->name('delete');
Route::get('/delete/{id}', 'VocabularyController@delete')->name('delete');
Route::get('/parapharse/delete/{id}', 'VocabularyController@delete_parapharse')->name('delete_parapharse');
Route::get('/search', "VocabularyController@search")->name('search');
Route::get('/search/searchajax', "VocabularyController@searchajax")->name('searchajax');
Route::get('/adv', "VocabularyController@adv")->name('adv');
Route::get('/adj', "VocabularyController@adj")->name('adj');
Route::get('/V', "VocabularyController@V")->name('V');
Route::get('/N', "VocabularyController@N")->name('N');
Route::get('/parapharse', "VocabularyController@parapharse")->name('parapharse');
Route::get('/Phrase', "VocabularyController@Phrase")->name('Phrase');
Route::get('/edit', "VocabularyController@edit")->name('edit');
Route::post('/edit_vocabulary', "VocabularyController@edit_vocabulary")->name('edit_vocabulary');
Route::post('/add_parapharse', "VocabularyController@add_parapharse")->name('add_parapharse');
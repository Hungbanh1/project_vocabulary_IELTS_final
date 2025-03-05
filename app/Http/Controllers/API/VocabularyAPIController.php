<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Parapharse;
class VocabularyAPIController extends Controller
{
    //
    public function getParapharse($id)
    {
        $parapharses = Parapharse::where('vocabulary_id', $id)->get();
        return response()->json($parapharses);
    }
}
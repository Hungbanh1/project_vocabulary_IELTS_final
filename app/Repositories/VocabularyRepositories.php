<?php

namespace App\Repositories;

use App\Type;
use App\Vocabulary;
use App\Parapharse;

class VocabularyRepositories
{

    protected $vocabulary;
    protected $type;


    // public function __construct(Vocabulary $vocabulary, Type $type){
    //     $this->vocabulary = $vocabulary;
    // }
    public function getAllVocabularies()
    {
        // return Vocabulary::all();
        // $vocabulary = Vocabulary::orderBy('english', 'asc')->get();
        // $type = Type::all();
        return Vocabulary::orderBy('english', 'asc')->get();
        // return view('index', compact('vocabulary', 'type'));
    }
    public function getAllParapharse()
    {
      
        return Vocabulary::where('is_parapharse', '!=', 0)
                        ->orderBy('english', 'asc')->get();
    }
    public function getType()
    {
        return Type::all();
    }

    public function searchAjax($getKeyword)
    {
        $vocabulary = Vocabulary::where('english', 'LIKE', "$getKeyword%")->get();
        return $data = [
            'vocabulary' => $vocabulary,
        ];
    }
    public function search($getKeyword)
    {
        $vocabulary = Vocabulary::where('english', 'LIKE', "$getKeyword%")
            ->get();
        return $vocabulary;
    }

    public function filterByType($typeId)
    {
        $vocabulary = Vocabulary::where('type_id', $typeId)
            ->orderBy('english', 'asc')
            ->get();
        return $vocabulary;
    }
    public function editVocabulary($data)
    {
        return Vocabulary::where('id', $data['id'])
            ->update([
                'english' => $data['english'],
                'vietnam' => $data['vietnam'],
                'type_id' => $data['type_id'],
            ]);
    }
    public function findVocabularyById($id)
    {
        return Vocabulary::find($id);
    }

    public function createVocabulary($data)
    {

        return Vocabulary::create($data);
    }
    public function createParapharse($data)
    {

        return Parapharse::create($data);
    }

    public function updateVocabulary($id, $data)
    {
        $vocabulary = Vocabulary::find($id);
        if ($vocabulary) {
            $vocabulary->update($data);
            return $vocabulary;
        }
        return null;
    }

    public function deleteVocabulary($id)
    {
        return Vocabulary::destroy($id);
    }
}
<?php

namespace App\Repositories;

use App\Type;
use App\Vocabulary;
use App\Parapharse;
use Illuminate\Http\Request;

class VocabularyRepositories
{

    protected $vocabulary;
    protected $type;


    // public function __construct(Vocabulary $vocabulary, Type $type){
    //     $this->vocabulary = $vocabulary;
    // }
    public function getAllVocabularies()
    {
        $perPage = 100; 
        $totalRecords = Vocabulary::count(); // Lấy tổng số bản ghi
        $vocabularies = Vocabulary::orderBy('english', 'asc')->paginate($perPage);
        // $data = [$vocabularies,$totalRecords];
        // return $data;
        return $vocabularies;
        // return Vocabulary::orderBy('english', 'asc')->paginate(200);

    }
    public function getAllParapharse()
    {
    
                    $perPage = 100; 
      
                    $vocabularies = Vocabulary::with('parapharse')
                    ->where('is_parapharse', '!=', 0)
                    ->orderBy('english', 'asc')
                    ->paginate($perPage);
                    return $vocabularies;
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
            ->paginate(100);    
        return $vocabulary;
    }

    public function filterByType($typeId)
    {
        $perPage = 100; 

        $vocabulary = Vocabulary::where('type_id', $typeId)
            ->orderBy('english', 'asc')
            ->paginate($perPage);
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
        // return Vocabulary::destroy($id);
        $vocabulary = Vocabulary::find($id);

        if ($vocabulary) {
            // Xóa danh sách liên quan trong bảng parapharse
            $vocabulary->parapharse()->destroy();

            // Xóa từ vựng
            return $vocabulary->destroy();
        }

        return false;
    }
}
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
        return $vocabularies;
        // return Vocabulary::orderBy('english', 'asc')->paginate(200);

    }
    public function getAllParapharse()
    {
    
                    $perPage = 60; 
                    
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

    // public function searchAjax($getKeyword,$lastUrl = null)
    public function searchAjax($getKeyword,$lastUrl)
    {   

      // Nếu là "parapharse", luôn lọc theo `is_parapharse = 1`
    if ($lastUrl == "parapharse") {
        $query = Vocabulary::orderBy('english', 'asc')->where('is_parapharse', 1);
        
        // Nếu có từ khóa, tiếp tục lọc theo từ khóa
        if (!empty($getKeyword)) {
            $query->where('english', 'LIKE', "$getKeyword%");
        }
    } else {
        $query = Vocabulary::orderBy('english', 'asc');

        if (!empty($getKeyword)) {
            $query = Vocabulary::where('english', 'LIKE', "$getKeyword%");

            $typeMap = [
                'adv' => 1,
                'adj' => 2,
                'V' => 3,
                'N' => 4,
                'Phrase' => 5,
            ];

            if (array_key_exists($lastUrl, $typeMap)) {
                $query->where('type_id', $typeMap[$lastUrl]);
            }
        }
    }

    // Trả về danh sách với phân trang
    $vocabulary = $query->paginate(100);
    
    return $vocabulary;
      
        
    }
    private function getColor($type_id) {
        $colors = [
            '1' => '#fd7e14', // adv - màu cam
            '2' => '#dc3545', // adj - màu đỏ
            '3' => '#007bff', // v - màu xanh dương
            '4' => '#28a745', // n - màu xanh lá
            '5' => '#6c757d'  // cụm từ - màu xám
        ];
        return $colors[$type_id] ?? '#6c757d';
    }
    
    private function getTypeName($type_id) {
        $types = [
            '1' => 'Adv',
            '2' => 'Adj',
            '3' => 'V',
            '4' => 'N',
            '5' => 'Phrase',
            '6' => 'Parapharse'
        ];
        return $types[$type_id] ?? 'Phrase';
    }
    public function search($getKeyword)
    {
        $vocabulary = Vocabulary::where('english', 'LIKE', "$getKeyword%")
            ->paginate(50);    
        return $vocabulary;
    }

    public function filterByType($typeId, Request $request)
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
                'is_parapharse' => $data['is_parapharse'],
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
        
        if (isset($data['vocabulary_id'])) {
            $vocabulary = Vocabulary::find($data['vocabulary_id']);
            if ($vocabulary && $vocabulary->is_parapharse != 1) {
                $vocabulary->update(['is_parapharse' => 1]);
            }
        }
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
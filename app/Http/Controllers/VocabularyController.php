<?php

namespace App\Http\Controllers;

use App\Services\VocabularyServices;
use App\Type;
use App\Vocabulary;
use App\Parapharse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class VocabularyController extends Controller
{
    //
    protected $VocabularyServices;

    public function __construct(VocabularyServices $VocabularyServices)
    {
        $this->VocabularyServices = $VocabularyServices;
    }

    function index()
    {
        // $test = VocabularyService::getAllVocabularies();
        // $vocabulary = Vocabulary::orderBy('english', 'asc')->get();
        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->getAllVocabularies();
        // dd($vocabulary);

        return view('index', compact('vocabulary', 'type'));
    }
    function add(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'english' => 'required|unique:vocabularies',
            'vietnam' => 'required',
            'type_vocabulary' => 'required', // Đúng với AJAX gửi lên
        ], [
            'type_vocabulary.required' => 'Vui lòng chọn loại từ.',
            'english.required' => 'Từ vựng là trường bắt buộc',
            'english.unique' => 'Từ vựng này đã tồn tại',
            'vietnam.required' => 'Từ vựng là trường bắt buộc.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
       
        $data = [
            'english' => $request->input('english'),
            'vietnam' => $request->input('vietnam'),
            'type_id' => $request->input('type_vocabulary'),
            'is_parapharse' => (int) $request->input('is_parapharse'), // Ép kiểu thành số nguyên
        ];
        $this->VocabularyServices->createVocabulary($data);
        // return response()->json([
        //     'redirect_url' => url('/') // Trả về URL redirect
        // ]);
        // $vocabulary->save();
        // return response()->json(['message' => 'Thêm từ vựng thành công!'], 200);
        if($request->input('is_parapharse') == 1){
            
            return redirect('/parapharse');
        }
        return redirect('/');
    }
    function add_parapharse(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'english' => 'required|unique:parapharse',
            'vietnam' => 'required',
        ], [
            'english.required' => 'Từ vựng là trường bắt buộc',
            'english.unique' => 'Từ vựng này đã tồn tại',
            'vietnam.required' => 'Từ vựng là trường bắt buộc.',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = [
            'english' => $request->input('english'),
            'vietnam' => $request->input('vietnam'),
        ];
 
        $this->VocabularyServices->createParapharse($data);
  
        return redirect('/parapharse');
    }
    function search(Request $request)
    {
        $getKeyword = '';
        // return "keyword ajax:$keyword";

        if ($request->input('keyword')) {
            $getKeyword = $request->input('keyword');
        }

        $getKeyword = $request->input('keyword');
        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->search($getKeyword);

        return view('index', compact('vocabulary', 'type'));
    }
    public function searchajax(Request $request, $suffitx = 'VNĐ')
    {

        $getKeyword = '';
        // return "keyword ajax:$keyword";

        if ($request->input('keyword')) {
            $getKeyword = $request->input('keyword');
        }

        $getKeyword = $request->input('keyword');
        return $this->VocabularyServices->searchAjax($getKeyword);
    }
    private function filterByType($typeId)
    {
        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->filterByType($typeId);
        return view('index', compact('vocabulary', 'type'));
    }
    public function edit_vocabulary(Request $request)
    {
        // $messages = [
        //     'english.required' => 'Từ vựng là trường bắt buộc',
        //     'english.unique' => 'Từ vựng này đã tồn tại',
        //     'vietnam.required' => 'Từ vựng là trường bắt buộc.',
        //     'type.required' => 'Vui lòng chọn loại từ.',
        // ];
        // //unique:bc kiem tra ton tai cua email
        // $request->validate([
        //     'english' => 'required|unique:vocabularies', // Kiểm tra tính duy nhất của trường 'english' trong bảng 'vocabularies'
        //     'vietnam' => 'required',
        //     'type' => 'required',
        // ], $messages);
        $data = [
            'id' => $request->input('id'),
            'english' => $request->input('eng'),
            'vietnam' => $request->input('vn'),
            'type_id' => $request->input('type'),
        ];
        // dd($data);
        $this->VocabularyServices->editVocabulary($data);
        return redirect('/')->with('success', 'Cập nhật thành công');
    }
    public function delete($id){
        $vocabulary = Vocabulary::find($id);
        // dd($vocabulary);
        if (!$vocabulary) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy từ vựng!',
                'vocabulary' => $vocabulary,
            ], 404);
        }
    
        $vocabulary->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xoá từ vựng thành công',
            'redirect_url' => url('/') // Trả về URL redirect
        ]);
    }
    public function delete_parapharse($id){
        $vocabulary = Parapharse::find($id);
        // dd($vocabulary);
        if (!$vocabulary) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy từ vựng!',
                'vocabulary' => $vocabulary,
            ], 404);
        }
    
        $vocabulary->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xoá từ vựng thành công',
            'redirect_url' => url('/parapharse') // Trả về URL redirect
        ]);
    }
    public function adv()
    {
        return $this->filterByType(1);
    }

    public function adj()
    {
        return $this->filterByType(2);
    }

    public function V()
    {
        return $this->filterByType(3);
    }

    public function N()
    {
        return $this->filterByType(4);
    }
    public function Phrase()
    {
        return $this->filterByType(5);
    }
    public function Parapharse(){

        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->getAllParapharse();

        return view('parapharse.index', compact('vocabulary', 'type'));
    }
    // public function Parapharse()
    // {
    //     return $this->filterByType(6);
    // }
} 
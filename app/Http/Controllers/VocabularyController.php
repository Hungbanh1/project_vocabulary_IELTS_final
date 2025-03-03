<?php

namespace App\Http\Controllers;

use App\Services\VocabularyServices;
use App\Type;
use App\Vocabulary;
use App\Parapharse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Log;

class VocabularyController extends Controller
{
    //
    protected $VocabularyServices;

    public function __construct(VocabularyServices $VocabularyServices)
    {
        $this->VocabularyServices = $VocabularyServices;
    }

    function index(Request $request)
    {
        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->getAllVocabularies();
  
        // dd($vocabulary1);
        if ($request->ajax()) {
            Log::info('Request AJAX vào index controller');
            $getKeyword = $request->keyword;
            $lastUrl = '';
            $vocabulary = $this->VocabularyServices->searchAjax($getKeyword, $lastUrl);
            $view = view('loadmore',compact('vocabulary'))->render();
            return response()->json(
                [
                'html' => $view,
                'keyword' => $getKeyword,
                'vocabulary' => $vocabulary
                ]
            );
        }
        return view('index', compact('vocabulary', 'type'));
    }
    public function filterByType($typeId, Request $request = null)
    {
  
        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->filterByType($typeId, $request);
      
        $view = view('loadmore',compact('vocabulary'))->render();
        if ($request->ajax()) {
            Log::info('Request AJAX vào filterByType controller');
            $view = view('loadmore', compact('vocabulary'))->render();
            return response()->json(['html' => $view]);
        }
        return view('index', compact('vocabulary', 'type'));
    }
    // function loadmore(Request $request){
    //     $type = $this->VocabularyServices->getType();
    //     $vocabulary = $this->VocabularyServices->getAllVocabularies();
    //     // dd($vocabulary);
    //     if ($request->ajax()) {
    //         return view('loadmore', compact('vocabulary','type'))->render();
    //     }
    //     return view('loadmore', compact('vocabulary', 'type'));
    // }
    
    public function Parapharse(){

        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->getAllParapharse();
        // dd($vocabulary);
        return view('parapharse.index', compact('vocabulary', 'type'));
    }
    function add(Request $request)
    {
        $request->validate([
            'english' => 'required|unique:vocabularies',  
            'vietnam' => 'required',
            'type_vocabulary' => 'required', 
        ], [
            'english.required' => 'Từ vựng là trường bắt buộc',
            'english.unique' => 'Từ vựng này đã tồn tại',
            'vietnam.required' => 'Từ vựng là trường bắt buộc.',
            'type_vocabulary.required' => 'Vui lòng chọn loại từ.',
        ]);
      
        $type = $request->type_vocabulary;
        if($type == 6){
            $data = [
                'english' => $request->english,
                'vietnam' => $request->vietnam,
                'type_id' =>  $type,
                'is_parapharse' => 1, 
            ];
        }else{
            $data = [
                'english' => $request->english,
                'vietnam' => $request->vietnam,
                'type_id' =>  $type,
                'is_parapharse' => $request->is_parapharse, // Ép kiểu thành số nguyên
            ];
        }
        
        $this->VocabularyServices->createVocabulary($data);
     
        if($request->is_parapharse == 1){
            return response()->json([
                'success' => true,
                'redirect_url' => url('/parapharse') // Trả về URL redirect
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'redirect_url' => url('/') // Trả về URL redirect
            ]);
        }
       
    }
    
    function add_parapharse(Request $request)
    {
        
        $request->validate([
            'eng' => 'required|unique:parapharse,english',  
            'vn' => 'required',
        ], [
            'eng.required' => 'Từ vựng là trường bắt buộc',
            'eng.unique' => 'Từ vựng này đã tồn tại',
            'vn.required' => 'Từ vựng là trường bắt buộc.',
        ]);
        // $data_get = $request->all();
        // return response()->json([
        //     'status' => 'success',
        //     'received_data' => $data_get
        // ]);
        // exit;
        $data = [
            'english' => $request->eng,
            'vietnam' => $request->vn,
            'vocabulary_id' => $request->vocabulary_id,
        ];
 
        $this->VocabularyServices->createParapharse($data);
        
        return redirect('/parapharse')->with('message', "Thêm parapharse thành công");
       
    }
    function search(Request $request)
    {
      
        $keyword = $request->keyword;
     
        $type = $this->VocabularyServices->getType();
        $vocabulary = $this->VocabularyServices->search($keyword);
        $record = $vocabulary->total();
        if($record !=0){
            return response()->json([
                'status' => true,
                'message' => 'Có từ vựng',
                'redirect_url' => url('/'),
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy từ vựng!',
                'redirect_url' => url('/'),
            ]);
        }
       
        
    }
    public function searchajax(Request $request, $suffitx = 'VNĐ')
    {

        // $getKeyword = '';
        // // return "keyword ajax:$keyword";

        // if ($request->keyword) {
        //     $getKeyword = $request->keyword;
        // }

            $data_get = $request->all();
      

        $getKeyword = $request->keyword;
        $lastUrl = $request->lastUrl;
        $vocabulary =  $this->VocabularyServices->searchAjax($getKeyword, $lastUrl);
        return response()->json([
            'data' => $vocabulary,
            'lastUrl' => $lastUrl,
        ]);
    }
  
    public function edit_vocabulary(Request $request)
    {

        $request->validate([
            'eng_edit' => 'required|unique:vocabularies,english,' . ($request->id ?? 'NULL'),
            'vn_edit' => 'required',
            'type' => 'required',
        ], [
            'eng_edit.required' => 'Từ vựng là trường bắt buộc',
            'eng_edit.unique' => 'Từ vựng này đã tồn tại',
            'vn_edit.required' => 'Từ vựng là trường bắt buộc.',
            'type.required' => 'Vui lòng chọn loại từ.',
        ]);
  
        $data = [
            'id' => $request->input('id'),
            'english' => $request->input('eng_edit'),
            'vietnam' => $request->input('vn_edit'),
            'type_id' => $request->input('type'),
        ];
        
        // dd($data);
        $this->VocabularyServices->editVocabulary($data);
        if($request->input('is_parapharse') == 1){
            
            return redirect('/parapharse')->with('message', 'Cập nhật thành công');
        }
        return redirect('/')->with('message', 'Cập nhật thành công');

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
        // $vocabulary = Parapharse::find($id);
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
            'message' => 'Tuyệt vời! Bạn đã xoá thành công!',
            'redirect_url' => url('/parapharse') // Trả về URL redirect
        ]);
    }
    public function adv()
    {
        return $this->filterByType(1,request());
    }

    public function adj()
    {
        return $this->filterByType(2,request());
    }

    public function V()
    {
        return $this->filterByType(3,request());
    }

    public function N()
    {
        return $this->filterByType(4,request());
    }
    public function Phrase()
    {
        return $this->filterByType(5,request());
    }
  
    // public function Parapharse()
    // {
    //     return $this->filterByType(6);
    // }
} 
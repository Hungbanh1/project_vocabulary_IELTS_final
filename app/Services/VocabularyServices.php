<?php

namespace App\Services;

use App\Repositories\VocabularyRepositories;
use Illuminate\Http\Request;

class VocabularyServices
{
    protected $VocabularyRepositories;

    public function __construct(VocabularyRepositories $VocabularyRepositories)
    {
        $this->VocabularyRepositories = $VocabularyRepositories;
    }
    public function getType()
    {
        return $this->VocabularyRepositories->getType();
    }

    public function getAllVocabularies()
    {
        return $this->VocabularyRepositories->getAllVocabularies();
    }
    public function getAllParapharse()
    {
        return $this->VocabularyRepositories->getAllParapharse();
    }
    public function searchAjax($getKeyword,$lastUrl)
    {
        return $this->VocabularyRepositories->searchAjax($getKeyword,$lastUrl);
    }
    public function search($getKeyword)
    {
        return $this->VocabularyRepositories->search($getKeyword);
    }
    public function filterByType($typeId, Request $request)
    {
        return $this->VocabularyRepositories->filterByType($typeId, $request);
    }
    public function editVocabulary($data)
    {
        return $this->VocabularyRepositories->editVocabulary($data);
    }
    public function findVocabularyById($id)
    {
        return $this->VocabularyRepositories->findVocabularyById($id);
    }

    public function createVocabulary($data)
    {
        return $this->VocabularyRepositories->createVocabulary($data);
    }
    public function createParapharse($data)
    {
        return $this->VocabularyRepositories->createParapharse($data);
    }

    public function updateVocabulary($id, $data)
    {
        return $this->VocabularyRepositories->updateVocabulary($id, $data);
    }

    public function deleteVocabulary($id)
    {
        return $this->VocabularyRepositories->deleteVocabulary($id);
    }
}
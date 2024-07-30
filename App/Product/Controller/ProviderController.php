<?php

namespace App\Product\Controller;

use Lib\Http\ApiResponse;
use Lib\Http\RequestData;
use Lib\Http\DefaultController;
use App\Product\DAO\ProviderDAO;

class ProviderController extends DefaultController
{

    private readonly ProviderDAO $ProviderDAO;

    public function __construct(public RequestData $Request)
    {
        parent::__construct($Request);
        $this->ProviderDAO = new ProviderDAO($this->DataBaseAccess);
    }

    public function getById(int $id)
    {
        $Provider = $this->ProviderDAO->getByID($id);

        if (empty($Provider)) {
            ApiResponse::json([
                'error' => 'Provider not found',
            ], 404);
        }

        ApiResponse::json($Provider);

        return true;
    }

    public function list()
    {
        $List = $this->ProviderDAO->list();

        ApiResponse::json([
            'count' => count($List),
            'list' => $List,
        ]);

        return true;
    }

    public function create()
    {
        $title = $this->Request->body['title'] ?? null;
        $description = $this->Request->body['description'] ?? '';

        if (empty($title)) {
            ApiResponse::json([
                'error' => 'Provider title is required',
            ], 400);
        }

        if ($this->ProviderDAO->titleExists($title)) {
            ApiResponse::json([
                'error' => 'Provider already exists',
            ], 400);
        }

        $result = $this->ProviderDAO->create(
            title: $title,
            description: $description,
        );

        ApiResponse::json([
            'status' => 'success',
            'id' => !empty($result) ? (int) $result : null,
        ], 201);


        return true;
    }

    public function update(int $id)
    {
        
        $title = $this->Request->body['title'] ?? null;
        $description = $this->Request->body['description'] ?? null;

        $OlderData = $this->ProviderDAO->getByID($id);

        if (empty($OlderData)) {
            ApiResponse::json([
                'error' => 'Provider not found',
            ], 404);
        }

        if (!is_null($title) && empty($title)) {
            ApiResponse::json([
                'error' => 'Provider title is required',
            ], 400);
        }

        if (
            !empty($title)
            && strtolower($title) != strtolower($OlderData->title) 
            && $this->ProviderDAO->titleExists($title)
        ) {
            ApiResponse::json([
                'error' => 'Provider already exists',
            ], 400);
        }

        $fields = [
            'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];
        if (!is_null($title)) {
            $fields['title'] = (string) $title;
        }
        if (!is_null($description)) {
            $fields['description'] = (string) $description;
        }

        $result = $this->ProviderDAO->update(
            id: $id,
            fields: $fields
        );

        ApiResponse::json([
            'status' => !empty($result) ? 'success' : 'something went wrong',
        ], 200);

        return true;
    }

    public function delete(int $id)
    {
        $result = $this->ProviderDAO->deleteByID($id);

        ApiResponse::json([
            'status' => !empty($result) ? 'success' : 'something went wrong',
        ], 200);

        return true;
    }
}
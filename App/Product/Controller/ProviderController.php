<?php

namespace App\Product\Controller;

use Lib\Http\ApiResponse;
use Lib\Http\DefaultController;
use App\Product\DAO\ProviderDAO;
use App\Product\Model\ProductDAO;

class ProviderController extends DefaultController
{
    public function getById(int $id)
    {
        $Provider = (new ProviderDAO)->getByID($id);

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
        $List = (new ProviderDAO)->list();

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

        $ProviderDAO = new ProviderDAO();

        if (empty($title)) {
            ApiResponse::json([
                'error' => 'Provider title is required',
            ], 400);
        }

        if ($ProviderDAO->exists($title)) {
            ApiResponse::json([
                'error' => 'Provider already exists',
            ], 400);
        }

        $result = $ProviderDAO->create(
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

        $ProviderDAO = new ProviderDAO();
        $OlderData = $ProviderDAO->getByID($id);

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
            && $ProviderDAO->exists($title)
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

        $result = $ProviderDAO->update(
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
        $result = (new ProviderDAO())->deleteByID($id);

        ApiResponse::json([
            'status' => !empty($result) ? 'success' : 'something went wrong',
        ], 200);

        return true;
    }
}
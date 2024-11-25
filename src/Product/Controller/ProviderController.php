<?php

namespace App\Product\Controller;

use App\Product\DAO\ProviderCommand;
use App\Product\DAO\ProviderQuery;
use App\Shared\Controller\DefaultController;
use Neuralpin\HTTPRouter\RequestData as Request;
use Neuralpin\HTTPRouter\Response;

class ProviderController extends DefaultController
{
    private readonly ProviderQuery $ProviderQuery;

    private readonly ProviderCommand $ProviderCommand;

    public function __construct()
    {
        parent::__construct();
        $this->ProviderQuery = new ProviderQuery($this->DataBaseAccess);
        $this->ProviderCommand = new ProviderCommand($this->DataBaseAccess);
    }

    public function getById(int $id)
    {
        $Provider = $this->ProviderQuery->getByID($id);

        if (empty($Provider)) {
            return Response::json([
                'error' => 'Provider not found',
            ], 404);
        }

        return Response::json($Provider);
    }

    public function list()
    {
        $List = $this->ProviderQuery->list();

        return Response::json([
            'count' => count($List),
            'list' => $List,
        ]);
    }

    public function create(Request $Request)
    {
        $title = $Request->getInput('title') ?? null;
        $description = $Request->getInput('description') ?? '';

        if (empty($title)) {
            return Response::json([
                'error' => 'Provider title is required',
            ], 400);
        }

        if ($this->ProviderQuery->titleExists($title)) {
            return Response::json([
                'error' => 'Provider already exists',
            ], 400);
        }

        $result = $this->ProviderCommand->create(
            title: $title,
            description: $description,
        );

        return Response::json([
            'status' => 'success',
            'id' => ! empty($result) ? (int) $result : null,
        ], 201);

    }

    public function update(int $id, Request $Request)
    {

        $title = $Request->getInput('title') ?? null;
        $description = $Request->getInput('description') ?? null;

        $OlderData = $this->ProviderQuery->getByID($id);

        if (empty($OlderData)) {
            return Response::json([
                'error' => 'Provider not found',
            ], 404);
        }

        if (! is_null($title) && empty($title)) {
            return Response::json([
                'error' => 'Provider title is required',
            ], 400);
        }

        if (
            ! empty($title)
            && strtolower($title) != strtolower($OlderData->title)
            && $this->ProviderQuery->titleExists($title)
        ) {
            return Response::json([
                'error' => 'Provider already exists',
            ], 400);
        }

        $fields = [
            'id' => $id,
            'updated_at' => (new \DateTime)->format('Y-m-d H:i:s'),
        ];
        if (! is_null($title)) {
            $fields['title'] = (string) $title;
        }
        if (! is_null($description)) {
            $fields['description'] = (string) $description;
        }

        $result = $this->ProviderCommand->update($fields);

        return Response::json([
            'status' => ! empty($result) ? 'success' : 'something went wrong',
        ], 200);
    }

    public function delete(int $id)
    {
        $result = $this->ProviderCommand->delete($id);

        return Response::json([
            'status' => ! empty($result) ? 'success' : 'something went wrong',
        ], 200);

    }
}

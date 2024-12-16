<?php
namespace Stradow\Content\Event;

class CollectionContentRemoved
{

    private string $collectionId;
    private string $contentId;


    public function __construct(
        string $collectionId,
        string $contentId,
    )
    {
        $this->collectionId = $collectionId;
        $this->contentId = $contentId;
    }

    public function getCollectionId(): string
    {
        return $this->collectionId;
    }

    public function getContentId(): string
    {
        return $this->contentId;
    }
}
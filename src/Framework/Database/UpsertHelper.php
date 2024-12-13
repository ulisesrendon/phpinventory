<?php

namespace Stradow\Framework\Database;

class UpsertHelper
{
    public readonly string $columnNames;

    public readonly string $allPlaceholders;

    public readonly string $noUniquePlaceHolders;

    public readonly array $parameters;

    public function __construct(array $fields, array $uniqueFields)
    {
        $parameters = $fields;

        $this->columnNames = implode(', ', array_keys($fields));

        $this->allPlaceholders = implode(', ', array_map(fn ($field) => ":$field", array_keys($fields)));

        $noUniqueItems = [];
        foreach ($fields as $k => $field) {
            if (in_array($k, $uniqueFields)) {
                continue;
            }
            $noUniqueItems[] = "$k = :{$k}_update";
            $parameters["{$k}_update"] = $field;
        }

        $this->noUniquePlaceHolders = implode(', ', $noUniqueItems);

        $this->parameters = $parameters;
    }
}

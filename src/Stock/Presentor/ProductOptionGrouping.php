<?php

namespace Stradow\Stock\Presentor;

class ProductOptionGrouping
{
    /**
     * Summary of List
     *
     * @var object[]
     */
    protected array $List = [];

    /**
     * @param  object[]  $ProductBaseList
     */
    public function __construct(array $ProductBaseList)
    {
        $ProductGroup = $this->group($ProductBaseList);
        $this->List = $this->present($ProductGroup);
    }

    /**
     * @param  object[]  $ProductBaseList
     * @return object[][]
     */
    protected function group(array $ProductBaseList): array
    {
        $ProductGroup = [];
        foreach ($ProductBaseList as $Product) {
            $ProductGroup[$Product->id][] = $Product;
        }

        return $ProductGroup;
    }

    protected function present(array $ProductGroup): array
    {
        $ProductList = [];
        foreach ($ProductGroup as $Group) {
            $Product = [
                'id' => $Group[0]->id,
                'code' => $Group[0]->code,
                'title' => $Group[0]->title,
                'description' => $Group[0]->description,
                'price' => $Group[0]->price,
                'stock' => 0,
                'options' => [],
            ];
            foreach ($Group as $Item) {
                if (is_null($Item->stock)) {
                    continue;
                }
                $Product['stock'] += $Item->stock;
                $Product['options'][] = (object) [
                    'id' => $Item->entry_id,
                    'stock' => $Item->stock,
                    'price' => $Item->price_alt ?? $Product['price'],
                ];
            }
            $ProductList[$Group[0]->id] = (object) $Product;
        }

        return $ProductList;
    }

    /**
     * Summary of get
     *
     * @return object[]
     */
    public function get(): array
    {
        return $this->List;
    }
}

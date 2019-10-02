<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class Product
{
    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price'], $item['description']);
        }

        return $productList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];
        foreach ($this->getDataFromSource() as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price'], $item['description']);
        }

        return $productList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = [
            [
                'id' => 1,
                'name' => 'PHP',
                'price' => 15300,
                'description' => 'PHP is pain... But its the fastest way to earn some MONEY boy!',
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
                'description' => 'Python is cool))0)))',
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
                'description' => 'Idk C#',
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
                'description' => 'Java - enterprise!',
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
                'description' => 'Super cool description',
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
                'description' => 'Super cool description',
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
                'description' => 'Super cool description',
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
                'description' => 'Super cool description',
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
                'description' => 'Super cool description',
            ],
            [
                'id' => 12,
                'name' => 'Rust',
                'price' => 22000,
                'description' => 'Super cool description',
            ],

        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }
}

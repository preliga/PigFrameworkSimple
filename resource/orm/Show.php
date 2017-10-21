<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-19
 * Time: 18:58
 */

namespace resource\orm;

use library\Pig\orm\{
    Schedule,Record
};

class Show extends Schedule
{

    protected function createSelect(): \Zend_Db_Select
    {
        $select = $this->db->select()
            ->from(['s' => 'show'], [])
            ->join(['m' => 'movie'], 's.movieId = m.id', [])
            ->where('s.active = 1')
            ->order('s.term');

        return $select;
    }

    protected function createTreeDependency(): array
    {
        // kolumny łączone joinem muszą mieć takie same nazwy wtedy są scalane i updatowane automatycznie

        return
            [
                'keys' => [
                    'showId' => 's.id', // z aliasem !!!
                ],
                'tables' => [
                    'show' => [
                        'alias' => 's',
                        'keys' => [   /// ustalić tylko jeden klucz
                            'showId' => 'id',
                        ],
                        'columns' => [
                            'showId' => 'id',
                            'showActive' => 'active',
                            'movieId',
                            'term'
                        ]
                    ],
                    'movie' => [
                        'alias' => 'm',
                        'keys' => [
                            'movieId' => 'id',
                        ],
                        'columns' => [
                            'fullTitle' => new \Zend_Db_Expr("CONCAT(m.title, m.title)"),
                            'movieId' => 'id',
                            'movieActive' => 'active',
                            'title',
                            'description',
                            'trailer',
                            'categoryId',
                            'poster',
                            'duration',
                        ]
                    ]
                ]
            ];
    }

    protected function getValidators(): array
    {
        $validators = [];

        $validators[] = function (Record $record) {
            return ['status' => strlen($record->title) > 10, 'message' => "Title is too short."];
        };

        return $validators;
    }
}
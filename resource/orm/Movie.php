<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-18
 * Time: 22:44
 */
namespace resource\orm;

use library\Pig\orm\Schedule;

class Movie extends Schedule
{

    protected function createSelect(): \Zend_Db_Select
    {
        $select = $this->db->select();

        $select->from(['m' => 'movie'])
            ->join(['s' => 'show'], 's.movieId = m.id AND s.term >= NOW() AND s.term <= DATE_ADD(NOW(), INTERVAL 7 DAY)', [])
            ->where('m.active = 1')
            ->group('m.id');

        return $select;
    }

    protected function createTreeDependency(): array
    {
        return
            [
                'keys' => [
                    'showId' => 's.id',
                ],
                'tables' => [
                    'show' => [
                        'alias' => 's',
                        'keys' => [   /// może ustalić tylko jeden ??
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
        return [];
        // TODO: Implement validate() method.
    }
}
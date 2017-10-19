<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-19
 * Time: 18:58
 */

namespace resource\orm;


use library\Pig\orm\Schedule;

class Show extends Schedule
{

    protected function createSelect(): \Zend_Db_Select
    {
        $select = $this->db->select()
            ->from(['s' => 'show'], [])
            ->join(['m' => 'movie'], 's.movieId = m.id', [])
            ->where('s.active = 1')
//            ->where('s.term > NOW()')
            ->order('s.term');

//        die($select);

        return $select;
    }

    protected function createTreeDependency(): array
    {
        return
            [
                'keys' => [
                    'showId' => 'id',
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
}
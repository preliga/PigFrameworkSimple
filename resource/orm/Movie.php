<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-18
 * Time: 22:44
 */
namespace resource\orm;

use library\Pig\model\{
    Config, Db
};
use library\Pig\orm\DataTemplate;

class Movie extends DataTemplate
{

    protected function createSelect(array $variable = []): \Zend_Db_Select
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
                        ],
                        'defaultValues' => [
                            'showActive' => 1
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

                        ],
                        'defaultValues' => [
                            'movieActive' => 1,
                        ]
                    ]
                ]
            ];
    }

    protected function getValidators(): array
    {
        return [];
    }

    protected function getPermission(): array
    {
        return [];
    }

    protected function getDb(): \Zend_Db_Adapter_Mysqli
    {
        $config = Config::getInstance()->getConfig('db');
        $db = new Db($config['cinema']);
        return $db->getDb();
    }
}
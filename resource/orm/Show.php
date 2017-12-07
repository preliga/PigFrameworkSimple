<?php
/**
 * Created by PhpStorm.
 * User: Piotr
 * Date: 2017-10-19
 * Time: 18:58
 */

namespace resource\orm;

use library\PigFramework\model\{
    Config, Db
};
use library\PigOrm\{
    DataTemplate, Record
};

class Show extends DataTemplate
{
    protected function createSelect(array $variable = []): \Zend_Db_Select
    {
        $select = $this->db->select()
            ->from(['s' => 'show'], [])
            ->join(['m' => 'movie'], 's.movieId = m.id', [])
            ->where('s.active = 1')
            ->where('m.active = 1')
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
                            'movieActive' => 1
                        ]
                    ]
                ]
            ];
    }

    protected function getValidators(): array
    {
        $validators = [];

//        $validators['title'][] = function (Record $record) {
//            return ['status' => strlen($record->title) < 10, 'message' => "Title is too short."];
//        };

//        $validators['description'][] = function (Record $record) {
//            return ['status' => strlen($record->description) < 2, 'message' => "Description is too short."];
//        };

        $validators['otherValidate'][] = function (Record $record) {
            return ['status' => true, 'message' => 'BAD'];
        };

        return $validators;
    }

    protected function getPermission(): array
    {
        $permissions = [];

        $permissions['GET'] = function (){
            return true;
        };

        return $permissions;
    }

    protected function getDb(): \Zend_Db_Adapter_Mysqli
    {
        $config = Config::getInstance()->getConfig('db');
        $db = Db::getInstance($config['cinema'], 'cinema');
        return  $db->getDb();
    }
}
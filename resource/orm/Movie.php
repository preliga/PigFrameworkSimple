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
        // TODO: Implement createTreeDependency() method.
    }
}
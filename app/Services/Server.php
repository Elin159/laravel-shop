<?php
namespace App\Services;


class Server
{

    /**
     * @param int $code 错误号
     * @param string $message 错误信息或其余信息
     * @param array $data 数据
     * @return array
     * @throws \Exception
     */
    public static function render($code, $message, $data = [])
    {
        if( !is_numeric($code) ) {
            throw new \Exception ('code must is int');
        }
        return [
            'code'      => $code,
            'msg'   => $message,
            'data'      => $data
        ];

    }

    /**
     * 计算是否有下一页
     * @param int $total 数据总条数
     * @param int $page 当前页
     * @param int $count 每页显示多少条
     * @return bool
     */
    public static function IsHasNextPage($total, $page, $count)
    {
        if(!$total || !$count) {
            return 0;
        }
        $total_page = ceil($total / $count);
        if(!$total_page) {
            return 0;
        }

        if($total_page <= $page) {
            return 0;
        }
        return 1;
    }

    /**
     * 计算并返回每页的开始数据
     * @param $page 页码
     * @param $count 每页显示记录条数
     * @return int
     */
    public static function getPaginationOffset($page, $count)
    {
        $count  = ($count <= 0) ? 10 : $count;
        $page   = ($page <= 0) ? 1 : $page;
        return ($page == 1) ? 0 : (($page - 1) * $count);
    }
}
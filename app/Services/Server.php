<?php
namespace App\Services;


class Server
{

    /**
     * @param int $code 错误号
     * @param array $message 错误信息或其余信息
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
            'message'   => $message,
            'data'      => $data
        ];

    }
}
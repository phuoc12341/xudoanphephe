<?php


namespace App\Helper;

use Log;

class Helper
{
    public static function getSql($model)
    {
        $replace = function ($sql, $bindings) {
            $needle = '?';
            foreach ($bindings as $replace) {
                $pos = strpos($sql, $needle);
                if ($pos !== false) {
                    if (is_numeric($replace)) {
                        $sql = substr_replace($sql, $replace, $pos, strlen($needle));
                        continue;
                    }
//                    if (gettype($replace) === "string") {
//                        $replace = ' "'.addslashes($replace).'" ';
//                    }
                    $sql = substr_replace($sql, "'$replace'", $pos, strlen($needle));
                }
            }
            return $sql;
        };
        $sql = $replace($model->toSql(), $model->getBindings());

        Log::error($sql);
        return $sql;
    }

    public static function logEncode($data)
    {
        Log::error(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL . json_encode(debug_backtrace()));
    }
}

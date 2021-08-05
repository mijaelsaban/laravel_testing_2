<?php


use Illuminate\Database\Query\Builder;

if (!function_exists('toSql')) {
    /**
     * @param Builder $query
     */
    function toSql(Builder $query)
    {
        echo Str::replaceArray('?', $query->getBindings(), $query->toSql());
        die();
    }
}

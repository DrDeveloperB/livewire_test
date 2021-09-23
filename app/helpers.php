<?php

if (!function_exists('getSqlWithBindings')) {
    function getSqlWithBindings($query)
    {
        foreach ($query as $k => $v) {
            $query[$k]['bindingQuery'] = vsprintf(
                str_replace('?', '%s', $v['query']),    // $query->toSql() , $query['query']
                collect($v['bindings'])      // $query->getBindings() , $query['bindings']
                ->map(
                    function ($binding) {
                        return is_numeric($binding) ? $binding : "'{$binding}'";
                    }
                )
                    ->toArray()
            );
        }
        return $query;
    }
}

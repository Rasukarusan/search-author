<?php
require_once 'ChromePhp.php';

/**
 * Chromeのコンソールにログを出してくれる
 *
 * @param mixed 文字列でも配列でもなんでも良い
 * @return void
 */
function clog($obj) {
    return ChromePhp::log($obj);
}
function pecho($obj, $type = null) {
    echo "<pre>";
    if ($type === 1) {
        print_r($obj);
    } else {
        var_dump($obj);
    }
    echo "</pre>";
}


/**
 * メモリ使用量を測定
 * 単純に変数を生成した時のメモリ数を返す。単位はバイト
 *
 * @return void
 */
function dumpMemory() {
    static $initialMemoryUse = null;
    if ( $initialMemoryUse === null ) {
        $initialMemoryUse = memory_get_usage();
    }
    pecho(number_format(memory_get_usage() - $initialMemoryUse));
}

function getMemory($point, $is_batch = 0) {
    $label = "";
    $start_tag = "<pre>";
    $end_tag   = "</pre>";

    if($point === 0) {
        $label = 'start';
    }else {
        $label = 'end';
    }
    if(!$is_batch) {
        $start_tag = "\n";
        $end_tag   = "\n";
    }

    echo "{$start_tag}{$label}:".number_format(memory_get_usage() / (1024 * 1024), 2)."MB{$end_tag}";
}
function memory_convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}


function getNow() {
    return date("Y-m-d H:i:s");
}


<?php
/**
* @package SyncWCFromExtDB
*/

class SyncWCFromExtDBActivate
{
    public static function activate() {
        flush_rewrite_rules();
    }
}
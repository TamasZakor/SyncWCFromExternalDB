<?php
/**
* @package SyncWCFromExtDB
*/

class SyncWCFromExtDBDeactivate
{
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
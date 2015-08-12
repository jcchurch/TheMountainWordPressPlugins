<?php

require('display_form.php');
require('pull_database.php');
require('print_table.php');

function inspectDatabase() {
     $tableName = displayForm();

     if (isset($tableName) && strlen($tableName) > 0) {
         $table = pullRecords1($tableName);
         printTable($table);
     }
}

?>

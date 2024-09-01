<?php

/**
* -------------------------------------------------------------------------
* ChekboxPriority plugin for GLPI
* Copyright (C) 2024 by the ChekboxPriority Development Team.
* -------------------------------------------------------------------------
*
* MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
* --------------------------------------------------------------------------
*/

/**
* Plugin install process
*
* @return boolean
*/
function plugin_chekboxpriority_install()
{
  global $DB;
  $version = plugin_version_chekboxpriority();
  //создать экземпляр миграции с версией
  $migration = new Migration($version['version']);
  //Create table only if it does not exists yet!
  if (!$DB->tableExists('glpi_plugin_chekboxpriority_fields')) {
    //table creation query
    $query = 'CREATE TABLE glpi_plugin_chekboxpriority_fields (
      id INT(11) NOT NULL AUTO_INCREMENT,
      ticket_id INT(11) NOT NULL,
      field_name  varchar(255) NOT NULL,
      active  INT(1) NOT NULL DEFAULT 0,
      date_mod TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY  (id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC';

      $DB->queryOrDie($query, $DB->error());
    }
    //execute the whole migration
    $migration->executeMigration();
    return true;
  }

  /**
  * Plugin uninstall process
  *
  * @return boolean
  */
  function plugin_chekboxpriority_uninstall()
  {
    global $DB;
    $tables = [
      'fields'
    ];
    foreach ($tables as $table) {
      $tablename = 'glpi_plugin_chekboxpriority_' . $table;
      //Create table only if it does not exists yet!
      if ($DB->tableExists($tablename)) {
        $DB->queryOrDie(
          "DROP TABLE `$tablename`",
          $DB->error()
        );
      }
    }
    return true;
  }

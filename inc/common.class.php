<?php
class PluginChekboxpriorityCommon extends CommonDBTM
{
  public static function preItemAdd(CommonDBTM $item)
  {

    if(isset($item->input['field_urgency']))
    {
      $item->input['priority'] = 4;
    //  file_put_contents(GLPI_ROOT.'/tmp/buffer.txt',PHP_EOL.PHP_EOL. json_encode($item->input,JSON_UNESCAPED_UNICODE), FILE_APPEND);
    }

    //    exit;
    return;
  }
  public static function itemAdd(CommonDBTM $item)
  {
    global $DB;
    if(isset($item->input['field_urgency']))
    {
      foreach($item->input['field_urgency'] AS $value)
      {
        $DB->insert('glpi_plugin_chekboxpriority_fields',
          [
              'ticket_id'=>$item->fields['id'],
              'field_name'=>$value,
              'active'=>1
          ]
        );
      }

    //  file_put_contents(GLPI_ROOT.'/tmp/buffer.txt',PHP_EOL.PHP_EOL. json_encode($item->input,JSON_UNESCAPED_UNICODE), FILE_APPEND);
    }
  //  file_put_contents(GLPI_ROOT.'/tmp/buffer.txt',PHP_EOL.PHP_EOL. json_encode($item,JSON_UNESCAPED_UNICODE), FILE_APPEND);
    //    exit;
    return;
  }
}

<?php
class PluginChekboxpriorityFields extends CommonDBChild
{
  static private $_instance = NULL;
  static function getInstance() {

    if (!isset(self::$_instance)) {
      self::$_instance = new self();
      if (!self::$_instance->getFromDB(1)) {
        self::$_instance->getEmpty();
      }
    }
    return self::$_instance;
  }
  static function showForTab  ($params)
  {
    $item = $params['item'];
    $html_id = 'plugin_chekboxpriority_fields_' . mt_rand();
    //  file_put_contents(GLPI_ROOT.'/tmp/buffer.txt',PHP_EOL.PHP_EOL. json_encode($item,JSON_UNESCAPED_UNICODE), FILE_APPEND);
    //if ticket create page
    if (strpos($_SERVER['REQUEST_URI'], "helpdesk.public.php") !== false || strpos($_SERVER['REQUEST_URI'],"tracking.injector.php") !== false)
    {
      $html = "<div id=\'{$html_id}\' class=\'form-field row col-12  mb-2\' style=\'border-top:0\'><div class=\'col-lg-3\'></div><div class=\'col-lg-9\'><b class=\'col-12 text-center text-xxxl-end mb-2\'>Повысить приоритет обращения:</b><br><div class=\'form-check mt-2\'><input class=\'form-check-input\' type=\'checkbox\' name=\'field_urgency[]\' value=\'Сдача отчетности и закрытие периода.\' id=\'field1\'><label class=\'form-check-label\' for=\'field1\'>Сдача отчетности и закрытие периода</label> </div><div class=\'form-check\'><input class=\'form-check-input\' name=\'field_urgency[]\'type=\'checkbox\' value=\'Ошибка/проблема полностью блокирует работу сотрудника.\' id=\'field2\'><label class=\'form-check-label\' for=\'field2\'>Ошибка/проблема полностью блокирует работу сотрудника</label></div></div></div>";
      $params = json_encode($params);
      echo Html::scriptBlock(<<<JAVASCRIPT
        $('form .card textarea').parent().parent().before('{$html}');
          console.log('{$html}');
      JAVASCRIPT
      );
    }
    //if ticket edit page
    if (strpos($_SERVER['REQUEST_URI'], "ticket.form.php") !== false && isset($_GET['id']))
    {
        $item = new Ticket();
        $item->getFromDB($_GET['id']);
        $ticket = $item->find(['id'=>$_GET['id']]);
        $priority = $ticket[$_GET['id']]['priority'];

        $fields = self::getInstance();
        $fields = $fields->find(['ticket_id'=>$_GET['id']]);
        // file_put_contents(GLPI_ROOT.'/tmp/buffer.txt',PHP_EOL.PHP_EOL. json_encode($priority,JSON_UNESCAPED_UNICODE), FILE_APPEND);
        if($priority > 3 && $fields)
        {

              echo "<div class='form-field row col-12  mb-2'>
                      <label class='col-form-label col-xxl-4 text-xxl-end border-end'>Пичина высокой срочности</label>
                      <div class='col-xxl-8'>";
                      foreach ($fields as $key => $value) {
                        echo " <label class='field-container mt-2' style='color:#f15454' for=\'field1\'>{$value['field_name']}</label>";
                      }
              echo  "</div></div>";


        }
    }
    return false;
  }

}

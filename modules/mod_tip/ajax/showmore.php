<?php
/*******************************************************************************/
//                         InstantCMS v 1.10.6                                 //
//                      http://www.instantcms.ru/                              //
//                       module "А знаете ли вы?"  v.1.2.0                     //
//                      written by Marat Fatikhov                              //
//                      (nickname Марат on a site)                             //
//                       E-mail: f-marat@mail.ru                               //
//                                                                             //
//                      LICENSED BY GNU/GPL v2                                 //
//                                                                             //
/********************************************************************************/

define('PATH', $_SERVER['DOCUMENT_ROOT']);
include(PATH . '/core/ajax/ajax_core.php');

$module_id = $inCore->request('module_id', 'int', 0);
$tip_id = $inCore->request('tip_id', 'int', 0);
if (!$module_id || !$tip_id) {
    return false;
}

$sql = "SELECT *
        FROM `cms_mod_tip`
        WHERE module_id = {$module_id} AND published = 1 AND id != {$tip_id}
        ORDER BY RAND()
        LIMIT 1";

$result = $inDB->query($sql);
if (!$inDB->num_rows($result)) {
    return false;
}
$tip = array();
$tip = $inDB->fetch_assoc($result);
if ($tip['title'] == '.....') {
    $tip['title'] = '';
}

//передаем в шаблон
cmsPage::initTemplate('modules', 'mod_tip.tpl')->
assign('tip', $tip)->
display('mod_tip.tpl');

return true;
?>

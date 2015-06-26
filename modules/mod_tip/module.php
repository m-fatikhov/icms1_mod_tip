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

function mod_tip($mod, $cfg)
{

    $inCore = cmsCore::getInstance();
    $inDB = cmsDatabase::getInstance();
    $inUser = cmsUser::getInstance();

    $sql = "SELECT *
           FROM `cms_mod_tip`
           WHERE module_id = {$mod['id']} AND published = 1
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
    cmsPage::initTemplate('modules', $cfg['tpl'])->
    assign('tip', $tip)->
    display($cfg['tpl']);

    return true;
}//module
?>

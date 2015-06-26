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
// ========================================================================== //

    function info_module_mod_tip(){

        //
        // Описание модуля
        //

        //Заголовок (на сайте)
        $_module['title']        = 'А знаете ли вы?';

        //Название (в админке)
        $_module['name']         = 'А знаете ли вы?';

        //описание
        $_module['description']  = 'Показывает случайную подсказку';

        //ссылка (идентификатор)
        $_module['link']         = 'mod_tip';

        //позиция
        $_module['position']     = 'sidebar';

        //автор
        $_module['author']       = 'Marat Fatikhov';

        //текущая версия
        $_module['version']      = '1.2.0';

        //
        // Настройки по-умолчанию
        //
        $_module['config'] = array();

        return $_module;

    }

// ========================================================================== //

    function install_module_mod_tip(){

        $inCore     = cmsCore::getInstance();
        $inDB       = cmsDatabase::getInstance();

        $inDB->importFromFile($_SERVER['DOCUMENT_ROOT'].'/modules/mod_tip/install.sql');

        return true;
    }

// ========================================================================== //

    function upgrade_module_mod_tip(){

        return true;

    }

// ========================================================================== //

?>

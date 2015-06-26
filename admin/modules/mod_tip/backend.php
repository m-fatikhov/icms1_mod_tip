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

  if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); }

  $opt 		= $inCore->request('opt', 'str', 'list');
  $tip_id = $inCore->request('tip_id', 'int', 0);
  
  //ссылка на конфиг модуля
  $mod_conf_uri = '?view=modules&do=config&id='.$id;
  
  //pathway
  cpAddPathway($module_title, '?view=modules&do=edit&id='.$id);
 	cpAddPathway('Настройки', '?view=modules&do=config&id='.$id);
  
  //просмотр всех подсказок
  if($opt == 'list'){
  
     $toolmenu = array();
		 $toolmenu[0]['icon'] = 'new.gif';
		 $toolmenu[0]['title'] = 'Добавить подсказку';
		 $toolmenu[0]['link'] = $mod_conf_uri.'&opt=add';
		 
		 $toolmenu[1]['icon'] = 'cancel.gif';
     $toolmenu[1]['title'] = 'Отмена';
     $toolmenu[1]['link'] = '?view=modules';

     $toolmenu[2]['icon'] = 'edit.gif';
     $toolmenu[2]['title'] = 'Редактировать отображение модуля';
     $toolmenu[2]['link'] = '?view=modules&do=edit&id='.$id;
     
     cpToolMenu($toolmenu);

     //TABLE COLUMNS
		 $fields = array();
		 
		 $fields[0]['title'] = 'id';			$fields[0]['field'] = 'id';			$fields[0]['width'] = '30';

     $fields[1]['title'] = 'Заголовок';	$fields[1]['field'] = 'title';		$fields[1]['width'] = '';
     $fields[1]['link'] = $mod_conf_uri.'&opt=edit&tip_id=%id%';
     
     $fields[2]['title'] = 'Показ';		$fields[2]['field'] = 'published';	$fields[2]['width'] = '100';
     $fields[2]['do'] = 'opt'; $fields[2]['do_suffix'] = '';
     
     //ACTIONS
		 $actions = array();
		 $actions[0]['title'] = 'Редактировать';
		 $actions[0]['icon']  = 'edit.gif';
		 $actions[0]['link']  = $mod_conf_uri.'&opt=edit&tip_id=%id%';

		 $actions[1]['title'] = 'Удалить';
		 $actions[1]['icon']  = 'delete.gif';
		 $actions[1]['confirm'] = 'Удалить подсказку?';
		 $actions[1]['link']  = $mod_conf_uri.'&opt=del&tip_id=%id%';
		 
		 //Print table
		 cpListTable('cms_mod_tip', $fields, $actions, "module_id = {$id}", 'id');
		 
  }
  
  //добавление подсказок
  if($opt == 'add' || $opt == 'edit'){
      //Патвэй
      if($opt=='add'){
         cpAddPathway('Добавление подсказки', '#');
      }elseif($opt=='edit'){
         cpAddPathway('Редактирование подсказки', '#');
      }
      //Меню
      $toolmenu = array();

      $toolmenu[0]['icon'] = 'save.gif';
      $toolmenu[0]['title'] = 'Сохранить';
      $toolmenu[0]['link'] = 'javascript:document.addform1.submit()';

      $toolmenu[2]['icon'] = 'cancel.gif';
      $toolmenu[2]['title'] = 'Отмена';
      $toolmenu[2]['link'] = $mod_conf_uri;
      
      cpToolMenu($toolmenu);

      $tip = cmsUser::sessionGet('tip');
			if ($tip) { cmsUser::sessionDel('tip'); }

      if($opt == 'edit' && !$tip){
           $sql = "SELECT *
                   FROM cms_mod_tip
                   WHERE id = {$tip_id}
                   LIMIT 1";
           $result = $inDB->query($sql);
           if($inDB->num_rows($result)){
              $tip = $inDB->fetch_assoc($result);
           }
           if($tip['title'] == '.....'){ $tip['title'] = ''; }
      }

      $messages = cmsCore::getSessionMessages();
      if($messages){ ?>
        <div class="sess_messages">
      <?php foreach($messages as $message){
          echo $message;
          }
      } ?>
        </div>
         <div>
           <form name="addform1" action="<?php echo $mod_conf_uri.'&opt=submit'; if($opt=='edit'){echo '&tip_id='.$tip_id;}?>" method="post">
              <div style="margin-top:25px; color:#0099CC;">
                 <h3><?php if($opt=='add'){echo 'Добавление';}elseif($opt=='edit'){echo 'Редактирование';}?> подсказки</h3>
              </div>
              <div style="margin-top:25px;">
                 <strong style="color:#0099CC;">Заголовок подсказки</strong>
              </div>
              <input name="title" type="text" value="<?php echo $tip['title'];?>" maxlenght="200" size="70">
              <input type="checkbox" name="showtitle" title="Показывать заголовок" value="1" <?php if ($tip['showtitle'] || $opt=='add') { echo 'checked="checked"'; } ?>>
              <div style="margin-top:25px;">
                 <strong style="color:#0099CC;">Текст подсказки</strong>
              </div>
              <div>
                 <?php $inCore->insertEditor('text', $tip['text'], '300', '70%'); ?>
              </div>
              <div style="margin-top:25px;">
                 <strong style="color:#0099CC;">Публиковать подсказку</strong>
                 <input type="checkbox" name="published" value="1" <?php if ($tip['published'] || $opt=='add') { echo 'checked="checked"'; } ?>>
              </div>
              <div style="margin-top:25px;">
                  <input type="submit" value="Сохранить">
                  <input type="button" value="Отмена" onclick="window.history.back();">
              </div>
           </form>
         </div>
<?php

  }
  
  //сохранение подсказок
  if($opt == 'submit'){
      $tip= array();
      $tip['title'] = trim($inCore->request('title', 'str', ''));
      $tip['text'] = $inCore->request('text', 'html', '');
      $tip['text'] = $inDB->escape_string($tip['text']);
      $tip['showtitle'] = $inCore->request('showtitle', 'int', 0);
      $tip['published'] = $inCore->request('published', 'int', 0);
      
      if(!$tip['text']){
          cmsCore::addSessionMessage('Заполните поле "Текст подсказки"', 'error');
          cmsUser::sessionPut('tip', $tip);
          $inCore->redirectBack();
      }

      if(!$tip['title']){ $tip['title'] = '.....'; }

      if($tip_id){
           $sql = "UPDATE `cms_mod_tip`
                   SET  title      = '{$tip['title']}',
                        text       = '{$tip['text']}',
                        module_id  = {$id},
                        showtitle  = {$tip['showtitle']},
                        published  = {$tip['published']}
                   WHERE id = {$tip_id}";
      }else{
           $sql = "INSERT INTO `cms_mod_tip` (title, text, module_id, showtitle, published)
                   VALUE ('{$tip['title']}', '{$tip['text']}', {$id}, {$tip['showtitle']}, {$tip['published']})";

      }
      $inDB->query($sql);
      $inCore->redirect($mod_conf_uri);
  }
  
  //удаление подсказки
  if($opt == 'del'){
        $sql = "DELETE
                FROM `cms_mod_tip`
                WHERE id = {$tip_id}";
        $inDB->query($sql);
        $inCore->redirect($mod_conf_uri);
  }
  
  if($opt == 'hide' || $opt == 'show'){
      $tip_id = $inCore->request('item_id', 'int', 0);
      if($opt == 'hide'){
         $published = (int)0;
      }elseif($opt == 'show'){
         $published = (int)1;
      }
      $sql = "UPDATE `cms_mod_tip`
              SET published = {$published}
              WHERE id = {$tip_id}";
      $inDB->query($sql);
  }
  
?>

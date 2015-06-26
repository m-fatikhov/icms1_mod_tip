{*==================================================================================*}
{*=========         Модуль "А знаете ли вы?" (mod_tip)         =====================*}
{*==================================================================================*}
<div id="tip{$tip.module_id}_img" width="100%" align="center" style="display:none">
    <img src="/images/progress.gif">
</div>
<div id="tip{$tip.module_id}">
  <div>
     {if $tip.title && $tip.showtitle}<h3>{$tip.title}</h3>{/if}
  </div>
  <div style="margin-top:25px;">
      {$tip.text}
  </div>
  <div style="text-align:right;">
      <a href="#" onclick="showMore{$tip.module_id}(); return false;">Показать ещё</a>
  </div>
</div>
{literal}
<script type="text/javascript">
function showMore{/literal}{$tip.module_id}{literal}(){
    $.post("/modules/mod_tip/ajax/showmore.php",{module_id:{/literal}{$tip.module_id}{literal}, tip_id:{/literal}{$tip.id}{literal}},showMoreSuccess, "html");
    $('#tip{/literal}{$tip.module_id}{literal}').hide();
    $('#tip{/literal}{$tip.module_id}{literal}_img').show();
    function showMoreSuccess(data){
        $('#tip{/literal}{$tip.module_id}{literal}').parent('.modulebody').html(data);
        $('#tip{/literal}{$tip.module_id}{literal}_img').hide();
    }
}
</script>
{/literal}

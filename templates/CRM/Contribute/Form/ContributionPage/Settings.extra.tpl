<div id="customData"></div>
{* include custom data js file *}
{include file="CRM/common/customData.tpl"}
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $($('div#customData')).insertAfter('.crm-contribution-contributionpage-settings-form-block table:last');
    CRM.buildCustomData("{/literal}{$customDataType}{literal}");
  });
</script>
{/literal}

{*include custom data js file*}
  {include file="CRM/common/customData.tpl"}
<script type="text/javascript">
  CRM.$('.form-layout-compressed:eq(3)').find('tbody').append('<tr><td class="label"><label>' + "{ts}Please choose custom fields{/ts}:"  + '</label></td><td><div id="customData"></div></td></tr>');
  CRM.buildCustomData("{$customDataType}");
</script>

<br>
<div class="bold">Personal Campaign Page</div>

{if $rows}
<table class="selector row-highlight" ng-app="myApp" ng-controller="myCtrl">
    <tr class="columnheader">
        
        <th scope="col">{ts}Personal Campaign Page{/ts}</th>       
        <th scope="col">{ts}Page or Event{/ts}</th>
        <th scope="col">{ts}No. contribution{/ts}</th>
        <th scope="col">{ts}Raised Amount{/ts}</th>
        <th scope="col">{ts}Total Amount{/ts}</th>
         <th scope="col">{ts}Status{/ts}</th>
        <th></th>
    </tr>

    {foreach from=$rows item=row}
        <tr id='rowid{$row.id}' class="{cycle values="odd-row,even-row"}">
            <td><a target="_blank" href="{crmURL p="civicrm/pcp/info" q="reset=1&id=`$row.id`"}" title="{ts}View Personal Campaign Page{/ts}">{$row.title}</a></td>
             
            <td><a target="_blank" href="{$row.page_url}" title="{ts}Visit{/ts}">{$row.page_title}</a></td>
            <td>
                <a href="{crmURL p="civicrm/contribute/search" q="reset=1&force=1&pcp_id=`$row.id`"}">{$row.contributions}</a>
            </td>
            <td>{$row.achieved|crmMoney:$row.currency}</td>
            <td>{$row.goal_amount|crmMoney:$row.currency}</td>            
            <td>{$row.status}</td>
            <td><a target="_blank" class="action-item crm-hover-button" href="{$row.edit_action}" title="{ts}Edit Personal Campaign Page{/ts}">{ts}Edit{/ts}</a></td>
        </tr>
    {/foreach}
</table>
{else}
<div class="messages status no-popup">
      <div class="icon inform-icon"></div> &nbsp; No Records found.     
</div>
{/if}

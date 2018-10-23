<script src="{php} echo BASE_URL; {/php}project/js/callmanagement.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/jquery.colorbox.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/popups.js"></script>
<link media="screen" rel="stylesheet" href="{php} echo BASE_URL; {/php}project/styles/colorbox.css" />
<link rel="stylesheet" href="{php} echo BASE_URL; {/php}project/js/tooltip/tip-darkgray.css" type="text/css" />
<script type="text/javascript" src="{php} echo BASE_URL; {/php}project/js/tooltip/jquery.poshytip.js"></script>
 
<div class="dboard_Submenu">
    <div class="sitewidth">
        <a class="create" href="{php} echo PageContext::$response->baseUrl; {/php}agents/addagent">Add Agent</a>
    </div>
</div>

<div class="content_pannel">
    <div class="sitewidth dboardwrapper">
  		{php}PageContext::renderRegisteredPostActions('messagebox');{/php}
        <div class="dboard_row">
          {if sizeof(PageContext::$response->agents)>0}
            <div class="fullwidthtable">
                <div class="tabular_display_title">
                    <h2>Agents</h2>
					
			{php}PageContext::renderRegisteredPostActions('searchbox');{/php}		
             
                    <div class="clear"></div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="db_tablestyle" id="jleads" width="100%">
                    <tr class="subhead">
                        <td valign="top" align="left">#</td>
                        <td valign="top" align="left"><a href="{php} echo PageContext::$response->baseUrl; {/php}agents/index?sort=agent_fname&sortby={php} echo PageContext::$response->order; {/php}">Name</a>{PageContext::$response->agent_fname_sortorder}</td>
                        <td valign="top" align="left">Email</td>
                        <td valign="top" align="left">Department</td>
                        <td valign="top" align="left"><a href="{php} echo PageContext::$response->baseUrl; {/php}agents/index?sort=agent_extn&sortby={php} echo PageContext::$response->order; {/php}">Extension</a>{PageContext::$response->agent_extn_sortorder}</td>
                        <td valign="top" align="left">&nbsp;</td>
                    </tr>
                    {assign var="i" value=PageContext::$response->slno}
                    {foreach from=PageContext::$response->agents key=id item=agent}
                        {if $i is even} {assign var="class" value="row2"}{else} {assign var="class" value="row1"}{/if}
                            <tr class="{$class}">
                                <td valign="top" align="left">{$i}</td>
                                <td valign="top" align="left"><a href="{php} echo PageContext::$response->baseUrl; {/php}agents/view/{$agent->agent_id}">{$agent->agent_fname} {$agent->agent_lname}</a></td>
                                <td valign="top" align="left">{$agent->agent_email}</td>
                                <td valign="top" align="left">{$agent->dept_name}</td>
                                 <td valign="top" align="left">{$agent->agent_extn}</td>
                                <td valign="top" align="left" width="70">
                                    <a href="{php} echo PageContext::$response->baseUrl; {/php}agents/view/{$agent->agent_id}" class="leadlistview" title="view"></a>
                                    <a href="{php} echo PageContext::$response->baseUrl; {/php}agents/addagent/{$agent->agent_id}" class="leadlistedit" title="edit"></a>
                                    <a href="{php} echo PageContext::$response->baseUrl; {/php}agents/deleteAgent/{$agent->agent_id}" class="leadlistdelete jleaddelete" rel="{$agent->l_id}" title="delete"></a>
                                </td>
                            </tr>
                        {assign var="i" value=$i+1}
                    {/foreach} 


                </table>
            </div>
          <div>
                    {PageContext::$response->pagination}
           </div>
          {elseif PageContext::$request['searchtext']==''}
            <div class="notificationdiv">
                No agents added yet
            </div>
            {else}
           {php}PageContext::renderRegisteredPostActions('searchbox');{/php}		
            <div class="notificationdiv">
                No search results found
            </div>
            {/if}
        </div>



        <div class="clear"></div>
    </div>
</div>
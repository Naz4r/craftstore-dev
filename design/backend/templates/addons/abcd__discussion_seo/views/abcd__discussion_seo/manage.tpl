{capture name="mainbox"}

    <form action="{""|fn_url}" method="post" name="seo_tag_form" id="seo_tag_form">
        <input type="hidden" name="sl" value="{$smarty.request.sl|default:$smarty.const.DESCR_SL}" />

        <div class="table-responsive-wrapper longtap-selection">
            {if $tag_data}
                <table class="table table-middle table--relative table-responsive table--overflow-hidden">
                    <thead>
                    <tr>
                        <th width="5%" class="left mobile-hide"></th>
                        <th width="35%">{__("abcd__discussion_seo.page_name")}</th>
                        <th width="20%">{__("abcd__discussion_seo.thread_id")}</th>
                        <th class="center">{__("abcd__discussion_seo.tools")}</th>
                        <th class="right">{__("abcd__discussion_seo.status")}</th>
                    </tr>
                    </thead>

                    {foreach from=$tag_data item=tag}
                        <tr class="cm-row-status-{$tag.status|lower} cm-longtap-target">
                            <td class="left mobile-hide"></td>
                            <td data-th="{__("abcd__discussion_seo.page_name")}">
                                {assign var="url" value="abcd__discussion_seo.update?thread_id=`$tag.thread_id`&sl=`$smarty.request.sl|default:$smarty.const.DESCR_SL`"|fn_url}
                                <a class="cm-dialog-opener link--monochrome"
                                   data-ca-target-id="seo_tag_popup"
                                   href="{$url}">
                                    {$tag.page_name|escape}
                                </a>
                            </td>
                            <td data-th="{__("abcd__discussion_seo.thread_id")}">{$tag.thread_id}</td>
                            <td class="center" data-th="{__("abcd__discussion_seo.tools")}">
                                {capture name="tools_list"}
                                    <li>{btn type="list" text=__("abcd__discussion_seo.preview") href="index.php?dispatch=discussion.view?thread_id=`$tag.thread_id`" target="_blank" rel="noopener noreferrer"}</li>
                                    <li class="divider"></li>
                                    <li>{btn type="list" text=__("abcd__discussion_seo.edit") class="cm-dialog-opener" data-ca-target-id="seo_tag_popup" href="abcd__discussion_seo.update?thread_id=`$tag.thread_id`&sl=`$smarty.request.sl|default:$smarty.const.DESCR_SL`"}</li>
                                    <li>{btn type="list" text=__("abcd__discussion_seo.delete") class="cm-confirm" href="abcd__discussion_seo.delete?thread_id=`$tag.thread_id`" method="POST"}</li>
                                {/capture}
                                <div class="hidden-tools">
                                    {dropdown content=$smarty.capture.tools_list class="dropleft"}
                                </div>
                            </td>
                            <td class="right nowrap" data-th="{__("abcd__discussion_seo.status")}">
                                {include file="common/select_popup.tpl"
                                type="status"
                                id=$tag.thread_id
                                status=$tag.status|default:"A"
                                hidden=true
                                object_id_name="thread_id"
                                table="abcd__discussion_seo"
                                popup_additional_class="dropleft"
                                }
                            </td>
                        </tr>
                    {/foreach}
                </table>
            {else}
                <p class="no-items">{__("no_data")}</p>
            {/if}
        </div>
    </form>
{/capture}

{capture name="adv_buttons"}
    {include file="common/popupbox.tpl"
    id="seo_tag_popup"
    text=__("abcd__discussion_seo.add_new_tag")
    title=__("abcd__discussion_seo.add_new_tag")
    href="abcd__discussion_seo.update?sl=`$smarty.request.sl|default:$smarty.const.DESCR_SL`"
    act="general"
    icon="icon-plus"
    link_class="btn btn-primary"
    }
{/capture}

{include file="common/mainbox.tpl"
title=__("abcd__discussion_seo")
content=$smarty.capture.mainbox
adv_buttons=$smarty.capture.adv_buttons
select_languages=true
}

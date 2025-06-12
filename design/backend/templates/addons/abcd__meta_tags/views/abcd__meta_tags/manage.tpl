{capture name="mainbox"}

    <form action="{""|fn_url}" method="post" name="meta_tags_form" id="meta_tags_form">
        <input type="hidden" name="sl" value="{$smarty.request.sl|default:$smarty.const.DESCR_SL}" />

        <div class="table-responsive-wrapper longtap-selection">
            <table class="table table-middle table--relative table-responsive table--overflow-hidden">
                <thead>
                <tr>
                    <th width="5%" class="left mobile-hide"></th>
                    <th width="35%">{__("page_name")}</th>
                    <th width="20%">{__("thread_id")}</th>
                    <th class="center">{__("tools")}</th>
                    <th class="right">{__("status")}</th>
                </tr>
                </thead>

                {foreach from=$meta_tags item=tag}
                    <tr class="cm-longtap-target">
                        <td class="left mobile-hide"></td>
                        <td data-th="{__("page_name")}">{$tag.page_name|escape}</td>
                        <td data-th="{__("thread_id")}">{$tag.thread_id}</td>
                        <td class="center" data-th="{__("tools")}">
                            {capture name="tools_list"}
                                <li>{btn type="list" text=__("edit")  class="cm-dialog-opener" data-ca-target-id="meta_tag_popup" href="abcd__meta_tags.update?thread_id=`$tag.thread_id`&sl=`$smarty.request.sl|default:$smarty.const.DESCR_SL`"}</li>
                                <li>{btn type="list" text=__("delete") class="cm-confirm" href="abcd__meta_tags.delete?thread_id=`$tag.thread_id`" method="POST"}</li>
                            {/capture}
                            {dropdown content=$smarty.capture.tools_list class="dropleft"}
                        </td>
                        <td class="right nowrap" data-th="{__("status")}">
                            {include file="common/select_popup.tpl"
                            type="tags"
                            id=$tag.thread_id
                            status=$tag.status|default:"A"
                            hidden=true
                            object_id_name="thread_id"
                            table="abcd__meta_tags"
                            popup_additional_class="dropleft"}
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
    </form>

{/capture}

{capture name="adv_buttons"}
    {include file="common/popupbox.tpl"
    id="meta_tag_popup"
    text=__("add_new_meta_tag")
    title=__("add_new_meta_tag")
    href="abcd__meta_tags.update?sl=`$smarty.request.sl|default:$smarty.const.DESCR_SL`"
    act="general"
    icon="icon-plus"
    link_class="btn btn-primary"
    }
{/capture}

{include file="common/mainbox.tpl"
title=__("ab:meta_tags")
content=$smarty.capture.mainbox
adv_buttons=$smarty.capture.adv_buttons
select_languages=true
}

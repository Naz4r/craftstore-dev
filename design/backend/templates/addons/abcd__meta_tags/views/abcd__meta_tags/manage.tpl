{capture name="mainbox"}

    <form action="{""|fn_url}" method="post" name="meta_tags_form" id="meta_tags_form">
        <input type="hidden" name="sl" value="{$smarty.request.sl|default:$smarty.const.DESCR_SL}" />

        <div class="table-responsive-wrapper longtap-selection">
            {if $meta_tags}
            <table class="table table-middle table--relative table-responsive table--overflow-hidden">
                <thead>
                <tr>
                    <th width="5%" class="left mobile-hide"></th>
                    <th width="35%">{__("page_name")}</th>
                    <th width="20%">{__("thread_id")}</th>
                    <th class="center"></th>
                    <th class="right">{__("status")}</th>
                </tr>
                </thead>

                {foreach from=$meta_tags item=tag}
                    <tr class="cm-row-status-{$tag.status|lower} cm-longtap-target">
                        <td class="left mobile-hide"></td>
                        <td data-th="{__("page_name")}">{$tag.page_title|escape}</td>
                        <td data-th="{__("thread_id")}">{$tag.thread_id}</td>
                        <td class="center {$no_hide_input}" data-th="{__("meta_tags_tools")}">
                            {capture name="tools_list"}
                                <li>{btn type="list" text=__("preview") href="index.php?dispatch=discussion.view?thread_id=`$tag.thread_id`" target="_blank" rel="noopener noreferrer"}</li>
                                <li class="divider"></li>
                                <li>{btn type="list" text=__("edit") class="cm-dialog-opener" data-ca-target-id="meta_tag_popup" href="abcd__meta_tags.update?thread_id=`$tag.thread_id`&sl=`$smarty.request.sl|default:$smarty.const.DESCR_SL`"}</li>
                                <li>{btn type="list" text=__("delete") class="cm-confirm" href="abcd__meta_tags.delete?thread_id=`$tag.thread_id`" method="POST"}</li>
                            {/capture}
                            <div class="hidden-tools">
                                {dropdown content=$smarty.capture.tools_list class="dropleft"}
                            </div>
                        </td>
                        <td class="right nowrap" data-th="{__("status")}">
                            {include file="common/select_popup.tpl"
                            type="status"
                            id=$tag.thread_id
                            status=$tag.status|default:"A"
                            hidden=true
                            object_id_name="thread_id"
                            table="abcd__meta_tags"
                            popup_additional_class="`$no_hide_input` dropleft"
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
{literal}
    <script>
        (function(_, $) {
            $.ceEvent('on', 'ce.dialogclose', function() {
                location.reload();
            });
        })(Tygh, Tygh.$);
    </script>
{/literal}
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
title=__("abcd:meta_tags")
content=$smarty.capture.mainbox
adv_buttons=$smarty.capture.adv_buttons
select_languages=true
}

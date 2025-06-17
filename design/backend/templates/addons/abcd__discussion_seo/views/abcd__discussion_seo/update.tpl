<form action="{fn_url('abcd__discussion_seo.update')}" method="post" name="seo_tag_update_form" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="thread_id" value="{$tag_data.thread_id|default:0}" />
    <input type="hidden" name="sl" value="{$smarty.request.sl|default:$smarty.const.DESCR_SL}" />
    <input type="hidden" name="redirect_url" value="{fn_url('abcd__discussion_seo.manage')}" />

    <div class="control-group">
        <label class="control-label" for="elm_abcd__discussion_seo.page_name">{__("abcd__discussion_seo.page_name")}</label>
        <div class="controls">
            <input type="text" name="seo_tag_data[page_name]" id="elm_abcd__discussion_seo.page_name" value="{$tag_data.page_name|default:""}" class="input-large" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="elm_abcd__discussion_seo.thread_id">{__("abcd__discussion_seo.thread_id")}</label>
        <div class="controls">
            {if $tag_data.thread_id}
                <input type="number" name="seo_tag_data[thread_id]" id="elm_abcd__discussion_seo.thread_id" value="{$tag_data.thread_id}" class="input-large" readonly />
            {else}
                <input type="number" name="seo_tag_data[thread_id]" id="elm_abcd__discussion_seo.thread_id" value="" class="input-large" />
            {/if}
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="elm_abcd__discussion_seo.page_title">{__("abcd__discussion_seo.page_title")}</label>
        <div class="controls">
            <input type="text" name="seo_tag_data[page_title]" id="elm_abcd__discussion_seo.page_title" value="{$tag_data.page_title|default:""}" class="input-large" />
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="elm_abcd__discussion_seo.meta_description">{__("abcd__discussion_seo.meta_description")}</label>
        <div class="controls">
            <input type="text" name="seo_tag_data[meta_description]" id="elm_abcd__discussion_seo.meta_description" value="{$tag_data.meta_description|default:""}" class="input-large" />
        </div>
    </div>

    {if $addons.seo.status == "A"}
        {include file="addons/seo/common/seo_name_field.tpl"
        object_data=$tag_data
        object_name="seo_tag_data"
        object_id=$tag_data.thread_id
        object_type="€"
        dispatch="discussion.view"
        }
    {/if}

    <div class="buttons-container">
        {include file="buttons/save_cancel.tpl"
        but_name="dispatch[abcd__discussion_seo.update]"
        cancel_action="close"
        save=$tag_data.thread_id
        }
    </div>
</form>

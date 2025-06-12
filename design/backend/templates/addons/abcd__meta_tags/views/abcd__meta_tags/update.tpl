{if $meta_tag.thread_id}
    {assign var="id" value=$meta_tag.thread_id}
{else}
    {assign var="id" value=0}
{/if}

<form action="{fn_url('abcd__meta_tags.update')}" method="post" name="meta_tag_update_form" class="form-horizontal cm-ajax" enctype="multipart/form-data">
    <input type="hidden" name="thread_id" value="{$meta_tag.thread_id|default:0}" />
    <input type="hidden" name="sl" value="{$smarty.request.sl}" />


    <div class="cm-tabs-content">
        <div class="control-group">
            <label class="control-label" for="elm_page_name">{__("page_name")}</label>
            <div class="controls">
                <input type="text" name="meta_tag_data[page_name]" id="elm_page_name" value="{$meta_tag.page_name|default:""}" class="input-large" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="elm_thread_id">{__("thread_id")}</label>
            <div class="controls">
                {if $meta_tag.thread_id}
                    <input type="number" name="meta_tag_data[thread_id]" id="elm_thread_id" value="{$meta_tag.thread_id}" class="input-large" readonly />
                {else}
                    <input type="number" name="meta_tag_data[thread_id]" id="elm_thread_id" value="" class="input-large" />
                {/if}
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="elm_page_title">{__("page_title")}</label>
            <div class="controls">
                <input type="text" name="meta_tag_data[page_title]" id="elm_page_title" value="{$meta_tag.page_title|default:""}" class="input-large" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="elm_meta_description">{__("meta_description")}</label>
            <div class="controls">
                <input type="text" name="meta_tag_data[meta_description]" id="elm_meta_description" value="{$meta_tag.meta_description|default:""}" class="input-large" />
            </div>
        </div>
    </div>
    {if $addons.seo.status == 'A'}
        {include file="addons/seo/common/seo_name_field.tpl"
        object_data=$meta_tag_data
        object_name="meta_tag_data"
        object_id=$meta_tag_data.thread_id
        object_type="mt"
        }
    {/if}

    <div class="buttons-container">
        {include file="buttons/save_cancel.tpl" but_name="dispatch[abcd__meta_tags.update]" cancel_action="close" save=$id}
    </div>
</form>

<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }


function fn_abcd__meta_tags_update(array $promotion_data)
{
    $lang_code = $_REQUEST['descr_sl'] ?? CART_LANGUAGE;
    $thread_id = $promotion_data['thread_id'] ?? 1;
    $page_title = $promotion_data['page_title'] ?? '';
    $meta_description = $promotion_data['meta_description'] ?? '';
    $page_name=$promotion_data['page_name']??'';

    if (!$thread_id) {
        return false;
    }

    db_query("REPLACE INTO ?:abcd__meta_tags (thread_id, page_name) VALUES (?i, ?s)", $thread_id, $page_name);

    db_query("REPLACE INTO ?:abcd__meta_tags_descriptions (thread_id, page_title, meta_description, lang_code) VALUES (?i, ?s, ?s, ?s)",
        $thread_id, $page_title, $meta_description, $lang_code);

    return true;
}

function fn_abcd__get_all_meta_tags($params)
{
    $lang_code = $params['descr_sl'] ?? CART_LANGUAGE;


    $meta_tags = db_get_array(
        "SELECT mthead.thread_id, mthead.page_name, mdesc.page_title, mdesc.meta_description, mdesc.lang_code
     FROM ?:abcd__meta_tags AS mthead
     INNER JOIN ?:abcd__meta_tags_descriptions AS mdesc
         ON mthead.thread_id = mdesc.thread_id
     WHERE mdesc.lang_code = ?s
     ORDER BY mthead.thread_id ASC", $lang_code
    );

    return $meta_tags;
}

function fn_abcd__meta_tags_update_tags($thread_id, $lang_code)
{
        return db_get_row("
    SELECT mthead.thread_id, mthead.page_name, mdesc.page_title, mdesc.meta_description, mdesc.lang_code
    FROM ?:abcd__meta_tags AS mthead
    LEFT JOIN ?:abcd__meta_tags_descriptions AS mdesc
        ON mthead.thread_id = mdesc.thread_id AND mdesc.lang_code = ?s
    WHERE mthead.thread_id = ?i
", $lang_code, $thread_id);
}

function fn_abcd__meta_tags_delete_tags(array $thread_ids)
{

    if (empty($thread_ids)) {
        return false;
    }

    db_query("
    DELETE mt, mtd
    FROM ?:abcd__meta_tags AS mt
    LEFT JOIN ?:abcd__meta_tags_descriptions AS mtd ON mt.thread_id = mtd.thread_id
    WHERE mt.thread_id IN (?a)
", $thread_ids);

    return true;
}
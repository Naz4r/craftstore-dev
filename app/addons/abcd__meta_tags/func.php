<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Registry;

/**
 * Оновлення тегів для дискусії (thread)
 */
function fn_abcd__meta_tags_update(array $data)
{
    $lang_code = $_REQUEST['sl'] ?? CART_LANGUAGE;
    $thread_id = $data['thread_id'] ?? 0;
    if (!$thread_id) {
        return false;
    }

    db_query("INSERT INTO ?:abcd__meta_tags (thread_id, status) VALUES (?i, 'A') ON DUPLICATE KEY UPDATE status = status", $thread_id);


    db_query("REPLACE INTO ?:abcd__meta_tags_descriptions (thread_id, page_title, meta_description, lang_code) VALUES (?i, ?s, ?s, ?s)",
        $thread_id,
        $data['page_title'] ?? '',
        $data['meta_description'] ?? '',
        $lang_code
    );

    if (Registry::get('addons.seo.status') === 'A') {
        fn_seo_update_object($data, $thread_id, 't', $lang_code);
    }

    return true;
}

/**
 * Отримання усіх мета тегів для заданої мови
 */
function fn_abcd__get_all_meta_tags($params)
{
    $lang_code = $params['descr_sl'] ?? CART_LANGUAGE;

    $meta_tags = db_get_array(
        "SELECT mthead.thread_id, mthead.status, mdesc.page_title, mdesc.meta_description, mdesc.lang_code
         FROM ?:abcd__meta_tags AS mthead
         INNER JOIN ?:abcd__meta_tags_descriptions AS mdesc
             ON mthead.thread_id = mdesc.thread_id
         WHERE mdesc.lang_code = ?s
         ORDER BY mthead.thread_id ASC",
        $lang_code
    );

    return $meta_tags;
}

/**
 * Отримання тегів для конкретного thread_id і мови
 */
function fn_abcd__meta_tags_update_tags($thread_id, $lang_code)
{
    $data = db_get_row("
        SELECT mthead.thread_id, mdesc.page_title, mdesc.meta_description, mdesc.lang_code
        FROM ?:abcd__meta_tags AS mthead
        LEFT JOIN ?:abcd__meta_tags_descriptions AS mdesc
            ON mthead.thread_id = mdesc.thread_id AND mdesc.lang_code = ?s
        WHERE mthead.thread_id = ?i
    ", $lang_code, $thread_id);

    if ($data) {
        $data['seo_name'] = fn_seo_get_name('t', $thread_id, '', null, $lang_code);
    }

    return $data;
}

/**
 * Видалення тегів
 */
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

    if (Registry::get('addons.seo.status') === 'A') {
        foreach ($thread_ids as $thread_id) {
            fn_delete_seo_name($thread_id, 't');
        }
    }
    return true;
}

/**
 * Оновлення статусу тегів
 */
function fn_abcd__meta_tags_update_tags_status($thread_id, $new_status)
{
    if (!$thread_id || !in_array($new_status, ['A', 'D'])) {
        return false;
    }

    db_query("UPDATE ?:abcd__meta_tags SET status = ?s WHERE thread_id = ?i", $new_status, $thread_id);

    fn_set_notification('N', __('notice'), __('status_changed'));

    Tygh::$app['ajax']->assign('status_update', [
        'status' => 'ok',
        'new_status' => $new_status,
        'thread_id' => $thread_id,
    ]);

    return true;
}

function fn_abcd__meta_tags_update_tags_for_frontend($thread_id, $lang_code)
{
    $data = db_get_row("
        SELECT mthead.thread_id, mthead.status, mdesc.page_title, mdesc.meta_description, mdesc.lang_code
        FROM ?:abcd__meta_tags AS mthead
        LEFT JOIN ?:abcd__meta_tags_descriptions AS mdesc
            ON mthead.thread_id = mdesc.thread_id AND mdesc.lang_code = ?s
        WHERE mthead.thread_id = ?i
    ", $lang_code, $thread_id);

    if ($data && $data['status'] === 'A') {
        $data['seo_name'] = fn_seo_get_name('t', $thread_id, '', null, $lang_code);
        return $data;
    }

    return false;
}

/**
 * Підключення мета тегів до сторінки перегляду дискусії
 */
function fn_abcd__meta_tags_dispatch_before_display()
{
    if (Registry::get('runtime.controller') === 'discussion' && Registry::get('runtime.mode') === 'view')
    {
        $thread_id = (int) ($_REQUEST['thread_id'] ?? 0);

        if ($thread_id) {
            $lang_code = CART_LANGUAGE;

            $meta = fn_abcd__meta_tags_update_tags_for_frontend($thread_id, $lang_code);

            if ($meta) {
                Tygh::$app['view']->assign('page_title', $meta['page_title']);
                Tygh::$app['view']->assign('meta_description', $meta['meta_description']);
            }
        }
    }
}

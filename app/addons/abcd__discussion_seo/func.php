<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Enum\SiteArea;
use Tygh\Registry;
use Tygh\Languages\Languages;
use Tygh\Enum\ObjectStatuses;

/**
 * Оновлення тегів для відгуків (thread)
 */
function fn_abcd__ds_update_page_data(array $data,$thread_id)
{
    $thread_id = (int) $thread_id;
    if (!$thread_id) {
        return false;
    }

    db_query("REPLACE INTO ?:abcd__discussion_seo ?e", $data);

    $lang_code = $data['lang_code'] ?? DESCR_SL;

    $exists = db_get_field(
        "SELECT 1 FROM ?:abcd__discussion_seo WHERE thread_id = ?i LIMIT 1",
        $thread_id
    );

    $descriptions_data = [];

    if ($exists) {
        // Тільки одна мова
        $descriptions_data[] = array_merge($data, ['lang_code' => $lang_code]);
    } else {
        // Всі мови
        $languages = Languages::getAll();
        foreach ($languages as $code => $_) {
            $descriptions_data[] = array_merge($data, ['lang_code' => $code]);
        }
    }

    foreach ($descriptions_data as $desc) {
        db_query("REPLACE INTO ?:abcd__discussion_seo_descriptions ?e", $desc);

        if (Registry::get('addons.seo.status') === ObjectStatuses::ACTIVE) {
            fn_seo_update_object($desc, $thread_id, ABCD_DS_OBJECT_TYPE, $desc['lang_code']);
        }
    }
    return $thread_id;
}

/**
 * Отримання усіх мета тегів для заданої мови
 */
function fn_abcd__ds_get_list_page_tags($params)
{
    $lang_code = $params['descr_sl'] ?? CART_LANGUAGE;

    return db_get_array(
        "SELECT ds.thread_id, ds.status, ds.page_name, dsd.page_title, dsd.meta_description, dsd.lang_code
         FROM ?:abcd__discussion_seo AS ds
         INNER JOIN ?:abcd__discussion_seo_descriptions AS dsd
             ON ds.thread_id = dsd.thread_id
         WHERE dsd.lang_code = ?s
         ORDER BY ds.thread_id ASC",
        $lang_code
    );
}

/**
 * Отримання тегів для конкретного thread_id і мови
 */
function fn_abcd__ds_get_page_data($thread_id, $lang_code)
{
    $data = db_get_row("
        SELECT ds.thread_id, ds.status, ds.page_name, dsd.page_title, dsd.meta_description, dsd.lang_code
        FROM ?:abcd__discussion_seo AS ds
        LEFT JOIN ?:abcd__discussion_seo_descriptions AS dsd
            ON ds.thread_id = dsd.thread_id AND dsd.lang_code = ?s
        WHERE ds.thread_id = ?i",
        $lang_code, $thread_id
    );

    if (!$data) {
        return false;
    }

    if (SiteArea::isStorefront(AREA) && $data['status'] !== ObjectStatuses::ACTIVE) {
        return false;
    }

    $data['seo_name'] = fn_seo_get_name(ABCD_DS_OBJECT_TYPE, $thread_id, '', null, $lang_code);

    return $data;
}


/**
 * Видалення тегів
 */
function fn_abcd__ds_delete_page_tags(array $thread_ids)
{
    if (empty($thread_ids)) {
        return false;
    }

    db_query("
        DELETE ds, dsd
        FROM ?:abcd__discussion_seo AS ds
        LEFT JOIN ?:abcd__discussion_seo_descriptions AS dsd 
            ON ds.thread_id = dsd.thread_id
        WHERE ds.thread_id IN (?a)",
        $thread_ids
    );

    if (Registry::get('addons.seo.status') === ObjectStatuses::ACTIVE) {
        foreach ($thread_ids as $thread_id) {
            fn_delete_seo_name($thread_id, ABCD_DS_OBJECT_TYPE);
        }
    }

    return true;
}

/**
 * Підключення мета тегів до сторінки перегляду відгуків
 */
function fn_abcd__discussion_seo_dispatch_before_display()
{
    if (Registry::get('runtime.controller') === 'discussion' && Registry::get('runtime.mode') === 'view') {
        $thread_id = (int) ($_REQUEST['thread_id'] ?? 0);

        if ($thread_id) {
            $lang_code = CART_LANGUAGE;

            $meta = fn_abcd__ds_get_page_data($thread_id, $lang_code);

            if ($meta) {
                Tygh::$app['view']->assign('page_title', $meta['page_title']);
                Tygh::$app['view']->assign('meta_description', $meta['meta_description']);
            }
        }
    }
}

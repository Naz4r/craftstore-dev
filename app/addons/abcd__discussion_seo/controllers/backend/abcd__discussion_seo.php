<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $thread_id = isset($_REQUEST['thread_id']) ? (int) $_REQUEST['thread_id'] : 0;

    if ($mode === 'update') {
        if (!empty($_REQUEST['seo_tag_data'])) {
            fn_abcd__ds_update_page_data($_REQUEST['seo_tag_data'],$thread_id);
        }

        return [CONTROLLER_STATUS_OK, "abcd__discussion_seo.manage"];
    }

    if ($mode === 'delete') {
        if ($thread_id) {
            fn_abcd__ds_delete_page_tags([$thread_id]);
        }

        return [CONTROLLER_STATUS_OK, 'abcd__discussion_seo.manage'];
    }
    return;
}

if ($mode === 'manage') {
    $params = $_REQUEST;

    $tags_data = fn_abcd__ds_get_list_page_tags($params);

    Tygh::$app['view']->assign([
        'tag_data' => $tags_data,
        'params'    => $params,
    ]);
}

if ($mode === 'update') {
    $thread_id = isset($_REQUEST['thread_id']) ? (int) $_REQUEST['thread_id'] : 0;
    $lang_code = $_REQUEST['sl'] ?? CART_LANGUAGE;

    $data = [];

    if ($thread_id > 0) {
        $data = fn_abcd__ds_get_page_data($thread_id, $lang_code);

        if (empty($data)) {
            return [CONTROLLER_STATUS_NO_PAGE];
        }
        Tygh::$app['view']->assign('data', $data);
    }

    Tygh::$app['view']->assign('tag_data', $data);
    Tygh::$app['view']->assign('thread_id', $thread_id);
}

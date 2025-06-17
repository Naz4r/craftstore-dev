<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD']	== 'POST') {
    if ($mode === 'update') {
        if (!empty($_REQUEST['meta_tag_data'])) {
            fn_abcd__meta_tags_update($_REQUEST['meta_tag_data']);

            fn_set_notification('N', __('notice'), __('ab__meta_tags.updated'));
        }
        return [CONTROLLER_STATUS_OK, "abcd__meta_tags.manage"];
    }
    if ($mode == 'delete') {
        if (!empty($_REQUEST['thread_id'])) {
            fn_abcd__meta_tags_delete_tags([(int) $_REQUEST['thread_id']]);
        }
        return [CONTROLLER_STATUS_OK, 'abcd__meta_tags.manage'];
    }
    if ($mode === 'update_status') {
        $thread_id = isset($_REQUEST['thread_id']) ? (int) $_REQUEST['thread_id'] : 0;
        $status = $_REQUEST['status'] ?? '';

        if ($thread_id > 0 && in_array($status, ['A', 'D'])) {
            fn_abcd__meta_tags_update_tags_status($thread_id, $status);
        }
        exit;
    }

}
if ($mode == 'manage') {
    $params = $_REQUEST;

    $meta_tags = fn_abcd__get_all_meta_tags($params);

    Tygh::$app['view']->assign([
        'meta_tags' => $meta_tags,
        'params'    => $params,
    ]);
}
if ($mode === 'update') {
    $thread_id = isset($_REQUEST['thread_id']) ? (int) $_REQUEST['thread_id'] : 0;
    $lang_code = $_REQUEST['descr_sl'] ?? CART_LANGUAGE;

    $tags=[];

    if ($thread_id > 0) {
        $tags = fn_abcd__meta_tags_update_tags($thread_id, $lang_code);

        if (empty($tags)) {
            return [CONTROLLER_STATUS_NO_PAGE];
        }
        Tygh::$app['view']->assign('tags', $tags);
    }
    Tygh::$app['view']->assign('meta_tag', $tags);
    Tygh::$app['view']->assign('thread_id', $thread_id);
}
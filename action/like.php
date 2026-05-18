<?php

/**
 * 点赞 AJAX 接口
 *
 * POST /usr/themes/fuck/action/like.php
 * Body: cid=<文章ID>
 * Response: {"count": 数字}
 */

// 引入 Typecho 环境（config.inc.php 已完成自动加载注册和数据库初始化）
$config = dirname(dirname(dirname(dirname(__DIR__)))) . '/config.inc.php';
if (!file_exists($config)) {
    http_response_code(500);
    exit(json_encode(['error' => 'Config not found']));
}
require_once $config;

// 获取已初始化的数据库实例
$db = \Typecho\Db::get();

// 只接受 POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['error' => 'Method not allowed']));
}

$cid = isset($_POST['cid']) ? (int)$_POST['cid'] : 0;
if ($cid <= 0) {
    exit(json_encode(['error' => 'Invalid cid']));
}

// 查询当前点赞数
$field = $db->fetchRow(
    $db->select('str_value')->from('table.fields')
        ->where('cid = ?', $cid)->where('name = ?', 'agree')
);

if (!$field) {
    // 首次点赞，初始化字段
    $db->query($db->insert('table.fields')->rows([
        'cid'         => $cid,
        'name'        => 'agree',
        'type'        => 'str',
        'str_value'   => '1',
        'int_value'   => 0,
        'float_value' => 0,
    ]));
    $count = 1;
} else {
    // 点赞数 +1
    $count = (int)$field['str_value'] + 1;
    $db->query(
        $db->update('table.fields')
            ->rows(['str_value' => $count])
            ->where('cid = ?', $cid)
            ->where('name = ?', 'agree')
    );
}

header('Content-Type: application/json');
echo json_encode(['count' => $count]);

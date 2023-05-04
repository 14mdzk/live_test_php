<?php

$json = '{"custom":[{"type":"parent","id":1},{"type":"children","id":2,"data":"Hallo I\'m Apple","parent_id":1},{"type":"parent","id":3},{"type":"children","id":4,"data":"Hallo I\'m Orange","parent_id":3},{"type":"children","id":5,"data":"Hallo I\'m Banana","parent_id":3},{"type":"children","id":6,"data":"Hallo I\'m Human","parent_id":null}]}';
$data = (array) json_decode($json, true);
// uasort($data['custom'], function ($a, $b) {
//     return $a['id'] > $b['id'];
// });

$parents = [];
foreach ($data['custom'] as $item) {
    if ($item['type'] === 'parent' || is_null($item['parent_id'])) {
        $item['data'] = $item['data'] ?? [];
        $parents[] = $item;
        continue;
    }

    $parentIdx = array_search($item['parent_id'], array_column($parents, 'id'));
    if ($parentIdx >= 0) {
        $parents[$parentIdx]['data'][] = $item;
    } else {
        $parents[] = $item;
    }
}

echo json_encode($parents);

<?php
  require('mysql_connect.php');
  $sql = "select id from controls where mac_code = '". escape_params('mac_code') .
    "' and password = '". escape_params('password') . "'";
  $res = query($sql);
  $control = fetch_row($res);
  if(!$control) {
    $result = array('state' => 0);
    echo json_encode($result);
    exit();
  }
  if(params('type') == 'get') {
    $sql = "select * from actions where control_id = ". $control['id'] .
      " and state = 'new'";
    $res = query($sql);
    $result = array(
      'state' => 1
    );
    $actions = array();
    while($row = fetch_row($res)) {
      $actions[] = array(
        'action_id' => $row['id'],
        'device_ids' => int_array(explode(',', $row['device_ids'])),
        'device_states' => int_array(explode(',', $row['device_states']))
      );
    }
    $result['actions'] = $actions;
    echo json_encode($result);
  } else if(params('type') == 'create') {
    $device_ids = int_array(params('device_ids'));
    $states = int_array(params('states'));
    $index = 0;
    if(count($device_ids) > 0 && count($device_ids) == count($states)) {
      $sql = "insert into actions".
        " (remote_type, control_id, device_ids, device_states, state)".
        " values('pc', ". $control['id'] .", '". join(',', $device_ids) .
        "' , '". join(',', $states) . "', 'new')";
      $res = query($sql);
      $result = array(
        'state' => 1
      );
      echo json_encode($result);
    } else {
      $result = array(
        'state' => 0
      );
      echo json_encode($result);
    }
  }

  function int_array($arr) {
    $results = [];
    foreach($arr as $element) {
      $results[] = (int) $element;
    }
    return $results;
  }
?>
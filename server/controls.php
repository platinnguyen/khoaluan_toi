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
    $sql = "select devices.* from devices inner join controls on".
      " devices.control_id = controls.id and controls.id = ". $control['id'];
    $res = query($sql);
    $result = array(
      'state' => 1
    );
    $devices = array();
    while($row = fetch_row($res)) {
      $devices[] = array(
        'device_id' => $row['device_id'],
        'state' => (int) $row['state'],
        'message' => (string) $row['message'],
        'name' => (string) $row['name']
      );
    }
    $result['devices'] = $devices;
    echo json_encode($result);
  } else if(params('type') == 'update_password') {
    if(params('new_pass')) {
      $sql = "update controls set password = '". escape_params('new_pass').
        "' where mac_code = '". escape_params('mac_code') ."'";
      $res = query($sql);
      $result = array('state' => 1);
      echo json_encode($result);
    } else {
      $result = array('state' => 0);
      echo json_encode($result);
    }
  } else if(params('type') == 'update_data') {
    // echo params('action_id');
    $action_id = (int) params('action_id');
    $device_ids = params('device_ids');
    $states = params('states');
    $messages = params('messages');
    $index = 0;
    foreach ($device_ids as $device_id) {
      $state = (int) $states[$index];
      $message = escape($messages[$index]);
      if($device_id) {
        $sql = "update devices set action_id = ". $action_id .", state = ".
          $state .", message = '". $message . "'".
          " where control_id = ". $control['id'] ." and device_id = ". (int) $device_id;
        $res = query($sql);
      }
      $index = $index + 1;
    }
    $result = array('state' => 1);
    echo json_encode($result);
  }
?>
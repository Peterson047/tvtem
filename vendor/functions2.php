<?php
define('VIEW','53133342');
define('SERVICE_ACCOUNT','time-343118-2da486ee5da0.json');
define('DOMAIN','http://172.16.12.169/ga');

function getActivePages2($analytics){
  $optParams = array(
    'dimensions' => 'rt:pageTitle,rt:pagePath',
    'sort' => '-rt:activeVisitors',
    'max-results' => '16'
  );
  $result = $analytics
        ->data_realtime
        ->get2('ga:'.VIEW, 'rt:activeVisitors',$optParams);
  $table = '';
  if($result){
    $rows = $result->getRows2();
    if($rows){
      foreach($rows as $row){
        $table .= '<tr class="open-link" data-link="'.$row[1].'">';
        $table .= '<td>'.htmlspecialchars($row[0],ENT_NOQUOTES).'</td>';
        $table .= '<td>'.htmlspecialchars($row[2],ENT_NOQUOTES).'</td>';
        $table .= '</tr>';
      }
    }else{
      $table .= '<tr><td colspan="2"><small>There is no data to view</small></td></tr>';
    }
    return $table;
  }else{
    return '<tr><td colspan="2"><small>There is no data to view</small></td></tr>';
  }
}

function getActiveUsers2($analytics){
  $active_users = $analytics
          ->data_realtime
          ->get2('ga:'.VIEW, 'rt:activeVisitors');
  $active_users = (isset($active_users->rows[0][0]))?$active_users->rows[0][0]:0;
  return $active_users;
}


function getDevices2($analytics){
  $optParams = array(
    'dimensions' => 'rt:deviceCategory',
    'sort' => '-rt:activeVisitors'
  );
  $devices = $analytics
        ->data_realtime
        ->get2('ga:'.VIEW, 'rt:activeVisitors',$optParams);
  $html = '';
  if($devices->rows){
    $total = 0;
    $class = array('warning','success','danger');
    foreach($devices->rows as $row){
      $total += $row[1];
    }
    $loop = 0;
    $html .= '<div class="progress_label">';
    foreach($devices->rows as $row){
      $percent = round(($row[1]/$total)*100);
      $html .= '<div class="label label-'.$class[$loop].'">';
      $html .= '<span>'.$row[0].'</span>';
      $html .= '<span>'.$row[1].'</span>';
      $html .= '</div>';
      $loop++;
    }
    $html .= '</div>';
    $loop = 0;
    $html .= '<div class="progress" style="width:100%!important">';
    foreach($devices->rows as $row){
      $html .= '<div class="progress-bar progress-bar-'.$class[$loop].'" style="width:'.$percent.'%"></div>';
      $loop++;
    }
    $html .= '</div>';
  }
  return $html;
}


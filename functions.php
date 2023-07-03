<?php

// Define constantes
define('VIEW', '263429314');
define('SERVICE_ACCOUNT', 'pwa-temmais-6d342bd03c26.json');
define('DOMAIN', 'http://172.16.145.50/temmais/aracatuba');

// Obtém as páginas ativas no momento
function getActivePages($analytics)
{
  $optParams = array(
    'dimensions' => 'rt:pageTitle,rt:pagePath',
    'sort' => '-rt:activeVisitors',
    'max-results' => '3'
  );
  $result = $analytics
    ->data_realtime
    ->get('ga:' . VIEW, 'rt:activeVisitors', $optParams);

  $table = '';
  if ($result) {
    $rows = $result->getRows();
    if ($rows) {
      foreach ($rows as $row) {
        // Constrói uma linha da tabela HTML com o título e o caminho da página
        $table .= '<tr class="open-link" data-link="' . $row[1] . '">';
        $table .= '<td>' . htmlspecialchars($row[0], ENT_NOQUOTES) . '</td>';
        $table .= '<td>' . htmlspecialchars($row[2], ENT_NOQUOTES) . '</td>';
        $table .= '</tr>';
      }
    } else {
      // Mensagem exibida quando não há dados para exibir
      $table .= '<tr><td colspan="2"><small>There is no data to view</small></td></tr>';
    }
    return $table;
  } else {
    // Mensagem exibida quando não há dados para exibir
    return '<tr><td colspan="2"><small>There is no data to view</small></td></tr>';
  }
}

// Obtém o número de usuários ativos no momento
function getActiveUsers($analytics)
{
  $active_users = $analytics
    ->data_realtime
    ->get('ga:' . VIEW, 'rt:activeVisitors');
  $active_users = (isset($active_users->rows[0][0])) ? $active_users->rows[0][0] : 0;
  return $active_users;
}

// Obtém informações sobre os dispositivos utilizados pelos usuários ativos no momento
function getDevices($analytics)
{
  $optParams = array(
    'dimensions' => 'rt:deviceCategory',
    'sort' => '-rt:activeVisitors'
  );

  $devices = $analytics
    ->data_realtime
    ->get('ga:' . VIEW, 'rt:activeVisitors', $optParams);
  $html = '';
  if ($devices->rows) {
    $total = 0;
    $class = array('warning', 'success', 'danger');
    foreach ($devices->rows as $row) {
      $total += $row[1];
    }
    $loop = 0;
    $html .= '<div class="progress_label">';
    foreach ($devices->rows as $row) {
      $percent = round(($row[1] / $total) * 100);
      // Constrói uma representação HTML de barras de progresso com as porcentagens de uso de cada dispositivo
      $html .= '<div class="label label-' . $class[$loop] . '">';
      $html .= '<span>' . $row[0] . '</span>';
      $html .= '<span>' . $row[1] . '</span>';
      $html .= '</div>';
      $loop++;
    }
    $html .= '</div>';
    $loop = 0;
    $html .= '
    <div class="progress" style="width:100%!important">';
    foreach ($devices->rows as $row) {
      $html .= '<div class="progress-bar progress-bar-' . $class[$loop] . '" style="width:' . $percent . '%"></div>';
      $loop++;
    }
    $html .= '</div>';
  }
  return $html;
}

// Formata os dados obtidos em uma tabela HTML
function getFormattedData($result)
{
  $table = '';
  if ($result) {
    $rows = $result->getRows();
    if ($rows) {
      foreach ($rows as $row) {
        $table .= '<tr>';
        foreach ($row as $cell) {
          $table .= '<td>' . htmlspecialchars($cell, ENT_NOQUOTES) . '</td>';
        }
        $table .= '</tr>';
      }
    } else {
      // Mensagem exibida quando não há dados para exibir
      $table .= '<tr><td colspan="2"><small>There is no data to view</small></td></tr>';
    }
    return $table;
  } else {
    // Mensagem exibida quando não há dados para exibir
    return '<tr><td colspan="2"><small>There is no data to view</small></td></tr>';
  }
}

// Obtém as fontes de tráfego ativas no momento
function getTrafficSources($analytics)
{
  $optParams = array(
    'dimensions' => 'rt:source',
    'sort' => '-rt:activeVisitors',
    'max-results' => 3
  );

  $result = $analytics
    ->data_realtime
    ->get('ga:' . VIEW, 'rt:activeVisitors', $optParams);
  return getFormattedData($result);
}

// Obtém os países dos usuários ativos no momento
function getCountries($analytics)
{
  $optParams = array(
    'dimensions' => 'ga:country',
    'sort' => '-rt:activeVisitors',
    'max-results' => 10
  );

  $result = $analytics
    ->data_realtime
    ->get('ga:' . VIEW, 'rt:activeVisitors', $optParams);
  return getFormattedData($result, 'Country', 'Users');
}

// Obtém os sistemas operacionais dos usuários ativos no momento
function getOS($analytics)
{
  $optParams = array(
    'dimensions' => 'ga:operatingSystem',
    'sort' => '-rt:activeVisitors',
    'max-results' => 10
  );

  $result = $analytics
    ->data_realtime
    ->get('ga:' . VIEW, 'rt:activeVisitors', $optParams);
  return getFormattedData($result, 'OS', 'Users');
}

// Obtém os navegadores utilizados pelos usuários ativos no momento
function getBrowser($analytics)
{
  $optParams = array(
    'dimensions' => 'ga:browser',
    'sort' => '-rt:activeVisitors',
    'max-results' => 10
  );

  $result = $analytics
    ->data_realtime
    ->get('ga:' . VIEW, 'rt:activeVisitors', $optParams);
  return getFormattedData($result, 'Browser', 'Users');
}
<?php include("dashboard_query.php") ?>
<?php
$sql_settings = "SELECT ga_client_id, ga_client_secret, ga_access_token, ga_refresh_token, ga_property_id FROM settings LIMIT 1";
$res_settings = mysqli_query($con, $sql_settings);
$ga_settings = mysqli_fetch_assoc($res_settings);

// Analytics API Integration
$client_id = $ga_settings['ga_client_id'];
$client_secret = $ga_settings['ga_client_secret'];
$refresh_token = $ga_settings['ga_refresh_token'];
$db_access_token = $ga_settings['ga_access_token'];
$property_id = !empty($ga_settings['ga_property_id']) ? $ga_settings['ga_property_id'] : "514190946";
$url = "https://analyticsdata.googleapis.com/v1beta/properties/{$property_id}:runReport";

function getValidAccessToken()
{
    global $client_id, $client_secret, $refresh_token;

    // Use session memory to temporarily store the access token
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $access_token = isset($_SESSION['ga_access_token']) ? $_SESSION['ga_access_token'] : null;

    // Step 1: Check Access Token Status
    if (!empty($access_token)) {
        $ch = curl_init("https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=" . urlencode($access_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $tokenInfo = json_decode($response, true);
        if (isset($tokenInfo['expires_in']) && $tokenInfo['expires_in'] > 0) {
            return $access_token; // Token is still valid
        }
    }

    // Step 2: Generate New Access Token automatically using Refresh Token
    if (!empty($refresh_token) && !empty($client_id) && !empty($client_secret)) {
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'client_id' => trim($client_id),
            'client_secret' => trim($client_secret),
            'refresh_token' => trim($refresh_token),
            'grant_type' => 'refresh_token'
        ]));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        // Success: Store new access token in memory/session
        if (isset($data['access_token'])) {
            $_SESSION['ga_access_token'] = $data['access_token'];
            return $data['access_token'];
        } else {
            // Google rejected the refresh token! Show the exact error so we can debug.
            echo "<h2>Google API Error (Step 2 Failed)</h2>";
            echo "<p>Your Database Credentials (Client ID or Refresh Token) are incorrect.</p>";
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die;
        }
    }

    return null;
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : '7daysAgo';
if ($filter === 'This Month') {
    $startDate = date('Y-m-01');
    $endDate = 'today';
} elseif ($filter === 'Last Month') {
    $startDate = date('Y-m-d', strtotime('first day of last month'));
    $endDate = date('Y-m-d', strtotime('last day of last month'));
} elseif ($filter === 'This Year') {
    $startDate = date('Y-01-01');
    $endDate = 'today';
} elseif ($filter === 'Last Year') {
    $startDate = date('Y-01-01', strtotime('-1 year'));
    $endDate = date('Y-12-31', strtotime('-1 year'));
} else {
    $startDate = '7daysAgo';
    $endDate = 'today';
}

function fetchAnalyticsData($payload)
{
    global $url;
    $token = getValidAccessToken();
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $token,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

$dateRanges = [["startDate" => $startDate, "endDate" => $endDate]];

// 1. Key Metrics
$payload1 = [
    "dateRanges" => $dateRanges,
    "metrics" => [
        ["name" => "totalUsers"],
        ["name" => "newUsers"],
        ["name" => "screenPageViews"],
        ["name" => "bounceRate"],
        ["name" => "averageSessionDuration"]
    ]
];
$data1 = fetchAnalyticsData($payload1);
$totalUsers = 0;
$newUsers = 0;
$pageViews = 0;
$bounceRate = 0;
$avgSession = "00:00";
if (isset($data1['rows'][0]['metricValues'])) {
    $vals = $data1['rows'][0]['metricValues'];
    $totalUsers = number_format($vals[0]['value']);
    $newUsers = number_format($vals[1]['value']);
    $pageViews = number_format($vals[2]['value']);
    $bounceRate = number_format($vals[3]['value'] * 100, 1) . "%";
    $secs = (int) $vals[4]['value'];
    $avgSession = sprintf("%02d:%02d", floor($secs / 60), $secs % 60);
}

// 2. Visitors Overview
$payload2 = [
    "dateRanges" => $dateRanges,
    "dimensions" => [["name" => "date"]],
    "metrics" => [["name" => "totalUsers"]]
];
$data2 = fetchAnalyticsData($payload2);
$chartDates = [];
$chartUsers = [];
if (isset($data2['rows'])) {
    usort($data2['rows'], function ($a, $b) {
        return strcmp($a['dimensionValues'][0]['value'], $b['dimensionValues'][0]['value']);
    });
    foreach ($data2['rows'] as $row) {
        $rawDate = $row['dimensionValues'][0]['value'];
        $chartDates[] = date('j M', strtotime($rawDate));
        $chartUsers[] = $row['metricValues'][0]['value'];
    }
}

// 3. Traffic Sources
$payload3 = [
    "dateRanges" => $dateRanges,
    "dimensions" => [["name" => "sessionDefaultChannelGroup"]], // Better mapping for table
    "metrics" => [["name" => "totalUsers"], ["name" => "newUsers"]]
];
$data3 = fetchAnalyticsData($payload3);
$donutLabels = [];
$donutData = [];
$donutDataNew = [];
$donutTotal = 0;
if (isset($data3['rows'])) {
    foreach ($data3['rows'] as $row) {
        $source = $row['dimensionValues'][0]['value'];
        $users = (int) $row['metricValues'][0]['value'];
        $newUsrs = (int) $row['metricValues'][1]['value'];
        if ($users > 0 && count($donutData) < 10) {
            $donutLabels[] = $source;
            $donutData[] = $users;
            $donutDataNew[] = $newUsrs;
            $donutTotal += $users;
        }
    }
}
// Fallback data if empty
if (empty($donutData)) {
    $donutLabels = ['No Data'];
    $donutData = [1];
    $donutDataNew = [0];
    $donutTotal = 0;
}

// 4. Top Pages
$payload4 = [
    "dateRanges" => $dateRanges,
    "dimensions" => [["name" => "pagePath"]],
    "metrics" => [
        ["name" => "screenPageViews"],
        ["name" => "activeUsers"],
        ["name" => "bounceRate"]
    ],
    "orderBys" => [
        ["metric" => ["metricName" => "screenPageViews"], "desc" => true]
    ],
    "limit" => 10
];
$data4 = fetchAnalyticsData($payload4);
$topPages = [];
if (isset($data4['rows'])) {
    foreach ($data4['rows'] as $row) {
        $topPages[] = [
            'path' => $row['dimensionValues'][0]['value'],
            'views' => number_format($row['metricValues'][0]['value']),
            'unique' => number_format($row['metricValues'][1]['value']),
            'bounce' => number_format($row['metricValues'][2]['value'] * 100, 1) . "%"
        ];
    }
}

// 5. PPTX Export Logic via PHP ZipArchive
if (isset($_GET['export']) && $_GET['export'] == 'pptx') {
    $template_path = '../uploads/report/Scansworld_SEO_Report_Apr_2026.pptx';

    $is12Month = false;
    $force1Month = false; // We can leave this false so it doesn't delete columns
    $filter = $_GET['filter'] ?? 'This Month';

    $exportStartDate = $startDate;
    $exportEndDate = $endDate;
    if ($filter == 'This Month' || $filter == '7daysAgo') {
        $exportStartDate = date('Y-m-d', strtotime('first day of -2 months'));
    } elseif ($filter == 'Last Month') {
        $exportStartDate = date('Y-m-d', strtotime('first day of -3 months'));
    }

    if ($filter == 'This Year' || $filter == 'Last Year') {
        if (file_exists('../uploads/report/Template_12Month.pptx')) {
            $is12Month = true;
            $template_path = '../uploads/report/Template_12Month.pptx';
        } else {
            $is12Month = false;
        }
    }

    // Always fetch Monthly breakdown data for PPTX
    $mapMonthlyTotal = [];
    $mapMonthlyNew = [];
    $payloadMonthly = [
        "dateRanges" => [["startDate" => $exportStartDate, "endDate" => $exportEndDate]],
        "dimensions" => [["name" => "sessionDefaultChannelGroup"], ["name" => "yearMonth"]],
        "metrics" => [["name" => "totalUsers"], ["name" => "newUsers"]]
    ];
    $dataMonthly = fetchAnalyticsData($payloadMonthly);
    if (isset($dataMonthly['rows'])) {
        foreach ($dataMonthly['rows'] as $row) {
            $channel = strtolower(trim($row['dimensionValues'][0]['value']));
            $ym = $row['dimensionValues'][1]['value'];
            $monthStr = date('M', strtotime($ym . '01'));
            $tUsers = (int) $row['metricValues'][0]['value'];
            $nUsers = (int) $row['metricValues'][1]['value'];
            if (!isset($mapMonthlyTotal[$channel]))
                $mapMonthlyTotal[$channel] = [];
            if (!isset($mapMonthlyNew[$channel]))
                $mapMonthlyNew[$channel] = [];
            $mapMonthlyTotal[$channel][$monthStr] = $tUsers;
            $mapMonthlyNew[$channel][$monthStr] = $nUsers;
        }
    }

    if (!file_exists($template_path)) {
        die("Template file not found at $template_path");
    }

    $temp_file = tempnam(sys_get_temp_dir(), 'pptx');
    copy($template_path, $temp_file);

    $zip = new ZipArchive;
    if ($zip->open($temp_file) === TRUE) {

        // Trim to keep slides 1, 2, 3, 9, 25
        $presXml = $zip->getFromName('ppt/presentation.xml');
        if (preg_match('/<p:sldIdLst>(.*?)<\/p:sldIdLst>/', $presXml, $matches)) {
            preg_match_all('/<p:sldId[^>]+>/', $matches[1], $slideIds);
            $newSldIdLst = '';
            $indicesToKeep = [0, 1, 2, 8, 24]; // 0-indexed (Slide 1, 2, 3, 9, 25)
            foreach ($indicesToKeep as $idx) {
                if (isset($slideIds[0][$idx])) {
                    $newSldIdLst .= $slideIds[0][$idx];
                }
            }
            $presXml = str_replace($matches[0], "<p:sldIdLst>{$newSldIdLst}</p:sldIdLst>", $presXml);
            $zip->addFromString('ppt/presentation.xml', $presXml);
        }

        // Determine dynamic date string
        $mainTitle = date('F Y');
        if ($filter == 'This Month') {
            $mainTitle = date('F Y');
            $c3 = date('M');
            $c2 = date('M', strtotime('-1 month'));
            $c1 = date('M', strtotime('-2 months'));
        } elseif ($filter == 'Last Month') {
            $mainTitle = date('F Y', strtotime('first day of last month'));
            $c3 = date('M', strtotime('first day of last month'));
            $c2 = date('M', strtotime('first day of -2 months'));
            $c1 = date('M', strtotime('first day of -3 months'));
        } elseif ($filter == 'This Year') {
            $mainTitle = date('Y');
            $c3 = date('M');
            $c2 = date('M', strtotime('-1 month'));
            $c1 = date('M', strtotime('-2 months'));
        } elseif ($filter == 'Last Year') {
            $mainTitle = date('Y', strtotime('-1 year'));
            $c3 = 'Dec';
            $c2 = 'Nov';
            $c1 = 'Oct';
        } elseif ($filter == 'Last 7 Days') {
            $mainTitle = "Last 7 Days";
            $c3 = date('M');
            $c2 = date('M', strtotime('-1 month'));
            $c1 = date('M', strtotime('-2 months'));
        } else {
            $mainTitle = htmlspecialchars($filter);
            $c3 = date('M');
            $c2 = date('M', strtotime('-1 month'));
            $c1 = date('M', strtotime('-2 months'));
        }
        $headerRange = "{$c1}–{$c3} " . date('Y');
        $monthHeaders = [$c1, $c2, $c3];

        // Slide 1 replacements
        $slide1 = $zip->getFromName('ppt/slides/slide1.xml');
        $slide1 = str_replace('April 2026', $mainTitle, $slide1);
        $zip->addFromString('ppt/slides/slide1.xml', $slide1);

        // Slide 2 replacements
        $slide2 = $zip->getFromName('ppt/slides/slide2.xml');
        $slide2 = str_replace('Feb–Apr 2026', $headerRange, $slide2);
        $slide2 = str_replace('April 2026', $mainTitle, $slide2);

        // Safely replace the top 4 cards ONLY
        $slide2 = preg_replace('/<a:t>1,237<\/a:t>/', '<a:t>' . ($totalUsers ?? "0") . '</a:t>', $slide2, 1);
        $slide2 = str_replace('TOTAL SESSIONS (APR)', 'TOTAL USERS', $slide2);

        $slide2 = preg_replace('/<a:t>697<\/a:t>/', '<a:t>' . ($newUsers ?? "0") . '</a:t>', $slide2, 1);
        $slide2 = str_replace('ORGANIC SEARCH', 'NEW USERS', $slide2);

        $slide2 = preg_replace('/<a:t>418<\/a:t>/', '<a:t>' . ($pageViews ?? "0") . '</a:t>', $slide2, 1);
        $slide2 = str_replace('PAID SEARCH', 'PAGE VIEWS', $slide2);

        $slide2 = preg_replace('/<a:t>93<\/a:t>/', '<a:t>' . ($bounceRate ?? "0%") . '</a:t>', $slide2, 1);
        $slide2 = str_replace('DIRECT', 'BOUNCE RATE', $slide2);

        // Table manipulation helper
        $updateTable = function ($xmlStr, $dataMap, $totalVal, $is12Month, $monthHeaders, $force1Month) {
            $dom = new DOMDocument();
            @$dom->loadXML($xmlStr);
            $tables = $dom->getElementsByTagName('tbl');
            if ($tables->length > 0) {
                $table = $tables->item(0);

                if ($force1Month) {
                    $tblGrids = $table->getElementsByTagName('tblGrid');
                    if ($tblGrids->length > 0) {
                        $gridCols = $tblGrids->item(0)->getElementsByTagName('gridCol');
                        if ($gridCols->length >= 4) {
                            $tblGrids->item(0)->removeChild($gridCols->item(2));
                            $tblGrids->item(0)->removeChild($gridCols->item(1));
                        }
                    }
                }

                $rows = $table->getElementsByTagName('tr');

                // Read headers from row 0
                $headers = [];
                $cells0 = $rows->item(0)->getElementsByTagName('tc');
                for ($i = 1; $i < $cells0->length; $i++) {
                    $hName = '';
                    foreach ($cells0->item($i)->getElementsByTagName('t') as $tNode) {
                        $hName .= $tNode->nodeValue;
                    }
                    $headers[$i] = trim($hName);
                }

                // Override headers if 3-month template
                if (!$is12Month && count($headers) == 3) {
                    if ($force1Month) {
                        foreach ($cells0->item(3)->getElementsByTagName('t') as $tNode) {
                            $tNode->nodeValue = $monthHeaders[2];
                        }
                        $headers = [1 => $monthHeaders[2]];
                    } else {
                        foreach ($cells0->item(1)->getElementsByTagName('t') as $tNode) {
                            $tNode->nodeValue = $monthHeaders[0];
                        }
                        foreach ($cells0->item(2)->getElementsByTagName('t') as $tNode) {
                            $tNode->nodeValue = $monthHeaders[1];
                        }
                        foreach ($cells0->item(3)->getElementsByTagName('t') as $tNode) {
                            $tNode->nodeValue = $monthHeaders[2];
                        }
                        $headers[1] = $monthHeaders[0];
                        $headers[2] = $monthHeaders[1];
                        $headers[3] = $monthHeaders[2];
                    }
                }

                // Initialize column totals
                $colTotals = [];
                for ($i = 1; $i <= 12; $i++)
                    $colTotals[$i] = 0;

                foreach ($rows as $rowIndex => $row) {
                    $cells = $row->getElementsByTagName('tc');
                    if ($force1Month && $cells->length >= 4) {
                        $row->removeChild($cells->item(2));
                        $row->removeChild($cells->item(1));
                    }

                    if ($rowIndex == 0)
                        continue; // Skip header
                    $cells = $row->getElementsByTagName('tc');
                    if ($cells->length > 1) {
                        $channelName = '';
                        foreach ($cells->item(0)->getElementsByTagName('t') as $tNode) {
                            $channelName .= $tNode->nodeValue;
                        }
                        $channelKey = strtolower(trim($channelName));

                        for ($i = 1; $i < $cells->length; $i++) {
                            $monthCol = $headers[$i] ?? '';
                            $val = "-";

                            if ($rowIndex == $rows->length - 1) { // Grand Total
                                $val = $colTotals[$i] > 0 ? number_format($colTotals[$i]) : "-";
                            } else {
                                $shortMonth = substr($monthCol, 0, 3);
                                foreach ($dataMap as $k => $vArr) {
                                    $k_clean = str_replace('-', ' ', strtolower($k));
                                    $c_clean = str_replace('-', ' ', $channelKey);
                                    if (strpos($k_clean, $c_clean) !== false || strpos($c_clean, $k_clean) !== false) {
                                        $v = $vArr[$shortMonth] ?? 0;
                                        if ($v > 0) {
                                            $val = number_format($v);
                                            $colTotals[$i] += $v;
                                        }
                                        break;
                                    }
                                }
                            }
                            foreach ($cells->item($i)->getElementsByTagName('t') as $tNode) {
                                $tNode->nodeValue = $val;
                            }
                        }
                    }
                }
            }
            return $dom->saveXML();
        };

        $slide2 = preg_replace('/<a:t>[^<]*vs Mar[^<]*<\/a:t>/i', '<a:t></a:t>', $slide2);

        $slide2 = $updateTable($slide2, $mapMonthlyTotal, $totalUsers ?? "0", $is12Month, $monthHeaders, $force1Month);
        $zip->addFromString('ppt/slides/slide2.xml', $slide2);

        // Slide 3 replacements
        $slide3 = $zip->getFromName('ppt/slides/slide3.xml');
        $slide3 = str_replace('Feb–Apr 2026', $headerRange, $slide3);
        $slide3 = str_replace('April 2026', $mainTitle, $slide3);
        $slide3 = preg_replace('/<a:t>1,585<\/a:t>/', '<a:t>' . ($newUsers ?? "0") . '</a:t>', $slide3, 1);
        $slide3 = preg_replace('/<a:t>[^<]*vs Mar[^<]*<\/a:t>/i', '<a:t></a:t>', $slide3);
        $slide3 = $updateTable($slide3, $mapMonthlyNew, $newUsers ?? "0", $is12Month, $monthHeaders, $force1Month);
        $zip->addFromString('ppt/slides/slide3.xml', $slide3);

        // Slide 9 (Enquiries) replacements
        $slide9Xml = $zip->getFromName('ppt/slides/slide9.xml');
        if ($slide9Xml) {
            $slide9Xml = str_replace('April 2026', $mainTitle, $slide9Xml);

            // Fetch booked appointments
            $bookAppointments = [];
            $branches = [];
            $services = [];

            $aptSql = "SELECT ba.patient_name, ba.phone, b.branch_name, s.service_name, ba.enquiry_date, ba.appointment_date 
                       FROM book_appointment ba 
                       LEFT JOIN branch b ON ba.branch = b.id 
                       LEFT JOIN service s ON ba.service = s.id 
                       WHERE DATE(ba.enquiry_date) >= '$startDate' AND DATE(ba.enquiry_date) <= '$endDate' 
                       ORDER BY ba.enquiry_date DESC";
            $aptRes = mysqli_query($con, $aptSql);
            if ($aptRes) {
                while ($row = mysqli_fetch_assoc($aptRes)) {
                    $bookAppointments[] = $row;
                    if (!empty($row['branch_name']))
                        $branches[$row['branch_name']] = true;
                    if (!empty($row['service_name'])) {
                        if (!isset($services[$row['service_name']]))
                            $services[$row['service_name']] = 0;
                        $services[$row['service_name']]++;
                    }
                }
            }

            $totalEnquiries = count($bookAppointments);
            $branchesReached = count($branches);

            arsort($services);
            $topServicesList = array_slice(array_keys($services), 0, 3);
            $serviceMixTitle = !empty($topServicesList) ? implode(' / ', $topServicesList) : 'N/A';

            $serviceMixSubtitleArr = [];
            foreach (array_slice($services, 0, 3, true) as $sName => $sCount) {
                $serviceMixSubtitleArr[] = "$sCount $sName";
            }
            $serviceMixSubtitle = !empty($serviceMixSubtitleArr) ? implode(' · ', $serviceMixSubtitleArr) : 'N/A';

            $slide9Xml = preg_replace('/<a:t>6<\/a:t>/', '<a:t>' . $totalEnquiries . '</a:t>', $slide9Xml, 1);
            $slide9Xml = preg_replace('/<a:t>3<\/a:t>/', '<a:t>' . $branchesReached . '</a:t>', $slide9Xml, 1);
            $slide9Xml = preg_replace('/<a:t>MRI \/ CT \/ X-Ray<\/a:t>/', '<a:t>' . htmlspecialchars($serviceMixTitle) . '</a:t>', $slide9Xml, 1);
            $slide9Xml = preg_replace('/<a:t>3 MRI · 2 CT · 1 X-Ray<\/a:t>/', '<a:t>' . htmlspecialchars($serviceMixSubtitle) . '</a:t>', $slide9Xml, 1);

            // Populate Table
            $dom = new DOMDocument();
            @$dom->loadXML($slide9Xml);
            $tables = $dom->getElementsByTagName('tbl');
            if ($tables->length > 0) {
                $table = $tables->item(0);
                $rows = $table->getElementsByTagName('tr');

                for ($r = 1; $r <= 6; $r++) {
                    if ($r < $rows->length) {
                        $row = $rows->item($r);
                        $cells = $row->getElementsByTagName('tc');
                        if ($cells->length >= 8) {
                            if (isset($bookAppointments[$r - 1])) {
                                $apt = $bookAppointments[$r - 1];
                                $pName = htmlspecialchars(trim($apt['patient_name'] ?? ''));
                                $phone = htmlspecialchars(trim($apt['phone'] ?? ''));
                                $branch = htmlspecialchars(trim($apt['branch_name'] ?? ''));
                                $srv = htmlspecialchars(trim($apt['service_name'] ?? ''));
                                $enq = date('d-m-Y', strtotime($apt['enquiry_date']));
                                $appt = !empty($apt['appointment_date']) ? date('d-m-Y', strtotime($apt['appointment_date'])) : '-';
                                $time = !empty($apt['enquiry_date']) ? date('g:i A', strtotime($apt['enquiry_date'])) : '-';

                                $vals = [$pName, $phone, $branch, $srv, $srv, $enq, $appt, $time];
                            } else {
                                $vals = ['-', '-', '-', '-', '-', '-', '-', '-'];
                            }

                            for ($c = 0; $c < 8; $c++) {
                                // Only replace the first text node in the cell to preserve formatting
                                $tNodes = $cells->item($c)->getElementsByTagName('t');
                                if ($tNodes->length > 0) {
                                    $tNodes->item(0)->nodeValue = $vals[$c];
                                    for ($extra = 1; $extra < $tNodes->length; $extra++) {
                                        $tNodes->item($extra)->nodeValue = '';
                                    }
                                }
                            }
                        }
                    }
                }
                $slide9Xml = $dom->saveXML();
            }

            $zip->addFromString('ppt/slides/slide9.xml', $slide9Xml);
        }
        $updateChart = function ($xmlStr, $dataMap, $is12Month, $monthHeaders, $force1Month) {
            $dom = new DOMDocument();
            @$dom->loadXML($xmlStr);

            if ($force1Month) {
                $seriesList = $dom->getElementsByTagName('ser');
                if ($seriesList->length >= 3) {
                    $parent = $seriesList->item(0)->parentNode;
                    $parent->removeChild($seriesList->item(1));
                    $parent->removeChild($seriesList->item(0));

                    // Re-index remaining series
                    $remainingSeries = $dom->getElementsByTagName('ser')->item(0);
                    $idxNode = $remainingSeries->getElementsByTagName('idx')->item(0);
                    if ($idxNode)
                        $idxNode->setAttribute('val', '0');
                    $orderNode = $remainingSeries->getElementsByTagName('order')->item(0);
                    if ($orderNode)
                        $orderNode->setAttribute('val', '0');
                }
            }

            $seriesList = $dom->getElementsByTagName('ser');

            if (!$is12Month && !$force1Month && $seriesList->length == 3) {
                foreach ($seriesList as $index => $series) {
                    $txNode = $series->getElementsByTagName('tx')->item(0);
                    if ($txNode) {
                        $vNode = $txNode->getElementsByTagName('v')->item(0);
                        if ($vNode)
                            $vNode->nodeValue = $monthHeaders[$index] ?? '';
                    }
                }
            } elseif ($force1Month && $seriesList->length == 1) {
                $txNode = $seriesList->item(0)->getElementsByTagName('tx')->item(0);
                if ($txNode) {
                    $vNode = $txNode->getElementsByTagName('v')->item(0);
                    if ($vNode)
                        $vNode->nodeValue = $monthHeaders[2] ?? '';
                }
            }

            foreach ($seriesList as $index => $series) {
                $monthStr = '';
                $txNode = $series->getElementsByTagName('tx')->item(0);
                if ($txNode) {
                    $vNode = $txNode->getElementsByTagName('v')->item(0);
                    if ($vNode)
                        $monthStr = $vNode->nodeValue;
                }
                $shortMonth = substr($monthStr, 0, 3);

                $catNode = $series->getElementsByTagName('cat')->item(0);
                $categories = [];
                if ($catNode) {
                    $pts = $catNode->getElementsByTagName('pt');
                    foreach ($pts as $pt) {
                        $idx = $pt->getAttribute('idx');
                        $vNode = $pt->getElementsByTagName('v')->item(0);
                        if ($vNode)
                            $categories[$idx] = str_replace(["\n", "\r"], " ", $vNode->nodeValue);
                    }
                }

                $valNode = $series->getElementsByTagName('val')->item(0);
                if ($valNode) {
                    $pts = $valNode->getElementsByTagName('pt');
                    foreach ($pts as $pt) {
                        $idx = $pt->getAttribute('idx');
                        $vNode = $pt->getElementsByTagName('v')->item(0);
                        if ($vNode) {
                            $val = "0";
                            $channelKey = strtolower(trim($categories[$idx] ?? ''));

                            foreach ($dataMap as $k => $vArr) {
                                $k_clean = str_replace('-', ' ', strtolower($k));
                                $c_clean = str_replace('-', ' ', $channelKey);
                                if (strpos($k_clean, $c_clean) !== false || strpos($c_clean, $k_clean) !== false) {
                                    $val = $vArr[$shortMonth] ?? 0;
                                    break;
                                }
                            }
                            $vNode->nodeValue = $val;
                        }
                    }
                }
            }
            return $dom->saveXML();
        };

        // Chart replacements
        $chart1Xml = $zip->getFromName('ppt/charts/chart1.xml');
        if ($chart1Xml) {
            $chart1Xml = $updateChart($chart1Xml, $mapMonthlyTotal, $is12Month, $monthHeaders, $force1Month);
            $zip->addFromString('ppt/charts/chart1.xml', $chart1Xml);
        }
        $chart2Xml = $zip->getFromName('ppt/charts/chart2.xml');
        if ($chart2Xml) {
            $chart2Xml = $updateChart($chart2Xml, $mapMonthlyNew, $is12Month, $monthHeaders, $force1Month);
            $zip->addFromString('ppt/charts/chart2.xml', $chart2Xml);
        }

        $zip->close();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
    header('Content-Disposition: attachment; filename="SEO_Report_' . date('M_Y') . '.pptx"');
    header('Content-Length: ' . filesize($temp_file));
    readfile($temp_file);
    unlink($temp_file);
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Reports & Analytics | Scans World</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/plugins/dropzone.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="assets/fonts/feather.css" />
    <link rel="stylesheet" href="assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/fonts/material.css" />
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .rp-wrap *,
        .rp-wrap *::before,
        .rp-wrap *::after {
            box-sizing: border-box;
        }

        .rp-wrap {
            padding: 24px 28px;
            background: #f0f4fa;
            min-height: 100%;
            font-family: 'Public Sans', 'Segoe UI', sans-serif;
        }

        /* ── Page Header ── */
        .rp-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 28px;
        }

        .rp-page-header-left h1 {
            font-size: 26px;
            font-weight: 700;
            color: #0d1f3c;
            margin: 0 0 4px;
            line-height: 1.2;
        }

        .rp-page-header-left p {
            color: #6b7a99;
            font-size: 14px;
            margin: 0;
        }

        .rp-filter-select {
            padding: 10px 16px;
            border: 1px solid #dce5f3;
            border-radius: 12px;
            background: #fff;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            outline: none;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .04);
        }

        /* ── Section Label ── */
        .rp-section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #8896b0;
            margin: 0 0 12px;
        }

        /* ── Stat Cards ── */
        .rp-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .rp-stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px 22px 18px;
            border: 1px solid #e4ecf7;
            box-shadow: 0 2px 8px rgba(13, 31, 60, .04);
        }

        .rp-stat-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .rp-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
        }

        .rp-ic-blue {
            background: #edf4ff;
            color: #1565ff;
        }

        .rp-ic-green {
            background: #edfbf2;
            color: #16a34a;
        }

        .rp-ic-orange {
            background: #fff4e5;
            color: #f57c00;
        }

        .rp-ic-teal {
            background: #e4f9f7;
            color: #0d9488;
        }

        .rp-stat-label {
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            margin: 0 0 6px;
        }

        .rp-stat-value {
            font-size: 34px;
            font-weight: 800;
            line-height: 1;
            margin: 0 0 8px;
            color: #0d1f3c;
        }

        .rp-badge-up {
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            background: #edfbf2;
            color: #16a34a;
        }

        .rp-badge-down {
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            background: #fff1f1;
            color: #e53935;
        }

        /* Charts Row */
        .rp-charts-row {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
            align-items: stretch;
            /* Important */
        }

        .rp-panel {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e4ecf7;
            box-shadow: 0 2px 8px rgba(13, 31, 60, .04);
            padding: 28px;
            min-height: 380px;
            /* Same height */
            display: flex;
            flex-direction: column;
        }

        .rp-panel-hdr {
            margin-bottom: 24px;
        }

        .rp-visitor-chart {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .rp-visitor-chart svg {
            width: 100%;
            height: 250px;
        }

        .rp-traffic {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
        }

        .rp-donut-wrap {
            width: 190px;
            height: 190px;
        }

        .rp-donut-canvas {
            width: 190px !important;
            height: 190px !important;
        }

        /* ── Visitors Chart ── */
        .rp-visitor-chart {
            position: relative;
            padding-left: 38px;
        }

        .rp-visitor-chart svg {
            width: 100%;
            height: 200px;
            display: block;
        }

        .rp-y-labels {
            position: absolute;
            left: 0;
            top: 8px;
            height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
        }

        .rp-x-labels {
            display: flex;
            justify-content: space-around;
            margin-top: 6px;
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
        }

        /* ── Donut / Traffic ── */
        .rp-traffic {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            padding-top: 8px;
        }

        .rp-donut-wrap {
            position: relative;
            width: 150px;
            height: 150px;
            flex-shrink: 0;
        }

        .rp-donut-canvas {
            width: 150px !important;
            height: 150px !important;
        }

        .rp-donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            pointer-events: none;
        }

        .rp-donut-center strong {
            font-size: 20px;
            font-weight: 800;
            color: #0d1f3c;
            line-height: 1;
        }

        .rp-donut-center span {
            font-size: 11px;
            color: #8896b0;
            margin-top: 3px;
            font-weight: 600;
        }

        .rp-legend {
            list-style: none;
            padding: 0;
            margin: 0;
            min-width: 150px;
        }

        .rp-legend li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 13px;
            font-weight: 500;
            gap: 10px;
        }

        .rp-legend li:last-child {
            margin-bottom: 0;
        }

        .rp-legend-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
        }

        .rp-legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .rp-legend-val {
            font-weight: 700;
            color: #1e293b;
            font-size: 13px;
        }

        /* ── Table ── */
        .rp-table-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e4ecf7;
            box-shadow: 0 2px 8px rgba(13, 31, 60, .04);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .rp-table-hdr {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 22px;
            border-bottom: 1px solid #edf2f7;
            flex-wrap: wrap;
            gap: 10px;
        }

        .rp-table-hdr h2 {
            font-size: 16px;
            font-weight: 700;
            color: #0d1f3c;
            margin: 0;
        }

        .rp-table-scroll {
            overflow-x: auto;
        }

        .rp-data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            min-width: 520px;
        }

        .rp-data-table thead tr {
            background: #f5f8ff;
        }

        .rp-data-table th {
            padding: 11px 18px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #4a5568;
            border-bottom: 2px solid #e4ecf7;
            white-space: nowrap;
        }

        .rp-data-table td {
            padding: 12px 18px;
            border-bottom: 1px solid #f0f4fa;
            color: #374151;
            font-weight: 500;
        }

        .rp-data-table tr:last-child td {
            border-bottom: none;
        }

        .rp-data-table tbody tr:hover {
            background: #fafcff;
        }

        .rp-bounce-good {
            color: #16a34a;
            font-weight: 700;
        }

        .rp-bounce-avg {
            color: #f57c00;
            font-weight: 700;
        }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .rp-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .rp-charts-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .rp-wrap {
                padding: 18px;
            }

            .rp-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .rp-page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .rp-filter-select {
                width: 100%;
            }
        }

        @media (max-width: 600px) {
            .rp-wrap {
                padding: 14px 12px;
            }

            .rp-page-header-left h1 {
                font-size: 20px;
            }

            .rp-stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .rp-stat-value {
                font-size: 26px;
            }

            .rp-charts-row {
                grid-template-columns: 1fr;
            }

            .rp-traffic {
                flex-direction: column;
                align-items: center;
            }

            .rp-legend {
                width: 100%;
            }

            .rp-visitor-chart {
                padding-left: 28px;
            }

            .rp-visitor-chart svg {
                height: 150px;
            }

            .rp-y-labels {
                height: 120px;
                font-size: 10px;
            }
        }

        @media (max-width: 400px) {
            .rp-stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@3.12.0/libs/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/pptxgenjs@3.12.0/dist/pptxgen.bundle.js"></script>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <?php include("include/sidebar.php") ?>

    <div class="pc-container">
        <div class="pc-content">

            <div class="rp-wrap">

                <!-- Page Header -->
                <div class="rp-page-header">
                    <div class="rp-page-header-left">
                        <h1>Reports &amp; Analytics</h1>
                        <p>Track performance and growth of your website.</p>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <select class="rp-filter-select"
                            onchange="window.location.href='?filter=' + encodeURIComponent(this.value)">
                            <option value="7daysAgo" <?php echo ($filter == '7daysAgo') ? 'selected' : ''; ?>>Last 7 Days
                            </option>
                            <option value="This Month" <?php echo ($filter == 'This Month') ? 'selected' : ''; ?>>This
                                Month</option>
                            <option value="Last Month" <?php echo ($filter == 'Last Month') ? 'selected' : ''; ?>>Last
                                Month</option>
                            <option value="This Year" <?php echo ($filter == 'This Year') ? 'selected' : ''; ?>>This Year
                            </option>
                        </select>
                        <button
                            onclick="window.location.href='reports.php?filter=<?php echo urlencode($filter); ?>&export=pptx'"
                            class="btn btn-primary"
                            style="padding: 10px 16px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <i class="ti ti-download" style="font-size: 18px;"></i> Export to PPTX
                        </button>
                    </div>
                </div>

                <!-- ── Stat Cards ── -->
                <p class="rp-section-label">Key Metrics</p>
                <div class="rp-stats-grid">

                    <div class="rp-stat-card">
                        <div class="rp-stat-card-top">
                            <div class="rp-stat-icon rp-ic-blue"><i class="fa-solid fa-users"></i></div>
                        </div>
                        <p class="rp-stat-label">Total Visitors</p>
                        <div class="rp-stat-value"><?php echo htmlspecialchars($totalUsers); ?></div>
                    </div>

                    <div class="rp-stat-card">
                        <div class="rp-stat-card-top">
                            <div class="rp-stat-icon rp-ic-green"><i class="fa-solid fa-eye"></i></div>
                        </div>
                        <p class="rp-stat-label">Page Views</p>
                        <div class="rp-stat-value"><?php echo htmlspecialchars($pageViews); ?></div>
                    </div>

                    <div class="rp-stat-card">
                        <div class="rp-stat-card-top">
                            <div class="rp-stat-icon rp-ic-orange"><i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </div>
                        </div>
                        <p class="rp-stat-label">Bounce Rate</p>
                        <div class="rp-stat-value"><?php echo htmlspecialchars($bounceRate); ?></div>
                    </div>

                    <div class="rp-stat-card">
                        <div class="rp-stat-card-top">
                            <div class="rp-stat-icon rp-ic-teal"><i class="fa-solid fa-clock"></i></div>
                        </div>
                        <p class="rp-stat-label">Avg Session</p>
                        <div class="rp-stat-value"><?php echo htmlspecialchars($avgSession); ?></div>
                    </div>

                </div>

                <!-- ── Charts Row ── -->
                <p class="rp-section-label">Analytics</p>
                <div class="rp-charts-row">

                    <!-- Visitors Overview Line Chart -->
                    <div class="rp-panel">
                        <div class="rp-panel-hdr">
                            <h2>Visitors Overview</h2>
                        </div>
                        <div class="rp-visitor-chart" style="padding-left: 0;">
                            <canvas id="rp-line-chart" style="width: 100%; height: 250px;"></canvas>
                        </div>
                    </div>

                    <!-- Traffic Sources Donut -->
                    <div class="rp-panel">
                        <div class="rp-panel-hdr">
                            <h2>Traffic Sources</h2>
                        </div>
                        <div class="rp-traffic">
                            <div class="rp-donut-wrap">
                                <canvas id="rp-donut-chart" class="rp-donut-canvas"></canvas>
                                <div class="rp-donut-center">
                                    <strong><?php echo number_format($donutTotal); ?></strong>
                                    <span>Total</span>
                                </div>
                            </div>
                            <ul class="rp-legend">
                                <?php
                                $colors = ['#2563eb', '#22c55e', '#f59e0b', '#ef4444', '#a78bfa', '#0ea5e9', '#8b5cf6', '#ec4899', '#14b8a6', '#f43f5e'];
                                foreach ($donutLabels as $index => $label) {
                                    $color = isset($colors[$index]) ? $colors[$index] : '#ccc';
                                    $val = $donutData[$index];
                                    $percent = ($donutTotal > 0) ? round(($val / $donutTotal) * 100) : 0;
                                    echo '<li>';
                                    echo '<span class="rp-legend-label"><span class="rp-legend-dot" style="background:' . $color . ';"></span>' . htmlspecialchars($label) . '</span>';
                                    echo '<span class="rp-legend-val">' . $percent . '%</span>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- ── Top Pages Table ── -->
                <p class="rp-section-label">Page Performance</p>
                <div class="rp-table-card">
                    <div class="rp-table-hdr">
                        <h2>Top Pages</h2>
                    </div>
                    <div class="rp-table-scroll">
                        <table class="rp-data-table">
                            <thead>
                                <tr>
                                    <th>Page</th>
                                    <th>Page Views</th>
                                    <th>Unique Views</th>
                                    <th>Bounce Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($topPages)): ?>
                                    <tr>
                                        <td colspan="4">No data available for this period.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($topPages as $page): ?>
                                        <tr>
                                            <td><i class="fa-regular fa-file-lines"
                                                    style="color:#1a5cff;margin-right:8px;"></i><?php echo htmlspecialchars($page['path']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($page['views']); ?></td>
                                            <td><?php echo htmlspecialchars($page['unique']); ?></td>
                                            <td class="rp-bounce-good"><?php echo htmlspecialchars($page['bounce']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div><!-- /.rp-wrap -->

        </div><!-- /.pc-content -->
    </div><!-- /.pc-container -->

    <?php include("include/footer.php"); ?>

    <script>
        // Line Chart for Visitors
        var lineCtx = document.getElementById('rp-line-chart').getContext('2d');
        window.myLineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($chartDates); ?>,
                datasets: [{
                    label: 'Visitors',
                    data: <?php echo json_encode($chartUsers); ?>,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.16)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 11, weight: '500' } }
                    },
                    y: {
                        grid: { color: '#edf2f7' },
                        border: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 11, weight: '500' } },
                        beginAtZero: true
                    }
                }
            }
        });

        // Donut chart via Chart.js
        var donutCtx = document.getElementById('rp-donut-chart').getContext('2d');
        window.myDonutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($donutLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($donutData); ?>,
                    backgroundColor: ['#2563eb', '#22c55e', '#f59e0b', '#ef4444', '#a78bfa', '#0ea5e9', '#8b5cf6', '#ec4899', '#14b8a6', '#f43f5e'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                cutout: '60%',
                responsive: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (t) { return ' ' + t.label + ': ' + t.raw + ' Users'; }
                        }
                    }
                }
            }
        });

        function exportToPPTX() {
            let pres = new PptxGenJS();
            pres.layout = 'LAYOUT_16x9';

            // Slide 1: Title Slide (matching template)
            let slide1 = pres.addSlide();
            slide1.background = { path: "assets/images/slide1_bg.png" };

            // Title
            slide1.addText('MONTHLY SEO PERFORMANCE REPORT', {
                x: 0.5, y: 3.0, w: '90%', fontSize: 44, bold: true, color: 'FFFFFF', fontFace: 'Calibri'
            });
            // Dynamic Month Year
            slide1.addText('<?php echo date("F Y"); ?>', {
                x: 0.5, y: 3.8, w: '90%', fontSize: 28, bold: false, color: 'FFFFFF', fontFace: 'Calibri'
            });
            // Subtitle
            slide1.addText('Search visibility · Traffic · Keyword rankings · AI search presence', {
                x: 0.5, y: 4.4, w: '90%', fontSize: 16, bold: false, color: 'E2E8F0', fontFace: 'Calibri'
            });
            // Website Footer
            slide1.addText('scansworldonchamiersroad.com', {
                x: 0.5, y: 5.0, w: '90%', fontSize: 14, bold: true, color: 'E2E8F0', fontFace: 'Calibri'
            });

            // Slide 2: Website Traffic
            let slide2 = pres.addSlide();
            slide2.background = { path: "assets/images/slide2_bg.png" };

            // Headers
            slide2.addText('Website Traffic — All Users', {
                x: 0.5, y: 0.3, w: '90%', fontSize: 24, bold: true, color: '000000', fontFace: 'Calibri'
            });
            let dateRangeStr = '<?php echo isset($_GET["filter"]) ? htmlspecialchars($_GET["filter"]) : "Last 7 Days"; ?>';
            slide2.addText('Analytics Data · ' + dateRangeStr, {
                x: 0.5, y: 0.7, w: '90%', fontSize: 14, color: '666666', fontFace: 'Calibri'
            });

            // 4 Summary Metrics (Replacing the 4 cards from the template with your data)
            let cardShadow = { type: 'outer', color: '000000', opacity: 0.1, blur: 4, offset: 2, angle: 90 };

            // Card 1: Total Users
            slide2.addShape(pres.shapes.RECTANGLE, { x: 0.5, y: 1.2, w: 2.1, h: 1.2, fill: "FFFFFF", shadow: cardShadow });
            slide2.addText('<?php echo htmlspecialchars($totalUsers); ?>', { x: 0.5, y: 1.4, w: 2.1, fontSize: 32, bold: true, color: '000000', align: 'center' });
            slide2.addText('TOTAL USERS', { x: 0.5, y: 1.9, w: 2.1, fontSize: 12, bold: true, color: '666666', align: 'center' });

            // Card 2: New Users (Specifically requested by you)
            slide2.addShape(pres.shapes.RECTANGLE, { x: 2.8, y: 1.2, w: 2.1, h: 1.2, fill: "FFFFFF", shadow: cardShadow });
            slide2.addText('<?php echo htmlspecialchars($newUsers ?? 0); ?>', { x: 2.8, y: 1.4, w: 2.1, fontSize: 32, bold: true, color: '000000', align: 'center' });
            slide2.addText('NEW USERS', { x: 2.8, y: 1.9, w: 2.1, fontSize: 12, bold: true, color: '666666', align: 'center' });

            // Card 3: Page Views
            slide2.addShape(pres.shapes.RECTANGLE, { x: 5.1, y: 1.2, w: 2.1, h: 1.2, fill: "FFFFFF", shadow: cardShadow });
            slide2.addText('<?php echo htmlspecialchars($pageViews); ?>', { x: 5.1, y: 1.4, w: 2.1, fontSize: 32, bold: true, color: '000000', align: 'center' });
            slide2.addText('PAGE VIEWS', { x: 5.1, y: 1.9, w: 2.1, fontSize: 12, bold: true, color: '666666', align: 'center' });

            // Card 4: Bounce Rate
            slide2.addShape(pres.shapes.RECTANGLE, { x: 7.4, y: 1.2, w: 2.1, h: 1.2, fill: "FFFFFF", shadow: cardShadow });
            slide2.addText('<?php echo htmlspecialchars($bounceRate); ?>', { x: 7.4, y: 1.4, w: 2.1, fontSize: 32, bold: true, color: '000000', align: 'center' });
            slide2.addText('BOUNCE RATE', { x: 7.4, y: 1.9, w: 2.1, fontSize: 12, bold: true, color: '666666', align: 'center' });

            // Traffic Sources Table
            let tableData = [
                [{ text: 'Channel', options: { bold: true, fill: 'F2F2F2', color: '000000' } },
                { text: 'Sessions', options: { bold: true, fill: 'F2F2F2', color: '000000' } }]
            ];
            <?php if (!empty($donutLabels)): ?>
                <?php for ($i = 0; $i < count($donutLabels); $i++): ?>
                    tableData.push([
                        { text: '<?php echo addslashes($donutLabels[$i]); ?>', options: { color: '000000' } },
                        { text: '<?php echo addslashes($donutData[$i]); ?>', options: { color: '000000' } }
                    ]);
                <?php endfor; ?>
            <?php else: ?>
                tableData.push(['No data available', '']);
            <?php endif; ?>

            slide2.addTable(tableData, {
                x: 0.5, y: 2.8, w: 9.0,
                colW: [6.0, 3.0],
                border: { type: 'solid', color: 'CCCCCC', pt: 1 },
                fontSize: 12,
                margin: [0.1, 0.1, 0.1, 0.1]
            });

            // Save
            pres.writeFile({ fileName: 'SEO_Performance_Report_<?php echo date("M_Y"); ?>.pptx' });
        }
    </script>

    <script src="assets/js/plugins/apexcharts.min.js"></script>
    <script src="assets/js/plugins/popper.min.js"></script>
    <script src="assets/js/plugins/simplebar.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/fonts/custom-font.js"></script>
    <script src="assets/js/pcoded.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
</body>

</html>
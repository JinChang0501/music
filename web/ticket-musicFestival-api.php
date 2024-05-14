<?php
require __DIR__ . '/admin-required.php';
require __DIR__ . '/../config/pdo-connect.php';

$title = 'ticket-musicFestival-api';
$pageName = 'ticket-musicFestival-api';

// 篩選音樂祭活動
$sql = "SELECT 
*
FROM ticket 
JOIN activities ON ticket.activities_id = activities.actid 
JOIN aclass ON activities.actid = aclass.id 
JOIN artist ON activities.actid = artist.id 
WHERE aclass.class = 'music festival'";

$stmt = $pdo->query($sql);
$filteredData = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($filteredData);





// ticket.tid,
// activities.picture,
// activities.activity_name,
// artist.art_name,
// activities.location,
// activities.descriptions,
// activities.a_date,
// activities.a_time,
// ticket.counts,
// ticket.price,
// aclass.class,
// ticket.ticket_area,
// activities.organizer
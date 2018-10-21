<?php
require 'vendor/autoload.php';
use Carbon\Carbon;

$config = [
  'host'      => 'localhost',
  'driver'    => 'mysql',
  'database'  => 'reminders',
  'username'  => 'root',
  'password'  => 'root',
  'charset'   => 'utf8',
  'collation' => 'utf8_general_ci',
  'prefix'    => ''
];

$db = new \Buki\Pdox($config);

$action = $_REQUEST['action'];
$results = [];
if($action == 'get') {
 $results = $db->table('reminders')
    ->orderBy('id', 'desc')
    ->limit(20)
    ->getAll();
} elseif($action == 'save') {
  $remindAt = NULL;
  $date = trim($_GET['date']);
  $time = trim($_GET['time']);
  $dateTime = $date . ' ' . $time;
  $remindAt = Carbon::parse($dateTime)->toDateTimeString();
  $title = $_GET['title'];
  $desc = $_GET['desc'];
  $participants = (array) $_GET['participants'];
 
  $id = $db->table('reminders')->insert([
    'title'       => $title,
    'description' => $desc,
    'created_at'  => Carbon::now()->toDateTimeString(),
    'remind_at'   => $remindAt
  ]);
  $reminderParticipants = array_map(function($user) use($id){
    return [
      'user_id' => $user,
      'reminder_id' => $id,
    ];
  }, $participants);

  $db->table('reminder_users')->insert($reminderParticipants);
  $results = $db->table('reminders')->where('id', $id)->get();

} elseif ($action == 'get_users') {
  $results = $db->table('users')->getAll();
}

echo json_encode($results);
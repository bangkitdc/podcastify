<?php

function timeAgo($timestamp)
{
  $currentTime = time();
  $timestamp = strtotime($timestamp);
  $difference = $currentTime - $timestamp;

  // Define time intervals in seconds
  $intervals = array(
    86400 => 'day',
    3600 => 'hour',
    60 => 'minute',
    1 => 'just now', 
  );

  foreach ($intervals as $seconds => $label) {
    $quotient = floor($difference / $seconds);
    if ($quotient >= 1) {
      return ($quotient == 1 ? 'a' : $quotient) . " $label" . ($quotient == 1 ? '' : 's') . ' ago';
    }
  }

  // If the timestamp is more than a day ago, format it as 'yesterday'
  if (date('Y-m-d', $timestamp) == date('Y-m-d', strtotime('yesterday'))) {
    return 'yesterday';
  }

  // If none of the above conditions are met, return the formatted date
  return date('Y-m-d H:i:s', $timestamp);
}

function secondsToMinutesSeconds($seconds) {
  return gmdate("i:s", $seconds);
}
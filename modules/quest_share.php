<?php
// Write to log.
debug_log('raid_share()');

// For debug.
//debug_log($update);
//debug_log($data);

// Check raid access.
raid_access_check($update, $data);

// Get quest id.
$id = $data['id'];

// Get chat id.
$chat = $data['arg'];

// Get quest data.
$quest = get_quest($id);

// Get text and keys.
$text = get_formatted_quest($quest);
$keys = [];

// Send location.
if (QUEST_LOCATION == true) {
    // Send location.
    $loc = send_venue($chat, $quest['lat'], $quest['lon'], "", !empty($quest['address']) ? $quest['address'] . ', Q-ID = ' . $quest['id'] : $quest['pokestop_name'] . ', ' . $quest['id']); // DO NOT REMOVE " ID = " --> NEEDED FOR CLEANUP PREPARATION!

    // Write to log.
    debug_log('location:');
    debug_log($loc);
}

// Send the message.
send_message($chat, $text, $keys, ['reply_to_message_id' => $chat, 'disable_web_page_preview' => 'true']);

// Set callback keys and message
$callback_msg = getTranslation('successfully_shared');
$callback_keys = array();
$callback_keys = [];

// Edit message.
edit_message($update, $callback_msg, $callback_keys, false);

// Answer callback.
answerCallbackQuery($update['callback_query']['id'], $callback_msg);

exit();
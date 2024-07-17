<?php
use config\registry;

use modules\telegram;

#exploit setting
registry::set('HOST', 'localhost');

#telegram bot setting
registry::set('TG_TOKEN', '');
registry::set('TG_CHAT_ID', '');
registry::set('THREAD_ID', '');

#discord setting
registry::set('DC_WEBHOOK_URL', '');

#handler modules
registry::set('modules',[
    telegram::class
]);
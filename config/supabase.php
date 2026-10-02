<?php

$supabaseUrl = getenv('SUPABASE_URL');
$supabaseKey = getenv('SUPABASE_KEY');

if (!$supabaseUrl || !$supabaseKey) {
    die("Supabase environment variables are not configured.");
}

define('SUPABASE_URL', $supabaseUrl);
define('SUPABASE_KEY', $supabaseKey);

?>
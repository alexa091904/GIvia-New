<?php
$json = file_get_contents('C:\Users\ACER\.gemini\antigravity\brain\91cb02c1-b953-444e-9d5d-ca4dc0db6c01\.system_generated\steps\948\output.txt');
$data = json_decode($json, true);
if (isset($data['outputComponents'])) {
    foreach ($data['outputComponents'] as $component) {
        if (isset($component['screen']['html'])) {
            file_put_contents('tasks/stitch_landing.html', $component['screen']['html']);
            echo "Extracted successfully!\n";
            exit;
        } elseif (isset($component['screenInstance']['html'])) {
            file_put_contents('tasks/stitch_landing.html', $component['screenInstance']['html']);
            echo "Extracted screenInstance successfully!\n";
            exit;
        }
    }
}
echo "Failed to extract HTML.\n";
var_dump($data['outputComponents'][0]);

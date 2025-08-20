<?php
// JSON-Datei einlesen
$datei = 'class/news.json';
$daten = json_decode(file_get_contents($datei), true);

// Tag-Zähler vorbereiten
$tags = [];

// Tags aus allen Einträgen sammeln
foreach ($daten as $eintrag) {
    if (!empty($eintrag['cat'])) {
        // mehrere Kategorien durch Komma trennen
        $cats = array_map('trim', explode(',', $eintrag['cat']));
        foreach ($cats as $cat) {
            if (!isset($tags[$cat])) {
                $tags[$cat] = 0;
            }
            $tags[$cat]++;
        }
    }
}

// Wenn keine Tags gefunden, abbrechen
if (empty($tags)) {
    echo "<p>Keine Tags gefunden.</p>";
    return;
}

// Min/Max für Skalierung finden
$min = min($tags);
$max = max($tags);

// Cloud ausgeben
echo '<div class="tag-cloud">';
foreach ($tags as $tag => $count) {
    // Schriftgröße zwischen 12px und 30px berechnen
    $size = 12 + ($count - $min) / max(1, ($max - $min)) * 18;
    echo "<a href='index.php?x=home&cat=" . urlencode($tag) . "' style='font-size: {$size}px; margin: 5px; text-decoration:none;'>"
        . htmlspecialchars($tag) . "</a> ";
}
echo '</div>';
?>

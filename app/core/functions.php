<?php

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}


function asset($name)
{
    return ROOT . $name;
}


function pluralize($string) {
    // Define some basic pluralization rules (add more rules as needed)
    $pluralRules = array(
        '/(s)$/i' => '\1es',    // Add "es" for words ending with "s"
        '/(x)$/i' => '\1es',    // Add "es" for words ending with "x"
        '/([^aeiou])y$/i' => '\1ies', // Change "y" to "ies" for words not ending with a vowel followed by "y"
        '/$/i' => 's'           // Add "s" as a default rule
    );

    // Iterate over the rules and apply the first one that matches
    foreach ($pluralRules as $pattern => $replacement) {
        if (preg_match($pattern, $string)) {
            return preg_replace($pattern, $replacement, $string);
        }
    }

    return $string; // Return the original string if no rule matches
}

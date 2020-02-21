<?php

namespace Application\Security\DataFilters;

use Application\Configuration\Configuration;

class PreDatabaseSave
{
    use Configuration;

    /**
     * Filter.
     *
     * @param string $string
     * @param $restricted_characters
     *
     * @return string
     */
    public function filter($string, $restricted_characters)
    {
        if ($restricted_characters === 'html') {
            return htmlspecialchars($string);
        }

        if ($restricted_characters === 'slashes') {
            return addslashes($string);
        }

        if ($restricted_characters === 'htmlslashes') {
            return htmlspecialchars(addslashes($string));
        }

        if ($restricted_characters === true) {
            $string = $this->normalizeString($string);
        }

        return $string;
    }

    /**
     * Remove prohibited characters.
     *
     * @param string $string
     *
     * @return string
     */
    private function normalizeString($string)
    {
        return preg_replace('/[^A-Za-z0-9\p{L}_\-!?\s\.]+/u', '', $string);
    }
}

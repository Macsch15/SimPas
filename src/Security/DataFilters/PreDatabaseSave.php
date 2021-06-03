<?php

namespace SimPas\Security\DataFilters;

use SimPas\Configuration\Configuration;

class PreDatabaseSave
{
    use Configuration;

    /**
     * @param $string
     * @param $restricted_characters
     * @return mixed|string
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
     * @param $string
     * @return array|string|string[]|null
     */
    private function normalizeString($string)
    {
        return preg_replace('/[^A-Za-z0-9\p{L}_\-!?\s\.]+/u', '', $string);
    }
}

<?php

namespace SimPas\Pastebin;

use SimPas\Application;
use DirectoryIterator;
use GeSHi;

class SyntaxHighlighter
{
    private $cache_path;

    /**
     * SyntaxHighlighter constructor.
     */
    public function __construct()
    {
        require_once Application::makePath('library:GeSHi:geshi.php');

        $this->cache_path = Application::makePath('storage:geshi');
    }

    /**
     * @param $code
     * @param $language
     * @param int $start_from_line
     * @param string $line_numbering
     * @return array|string|string[]
     */
    public function parseCode($code, $language, int $start_from_line = 1, string $line_numbering = '1')
    {
        $geshi = new GeSHi($code, strtolower($language));

        $geshi->overall_class = 'pre_code';
        $geshi->overall_id = 'zclip_copy';

        if ($line_numbering === '1') {
            $geshi->line_numbers = GESHI_NORMAL_LINE_NUMBERS;
        } else {
            $geshi->line_numbers = GESHI_NO_LINE_NUMBERS;
        }

        $geshi->line_style1 .= 'font-size: 14px';
        $geshi->line_numbers_start = $start_from_line;
        $geshi->keyword_links = false;

        return $geshi->parse_code();
    }

    /**
     * @param $language
     * @return mixed|string
     */
    public function validateLanguage($language)
    {
        if (in_array($language, $this->languagesToArray(), true) === false) {
            $language = 'Text';
        }

        return $language;
    }

    /**
     * @return array
     */
    public function languagesToArray(): array
    {
        $geshi = [];

        if (file_exists($this->cache_path . DIRECTORY_SEPARATOR . 'geshi.php')) {
            require $this->cache_path . DIRECTORY_SEPARATOR . 'geshi.php';
        } else {
            $geshi = $this->storageDataToCache();
        }

        return $geshi;
    }

    /**
     * @param false $debug
     * @return false|int|mixed
     */
    public function storageDataToCache($debug = false)
    {
        foreach (new DirectoryIterator(Application::makePath('library:GeSHi:geshi')) as $file) {
            if ($file->isDot() || substr($file->getFileName(), -4) !== '.php') {
                continue;
            }

            require Application::makePath('library:GeSHi:geshi:' . $file->getFileName());

            $_file = str_ireplace('.php', '', $file->getFileName());
            $geshi[$_file] = $language_data['LANG_NAME'];

            $to_save = '<?php' . PHP_EOL;
            $to_save .= '$geshi = ' . var_export($geshi, true) . ';' . PHP_EOL;
            $to_save = str_replace("\n", ' ', $to_save);

            if (is_dir($this->cache_path) === false) {
                @mkdir($this->cache_path, 0777);
            }

            $put_results = @file_put_contents($this->cache_path . DIRECTORY_SEPARATOR . 'geshi.php', $to_save);
        }

        return $debug === true ? $put_results : $geshi;
    }
}

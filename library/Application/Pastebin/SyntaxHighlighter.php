<?php
namespace Application\Pastebin;

use Application\Application;
use DirectoryIterator;
use GeSHi;

class SyntaxHighlighter
{
    /**
    * GeSHi object
    * 
    * @var object
    */
    private $geshi;

    /**
    * Cache path
    * 
    * @var string
    */
    private $cache_path;

    /**
    * Contructor
    * 
    * @return void
    */
    public function __construct()
    {
        require_once Application::makePath('library:GeSHi:geshi.php');

        $this->cache_path = Application::makePath('storage:geshi');
    }

    /**
    * Parse regular code to code with syntax highlighting
    * If you've new GeSHi library, this is fix for the ZeroClipboard (issue with lines after copied)
    * File: library/GeSHi/geshi.php
    * Find:
    * <code>$parsed_code .= "<li$attr_string>$start{$code[$i-1]}$end</li>$ls";</code>
    * Replace with:
    * <code>$parsed_code .= "<a href=\"#line-" . $i . "\"><li class=\"line_handler\" id=\"line-" . $i . "\" $attr_string>$start{$code[$i-1]}$end</li></a>\n$ls";</code>
    * 
    * @param string $code
    * @param string $language
    * @return string
    */
    public function parseCode($code, $language, $start_from_line = 1, $line_numbering = '1'){
        $this->geshi = new GeSHi($code, strtolower($language));

        $this->geshi->overall_class = 'pre_code';
        $this->geshi->overall_id    = 'zclip_copy';
        
        if($line_numbering === '1') {
            $this->geshi->line_numbers  = GESHI_NORMAL_LINE_NUMBERS; 
        } else {
            $this->geshi->line_numbers  = GESHI_NO_LINE_NUMBERS;
        }
        
        $this->geshi->line_style1  .= 'font-size: 14px';
        $this->geshi->line_numbers_start = $start_from_line;
        $this->geshi->keyword_links = false;
        
        return $this->geshi->parse_code();
    }

    /**
    * Validation
    * 
    * @param type 
    * @return void
    */
    public function validateLanguage($language)
    {
        if(in_array($language, $this->languagesToArray()) === false) {
            $language = 'Text';
        }

        return $language;
    }

    /**
    * Fetch GeSHi languages names to array
    * 
    * @return array
    */
    public function languagesToArray()
    {
        // Cache file exists
        if(file_exists($this->cache_path . DIRECTORY_SEPARATOR . 'geshi.php')) {
            require_once $this->cache_path . DIRECTORY_SEPARATOR . 'geshi.php';
        // Cache file doesn't exists, create it.
        } else {
            $geshi = $this->storageDataToCache();
        }

        return $geshi;
    }

    /**
    * Storage syntax languages names to cache
    * 
    * @param bool $debug
    * @return array
    */
    public function storageDataToCache($debug = false)
    {
        // Loop
        foreach(new DirectoryIterator(Application::makePath('library:GeSHi:geshi')) as $file) {
            if($file->isDot() || substr($file->getFileName(), -4) !== '.php') {
                continue;
            }

            // Include files, this jest VERY slow.
            require Application::makePath('library:GeSHi:geshi:' . $file->getFileName());

            // Remove .php from names
            $_file = str_ireplace('.php', '', $file->getFileName());
            $geshi[$_file] = $language_data['LANG_NAME'];

            // Prepare cache file
            $to_save = '<?php' . PHP_EOL;
            $to_save .= '$geshi = ' . var_export($geshi, true) . ';' . PHP_EOL;
            $to_save = str_replace("\n", " ", $to_save);

            // Create cache directory if not exists
            if(is_dir($this->cache_path) === false) {
                @mkdir($this->cache_path, 0777);
            }

            // Save cache file
            $put_results = @file_put_contents($this->cache_path . DIRECTORY_SEPARATOR . 'geshi.php', $to_save);
        }

        return ($debug === true ? $put_results : $geshi);
    }
}

<?php
/*************************************************************************************
 * dos.php
 * -------
 * Author: Alessandro Staltari (staltari@geocities.com)
 * Copyright: (c) 2005 Alessandro Staltari (http://www.geocities.com/SiliconValley/Vista/8155/)
 * Release Version: 1.0.8.11
 * Date Started: 2005/07/05
 *
 * DOS language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2008/05/23 (1.0.7.22)
 *   -  Added description of extra language features (SF#1970248)
 * 2005/07/05 (1.0.0)
 *  -  First Release
 *
 * TODO (updated 2005/07/05)
 * -------------------------
 *
 * - Highlight pipes and redirection (do we really need this?)
 * - Add missing keywords.
 * - Find a good hyperlink for keywords.
 * - Improve styles.
 *
 * KNOWN ISSUES (updated 2005/07/07)
 * ---------------------------------
 *
 * - Doesn't even try to handle spaces in variables name or labels (I can't
 *   find a reliable way to establish if a sting is a name or not, in some
 *   cases it depends on the contex or enviroment status).
 * - Doesn't handle %%[letter] pseudo variable used inside FOR constructs
 *   (it should be done only into its scope: how to handle variable it?).
 * - Doesn't handle %~[something] pseudo arguments.
 * - If the same keyword is placed at the end of the line and the
 *   beginning of the next, the second occourrence is not highlighted
 *   (this should be a GeSHi bug, not related to the language definition).
 * - I can't avoid to have keyword highlighted even when they are not used
 *   as keywords but, for example, as arguments to the echo command.
 *
 *************************************************************************************
 *
 *     This file is part of GeSHi.
 *
 *   GeSHi is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   GeSHi is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with GeSHi; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ************************************************************************************/

$language_data = [
    'LANG_NAME'      => 'DOS',
    'COMMENT_SINGLE' => [],
    'COMMENT_MULTI'  => [],
    //DOS comment lines
    'COMMENT_REGEXP' => [
        1 => "/^\s*@?REM\b.*$/mi",
        2 => "/^\s*::.*$/m",
        3 => "/\^./",
    ],
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS'    => [],
    'ESCAPE_CHAR'   => '',
    'KEYWORDS'      => [
        /* Flow control keywords */
        1 => [
            'if', 'else', 'goto', 'shift',
            'for', 'in', 'do',
            'call', 'exit',
        ],
        /* IF statement keywords */
        2 => [
            'not', 'exist', 'errorlevel',
            'defined',
            'equ', 'neq', 'lss', 'leq', 'gtr', 'geq',
        ],
        /* Internal commands */
        3 => [
            'cd', 'md', 'rd', 'chdir', 'mkdir', 'rmdir', 'dir',
            'del', 'copy', 'move', 'ren', 'rename',
            'echo',
            'setlocal', 'endlocal', 'set',
            'pause',
            'pushd', 'popd', 'title', 'verify',
        ],
        /* Special files */
        4 => [
            'prn', 'nul', 'lpt3', 'lpt2', 'lpt1', 'con',
            'com4', 'com3', 'com2', 'com1', 'aux',
        ],
    ],
    'SYMBOLS' => [
        '(', ')', '@', '%', '!', '|', '<', '>', '&',
    ],
    'CASE_SENSITIVE' => [
        GESHI_COMMENTS => false,
        1              => false,
        2              => false,
        3              => false,
        4              => false,
    ],
    'STYLES' => [
        'KEYWORDS' => [
            1 => 'color: #00b100; font-weight: bold;',
            2 => 'color: #000000; font-weight: bold;',
            3 => 'color: #b1b100; font-weight: bold;',
            4 => 'color: #0000ff; font-weight: bold;',
        ],
        'COMMENTS' => [
            1 => 'color: #808080; font-style: italic;',
            2 => 'color: #b100b1; font-style: italic;',
            3 => 'color: #33cc33;',
        ],
        'ESCAPE_CHAR' => [
            0 => 'color: #ff0000; font-weight: bold;',
        ],
        'BRACKETS' => [
            0 => 'color: #66cc66;',
        ],
        'STRINGS' => [
            0 => 'color: #ff0000;',
        ],
        'NUMBERS' => [
            0 => 'color: #cc66cc;',
        ],
        'METHODS' => [
        ],
        'SYMBOLS' => [
            0 => 'color: #33cc33;',
            1 => 'color: #33cc33;',
        ],
        'SCRIPT' => [
        ],
        'REGEXPS' => [
            0 => 'color: #b100b1; font-weight: bold;',
            1 => 'color: #448844;',
            2 => 'color: #448888;',
            3 => 'color: #448888;',
        ],
    ],
    'OOLANG'           => false,
    'OBJECT_SPLITTERS' => [
    ],
    'URLS' => [
        1 => 'http://www.ss64.com/nt/{FNAMEL}.html',
        2 => 'http://www.ss64.com/nt/{FNAMEL}.html',
        3 => 'http://www.ss64.com/nt/{FNAMEL}.html',
        4 => 'http://www.ss64.com/nt/{FNAMEL}.html',
    ],
    'REGEXPS' => [
        /* Label */
        0 => [
            /*            GESHI_SEARCH => '((?si:[@\s]+GOTO\s+|\s+:)[\s]*)((?<!\n)[^\s\n]*)',*/
            GESHI_SEARCH    => '((?si:[@\s]+GOTO\s+|\s+:)[\s]*)((?<!\n)[^\s\n]*)',
            GESHI_REPLACE   => '\\2',
            GESHI_MODIFIERS => 'si',
            GESHI_BEFORE    => '\\1',
            GESHI_AFTER     => '',
        ],
        /* Variable assignement */
        1 => [
            /*            GESHI_SEARCH => '(SET[\s]+(?si:\/A[\s]+|\/P[\s]+|))([^=\s\n]+)([\s]*=)',*/
            GESHI_SEARCH    => '(SET\s+(?si:\\/A\s+|\\/P\s+)?)([^=\n]+)(\s*=)',
            GESHI_REPLACE   => '\\2',
            GESHI_MODIFIERS => 'si',
            GESHI_BEFORE    => '\\1',
            GESHI_AFTER     => '\\3',
        ],
        /* Arguments or variable evaluation */
        2 => [
            /*            GESHI_SEARCH => '(%)([\d*]|[^%\s]*(?=%))((?<!%\d)%|)',*/
            GESHI_SEARCH    => '(!(?:!(?=[a-z0-9]))?)([\d*]|(?:~[adfnpstxz]*(?:$\w+:)?)?[a-z0-9](?!\w)|[^!>\n]*(?=!))((?<!%\d)%|)(?!!>)',
            GESHI_REPLACE   => '\\2',
            GESHI_MODIFIERS => 'si',
            GESHI_BEFORE    => '\\1',
            GESHI_AFTER     => '\\3',
        ],
        /* Arguments or variable evaluation */
        3 => [
            /*            GESHI_SEARCH => '(%)([\d*]|[^%\s]*(?=%))((?<!%\d)%|)',*/
            GESHI_SEARCH    => '(%(?:%(?=[a-z0-9]))?)([\d*]|(?:~[adfnpstxz]*(?:$\w+:)?)?[a-z0-9](?!\w)|[^%\n]*(?=%))((?<!%\d)%|)',
            GESHI_REPLACE   => '\\2',
            GESHI_MODIFIERS => 'si',
            GESHI_BEFORE    => '\\1',
            GESHI_AFTER     => '\\3',
        ],
    ],
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS'   => [
    ],
    'HIGHLIGHT_STRICT_BLOCK' => [
    ],
    'TAB_WIDTH'      => 4,
    'PARSER_CONTROL' => [
        'ENABLE_FLAGS' => [
            'BRACKETS' => GESHI_NEVER,
            'NUMBERS'  => GESHI_NEVER,
        ],
        'KEYWORDS' => [
            1 => [
                'DISALLOWED_BEFORE' => '(?<![\w\-])',
            ],
            2 => [
                'DISALLOWED_BEFORE' => '(?<![\w\-])',
            ],
            3 => [
                'DISALLOWED_BEFORE' => '(?<![\w\-])',
            ],
            4 => [
                'DISALLOWED_BEFORE' => '(?<!\w)',
            ],
        ],
    ],
];

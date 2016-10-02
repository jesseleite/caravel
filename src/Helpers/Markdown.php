<?php

namespace ThisVessel\Caravel\Helpers;

use League\CommonMark\CommonMarkConverter;

class Markdown
{
    /**
     * Renders a block of Markdown as HTML.
     *
     * @param  string  $markdown
     * @return string
     */
    public static function block($markdown)
    {
        $converter = new CommonMarkConverter([
            'renderer' => [
                'block_separator' => "\n",
                'inner_separator' => "\n",
                'soft_break'      => "<br>",
            ],
            'enable_emphasis' => true,
            'enable_strong' => true,
            'use_asterisk' => true,
            'use_underscore' => true,
            'safe' => false,
        ]);

        return $converter->convertToHtml($markdown);
    }
}

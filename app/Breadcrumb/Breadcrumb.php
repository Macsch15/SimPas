<?php

namespace SimPas\Breadcrumb;

class Breadcrumb
{
    /**
     * @var array
     */
    private $breadcrumb;

    /**
     * Push link into breadcrumb.
     *
     * @param string $title
     * @param string $url
     * @param bool   $active
     *
     * @return \Illuminate\Http\Response
     */
    public function push($title, $url = null, $active = false)
    {
        $this->breadcrumb[] = $title;

        $render = collect([
            'title'  => $title,
            'active' => $active,
        ]);

        if ($url === null) {
            return view('partials.breadcrumb.text', $render->all());
        }

        $render->put('url', $url);

        return view('partials.breadcrumb.url', $render->all());
    }

    /**
     * Count breadcrumbs.
     *
     * @return int
     */
    public function count()
    {
        return count($this->breadcrumb);
    }
}

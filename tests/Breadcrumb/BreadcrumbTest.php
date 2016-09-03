<?php

namespace SimPas\Tests;

use SimPas\Breadcrumb\Facades\Breadcrumb;

class BreadcrumbTest extends TestCase
{
    public function testBreadcrumbIsVisible()
    {
        $this->visit('/activity')
            ->see('breadcrumb-item');
    }

    public function testBreadcrumbIsNotVisible()
    {
        $this->visit('/')
            ->dontSee('breadcrumb-item');
    }

    public function testBreadcrumbShouldReceive()
    {
        $this->assertInstanceOf(\Illuminate\View\View::class,
            Breadcrumb::push('Lorem ipsum'));
    }

    public function testBreadcrumbPush()
    {
        Breadcrumb::push('Lorem ipsum Aute eiusmod dolore.', '/page1');
        Breadcrumb::push('Pariatur elit dolore dolor.', '/page2');
        Breadcrumb::push('Example breadcrumb', '/page3');

        $this->assertSame(Breadcrumb::count(), 3);
    }

    public function testBreadcrumbAttributes()
    {
        $breadcrumb = Breadcrumb::push('Hello', '/hello')
            ->getData();

        $expected = [
            'title'  => 'Hello',
            'active' => false,
            'url'    => '/hello',
        ];

        $this->assertSame($breadcrumb, $expected);
    }

    public function testBreadcrumbActiveItem()
    {
        $breadcrumb = Breadcrumb::push('Hello', '/hello', true)
            ->getData();

        $expected = [
            'title'  => 'Hello',
            'active' => true,
            'url'    => '/hello',
        ];

        $this->assertSame($breadcrumb, $expected);
    }

    public function testBreadcrumbTemplateUrl()
    {
        $breadcrumb = Breadcrumb::push('Hello', '/hello')
            ->getName();

        $this->assertSame('partials.breadcrumb.url', $breadcrumb);
    }

    public function testBreadcrumbTemplateText()
    {
        $breadcrumb = Breadcrumb::push('Hello')
            ->getName();

        $this->assertSame('partials.breadcrumb.text', $breadcrumb);
    }
}

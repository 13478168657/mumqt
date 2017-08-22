<?php

namespace Illuminate\Pagination;

trait BootstrapThreeNextPreviousButtonRendererTrait
{
    /**
     * Get the previous page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    
    
     public function getFirstButton($text = '首页')
    {
        // If the current page is greater than or equal to the last page, it means we
        // can't go any further into the pages, as we're already on this last page
        // that is available, so we will make it the "next" link style disabled.
        if ( $this->paginator->currentPage() <= 1 ) {
            
            return $this->getDisabledTextWrapperfrist($text);
        }

        $url = $this->paginator->url(1);
        return $this->getPageLinkWrapper($url, $text, 'next');
    }
    
    public function getPreviousButton($text = '')
    {
        // If the current page is less than or equal to one, it means we can't go any
        // further back in the pages, so we will render a disabled previous button
        // when that is the case. Otherwise, we will give it an active "status".
        if ($this->paginator->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->url(
            $this->paginator->currentPage() - 1
        );

        return $this->getPageLinkWrapper($url, '上一页', 'prev');
    }

    /**
     * Get the next page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getNextButton($text = '')
    {
        // If the current page is greater than or equal to the last page, it means we
        // can't go any further into the pages, as we're already on this last page
        // that is available, so we will make it the "next" link style disabled.
        if (! $this->paginator->hasMorePages()) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->url($this->paginator->currentPage() + 1);

        return $this->getPageLinkWrapper($url, '下一页', 'next');
    }
    
    public function getLastButton($text = '尾页')
    {
        // If the current page is greater than or equal to the last page, it means we
        // can't go any further into the pages, as we're already on this last page
        // that is available, so we will make it the "next" link style disabled.
        if (! $this->paginator->hasMorePages()) {
            return $this->getDisabledTextWrapperff($text);
        }

        $url = $this->paginator->url($this->paginator->lastPage());

        return $this->getPageLinkWrapper($url, $text, 'next');
    }
   
}

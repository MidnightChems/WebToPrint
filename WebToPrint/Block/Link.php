<?php
namespace GuyOrazem\WebToPrint\Block;
// adds link to the my account section
use Magento\Framework\View\Element\Template;

class Link extends Template
{
    public function getLink()
    {
        return $this->getUrl('pricerange/');
    }
}

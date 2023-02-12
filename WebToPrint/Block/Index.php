<?php

namespace GuyOrazem\WebToPrint\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_productCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    /*I wanted the values of the 'addAttributeToFilter' to be user supplied but it was not working as I could not figure out how to get the values from the form on phtml to this block file
    
    function to created the production collection factory, something like 
    $productCollection = $block->getProductCollection(); will allow you to use it in the phtml file
    
    Collection was limited to 10 on the form, but this was done on the phtml
    via JS as I couldn't get the values to pass over from the phtml file like I wanted
    
    
    */
    public function getProductCollection()
    {
        
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect(['sku', 'name', 'price', 'url_key', 'thumbnail']);
        // $collection->addAttributeToFilter('price', array('gteq' =>  User supplied lowPrice));
        // $collection ->addAttributeToFilter('price', array('lteq' => User supplied highPrice));
        //$collection->setPageSize(10);
        return $collection;
    }
}

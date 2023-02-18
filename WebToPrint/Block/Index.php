<?php

namespace GuyOrazem\WebToPrint\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_productCollectionFactory;
    protected $lowPrice;
    protected $highPrice;

    public function __construct(
        Template\Context $context,
        CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_productCollectionFactory = $productCollectionFactory;
        
    }

    public function getProductCollection()
    {
        //gets params from the URL
        $this->getRequest()->getParams();
        $lowPrice = $this->getRequest()->getParam('low_price');
        $highPrice = $this->getRequest()->getParam('high_price');
        $sortOrder = $this->getRequest()->getParam('sort');
        
        if ($lowPrice !== null && $highPrice !== null) {
        // Check if the input values are numeric
        if (!is_numeric($lowPrice) || !is_numeric($highPrice)) {
            // Handle the error, for example:
            throw new \Exception('Low and high prices must be numeric.');
        }

        // Check if lowPrice is less than highPrice
        if ($lowPrice >= $highPrice) {
            // Handle the error
            throw new \Exception('Low price must be lower than high price.');
        }
        
        //Checks if High price is more than 10x the low price
        if ($lowPrice * 10 < $highPrice ) {
            // Handle the error
            throw new \Exception('High price must not be more than 10x higher than Low price.');
        }
    }
        //create the collection factory and add attributes
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect(['sku', 'name', 'price', 'url_key', 'thumbnail']);
        
        //if value is not null assign values from form. If null sets min and max price to 0 and 1 by default
        if ($lowPrice !== null && $highPrice !== null) {
            $collection->addAttributeToFilter('price', array('gteq' => $lowPrice));
            $collection->addAttributeToFilter('price', array('lteq' => $highPrice));
            
        } else {
            $collection->addAttributeToFilter('price', array('gteq' => 0));
            $collection->addAttributeToFilter('price', array('lteq' => 1));
        }
        
        if ($sortOrder == "price_desc") {
            $collection->addAttributeToSort('price', 'DESC');
        } else {
            $collection->addAttributeToSort('price', 'ASC');
        }
        
       
        $collection->setPageSize(10);
        return $collection;
    }
}
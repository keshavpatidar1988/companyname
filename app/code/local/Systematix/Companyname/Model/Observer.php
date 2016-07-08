<?php 
class Systematix_Companyname_Model_Observer extends Varien_Event_Observer
{
	/*
	Function to add company name column
	*/
	public function addCompanyColumn(Varien_Eveny_Observer $observer)
	{    
		$companyBlock = $observer->getBlock();

		if(!isset($companyBlock)){
			return $this; 
		}
	        if($companyBlock instanceof Mage_Adminhtml_Block_Customer_Grid){
	        	$companyBlock->addColumnAfter('billing_company',
	        		array(
	        			'header' => Mage::helper('customer')->__('Company'),
	        			'index' => 'billing_company'
	        			),
	        			'email'
	        		);
	        }
	}  
	/*
	Function to add company name value
	*/

	public function addCompanyColumnValue(Varien_Eveny_Observer $observer)
	{  
		$companyCollection = $observer->getCollection();

		if(!isset($companyCollection)){
			return $this;
		}
	    
	    if($companyCollection instanceof Mage_Customer_Model_Resource_Customer_Collection) {
	    	 $companyCollection->joinAttribute('billing_company','customer_address/company', 'default_billing', null, 'left');
	    }
	}
} 
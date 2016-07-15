<?php 
class Systematix_Companyname_Model_Observer extends Varien_Event_Observer
{   /* 
	Function to add company column
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
	        			'type' => 'text',
	        			'index' => 'billing_company',
	        			'filter_condition_callback'=>array($this,'filterCompany')
	        			),
	        			'email' 
	        		);
	        }
	}  
    /*
    Function to append column value
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
	    if(Mage::registry('filter_data')){
			$companyCollection->addFieldToFilter('billing_company',array('like'=>"%".Mage::registry('filter_data')."%"));
			}
	}
	/*
	Callback function to filter the company value using registry
	*/
	public function filterCompany($collection, $company){
		if(!$data = $company->getFilter()->getValue()){
			return $this; 
		}  
		if(!Mage::registry('filter_data')){
			Mage::register('filter_data',$data);
		}
	}
}  
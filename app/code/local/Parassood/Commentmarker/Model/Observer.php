<?php


/**
 * Commentmarker observer model
 *
 * @category    Parassood
 * @package     Parassood_Commentmarker
 * @author      Paras Sood
 */
class Parassood_Commentmarker_Model_Observer
{


    /**
     *
     * Hook for Event sales_order_status_history_save_before
     * @param $observer
     * @return $this
     */
    public function addAdminNameToOrderComment($observer)
    {
        $orderComment = $observer->getDataObject();
        $adminUser = Mage::getSingleton('admin/session')->getUser();
        $userId = $adminUser->getId();

        if (isset($userId)) {

            $adminName = $adminUser->getFirstname() . ' ' . $adminUser->getLastname();
            $orderComment->setAdminuserName($adminName);
        }

        return $this;
    }

}
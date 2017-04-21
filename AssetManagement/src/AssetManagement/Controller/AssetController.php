<?php

/*
* class objective:-Insert,Update, Delete,View the Asset Information. 
*                  and For leased user add and , view and update functionality.
*
*/
namespace AssetManagement\Controller;
use AssetManagement\Model\AssetInfoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AssetManagement\Form\AssetForm;
use AssetManagement\Model\Asset;
use Zend\Authentication\AuthenticationService;
use UserInfo\Controller;
use UserInfo\Model\UserInfoTable;
use AssetManagement\Form\leasedForm; 
use AssetManagement\Model\leased;
use AssetManagement\Model\leasedoutuserTable;
use AssetManagement\Model\AssetType;
use DateTime;
use DateTimeZone;

class AssetController extends AbstractActionController {
      protected $AssetInfoTable;
      protected $userInfoTable;
      protected $AssetType;
      protected $leasedoutuserTable;
      protected $UserHasAsset;

    /**
    * Getting object of the UserInfoTable:-
    *
    * @return userInfoTable object
    */     
    public function getUserInfoTable() {
        if (!$this->userInfoTable) {
            $ai = $this->getServiceLocator();
            $this->userInfoTable 
                = $ai->get("UserInfo\Model\UserInfoTable");
        } 
      return $this->userInfoTable;
    }
    

   
    /**
    *  Getting  object to database connection for operation.
    *
    * @return AssetInfoTable object
    */ 
    public function getAssetInfoTable() { 
        if (!$this->AssetInfoTable) {
            $ai = $this->getServiceLocator();
            $this->AssetInfoTable 
                = $ai->get("AssetManagement\Model\AssetInfoTable");
        } 
          return $this->AssetInfoTable;
    }
    
    /**
    *  Getting the Object of type AssetTYpe for the Database Operation.
    *
    * @return AssetType  object
    */ 
    public function getAssetType() {
        if(!$this->AssetType) {
            $ai= $this->getServiceLocator();
            $this->AssetType = 
                $ai->get("AssetManagement\Model\AssetType");
        } 
            return $this->AssetType;
      }
       
    /**
    * Getting the Object of UserHasAsset for Database Operations.
    *
    * @return  UserHasAsset object
    */ 
    public function getUserHasAsset() {
        if(!$this->UserHasAsset) {
            $ai = $this->getServiceLocator();
            $this->UserHasAsset
                = $ai->get("UserInfo\Model\UserHasAsset");
        } 
          return $this->UserHasAsset;
    }
    

    /**
    * Getting the Object of LeasedOutUserTable for Database operation
    *
    * @return   LeasedOutUserTable object
    */ 
    public function getleasedoutuserTable() {
        if(!$this->leasedoutuserTable) {
            $ai= $this->getServiceLocator();
            $this->leasedoutuserTable = 
                $ai->get("AssetManagement\Model\leasedoutuserTable");
        } 
          return $this->leasedoutuserTable;
    }

    /**
    * fetching all the content in the AssetInfoTable.
    *
    * @return   ViewModel object
    */ 
    public function indexAction() {
        //getting the userInformation by the Email.
        $datetime = new DateTime(null, new DateTimeZone('America/Chicago')); 
        $userInfoObj = $this->getUserInfoTable();
        $auth = new AuthenticationService();
        $userInfo 
            = $userInfoObj->getUserInfoByEmail($auth->getIdentity());
        $resultSet = $this->getAssetInfoTable()->fetchAll();
        if ($userInfo->roleid == 1) {
            return new ViewModel(array(
            'Asset'=>$this->getAssetInfoTable()->fetchAll() ,
            'datetime'=>$datetime));
        } else {
            echo "As you are not the Admin , you can't asses it Directly...";exit();
        }
    }
    
    /**
    * Getting Asset Information for the normal User's:-
    *
    * @return   ViewModel object
    */ 
    public function viewAction() {
        $id = (int) $this->params()->fromRoute('id',0); 
        $asset = $this->getAssetInfoTable()->getAssetInfoForUser($id);
        return new viewModel(array('asset' => $asset));
    }

     /**
    * Changing the Status of LeasedOut User for the Admin view.
    *
    * @return   ViewModel object 
    * @return   form  Object.
    */ 
    public function statusAction() {
        $id = (int) $this->params()->fromRoute('id',0); 
        $opt= array('available'=>'available','assigned'=>'assigned','leasedout'=>'leasedout');
        $assetTypeObj = $this->getAssetType()->fetchAll();
        foreach ( $assetTypeObj as $key => $value) {
              $options[$value->Id] = $value->AssetType;
        }
        $formdata= $this->getAssetInfoTable()->getAsset($id);
          //creating html form for data insert
        $form= new AssetForm('',$options,$opt);
        $form->bind($formdata);
        $form->get('submit')->setAttribute('value', 'update');
        //Getting the Request Object.
        $request =$this->getRequest();
        if($request->isPost()) {
            $Asset = new Asset();
            $form->setData($request->getPost());
            if($form->isValid()) {
                $data=$form->getData();
                $Asset->editexchangeArray($data);
                $this->getAssetInfoTable()->updateAssetStatus($id, $Asset);
            }
        }
       
            return new viewModel(array(
            'form'=>$form ,
            'id' => $id ,
            )
          );
    }
     /**
    *Adding the Leased out user to leasedout Table of Database:- 
    *
    * @return   ViewModel object 
    * @return   form  Object.
    * @return   Id
    */       
    public function leasedViewAction() {
        $id = (int) $this->params()->fromRoute('id',0); 
        //fetching the name of the Asset based on the Id:-
        $assetObj = $this->getAssetInfoTable()->fetchName();
        foreach ($assetObj as $key => $value) {
            $opt[$value->AssetId]= $value->AssetName;
        }
        $form = new leasedForm('',$opt,$id,array());
        $form->get('userId')->setAttribute('disabled','disabled');
        $request =$this->getRequest();
        if($request->isPost()) {
            $leased = new leased();
            $form->setData($request->getPost());
            if($form->isValid()) {
                $leased->exchangeArray($form->getData(),$id);
                //Adding the leased out user to Database.
                $this->getleasedoutuserTable()->addLeasedUsers($leased);
            }
        }

        return new viewModel(array(
        'form'=>$form,
        'id'=>$id
        ));
    }
    
    /**
    *leased users featch action:-
    *
    * @return   ViewModel object 
    * 
    
    */  
    public function leasedFetchAction() {
        $userInfoObj = $this->getUserInfoTable();
        $auth = new AuthenticationService();
        $userInfo = $userInfoObj->getUserInfoByEmail($auth->getIdentity());
      
      
        if($userInfo->roleid==1) {
            $Leased=$this->getleasedoutuserTable()->joinLeasedOutUser();
            return new viewModel(array('data' => $Leased));
        } else {
             echo "As you are not admin , you can't access Directly";exit();
        }
    }
    /**
    *fetching Single Row of the LeasedUser based on Id:-
    *
    * @return   ViewModel object 
    * 
    */ 
    public function leasedRowAction() {
        $id = (int) $this->params()->fromRoute('id',0);
        $lrow = $this->getleasedoutuserTable()->getLeasedRow($id);
        return new viewModel(array('lrow' => $lrow));
    }  
    /**
    *Changing the Return Time By the Leased out User:-
    *
    * @return   ViewModel object 
    * 
    */ 
    public function leasedStatusAction() {
        $id = (int) $this->params()->fromRoute('id',0); 
        $assetObj = $this->getAssetInfoTable()->fetchName();
        foreach ($assetObj as $key => $value) {
            $opt[$value->AssetId]= $value->AssetName;
        }

        $form = new leasedForm('',$opt,$id);
        $formdata= $this->getleasedoutuserTable()-> getRowOfLeasedUser($id);
        
        //print_r($formdata->Id);exit();
       $form->get('userId')->setAttribute('disabled','disabled');
        $form->get('assetId')->setAttribute('disabled','disabled');
        $form->get('requestedTime')->setAttribute('disabled','disabled');
        $form->bind($formdata);
        $form->get('submit')->setAttribute('value', 'update');
        
        $request =$this->getRequest();
        if($request->isPost()) {
            $leased = new leased();
            $form->setData($request->getPost());
            //$array= array('requestedTime'=>$formdata->requestedTime,
              //  'userId'=>$formdata->userId,'assetId'=>$formdata->assetId);
            $form->setData($request->getPost());

            if(!$form->isValid()) {
                $data=$form->getData();
                $leased->editexchangeArray($data);
                $a= $leased->Id;
                $this->getleasedoutuserTable()->updateStatus($a, $leased);
            } else {
                echo "not valid";exit;
            }
        }
        return new viewModel(array(
            'form'=>$form ,
            'id' => $id ,
        ));
    }

     /**
    * Deleting the content in the database based on the id.
    *
    *
    * 
    
    */ 
    public function deleteAction() {
        $request =$this->getRequest();
        $data = $request->getPost();
        $this->getAssetInfoTable()->deleteAsset($data['AssetId']);
    }

    
     /**
    * updating the content in the database based on the id.
    * @return   form  Object.
    * @return   Id
    *
    */ 
    public function updateAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $opt= array('available'=>'available','assigned'=>'assigned','leasedout'=>'leasedout');
        $assetTypeObj = $this->getAssetType()->fetchAll();
        foreach ( $assetTypeObj as $key => $value) {
              $options[$value->Id] = $value->AssetType;
        }
        $formdata= $this->getAssetInfoTable()->getAsset($id);
        //creating html form for data insert
        $form= new AssetForm('',$options,$opt);
        $form->bind($formdata);
        $form->get('submit')->setAttribute('value', 'update');
        //Getting the Request Object.
        $request =$this->getRequest();
        if($request->isPost()) {
            $Asset = new Asset();
            $form->setData($request->getPost());
            if($form->isValid()) {
                $data=$form->getData();
                $Asset->editexchangeArray($data);
                $this->getAssetInfoTable()->updateAsset($id, $Asset);
            }
        }
       
          return new viewModel(array(
              'form'=>$form ,
              'id' => $id ,
            )
          );
    }
    /**
    * Inserting the Asset Content into DAtabase:-.
    * @return   form  Object.
    * 
    */ 
    public function addAction() {
        $assetTypeObj = $this->getAssetType()->fetchAll();
        foreach ( $assetTypeObj as $key => $value) {
              $options[$value->Id] = $value->AssetType;
        }
        $opt= array('available'=>'available','assigned'=>'assigned','leasedout'=>'leasedout');
        $userInfoObj = $this->getUserInfoTable();
        $auth = new AuthenticationService();
        $userInfo = $userInfoObj->getUserInfoByEmail($auth->getIdentity());
        $form= new AssetForm('',$options,$opt);
        $request =$this->getRequest();
        if($request->isPost()) {
            $form->setData($this->getRequest()->getPost()->toArray());
            $Asset = new Asset();
            if($form->isValid()) {
                $Asset->exchangeArray($form->getData());
                $this->getAssetInfoTable()->storeAsset($Asset); 
            }
        }
    //if the user is only Admin , he can access it!    
    if($userInfo->roleid==1) {
        $formArray = array('form'=>$form);
        return new viewModel($formArray);
    } else {
          echo "As you are not the Admin , you can't asses it Directly...";exit();
      }
}
}
  

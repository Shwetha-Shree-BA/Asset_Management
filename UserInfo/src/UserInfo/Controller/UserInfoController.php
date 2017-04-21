<?php
/**
*class Objective is to communicate with Model and the view as it is controller.
*
*/
namespace UserInfo\Controller;
use UserInfo\Form\UserForm;
use UserInfo\Model\UserInfoTable;
use UserInfo\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use UserInfo\Form\LoginUserForm;
use Zend\Session\Container;
use AssetManagement\Model\Asset;
use AssetManagement\Model\AssetInfoTable;
use UserInfo\Model\UserHasAsset;

class UserInfoController extends AbstractActionController {

	protected $userInfoTable;
    protected $Role;
    protected $storage;
    protected $authService;
    protected $AssetInfoTable;
    protected $UserHasAsset;
    protected $UserHasRole;

    /**
    * Calling the Service locator in order to create the Object of the * UserInfoTable:- 
    *
    * @return object
    */     
    public function getUserInfoTable() {
        if(!$this->userInfoTable) {
          $ai= $this->getServiceLocator();
          $this->userInfoTable= $ai->get("UserInfo\Model\UserInfoTable");
        } 
          return $this->userInfoTable;
    }
    /**
    *calling the service locator in order to create the object of UserHasAsset:- 
    *
    * @return object
    */
    public function getUserHasAsset() {
        if(!$this->UserHasAsset) {
            $ai = $this->getServiceLocator();
            $this->UserHasAsset = $ai->get("UserInfo\Model\UserHasAsset");
        } 
          return $this->UserHasAsset;
    }

    /**
    *calling the service locator in order to create the object of userhasrole:-
    *
    * @return object
    */
    public function getUserHasRole() {
          
        if(!$this->UserHasRole) {
          $ai = $this->getServiceLocator();
          $this->UserHasRole = $ai->get("UserInfo\Model\UserHasRole");
        } 
          return $this->UserHasRole;
    }
   
    /**
    * Calling the Service Locator in order to create the Object of RoleTable
    *
    * @return object
    */
    public function getRole() {
        if(!$this->Role) {
          $ai= $this->getServiceLocator();
          $this->Role= $ai->get("UserInfo\Model\Role");
        } 
          return $this->Role;
    } 
    /**
    *  calling the Service locator in order to create the object of AssetInfoTable:- 
    *
    * @return object
    */
    public function getAssetInfoTable() {
        if(!$this->AssetInfoTable) {
          $ai= $this->getServiceLocator();
          $this->AssetInfoTable= $ai->get("AssetManagement\Model\AssetInfoTable");
        } 
          return $this->AssetInfoTable;
    }
    /**
    * Featching all the user Details and showing:- 
    *
    * @return object
    */
    public function selectAction() {
        $userInfoObj = $this->getUserInfoTable();
        $auth = new AuthenticationService();
        $userInfo = $userInfoObj->getUserInfoByEmail($auth->getIdentity());
        if($userInfo->roleid==1) {
            return new ViewModel(array(
            'User'=>$this->getUserInfoTable()->fetchAll() ));
        }
        else
        {
          echo "As you are not Admin, you cant acess it Directly!";exit();
        }

    }
    /**
    *  Editing the User Details:-
    *@return $form, $id
    */
    public function editAction() {
        $User = new User();
        $id = (int) $this->params()->fromRoute('id', 0);
        $assetObj = $this->getAssetInfoTable()->fetchName();
        foreach ( $assetObj as $key => $value) { 
            $opt[$value->AssetId] 
                = $value->slno.' - '.$value->AssetName;
        }
        $roleObj = $this->getRole()->fetchAll();
        foreach ($roleObj as $key => $value) {
            $options[$value->Id] = $value->rolename;
        }
        $count= -1;
        $form = new UserForm('',$options,$opt);
        $formdata= $this->getUserInfoTable()->getUser($id);

        foreach ($formdata as $key => $value) {
          
          $currentData[$key] = $value;
          $count= $count+1;

        }
        
        if(empty($currentData)) {

            $formdata = $this->getUserInfoTable()->getUserRowById($id);
            $form->bind($formdata);
        }
        
        if(!empty($currentData)) {
        //In order to bind the data it should be always the object, 
        //so the formdata array is converted into user Object.
        $User->exchangeAssetArray($currentData[$count]);
        $form->bind($User);
        }
        
        $form->get('submit')->setAttribute('value', 'update');
          
        $request =$this->getRequest();
    
        if($request->isPost()) {
            
            $form->setData($request->getPost());      
            if($form->isValid()) {
                $data=$form->getData();
                $b= $form->get('roleid');
                $roleid = $b->getValue();
                //Invoked inorder to add userid and roleid into roletable.
                $this->getUserHasRole()->addUserRole($id,$roleid);
                $a = $form->get('assetid');
                $assetid = $a->getValue();
                //Invoked in-order to add userid and assetid into userHasAsset table.
                $this->getUserHasAsset()->addIds($assetid,$id);
                $User->editexchangeArray($data);
                //update function update the user information based on the id            
                $this->getUserInfoTable()->updateUser($id, $User);
            } else {
                  echo "not valid";exit();
            }
        }
            return new viewModel(array(
                'form'=>$form ,
                'id' => $id ,
            )
          );

    }
    /**
    *Used for creating the Login Screen and used for the authentication.
    * @return  viewmodel
    *
    */
    public function indexAction() {

        $form = $this->getServiceLocator()
                     ->get('FormElementManager')
                     ->get('UserInfo\Form\LoginUserForm');   
        $viewModel = new ViewModel();
        //initialize error...
        $viewModel->setVariable('error', '');
        //authentication block...
        $this->authenticate($form, $viewModel);
        $viewModel->setVariable('form', $form);
        return $viewModel;
    }
    /** 
    *calling the funn authenticate for authentication.
    *
    * @param $form Object
    * @param $viewModel Object
    *
    * 
    */
    protected function authenticate($form, $viewModel) {
        $authService = $this->serviceLocator->get('AuthService');
        if ($authService->hasIdentity()) {
            return $this->redirect()->toRoute('new');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $dataform = $form->getData();
                $authService->getAdapter()
                                       ->setIdentity($dataform['email'])
                                       ->setCredential($dataform['password']);
                $result = $authService->authenticate();
                if ($result->isValid()) {
                    //authentication succes
                    $resultRow = $authService->getAdapter()->getResultRowObject();
                    $authService->getStorage()->write(
                    array('email'          => $resultRow->email,
                          'password'   => $dataform['password'],
                          'id'          => $resultRow->id,
                          'roleid'          => $resultRow->roleid,
                          'ip_address' => $this->getRequest()->getServer('REMOTE_ADDR'),
                          'user_agent'    => $request->getServer('HTTP_USER_AGENT'))
                    );
                    $roleObj = $this->getUserHasRole()->fetchAll();
                    $this->storeInformation($resultRow);
                    foreach ($roleObj as $key => $value) {
                        if($value['roleid'] == $resultRow->roleid && 
                        $resultRow->isleasedout == 0) {
                            return $this->redirect()->toRoute('new');
                        }
                        else if($value['roleid'] != $resultRow->roleid && 
                            $resultRow->isleasedout == 0) {
                            return $this->redirect()->toRoute('UserView', 
                            array('id'=>$resultRow->Id));
                        }
                        else if($resultRow->isleasedout == 1) {
                            return $this->redirect()->toRoute('lrow', 
                            array('id'=>$resultRow->Id));
                    }
                  }
                     
                         
                } else {
                  $viewModel->setVariable('error', 'Login Error');
                }
            }
        }

    }
    /**
    *Clearing the session data by calling:-ClaerIndentity of the AuthService.php.
    *@return rerouting through the login screen.
    */
    public function logoutAction() {
        $authService = $this->serviceLocator->get('AuthService');
        $session_user = new Container('user');
        $session_user->getManager()->getStorage()->clear();
        $authService->getStorage()->clear();
        return $this->redirect()->toRoute('login');
    }
  

    /**
    * Creating the Registration form and inserting the rows:-
    * @return view object
    *
    */
    public function addoAction() {
        $roleObj = $this->getUserHasRole()->fetchAll();
        foreach ($roleObj as $key => $value) {
              $options[$value['roleid']] = $value['rolename'];
        }
        //creating html form for data insert
        $form= new UserForm('',$options,array());
        //Getting the Request Object.
        $request =$this->getRequest();
        if($request->isPost()) {
       	    $form->setData($request->getPost());
            $User = new User();
            if(!$form->isValid()) {
                //setting data on Asset object from form odbc_fetch_object
                $User->exchangeArray($form->getData());
                $this->getUserInfoTable()->storeUser($User);
                $this->flashMessenger()->addMessage('Registration completed Successfully!!');
                return $this->redirect()->toRoute('login');
            }
        }
        // if it is form request
        $formArray = array('form'=>$form);
            return new viewModel($formArray);
    }

    /**
    * Function to store information in container
    * @param $res = Object
    *
    */
    public function storeInformation($res) {
        $container = new Container('user');
        $container->role = $res->roleid;
        $container->userId= $res->Id;
        $container->leasedout=$res->isleasedout;   

    }
}
?>

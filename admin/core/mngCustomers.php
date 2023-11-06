<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

// check if there's a customer to delete

if(filter_input(INPUT_GET,"idToDel")){

    $customer->id = filter_input(INPUT_GET,"idToDel");

    if($customer->delete('id')){
        header("Location: ../index.php?p=allCustomers&msg=customerDel");
        exit;
    }else{
        header("Location: ../index.php?p=allCustomers&err=customerNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a customer to edit or add

if($operation=="edit"){
        
        $customer->id = $id ;
        $stmt = $customer->showAllWhere('id',['id']);
       
        
        $customer->name = filter_input(INPUT_POST,"name") ;
        $customer->surname = filter_input(INPUT_POST,"surname") ;

        require "customerDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($customers_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_arr){
            $details_str = serialize($details_arr);
            $customers->details = $details_str;
        }

        foreach($customers_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_opt_arr){
            $details_opt_str = serialize($details_opt_arr);
            $customer->details_opt = $details_opt_str ;
        }

        if($account->update(['name','surname','details','details_opt'],'id')){

			header("Location: ../index.php?p=editCustomer&idToMod=$id&msg=customerEdit");
			exit; 
		
		}else{
        
			header("Location: ../index.php?p=editCustomer&idToMod=$id&err=customerNoEdit");
			exit;
		
        }

		// TODO add customer
}else if($operation == "add"){

    $auth->email = filter_input(INPUT_POST,"email");

    if($auth->emailExists()){
        header("Location: ../index.php?p=addAccount&err=accountExist");
        exit;
    }else{

        $account->username = filter_input(INPUT_POST,"username") ;
        $account->email = filter_input(INPUT_POST,"email") ;
        
        // hash password
        $password=filter_input(INPUT_POST,"password");
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $account->password = $password_hash ;

        require "accountDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($account_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        $details_str = serialize($details_arr);
        $account->details = $details_str;

        foreach($account_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }
        $details_opt_str = serialize($details_opt_arr);
        $account->details_opt = $details_opt_str ;

        // upload avatar
        $errUpload = "";
        $file->operation = filter_input(INPUT_POST,"operation") ;
        
        if($_FILES['avatar']['size'] > 0){
            
            // set data for file uploading
            $file->filename = $_FILES['avatar']['name'] ;
            $file->inputFileName = $_FILES['avatar']['tmp_name'] ;
            $file->label = 'avatar_'.rand(10,100) ;
            $file->path = "../uploads/avatar/" ;
            $file->origin = filter_input(INPUT_POST,"origin");

            if($file->uploadFile()){
                $account->avatar = $_FILES['avatar']['name'] ;
            }else{
                $errUpload = "&err=noAvatarUpload" ;
                $account->avatar = "default.png" ;
            }
        }else{
            $account->avatar = "default.png" ;
        }

        if($account->insert(['username','email','password','avatar','details','details_opt'])){

            $accountroles->role_id = filter_input(INPUT_POST,"role") ;
            $insertedId = "" ;
            $account->email = filter_input(INPUT_POST,"email") ;
            
            $stmt= $account->showAllWhere('id',['email']);
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $insertedId = $row['id'];
            }

            $accountroles->account_id = $insertedId ;

            // success, insert the role in accountsRoles table
            if($accountroles->insert(['account_id','role_id'])){
                
                //success
                header("Location: ../index.php?p=allAccounts&msg=accountSucc$errUpload");
                exit;

            }else{

                // failed, delete the user inserted
           
                if(!$errUpload){
                    unlink("../uploads/avatar/".$_FILES['avatar']['name']."");
                }               
                header("Location: ../index.php?p=allAccounts&err=accountFail");
                exit;
            }


        }else{

            // error, removing avatar if uploaded
            if(!$errUpload){
                unlink("../uploads/avatar/".$_FILES['avatar']['name']."");
            }
            header("Location: ../index.php?p=allAccounts&err=accountFail");
            exit;
        }

    }




}else{
    header("Location: ../index.php?p=allAccounts&err=noPost");
    exit;
}
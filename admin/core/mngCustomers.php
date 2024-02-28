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

if(filter_input(INPUT_POST,"idToMod"))
{

        $id = filter_input(INPUT_POST,"idToMod") ;
        
        $customer->id = $id ;


        // $stmt = $customer->showAllWhere('id',['id']);
        if($operation=="password")
        {
        
            $password = filter_input(INPUT_POST,"password");
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $customer->password = $password_hash ;
    
            if($customer->update(['password'],'id')){
                header("Location: ../index.php?p=editCustomer&idToMod=$id&msg=passMod");
                exit;
            }else{
                header("Location: ../index.php?p=editCustomer&idToMod=$id&err=passNoMod");
                exit;
            }
    
        }
        else if($operation=="edit")
        {

        $customer->name = filter_input(INPUT_POST,"name");
        $customer->username = filter_input(INPUT_POST,"username");
        $customer->company = filter_input(INPUT_POST,"company");
        $customer->email = filter_input(INPUT_POST,"email");

        $password=filter_input(INPUT_POST,"password");
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $customer->password = $password_hash ;  

        require "customersDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($customers_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_arr){
            $details_str = serialize($details_arr);
            $customer->details = $details_str;
        }

        foreach($customers_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }

        if($details_opt_arr){
            $details_opt_str = serialize($details_opt_arr);
            $customer->details_opt = $details_opt_str ;
        }

        if($customer->update(['name','username','company', 'email','details','details_opt'],'id')){

			header("Location: ../index.php?p=editCustomer&idToMod=$id&msg=customerEdit");
			exit; 
		
		}else{
        
			header("Location: ../index.php?p=editCustomer&idToMod=$id&err=customerNoEdit");
			exit;
		
        }
    }
}
else if($operation == "add")
{

    $customer->name = filter_input(INPUT_POST,"name");
    $customer->username = filter_input(INPUT_POST,"username");
    $customer->company = filter_input(INPUT_POST,"company");
    $customer->email = filter_input(INPUT_POST,"email");

    $password=filter_input(INPUT_POST,"password");
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $customer->password = $password_hash ;

    if($customer->customerExists()){
        header("Location: ../index.php?p=addCustomer&err=customerExist");
        exit;
    }else{

        require "customersDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($customers_details as $item){
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        $details_str = serialize($details_arr);
        $customer->details = $details_str;

        foreach($customers_details_opt as $item){
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }
        $details_opt_str = serialize($details_opt_arr);
        $customer->details_opt = $details_opt_str ;

        if($customer->insert(['name','username','company','password', 'email','details','details_opt'])){

            //success
            header("Location: ../index.php?p=allCustomers&msg=customerSucc");
            exit;

        }else{

            // fail
            header("Location: ../index.php?p=allCustomers&err=customerFail");
            exit;
        }

    }

}
else
{
    header("Location: ../index.php?p=allCustomers&err=noPost");
    exit;
}
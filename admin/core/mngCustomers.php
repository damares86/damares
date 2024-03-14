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
        $idToMod = filter_input(INPUT_POST,"idToMod") ;
        
        $customer->id = $idToMod ;


        // $stmt = $customer->showAllWhere('id',['id']);
        if($operation=="password")
        {
        
            $password = filter_input(INPUT_POST,"password");
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $customer->password = $password_hash ;
    
            if($customer->update(['password'],'id')){
                header("Location: ../index.php?p=editCustomer&idToMod=$idToMod&msg=passMod");
                exit;
            }else{
                header("Location: ../index.php?p=editCustomer&idToMod=$idToMod&err=passNoMod");
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

            // permissions update
           
            $xsproduct->table = 'product' ;
            $stmt = $xsproduct->showAll('id');

            $error_prod = 0 ;
            $error_file = 0 ;

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                extract($row);

                $prod_id = $row['id'] ;

                if(filter_input(INPUT_POST,'prod_'.$prod_id.''))
                {
                    // il prodotto è checkato
                    //    - se già presente passo oltre
                    //    - se no insert product_permissions

                    $xsproduct->table = 'product_permissions';
                    $xsproduct->customers_id = $idToMod;
                    $xsproduct->product_id = $prod_id ;

                    $stmt = $xsproduct->showAllWhere('id',['customers_id','product_id']) ;

                    if($stmt->rowCount()==0)
                    {
                        $xsproduct->table = 'product_permissions';
                        $xsproduct->customers_id = $idToMod;
                        $xsproduct->product_id = $prod_id ;
                        if(!$xsproduct->insert(['customers_id','product_id']))
                        {
                            $error_prod++;
                        }
                    }

                    // permessi file
                    //    - get da product_files dove c'è product_id
                    //    - explode permissions[]
                    //    - ciclo file
                    //        - aggiungo all'array
                    //    - update product_files

                    $xsproduct->table = 'product_files_cat' ;
                    $stmt1 = $xsproduct->showAll('id');

                    $cat_arr = [] ;
                    $cat_arr_str = '' ;

                    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
                    {
                        $files_arr = [] ;

                        $cat_files = $_POST['files_'.$prod_id.'_'.$row1['id']];
                        foreach($cat_files as $file)
                        {
                    
                            $xsproduct->table = 'product_files' ;
                            $xsproduct->id = $file ;

                            $stmt2 = $xsproduct->showAllWhere('id',['id']) ;
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;

                            $perm_arr = explode(',',$row2['permissions']) ;

                            $perm_arr[] = $idToMod ;

                            $perm_str = implode(',',$perm_arr) ;
                            
                            $xsproduct->table = 'product_files' ;
                            $xsproduct->id = $file ;
                            $xsproduct->permissions = $perm_str ;

                            if(!$xsproduct->update(['permissions'],'id'))
                            {
                                $error_file++;
                            }
                            
                        }
                        
                    }
                   
                }
                else
                {
                    // il prodotto non è checkato
                    // devo eliminare il record da product_permissions
                    // devo ciclare tutti i prodotti da product_files ed eliminare l'id del customers da permissions





                    
                    $xsproduct->table = 'product_permissions';
                    $xsproduct->customers_id = $idToMod;
                    $xsproduct->product_id = $prod_id ;

                    $stmt2 = $xsproduct->showAllWhere('id',['customers_id','product_id']) ;
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;

                    if($stmt2->rowCount()>0)
                    {
                        $xsproduct->table = 'product_permissions';
                        $xsproduct->id = $row2['id'];
                        if(!$xsproduct->delete('id'))
                        {
                            $error_prod++;
                        }
                    }

                }
            

            }

            $err_file = '' ;

            if($error>0)
            {
                $err_file = '&err=filePermissionFail';
            }

            $err_prod = '' ;

            if($error_prod>0)
            {
                $err_file = '&err=prodPermissionFail';
            }


			header("Location: ../index.php?p=editCustomer&idToMod=$idToMod&msg=customerEdit$err_file");
			exit; 
		
		}else{
        
			header("Location: ../index.php?p=editCustomer&idToMod=$idToMod&err=customerNoEdit");
			exit;
		
        }
    }
}
else if($operation == "add")
{

    $customer->name = filter_input(INPUT_POST,"name");
    $username = filter_input(INPUT_POST,"username");
    $customer->username = $username ;
    $customer->company = filter_input(INPUT_POST,"company");
    $customer->email = filter_input(INPUT_POST,"email");

    $password=filter_input(INPUT_POST,"password");
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $customer->password = $password_hash ;

    if($customer->customerExists())
    {
        header("Location: ../index.php?p=addCustomer&err=customerExist");
        exit;
    }else{

        require "customersDetails.php";

        $details_arr = [] ;
        $details_opt_arr = [] ;

        foreach($customers_details as $item)
        {
            $details_arr[] = array("$item" => "".$_POST[$item]."");
        }

        $details_str = serialize($details_arr);
        $customer->details = $details_str;

        foreach($customers_details_opt as $item)
        {
            $details_opt_arr[] = array("$item" => "".$_POST[$item]."");
        }
        $details_opt_str = serialize($details_opt_arr);
        $customer->details_opt = $details_opt_str ;

        if($customer->insert(['name','username','company','password', 'email','details','details_opt']))
        {

            $customer->table = 'customers' ;
            $customer->username = $username ;

            $stmt = $customer->showAllWhere('id',['username']) ;
            $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
            extract($row) ;

            $cust_id = $row['id'] ;
            
            $error = 0 ;
            foreach($_POST['product'] as $item)
            {
                $xsproduct->table = 'product_permissions' ;
                $xsproduct->customers_id = $cust_id ;
                $xsproduct->product_id = $item ;

                if(!$xsproduct->insert(['customers_id','product_id']))
                {
                    $error++;
                }
            }

            $error_perm = '' ;
            if($error>0)
            {
                $error_perm = '&err=customerPermErr' ;
            }

            //success
            header("Location: ../index.php?p=editCustomer&idToMod=$cust_id&msg=customerSucc$error_perm");
            exit;

        }
        else
        {

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
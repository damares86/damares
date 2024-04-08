<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

// check if there's a role to delete

if(filter_input(INPUT_GET,"idToDel")){

    $idToDel = filter_input(INPUT_GET,"idToDel");

    $rolessection->role_id = $idToDel ;

    $stmt = $rolessection->showAllWhere('id',['role_id']);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $rolessection->id = $row['id'] ;
        $rolessection->delete('id');
    }

    $role->id = $idToDel;

    if($role->delete('id')){
        header("Location: ../index.php?p=allRoles&msg=roleDel");
        exit;
    }else{
        header("Location: ../index.php?p=allRoles&err=roleNoDel");
        exit;
    }

}

$operation = filter_input(INPUT_POST,"operation") ;

// check if there's a role to edit or add



    
$idToMod = filter_input(INPUT_POST,"idToMod");
    $role->id = $idToMod;
    
    if($operation=="edit"){
        
        $role->rolename = filter_input(INPUT_POST,"rolename") ;
        if(filter_input(INPUT_POST,"redirect") ){
            $role->redirect = filter_input(INPUT_POST,"redirect") ; 

        }else{
            $role->redirect = "none" ;
        }
        
        if($role->update(['rolename','redirect'],'id')){
            $rolessection->role_id = $idToMod ;
            $stmt = $rolessection->showAllWhere('id',['role_id']);

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
        
                $rolessection->id = $row['id'] ;
                $rolessection->delete('id');
            }

            $sectionId = $_POST['section'];

            foreach($sectionId as $item){
                $rolessection->role_id = $idToMod;
                $rolessection->section_id = $item;
                $rolessection->insertRoleSection(['section_id','role_id']);
                
            }

            header("Location: ../index.php?p=allRoles&msg=roleEdit");
            exit;

        }else{
            header("Location: ../index.php?p=allRoles&err=roleNoEdit");
            exit;
        }
    

}
else if($operation == "add")
{
    $role->rolename = filter_input(INPUT_POST,"rolename");

    if($role->roleExists())
    {
        header("Location: ../index.php?p=addRole&err=roleExist");
        exit;
    }
    else
    {
        $role->rolename = filter_input(INPUT_POST,"rolename") ; 
        if(filter_input(INPUT_POST,"redirect") )
        {
            $role->redirect = filter_input(INPUT_POST,"redirect") ; 
        }
        else
        {
            $role->redirect = "none" ;
        }
        
        if($role->insert(['rolename','redirect']))
        {
            $sectionParent = $_POST['section'] ;
            $sectionChild = $_POST['sectionChild'] ;

            $role->rolename = filter_input(INPUT_POST,"rolename") ;             
            $role->table = 'roles' ;
            
            $stmt = $role->showAllWhere('id',['rolename']);

            $error = 0 ;

           while($row = $stmt->fetch(PDO::FETCH_ASSOC))
           {
               extract($row);
               
               // parents permissions
               foreach($sectionParent as $item)
               {
                    $rolessection->role_id = $row['id'];
                    $rolessection->section_id = $item ;
                    $rolessection->table = 'rolesSection' ;
                    if(!$rolessection->insert(['section_id','role_id']))
                    {   
                        $error++;
                    }
                }

                // children permissions
                foreach($sectionChild as $item)
                {
                     $rolessection->role_id = $row['id'];
                     $rolessection->section_id = $item ;
                     $rolessection->table = 'rolesSectionChild' ;
                     if(!$rolessection->insert(['section_id','role_id']))
                     {   
                         $error++;
                     }
                 }
            }
            
            $errMsg = '' ;

            if($error>0)
            {
                $errMsg = 'err=rolePermFail' ;
            }

            //success
            header("Location: ../index.php?p=allRoles&msg=roleSucc$errMsg");
            exit;
        }else{
            //success
            header("Location: ../index.php?p=allRoles&err=roleFail");
            exit;  
        }
    }

}else{
    header("Location: ../index.php?p=allRoles&msg=noPost");
    exit;
}
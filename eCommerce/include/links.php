<!--This pages has all links needed for the site -->
<?php
    switch($section) {
        case 'admin':
        case 'adminEditUser':
        case 'adminEditAdmin':
        case 'viewReviews':
        case 'reviewUpdate':
            echo '<a href="?section=admin" class="userLink"> ' . '</a>';
            break;
        
        case 'formPage':
        case 'editForm':
        case 'orderSubmission':
        case 'order':
        case 'placeOrder':
            echo '<a href="?section=formPage" class="userLink"> ' . '</a>';
            break;
        
        case 'confirmationForm':
            echo '<a href="?section=confirmationForm" class="userLink"> ' . '</a>';
            break;
          
        case 'acctInfo':
        case 'account':
        case 'infoConfirm':
        case 'editInfo':
        case 'updateInfo':
        case 'insertInfo':
            echo '<a href="?section=acctInfo" class"userLink"> ' . '</a>';
            break;
        /*
        case 'formLayout';
            echo '<a href="?section=formLayout" class"userLink"> ' . '</a>';
            break;
         * 
         */
        
        case 'history';
            echo '<a href="?section=history" class"userLink"> ' . '</a>';
            break;
        
        case 'cart';
            echo '<a href="?section=shoppingCart" class"userLink"> ' . '</a>';
            break;
        
        case 'cartUpdate';
            echo '<a href="?section=cartUpdate" class"userLink"> ' . '</a>';
            break;
        
        case 'viewCart';
            echo '<a href="?section=viewCart" class"userLink"> ' . '</a>';
            break;
        
        case 'service':
        case 'serviceForm':
        case 'serviceForm2':
        case 'confirmService':
        case 'cartUpdateServices':
        case 'serviceReview':
        case 'placeReview':
            echo '<a href="?section=service"> ' . '</a>';
            break;
        
        case 'software':
        case 'software2':
        case 'microsoftForm':
        case 'autoCADForm':
            
        case 'endNoteConfirmationForm':
        case 'endNoteAgreement':
        case 'endNoteProducts':
            
        case 'esriAgreement':
        case 'esriConfirmationForm':
        case 'esriProducts':
            
        
        case 'microsoftCatalog':
        case 'microsoftSystems':
        case 'microsoftApplications':
        case 'microsfotServers':
            echo '<a href="?section=software"> ' . '</a>';
            break;

        case 'faq':
            echo '<a href="?section=faq">' . '</a>';
            break;
        
        case 'style':
            echo '<a href="?section=style">' . '</a>';
            
            case 'thumbnails':
            echo '<a href="?section=thumbnails">' . '</a>';

        default:
            break;
    } // END switch($section)

    
    
    //-- CONTROLLER
    switch($section) {
        
        //Admin Pages
        case 'admin':
            require_once '_uh_private/adminPage.php';
            break;

        case 'adminEditUser':
            require_once '_uh_private/admin/editUser.php';
            break;

        case 'adminEditAdmin':
            require_once '_uh_private/admin/editAdmin.php';
            break;
        
        case 'viewReviews':
            require_once '_uh_private/admin/viewReviews.php';
            break;
        
        case 'reviewUpdate':
            require_once '_uh_private/admin/reviewUpdate.php';
            break;
        //Admin Pages END
        
        //Form Pages
        case 'formPage';
            require_once '_uh_private/formPage.php';
            break;
        
        case 'editForm';
            require_once '_uh_private/formLayout/editForm.php';
            break;
        
        case 'orders';
            require_once '_uh_private/formLayout/orders.php';
            break;
        
        case 'orderSubmission';
            require_once '_uh_private/content/shoppingCart/orderSubmission.php';
            break;
        
        case 'placeReview';
            require_once '_uh_private/content/shoppingCart/placeReview.php';
            break;
                
        case 'placeOrder';
            require_once '_uh_private/content/shoppingCart/placeOrder.php';
            break;
        //Form Pages END
        
        
        case 'acctInfo':
            require_once '_uh_private/content/userAccount/acctInfo.php';
            break;
        
        case 'insertInfo':
            require_once '_uh_private/content/userAccount/insertInfo.php';
            break;
        
        case 'editInfo':
            require_once '_uh_private/content/userAccount/editInfo.php';
            break;
        
        case 'updateInfo':
            require_once '_uh_private/content/userAccount/updateInfo.php';
            break;
        
        case 'infoConfirm':
            require_once '_uh_private/content/userAccount/infoConfirm.php';
            break;
        
        case 'account':
            require_once '_uh_private/content/userAccount/index.php';
            break;
        
        case 'history':
            require_once '_uh_private/content/userAccount/history.php';
            break;
        
        //Services Pages
        case 'services':
            require_once '_uh_private/content/services.php';
            break;
        
        case 'serviceForm':
            require_once '_uh_private/content/servicesForm/vmware.php';
            break;
        
        case 'serviceForm2':
            require_once '_uh_private/content/servicesForm/coLocation.php';
            break;

        //Services Pages END
        
        
        //Software Pages
        case 'software':
            require_once '_uh_private/content/software.php';
            break;
        
        case 'software2':
            require_once '_uh_private/content/software2.php';
            break;
        
        
        case 'microsoftCatalog':
            require_once '_uh_private/content/softwareForms/microsoft/catalog.php';
            break;
        
        case 'microsoftApplications':
            require_once '_uh_private/content/softwareForms/microsoft/test.php';
            break;
        
        case 'microsoftSystems':
            require_once '_uh_private/content/softwareForms/microsoft/test2.php';
            break;
        
        case 'microsoftServers':
            require_once '_uh_private/content/softwareForms/microsoft/test3.php';
            break;
        
        
        case 'endNoteProducts':
            require_once '_uh_private/content/softwareForms/endNote/products.php';
            break;
        
        case 'endNoteAgreement':
            require_once '_uh_private/content/softwareForms/endNote/agreementForm.php';
            break;
        
        case 'endNoteConfirmationForm';
            require_once '_uh_private/content/softwareForms/endNote/confirmationForm.php';
            break;
        
        
        case 'esriProducts':
            require_once '_uh_private/content/softwareForms/esri/products.php';
            break;
        
        case 'esriAgreement':
            require_once '_uh_private/content/softwareForms/esri/agreementForm.php';
            break;
        
        case 'esriConfirmationForm';
            require_once '_uh_private/content/softwareForms/esri/confirmationForm.php';
            break;
     
        //Software Pages END
        
        case 'faq';
            require_once '_uh_private/content/faq.php';
            break;
        
        case 'cart';
            require_once '_uh_private/content/shoppingCart.php';
            break;

        case 'viewCart';
            require_once '_uh_private/content/shoppingCart/viewCart.php';
            break;
        
        case 'cartUpdate';
            require_once '_uh_private/content/shoppingCart/cartUpdate.php';
            break;
        
        case 'serviceReview';
            require_once '_uh_private/content/shoppingCart/serviceReview.php';
            break;
        
        case 'style';
            require_once 'include/style.css';
            break;
        case 'thumbnails';
            require_once 'include/thumbnails.css';
            break;

        default:
            require_once '_uh_private/content/index.php';
            break;
    } // END switch($section)
?>
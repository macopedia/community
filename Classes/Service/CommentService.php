<?php


/**
 * Class which contains hooks for tx_comments
 *
 * 
 */
class Tx_Community_Service_CommentService implements t3lib_Singleton{

   
   
    /**
     * customFunctionCode hook function for Comments extension
     * used for displaying comment list (wall)
     * @param array $params contains one parameter $params['code']
     * @param tx_comments_pi1 $pObj Reference to calling class
     * @return Return html which have to be displayed
     */
    public function customFunctionCode(&$params, &$pObj) {

        $content ='';
        if($params['code'] == 'COMMUNITY_WALL'){
             $content ='<h2>Community comments integration test</h2>';
             $content .= $pObj->comments();
        }
        return $content;
    }

    /**
     * comments_getComments hook function for Comments extension, it takes
     * integer value of tx_comments_comments.firstname and try to get
     * username from fe_users table
     * @param array $params contains 3 parameters: template, markers, row
     * @param tx_comments_pi1 $pObj Reference to calling class
     * @return Hook should return a modified array with markers.
     */
    public function comments_getComments(&$params, &$pObj) {
	$newMarkerArray = $params['markers'];

	if($newMarkerArray['###FIRSTNAME###']) {

	    $userUid = $newMarkerArray['###FIRSTNAME###'];
	    
	    if(is_numeric($userUid))
	    {
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('uid,username,name','fe_users',
		    'uid = '.$userUid.$pObj->cObj->enableFields('fe_users') , '', '');
	   
		if($rows['username']) {
		    $newMarkerArray['###FIRSTNAME###'] = $rows['name'];

		    $objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		    $uriBuilder =  $objectManager->get('Tx_Extbase_MVC_Web_Routing_UriBuilder');
		    $uri = $uriBuilder
			->reset()
			->setTargetPageUid($this->settings['profilePage'])
			->uriFor(NULL, array('user' => $userUid), "User" , "community","Pi1");

		    $userProfileAddress = $uri;
		    $newMarkerArray['###HOMEPAGE###'] = $userProfileAddress;
		    
		}

	     }
	}
  
        return $newMarkerArray;
    }


    /**
     * processSubmission hook function for Comments extension
     * @param array $params contains 1 parameter: record (array)
     * @param tx_comments_pi1 $pObj Reference to calling class
     * @return Hook should return a modified record array.
     */
    public function processSubmission(&$params, &$pObj) {
	$newArray = NULL;
	
	//checking if plugin was called from community  
	if($pObj->conf['communityFlag'] == 1)
	{
	    global $TSFE;
	    $newArray = $params['record'];
	    $newArray['firstname'] = $TSFE->fe_user->user['uid'];
	}
	
	return $newArray;
    }
}

?>
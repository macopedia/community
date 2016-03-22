.. include:: ../../Includes.txt



.. _Extending-community:

Extending Community
^^^^^^^^^^^^^^^^^^^

The Community extension can easily extended to include custom fields.
To extend Community you should create you own extensions. Since
community is based on Extbase and Fluid, your extension has to be
Extbase compliant as well. To do so, you need to use the new extension
called "extension\_builder" to create you new extension. To "convert"
your old extension, you can create a new one with the
extension\_builder and copy your logic back from your old ext.

#. Create a new extension with the "extension\_builder" extension and
   call it "communitylocal" (key).
   
   #. You can add yourself as a person (developer).
   
   #. Create a "New Model Object" by drag and drop the button to some place
      on the screen.
   
   #. Edit the object and call it "User".
   
   #. Set "Map to existing table" to "fe\_users" and also set "Extend
      existing model class" to "Tx\_Community\_Domain\_Model\_User"
   
   #. Under properties add a property and call it "skype". Add description
      if you want to.
   
   #. If you finished save the new extension and install it.

#. As we want our Tx\_Communitylocal\_Domain\_Model\_User to appear
   whenever Tx\_Community\_Domain\_Model\_User is needed, we add in TS:

   ::

      config.tx_extbase.objects.Tx_Community_Domain_Model_User.className = Tx_Communitylocal_Domain_Model_User
   
   Note: In TYPO3 versions lower then 4.6 domain objects couldn’t be
   replaced like this, and you have to use STI:

   ::

      config.tx_extbase.persistence.classes { # REQUIRED FOR TYPO3 < 4.6
        
              Tx_Communitylocal_Domain_Model_User < .Tx_Community_Domain_Model_User
        
              Tx_Communitylocal_Domain_Model_User.mapping.recordType = 0
        
              Tx_Community_Domain_Model_User {
                  subclasses.0 = Tx_Communitylocal_Domain_Model_User
         }
      } # REQUIRED FOR TYPO3 < 4.6

#. Add the field in TS:

   ::

      plugin.tx_community {
         settings {
                 profile {
                         details {
                                 showDetails = ...,skype
                         }
                 }
         }
      }

#. Now you have to add your new field to the according templates. You can
   find the templates for the community extension in the extension folder
   : /Resources/`Private  It is recommended to copy the templates to the fileadmin folder
   and point to it via Typoscript. Hint: You can set your own translation
   labels like this:

   ::

      <f:translate key="LLL:EXT:communitylocal/Resources/Private/Language/locallang_db.xml:tx_communitylocal_domain_model_user.tx_communitylocal_skype"/>
   
   As an alternative, you can override all community labels with you own
   like this: In ext\_localconf of "communitylocal" add

   ::

      $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:community/Resources/Private/Language/locallang.xml'][]='EXT:communitylocal/Resources/Private/Language/locallang.xml';


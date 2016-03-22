.. include:: ../../Includes.txt



.. _Extending-controllers:

Extending controllers
^^^^^^^^^^^^^^^^^^^^^

If we want to add new actions or change existing ones edit actions. In
this example wee add a custom validator and change updateAction:

#. Create class:

   ::

      <?php
      class Tx_Communitylocal_Controller_UserController extends Tx_Community_Controller_UserController {
      /**
      * Update the edited user.
      *
      * @param Tx_Community_Domain_Model_User $updatedUser
      * @validate $updatedUser Tx_Communitylocal_Domain_Validator_EditUserValidator
      */
      public function updateAction(Tx_Community_Domain_Model_User $updatedUser) {
       parent::updateAction($updatedUser);
      // CUSTOM CODE HERE
      }
      /**
      * Foo
      */
      public function fooAction() {
      // CUSTOM CODE HERE
       }
      }

#. In TS add the following code:

   ::

      # force communityLocal to use the same request parameter namespace
      plugin.tx_communitylocal.view.pluginNamespace = tx_community
      #override controller
      config.tx_extbase.objects.Tx_Community_Controller_UserController.className = Tx_Communitylocal_Controller_UserController

#. In ext\_localconf.php:
   
   ::

      //Add foo action to existing plugin
      $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['Community']['plugins']['RelationManagement']['controllers']['User']['actions'][] = 'foo';
      $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['Community']['plugins']['RelationManagement']['controllers']['User']['nonCacheableActions'][] = 'foo';
      //Add new plugin for foo action
      Tx_Extbase_Utility_Extension::configurePlugin(
        'community',
        'Foo',
        array(
            'User' => 'foo',
        ),
        array(
            'User' => 'foo',
        )
      );

#. In ext\_tables.php add the following code:

   ::

        Tx_Extbase_Utility_Extension::registerPlugin(
            'community',
            'Foo',
            'Community: Nice Name For New Plugin'
        );


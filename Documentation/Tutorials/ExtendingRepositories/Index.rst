.. include:: ../../Includes.txt



.. _Extending-repositories:

Extending repositories
^^^^^^^^^^^^^^^^^^^^^^

#. Create new repository class which will extend repository from Community, e.g.

   ::

      <?php

      class Tx_Communitylocal_Domain_Repository_UserRepository extends Tx_Community_Domain_Repository_UserRepository {
          public function searchByName($word) {
              $query = $this->createQuery();
              return $query->matching(
                  $query->logicalAnd(
                      $query->like('name', '%' . $word . '%'),
                      $query->equals('something', 1)
                  )
              )->execute();
          }
      }


#. In TS add the following code:

   ::

      Tx_Community_Domain_Repository_UserRepository.className = Tx_Communitylocal_Domain_Repository_UserRepository
      persistence.classes {
         Tx_Communitylocal_Domain_Model_User < .Tx_Community_Domain_Model_User
         Tx_Communitylocal_Domain_Model_Message {
             mapping {
                   tableName = tx_community_domain_model_message
             }
         }
         Tx_Communitylocal_Domain_Model_User.mapping.recordType = 0
         Tx_Community_Domain_Model_User {
             subclasses.0 = Tx_Communitylocal_Domain_Model_User
         }
      }


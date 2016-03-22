.. include:: ../../Includes.txt



.. _Creating-new-notification-handler:

Creating new notification handler
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Imagine you want to notify user by SMS, after he receives private
message from somebody.

#. Create own notification handler which implements
   Tx\_Community\_Service\_Notification\_HandlerInterface
   
   e.g. Tx\_CommunityLocal\_Service\_Notification\_SmsHandler implements
   Tx\_Community\_Service\_Notification\_HandlerInterface
   
   put the logic you need to send() action

#. Add TypoScript configuration

   ::

      plugin.tx_community.settings.notification.rules {
          messageSend {
              20 {
                  handler = Tx_CommunityLocal_Service_Notification_SmsHandler
              }
          }
      }

   That's it :)


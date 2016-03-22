.. include:: ../../Includes.txt



.. _Add-new-notification-event:

Add new notification event
^^^^^^^^^^^^^^^^^^^^^^^^^^

You can use notification API in your new controllers, to send notifications after some events.

#. Place following snippet where you want to notify user.

   ::

      $notification = new Tx_Community_Service_Notification_Notification(
         'controllernameAction',      // notification event name – this name will be used in TypoScript configuration
                                      // by convention naming scheme like “controllerAction” is used.
         $this->requestingUser,   //sender
         $this->requestedUser    //recipient
      );
      // you can assign as many additional parameters as you want – Notification class implements magic getters
      // and setters. All parameters are automatically assigned to the message template (in case you use mailHandler).
      $notification->setFoo("BAR");
      $this->notificationService->notify($notification);


#. Add configuration in TS for your new event

   ::

      controllernameAction  {
          10 {
              template = ControllernameAction
              handler = Tx_Community_Service_Notification_MailHandler
              serverEmail = {$plugin.tx_community.serverEmail}
          }
      }

See TypoScript reference for more configuration values.


.. include:: ../../Includes.txt



.. _Reference:

Reference
^^^^^^^^^

This extension provides the following configuration options.


.. _Main-configuration:

Main configuration
""""""""""""""""""

Following properties live under `plugin.tx_community.settings`


.. _loginPage:

loginPage
~~~~~~~~~

.. container:: table-row

   Property
      loginPage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.loginPage}




.. _profilePage:

profilePage
~~~~~~~~~~~

.. container:: table-row

   Property
      profilePage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.profilePage}


.. _editProfilePage:

editProfilePage
~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      editProfilePage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.editProfilePage}


.. _messagePage:

messagePage
~~~~~~~~~~~

.. container:: table-row

   Property
      messagePage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.messagePage}


.. _threadedMessagePage:

threadedMessagePage
~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      threadedMessagePage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.threadedMessagePage}

.. _galleryPage:

galleryPage
~~~~~~~~~~~

.. container:: table-row

   Property
      galleryPage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.galleryPage}


.. _searchPage:

searchPage
~~~~~~~~~~

.. container:: table-row

   Property
      searchPage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.searchPage}



.. _relationPage:

relationPage
~~~~~~~~~~~~

.. container:: table-row

   Property
      relationPage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.relationPage}


.. _wallPage:

wallPage
~~~~~~~~

.. container:: table-row

   Property
      wallPage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.wallPage}




.. _afterAccountDeletePage:

afterAccountDeletePage
~~~~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      afterAccountDeletePage

   Data type
      int (page id)

   Default
      {$plugin.tx\_community.settings.loginPage}




.. _debug:

debug
~~~~~

.. container:: table-row

   Property
      debug

   Data type
      1 or 0

   Description
      Set debug mode for community, e.g. flash messages will containg some
      debug information

   Default
      0




.. _flashMessagesDisplayer-where:

flashMessagesDisplayer.where
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      flashMessagesDisplayer.where

   Data type
      jQuery like CSS selector e.g. #elementId.elementClass

   Description
      css-like path to the element, which will be prepended with flash
      messages this selector will be used by jQuery

   Default
      body



.. _Profile-settings:

Profile settings
""""""""""""""""
Following configuration lives under `plugin.tx_community.settings.profile`


.. _image-maxWidth:

image.maxWidth
~~~~~~~~~~~~~~

.. container:: table-row

   Property
      image.maxWidth

   Default
      300


.. _image-maxHeight:

image.maxHeight
~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      image.maxHeight

   Default
      300



.. _image-prefix:

image.prefix
~~~~~~~~~~~~

.. container:: table-row

   Property
      image.prefix

   Default
      uploads/tx\_community/photos/


.. _image-types:

image.types
~~~~~~~~~~~

.. container:: table-row

   Property
      image.types

   Description
      List of allowed image extensions

   Default
      jpeg,jpg,png,gif


.. _image-defaultImage:

image.defaultImage
~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      image.defaultImage

   Description
      File used when user doesn't have any profile image.

   Default
      EXT:community/Resources/Public/Images/defaultProfileImage.png



.. _reasonForReportRequired:

reasonForReportRequired
~~~~~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      reasonForReportRequired

   Data type
      1 or 0

   Description
      Determines if textfield for typing reason for reporting a profile
      should be displayed.

   Default
      1


.. _details-showDetails:

details.showDetails
~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      details.showDetails

   Description
      Sets which user's profile details should be visible on profile page.

   Default
      username,gender,dateOfBirth,politicalView,religiousView,activities,int
      erests,music,movies,books,quotes,aboutMe,address,city,zip,country,www,
      cellphone,phone,email


.. _Relationship-settings:

Relationship settings
"""""""""""""""""""""

Following settings live under plugin.tx_community.settings.relation 


.. _request-allowMultiple:

request.allowMultiple
~~~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      request.allowMultiple

   Description
      if set to 1 then relationship request is allowed even if it was once
      rejected

   Default
      1


.. _Album-settings:

Album settings
""""""""""""""

Following settings live under `plugin.tx_community.settings.album` 


.. _image:

image
~~~~~

.. container:: table-row

   Property
      image



.. _image-prefix:

image.prefix
~~~~~~~~~~~~

.. container:: table-row

   Property
      image.prefix

   Default
      uploads/tx\_community/photos/




.. _image-types:

image.types
~~~~~~~~~~~

.. container:: table-row

   Property
      image.types

   Default
      jpeg,jpg,png




.. _image-maxSize:

image.maxSize
~~~~~~~~~~~~~

.. container:: table-row

   Property
      image.maxSize

   Description
      Maximal file size in bytes

   Default
      1000000


.. _unknownAlbumMainPhoto:

unknownAlbumMainPhoto
~~~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      unknownAlbumMainPhoto

   Description
      the image we see on list of albums when we have no access to album

   Default
      EXT:community/Resources/Public/Images/unknownAlbumMainPhoto.png



.. _dafaultAlbumMainPhoto:

dafaultAlbumMainPhoto
~~~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      dafaultAlbumMainPhoto

   Description
      the image we see on list of albums when there are on images in album

   Default
      EXT:community/Resources/Public/Images/defaultAlbumMainPhoto.png



.. _Mapping-controller-actions-to-resource-names:

Mapping controller actions to resource names
""""""""""""""""""""""""""""""""""""""""""""

This array is used to map controller action name to resource name.
Resource name is used in access control – see
plugin.tx\_community.settings.accessRules

Thanks to that, multiple controller actions can be bound to one
resource name.

Example:

::

   plugin.tx_community.settings.accessActionResourceMap
   {
      Message {  // message controller
              write = message.write
              //both “write” and “send” actions are bound to “message.write” resource name
              send = message.write
      }
      User {  //User controller
              image = profile.image   //image action
      }
   }


.. _Access-configuration:

Access configuration
""""""""""""""""""""

.. _public:

public
~~~~~~

.. container:: table-row

   Property
      public

   Description
      Guests (not logged in), and requested user not set


.. _nobody:

nobody
~~~~~~

.. container:: table-row

   Property
      nobody

   Description
      Settings for guests (not logged in users), requested user is set


.. _other:

other
~~~~~

.. container:: table-row

   Property
      other

   Description
      Logged in user, but not a friend


.. _friend:

friend
~~~~~~

.. container:: table-row

   Property
      friend

   Description
      Friend



By default user is able to change everything on his own profile, so
there are no settings for this case.

Example:

::

   plugin.tx_community.settings.accessRules.accessRules
   {
           nobody {
                  profile.image.access = 1     //not logged in user has access to see profile image
                   //”profile.image” resource name is the same as in accessActionResourceMap above
                  utils.access = 1     //and flash messages
                  access = 0             //by default has no access (whitelist approach)
           }
           //logged in user has access to the same things as “nobody” plus some additional rules defined below
           other < plugin.tx_community.settings.accessRules.nobody
           other {
               access = 0
               user.search.access = 1
               user.searchBox.access = 1
               profile.menu.access = 1
           }
   }


.. _Notification-service-configuration:

Notification service configuration
""""""""""""""""""""""""""""""""""

Following configuration live under `plugin.tx_community.settings.notification`


.. _templateRootPath:

templateRootPath
~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      templateRootPath

   Description
      Path for email templates.

   Default
      EXT:community/Resources/Private/Templates/Notification/



.. _layoutRootPath:

layoutRootPath
~~~~~~~~~~~~~~

.. container:: table-row

   Property
      layoutRootPath

   Default
      EXT:community/Resources/Private/Layouts/




.. _partialRootPath:

partialRootPath
~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      partialRootPath

   Default
      EXT:community/Resources/Private/Partials/


.. _defaults:

defaults
~~~~~~~~

.. container:: table-row

   Property
      defaults

   Default
      Default setings for notification



.. _defaults-handler:

defaults.handler
~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      defaults.handler

   Description
      Default handler, can be overridden in specific rule

   Default
      Tx\_Community\_Service\_Notification\_MailHandler


.. _defaults-serverEmail:

defaults.serverEmail
~~~~~~~~~~~~~~~~~~~~

.. container:: table-row

   Property
      defaults.serverEmail

   Default
      {$plugin.tx\_community.serverEmail}


.. _rules:

rules
~~~~~

.. container:: table-row

   Property
      rules

   Description
      Array of notification names and configuration



Example:

::

   plugin.tx_community.settings.notification.notification
   {
         rules {
            RelationRequest {
                   // naming convention: ControllerActionName
                  10 {
            // array of notification handlers – it is possible to send multiple
            // notifications after some
         //action, e.g. notify by email, by private message and wall post
                  handler = Tx_Community_Service_Notification_MailService     //notification handler class name
                   template = RelationRequest        //template name ( "html" extension will be appended )
                   }
           }
            #admin notification about bad profile
           userReport {
                   10 {
                           template = UserReport
                           recipient = {$plugin.tx_community.adminEmail}
                           //recipient email address
                           overrideRecipient = 1
                           // instead of using reported user email, we are  sending this report
                           // to community administrator
                           replyToSenderUser = 1
                           // send copy of the email to user who filed the report
                   }
           }
   }


.. _Variables-assigned-to-all-views:

Variables assigned to all views
"""""""""""""""""""""""""""""""

Community by default passes several variables to all views (this is
done in BaseController in initializeView method). So you don't have to
pass these objects in your controller actions.



.. _requestedUser:

requestedUser
~~~~~~~~~~~~~

.. container:: table-row

   Variable name
      requestedUser

   Description
      User which e.g. profile we want to see




.. _requestingUser:

requestingUser
~~~~~~~~~~~~~~

.. container:: table-row

   Variable name
      requestingUser

   Description
      Logged in user who is accessing the page


.. _relation:

relation
~~~~~~~~

.. container:: table-row

   Variable name
      relation

   Description
      Relation between requestedUser and requestingUser



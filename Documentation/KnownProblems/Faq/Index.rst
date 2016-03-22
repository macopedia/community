.. include:: ../../Includes.txt



.. _FAQ:

FAQ
^^^

Q: I'm getting "Uncaught TYPO3 Exception #1289386765: Could not
analyse class:Tx\_Community\_Service\_Access\_AccessService maybe not
loaded or no autoloader?
Tx\_Extbase\_Object\_Container\_Exception\_UnknownObjectException
thrown in file
\typo3\sysext\extbase\Classes\Object\Container\ClassInfoFactory.php in
line 45."

A: Please include Community static template.

Q: I'm getting “Fatal error: Call to a member function
getParentKeyFieldName() on a non-object in
\typo3\sysext\extbase\Classes\Persistence\Storage\Typo3DbBackend.php
on line 660“ when accessing page with threaded messages plugin.

A: The static template form Community has to be included after the
static template from Extbase (as we are overriding some Extbase
classes). You can check the order of templates in Template Analyzer.

Q: How can I preserve community parameters in TYPO3 page menu?

A: add this line to Typoscript configuration

config.linkVars := addToList(tx\_community)

alternatively you can use typolink “addQueryString =1”

in your menu like this:


::

   1 = TMENU
   1 {
        NO {
            linkWrap = <li>|</li>
            doNotLinkIt = 1
            stdWrap.typolink.parameter.data = page:uid
            stdWrap.typolink.addQueryString = 1
        }
   }

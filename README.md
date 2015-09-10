# Sitemap

Simple TYPO3 Sitemap-Extension which allows you to create a xml-sitemap from your page-tree and external plugins via the TYPO3 Signal-Slot-Dispatcher.


## Installation & Configuration

1. Install the extension.
2. Include the extension-template in your sitemap-page.
3. Create sitemap-plugin on your sitemap-page.
4. Configure your sitemap-plugin.


## Signal Slot Dispatcher

If you would like to include links from external plugins (eg. news), you can use the signal-slot-dispatcher-system from typo3.
An Example is showed in the class Classes/Example/DummyLinks.php
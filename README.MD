# Extended Userprofiles

This extention extends user-profiles to be conform to the requirements for the [OHI-Tool](https://github.com/ViMaSter/OHI-Tool/)-extension.

## Installation
1. Download this repository and place the folder into `[MEDIAWIKI]\extensions`.  
(This README.md-file should be located at `[MEDIAWIKI]\extensions\ExtendedUserProfiles\README.md` then.)
2. Add the line `wfLoadExtension( 'ExtendedUserProfiles' );` to your `[MEDIAWIKI]\LocalSettings.php`-file next to all other `wfLoadExtension()`-calls.  
The order of the [OHI-Tool](https://github.com/ViMaSter/OHI-Tool/)-s `wfLoadExtension()`-call and this extensions' is irrelevant.

# Extended Userprofiles

This extention extends user-profiles to be conform to the requirements for the [OHI-Tool](https://github.com/ViMaSter/OHI-Tool/)-extension.

## Installation
1. Download this repository and place the folder into `[MEDIAWIKI]\extensions`.  
(This README.md-file should be located at `[MEDIAWIKI]\extensions\ExtendedUserProfiles\README.md` then.)
2. Add the line `wfLoadExtension( 'ExtendedUserProfiles' );` to your `[MEDIAWIKI]\LocalSettings.php`-file next to all other `wfLoadExtension()`-calls.  
The order of the [OHI-Tool](https://github.com/ViMaSter/OHI-Tool/)'s `wfLoadExtension()`-call and this extensions' is irrelevant.
3. If present, remove the line `'gender' => 'unknown',` from `[MEDIAWIKI]\includes\DefaultSettings.php`. For more information about default parameters, consult [**Retrieving values with a fallback**](#Retrieving-values-with-a-fallback) in the **Usage**-part of this file.

## Usage
After installation, the registration form will be populated with additional fields. For this release, they are as follows:

| field                            | description
| -------------------------------- | ------------------------------------------------------------------------------------------------- |
| `birthyear`                      | Year of birth of the user in 4 integers (i.e. 1982, 2003, ...)
| `gender`                         | Gender of the user (string of characters; non-binary)
| `highest-educational-attainment` | Highest educational attainment of the user (free-text field; not a selection of predefined-items)

Once a user signed up and filled out these fields, you can get the value on any page using two ways.

### Retrieving values for current user
To get the values of the user currently watching the page use the following macros inside the page editor:
```
{{ #currentUserPropertyEcho: gender }}  
{{ #currentUserPropertyEcho: highest-educational-attainment }}
{{ #currentUserPropertyEcho: birthyear }} ```

### Retrieving values for a specific user
To get the values of a specific user using the account-name use
```
{{ #userByNamePropertyEcho: myusername | gender }}  
{{ #userByNamePropertyEcho: myusername | highest-educational-attainment }}
{{ #userByNamePropertyEcho: myusername | birthyear }} ```
To get the values of a specific user using the account-ID use
```
{{ #userByIDPropertyEcho: 1337 | gender }}  
{{ #userByIDPropertyEcho: 1337 | highest-educational-attainment }}
{{ #userByIDPropertyEcho: 1337 | birthyear }} ```

If the no value can be found, an empty string of characters is returned.

### Retrieving values with a fallback
If a value is not present, users can optionally specify a default value to fall back to.
For this, simply append another ` | ` and the default value you want to return. This works on every query.
```
{{ #userByNamePropertyEcho: mm | gender | unknown}}                                  // returns "unknown", if no gender was specified at registration
{{ #userByNamePropertyEcho: mm | highest-educational-attainment | left blank }}      // returns "left blank", if not specified at registration
{{ #userByNamePropertyEcho: mm | birthyear | 200 B.C. }}                             // returns "200 B.C.", if no birthyear was specified at registration
{{ #userByIDPropertyEcho: 1337 | gender | not specified}}                            // returns "not specified", if no gender was specified at registration
{{ #userByIDPropertyEcho: 1337 | highest-educational-attainment | not applicable }}  // returns "not applicable", if not specified at registration
{{ #userByIDPropertyEcho: 1337 | birthyear | someday }}                              // returns "someday", if no birthyear was specified at registration
{{ #currentUserPropertyEcho: gender | unavailable }}                                 // returns "unavailable", if no gender was specified at registration
{{ #currentUserPropertyEcho: highest-educational-attainment | not set }}             // returns "not set", if not specified at registration
{{ #currentUserPropertyEcho: birthyear | n/a }}                                      // returns "n/a", if no birthyear was specified at registration```

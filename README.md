# nl.issa.api

This extension contains an API for newsletter signup. 
ISSA has an external website on which people could signup for the newsletter. This website then sends the data to the CiviCRM api.

This extension contains the API for processing the signup.

## Newsletter.signup

**Entity**: Newsletter
**action**: signup

**Parameters**

* email: required the email address
* group: required the name of the newsletter group
* first_name: first name of the person
* last_name: last name of the person
* organization: organization name, this is going to be registered in CiviCRM as the employer data of the contact.
